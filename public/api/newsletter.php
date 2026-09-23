<?php
// CORS headers for local testing and cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read JSON data
    $data = json_decode(file_get_contents("php://input"), true);
    $email = htmlspecialchars(strip_tags($data['email'] ?? ''));

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Valid email is required."]);
        exit;
    }

    $file = 'subscribers.txt';

    // Create the file if it doesn't exist
    if (!file_exists($file)) {
        file_put_contents($file, "");
    }

    $current = file_get_contents($file);
    
    // Check if email already exists
    if (strpos($current, $email) !== false) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Email already subscribed."]);
        exit;
    }

    // Append email
    $current .= $email . "\n";
    file_put_contents($file, $current);

    /* =========================================================================
       SMTP CONFIGURATION for Welcome Email (Fill in these slots)
       ========================================================================= */
       
    // 1. Where should YOU receive notifications about new subscribers?
    $admin_email = "hello@zihconsultancy.com"; 

    // 2. SMTP Server Credentials
    $smtp_host = "smtp.hostinger.com"; 
    $smtp_username = "no-reply@yourdomain.com"; // Your sending email address
    $smtp_password = "YOUR_EMAIL_PASSWORD_HERE"; // Password
    $smtp_port = 465; 

    // HTML Email Template for Subscriber
    $message = "
    <html>
    <head>
      <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f5; padding: 30px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(to right, #8b5cf6, #d946ef); padding: 30px 20px; text-align: center; color: #ffffff; font-size: 28px; font-weight: bold; }
        .content { padding: 40px 30px; color: #334155; line-height: 1.6; text-align: center; font-size: 16px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; background-color: #f8fafc; }
      </style>
    </head>
    <body>
      <div class='container'>
        <div class='header'>Welcome to ZIH Consultancy</div>
        <div class='content'>
          <p>Thank you for subscribing to our newsletter!</p>
          <p>We're thrilled to have you with us. You'll now be the first to receive our latest insights, strategies, and updates on how to build a meaningful brand and drive growth.</p>
          <p style='margin-top: 30px; font-weight: bold;'>- The ZIH Team</p>
        </div>
        <div class='footer'>You received this email because you subscribed on our website.</div>
      </div>
    </body>
    </html>
    ";

    // Email Template for Admin Notification
    $admin_subject = "New Newsletter Subscriber!";
    $admin_message = "Great news! You have a new newsletter subscriber.\n\nSubscriber Email: $email\n\nThis email has automatically been saved to your subscribers.txt file.";

    // -------------------------------------------------------------------------
    // IF USING PHPMAILER (Recommended):
    // -------------------------------------------------------------------------
    
    /*
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_username;
        $mail->Password   = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $smtp_port;

        // 1. Send Welcome Email to Subscriber
        $mail->setFrom($smtp_username, 'ZIH Marketing');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Welcome to the ZIH Newsletter";
        $mail->Body    = $message;
        $mail->send();

        // 2. Send Notification to Admin
        $mail->clearAddresses();
        $mail->addAddress($admin_email);
        $mail->isHTML(false);
        $mail->Subject = $admin_subject;
        $mail->Body    = $admin_message;
        $mail->send();

    } catch (Exception $e) {
        // Silently fail the email, but still return success for the subscription
    }
    */
    
    // -------------------------------------------------------------------------
    // FALLBACK: BASIC MAIL() (Currently active)
    // -------------------------------------------------------------------------
    $subject = "Welcome to the ZIH Newsletter";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: " . $smtp_username . "\r\n"; 
    
    // 1. Send Welcome Email to Subscriber
    @mail($email, $subject, $message, $headers);

    // 2. Send Notification to Admin
    $admin_headers = "From: " . $smtp_username . "\r\n";
    $admin_headers .= "Reply-To: $email\r\n";
    @mail($admin_email, $admin_subject, $admin_message, $admin_headers);

    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "Subscribed successfully."]);
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed."]);
}
?>
