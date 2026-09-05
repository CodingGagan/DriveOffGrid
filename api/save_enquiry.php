<?php
/**
 * API Endpoint: Save Travel Enquiry Form Data
 * 
 * Handles both individual field updates (on blur) and full form submission
 * 
 * POST Parameters:
 * - action: 'save_field' or 'submit_form'
 * - form_session_id: Unique session ID for tracking the same form submission
 * - field_name: Field name (for save_field action)
 * - field_value: Field value (for save_field action)
 * - OR full form data as JSON (for submit_form action)
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400'); // 24 hours

// Handle CORS preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../includes/db_config.php';
require_once __DIR__ . '/../includes/smtp_mail.php';

/**
 * Send enquiry email notification
 */
function sendEnquiryEmail($data, $enquiryId) {
    $to = 'hello@driveoffgrid.com';
    $subject = 'New Travel Enquiry - ' . htmlspecialchars($data['first_name']);
    
    // Parse selected countries - handle both JSON string and array
    $selectedCountries = [];
    if (!empty($data['selected_countries'])) {
        if (is_string($data['selected_countries'])) {
            // Try to decode JSON
            $decoded = json_decode($data['selected_countries'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $selectedCountries = $decoded;
            } else {
                // If not JSON, treat as comma-separated string
                $selectedCountries = array_filter(array_map('trim', explode(',', $data['selected_countries'])));
            }
        } elseif (is_array($data['selected_countries'])) {
            $selectedCountries = $data['selected_countries'];
        }
    }
    
    // Format selected countries - extract country names if it's an array of objects
    $countriesText = 'Not specified';
    if (!empty($selectedCountries)) {
        $countryNames = [];
        foreach ($selectedCountries as $country) {
            if (is_array($country)) {
                // If it's an object/array, try to get the name
                if (isset($country['name'])) {
                    $countryNames[] = $country['name'];
                } elseif (isset($country['country'])) {
                    $countryNames[] = $country['country'];
                } elseif (isset($country[0])) {
                    $countryNames[] = $country[0];
                } else {
                    $countryNames[] = implode(' ', $country);
                }
            } else {
                // If it's a string, use it directly
                $countryNames[] = $country;
            }
        }
        $countriesText = !empty($countryNames) ? implode(', ', $countryNames) : 'Not specified';
    }
    
    // Format travel month
    $travelMonth = $data['travel_month'] ?? 'Not specified';
    if ($travelMonth && $travelMonth != 'Not specified') {
        $date = DateTime::createFromFormat('Y-m', $travelMonth);
        if ($date) {
            $travelMonth = $date->format('F Y');
        }
    }
    
    // Create HTML email template
    $htmlMessage = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #FF974F; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #2C4B3B; }
            .value { margin-top: 5px; padding: 10px; background-color: white; border-left: 3px solid #FF974F; }
            .message-box { padding: 15px; background-color: white; border-left: 3px solid #2C4B3B; margin-top: 10px; }
            .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>New Travel Enquiry</h1>
                <p>Enquiry ID: #' . $enquiryId . '</p>
            </div>
            <div class="content">
                <div class="field">
                    <div class="label">Name:</div>
                    <div class="value">' . htmlspecialchars($data['first_name']) . '</div>
                </div>
                
                <div class="field">
                    <div class="label">Email:</div>
                    <div class="value">' . htmlspecialchars($data['email'] ?? 'Not provided') . '</div>
                </div>
                
                <div class="field">
                    <div class="label">Phone:</div>
                    <div class="value">' . htmlspecialchars($data['phone']) . '</div>
                </div>
                
                <div class="field">
                    <div class="label">Selected Countries:</div>
                    <div class="value">' . htmlspecialchars($countriesText) . '</div>
                </div>
                
                <div class="field">
                    <div class="label">Number of People:</div>
                    <div class="value">' . htmlspecialchars($data['number_of_people'] ?? 'Not specified') . '</div>
                </div>
                
                <div class="field">
                    <div class="label">Travel Month:</div>
                    <div class="value">' . htmlspecialchars($travelMonth) . '</div>
                </div>
                
                <div class="field">
                    <div class="label">Message:</div>
                    <div class="message-box">' . nl2br(htmlspecialchars($data['message'])) . '</div>
                </div>
            </div>
            <div class="footer">
                <p>This email was sent from the DriveOffGrid contact form.</p>
                <p>Submitted on: ' . date('F j, Y \a\t g:i A') . '</p>
            </div>
        </div>
    </body>
    </html>';
    
    return sendSMTPEmail($to, $subject, $htmlMessage);
}

// Only allow POST requests (after OPTIONS preflight)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed. Only POST requests are accepted.']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON data']);
    exit;
}

$action = $input['action'] ?? '';
$formSessionId = $input['form_session_id'] ?? '';

if (empty($formSessionId)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Form session ID is required']);
    exit;
}

$pdo = getDBConnection();

if (!$pdo) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

try {
    if ($action === 'save_field') {
        // Save individual field on blur
        $fieldName = $input['field_name'] ?? '';
        $fieldValue = $input['field_value'] ?? '';
        
        if (empty($fieldName)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Field name is required']);
            exit;
        }
        
        // Whitelist allowed field names to prevent SQL injection
        $allowedFields = [
            'first_name' => 'firstName',
            'email' => 'email',
            'phone' => 'phone',
            'trip_type' => 'tripType',
            'selected_countries' => 'selectedCountries',
            'number_of_people' => 'numberOfPeople',
            'travel_month' => 'travelMonth',
            'message' => 'message'
        ];
        
        // Map frontend field name to database column name
        $dbFieldName = array_search($fieldName, $allowedFields);
        if ($dbFieldName === false) {
            // Try direct match (in case frontend sends DB column name)
            if (in_array($fieldName, array_keys($allowedFields))) {
                $dbFieldName = $fieldName;
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid field name']);
                exit;
            }
        }
        
        // Check if record exists for this session
        $stmt = $pdo->prepare("SELECT id FROM travel_enquiries WHERE form_session_id = ?");
        $stmt->execute([$formSessionId]);
        $existing = $stmt->fetch();
        
        if ($existing) {
            // Update existing record - use whitelisted field name
            $stmt = $pdo->prepare("
                UPDATE travel_enquiries 
                SET `{$dbFieldName}` = ?, updated_at = NOW() 
                WHERE form_session_id = ?
            ");
            $stmt->execute([$fieldValue, $formSessionId]);
        } else {
            // Insert new record with just this field
            $stmt = $pdo->prepare("
                INSERT INTO travel_enquiries (form_session_id, `{$dbFieldName}`, created_at, updated_at) 
                VALUES (?, ?, NOW(), NOW())
            ");
            $stmt->execute([$formSessionId, $fieldValue]);
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Field saved successfully',
            'form_session_id' => $formSessionId
        ]);
        
    } elseif ($action === 'submit_form') {
        // Save complete form on submission
        $data = [
            'first_name' => $input['firstName'] ?? '',
            'email' => $input['email'] ?? '',
            'phone' => $input['phone'] ?? '',
            'trip_type' => $input['tripType'] ?? '', // JSON array of selected trips
            'selected_countries' => $input['selectedCountries'] ?? '', // JSON array of globe-selected countries
            'number_of_people' => $input['numberOfPeople'] ?? null,
            'travel_month' => $input['travelMonth'] ?? '',
            'message' => $input['message'] ?? '',
            'status' => 'submitted'
        ];
        
        // Validate required fields
        $required = ['first_name', 'phone', 'number_of_people', 'travel_month', 'message'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => "Field {$field} is required"]);
                exit;
            }
        }
        
        // Check if record exists
        $stmt = $pdo->prepare("SELECT id FROM travel_enquiries WHERE form_session_id = ?");
        $stmt->execute([$formSessionId]);
        $existing = $stmt->fetch();
        
        if ($existing) {
            // Update existing record
            $stmt = $pdo->prepare("
                UPDATE travel_enquiries 
                SET first_name = ?,
                    email = ?,
                    phone = ?,
                    trip_type = ?,
                    selected_countries = ?,
                    number_of_people = ?,
                    travel_month = ?,
                    message = ?,
                    status = ?,
                    submitted_at = NOW(),
                    updated_at = NOW()
                WHERE form_session_id = ?
            ");
            $stmt->execute([
                $data['first_name'],
                $data['email'],
                $data['phone'],
                $data['trip_type'],
                $data['selected_countries'],
                $data['number_of_people'],
                $data['travel_month'],
                $data['message'],
                $data['status'],
                $formSessionId
            ]);
            $enquiryId = $existing['id'];
        } else {
            // Insert new record
            $stmt = $pdo->prepare("
                INSERT INTO travel_enquiries (
                    form_session_id, first_name, email, phone, trip_type, 
                    selected_countries, number_of_people, travel_month, message, status,
                    created_at, submitted_at, updated_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), NOW())
            ");
            $stmt->execute([
                $formSessionId,
                $data['first_name'],
                $data['email'],
                $data['phone'],
                $data['trip_type'],
                $data['selected_countries'],
                $data['number_of_people'],
                $data['travel_month'],
                $data['message'],
                $data['status']
            ]);
            $enquiryId = $pdo->lastInsertId();
        }
        
        // Send email notification (don't fail form submission if email fails)
        $emailSent = false;
        try {
            $emailSent = sendEnquiryEmail($data, $enquiryId);
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            // Continue even if email fails - form submission was successful
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Form submitted successfully',
            'enquiry_id' => $enquiryId,
            'form_session_id' => $formSessionId,
            'email_sent' => $emailSent
        ]);
        
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    $debugMode = defined('DEBUG') && constant('DEBUG');
    echo json_encode([
        'success' => false,
        'error' => 'Database error occurred',
        'debug' => $debugMode ? $e->getMessage() : null
    ]);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    http_response_code(500);
    $debugMode = defined('DEBUG') && constant('DEBUG');
    echo json_encode([
        'success' => false,
        'error' => 'An error occurred',
        'debug' => $debugMode ? $e->getMessage() : null
    ]);
}

