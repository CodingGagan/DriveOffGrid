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
        $required = ['first_name', 'email', 'phone', 'number_of_people', 'travel_month', 'message'];
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
        
        echo json_encode([
            'success' => true,
            'message' => 'Form submitted successfully',
            'enquiry_id' => $enquiryId,
            'form_session_id' => $formSessionId
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

