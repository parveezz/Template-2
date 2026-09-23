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
    
    $name = htmlspecialchars(strip_tags($data['name'] ?? ''));
    $email = htmlspecialchars(strip_tags($data['email'] ?? ''));
    $message = htmlspecialchars(strip_tags($data['message'] ?? ''));

    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid email format."]);
        exit;
    }

    /* =========================================================================
       SMTP CONFIGURATION (Fill in these slots for Hostinger / your email provider)
       ========================================================================= */
       
    // 1. Where do you want to receive the contact form emails?
    $recipient_email = "hello@zihconsultancy.com"; 

    // 2. SMTP Server Credentials
    $smtp_host = "smtp.hostinger.com"; 
    $smtp_username = "no-reply@yourdomain.com"; // Your sending email address
    $smtp_password = "YOUR_EMAIL_PASSWORD_HERE"; // The password for the email above
    $smtp_port = 465; 

    // HTML Email Template
    $email_content = "
    <html>
    <head>
      <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f5; padding: 30px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #8b5cf6; padding: 20px; text-align: center; color: #ffffff; font-size: 24px; font-weight: bold; }
        .content { padding: 30px; color: #334155; line-height: 1.6; }
        .field { margin-bottom: 20px; }
        .label { font-size: 12px; text-transform: uppercase; color: #94a3b8; font-weight: bold; letter-spacing: 1px; margin-bottom: 5px; }
        .value { font-size: 16px; color: #0f172a; padding: 12px; background-color: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; }
      </style>
    </head>
    <body>
      <div class='container'>
        <div class='header'>New Contact Submission</div>
        <div class='content'>
          <div class='field'>
            <div class='label'>Name</div>
            <div class='value'>$name</div>
          </div>
          <div class='field'>
            <div class='label'>Email Address</div>
            <div class='value'>$email</div>
          </div>
          <div class='field'>
            <div class='label'>Message</div>
            <div class='value'>" . nl2br($message) . "</div>
          </div>
        </div>
        <div class='footer'>Sent from your website's contact form.</div>
      </div>
    </body>
    </html>
    ";

    // -------------------------------------------------------------------------
    // IF USING PHPMAILER (Recommended for SMTP):
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

        $mail->setFrom($smtp_username, 'Website Contact Form');
        $mail->addAddress($recipient_email);
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission from $name";
        $mail->Body    = $email_content;

        $mail->send();
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Message sent successfully."]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
    */
    
    // -------------------------------------------------------------------------
    // FALLBACK: BASIC MAIL() (Currently active)
    // -------------------------------------------------------------------------
    $subject = "New Contact Form Submission from $name";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: " . $smtp_username . "\r\n"; 
    $headers .= "Reply-To: $email\r\n";

    if (mail($recipient_email, $subject, $email_content, $headers)) {
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Message sent successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Failed to send message."]);
    }
    
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed."]);
}
?>
