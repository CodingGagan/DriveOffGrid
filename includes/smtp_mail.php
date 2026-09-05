<?php
/**
 * Simple SMTP Email Function
 * Sends email using SMTP with SSL (Port 465)
 */

function sendSMTPEmail($to, $subject, $htmlMessage, $fromEmail = 'hello@driveoffgrid.com', $fromName = 'DriveOffGrid') {
    // SMTP Configuration
    $smtpHost = 'smtp.hostinger.com';
    $smtpPort = 465;
    $smtpUsername = 'hello@driveoffgrid.com';
    $smtpPassword = '6r=bll^?rK'; // TODO: Add your email password here
    
    // If password is not configured, log error and return false
    if (empty($smtpPassword)) {
        error_log('SMTP Error: Email password not configured in includes/smtp_mail.php');
        return false;
    }
    
    try {
        // Create SSL socket connection
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        
        $socket = @stream_socket_client(
            "ssl://{$smtpHost}:{$smtpPort}",
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT,
            $context
        );
        
        if (!$socket) {
            error_log("SMTP Connection failed: $errstr ($errno)");
            return false;
        }
        
        // Read server greeting
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) != '220') {
            error_log("SMTP Error: $response");
            fclose($socket);
            return false;
        }
        
        // Send EHLO
        fputs($socket, "EHLO " . $smtpHost . "\r\n");
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) == ' ') break;
        }
        
        // Authenticate
        fputs($socket, "AUTH LOGIN\r\n");
        $response = fgets($socket, 515);
        
        fputs($socket, base64_encode($smtpUsername) . "\r\n");
        $response = fgets($socket, 515);
        
        fputs($socket, base64_encode($smtpPassword) . "\r\n");
        $response = fgets($socket, 515);
        
        if (substr($response, 0, 3) != '235') {
            error_log("SMTP Authentication failed: $response");
            fclose($socket);
            return false;
        }
        
        // Set sender
        fputs($socket, "MAIL FROM: <" . $fromEmail . ">\r\n");
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) != '250') {
            error_log("SMTP MAIL FROM failed: $response");
            fclose($socket);
            return false;
        }
        
        // Set recipient
        fputs($socket, "RCPT TO: <" . $to . ">\r\n");
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) != '250') {
            error_log("SMTP RCPT TO failed: $response");
            fclose($socket);
            return false;
        }
        
        // Send data
        fputs($socket, "DATA\r\n");
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) != '354') {
            error_log("SMTP DATA failed: $response");
            fclose($socket);
            return false;
        }
        
        // Email headers and body
        $headers = "From: " . $fromName . " <" . $fromEmail . ">\r\n";
        $headers .= "Reply-To: " . $fromEmail . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Date: " . date('r') . "\r\n";
        
        fputs($socket, "Subject: " . $subject . "\r\n");
        fputs($socket, $headers);
        fputs($socket, "\r\n");
        fputs($socket, $htmlMessage . "\r\n");
        fputs($socket, ".\r\n");
        
        $response = fgets($socket, 515);
        
        // Quit
        fputs($socket, "QUIT\r\n");
        fclose($socket);
        
        if (substr($response, 0, 3) == '250') {
            return true;
        } else {
            error_log("SMTP Send failed: $response");
            return false;
        }
        
    } catch (Exception $e) {
        error_log("SMTP Exception: " . $e->getMessage());
        return false;
    }
}
