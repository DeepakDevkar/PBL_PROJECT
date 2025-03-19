<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer library
require 'C:/xampp/htdocs/css/PHPMailer-master/src/Exception.php';
require 'C:/xampp/htdocs/css/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/htdocs/css/PHPMailer-master/src/SMTP.php';

//C:\Users\ADMIN\Documents\GitHub\PBL_PROJECT\PHPMailer-master

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Server settings for Gmail SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'deepakdevkar60@gmail.com';  // Your Gmail email address
        $mail->Password = 'knmh xuiq wtne wsuz';  // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('deepakdevkar60@gmail.com', 'Inance');
        $mail->addAddress('deepakdevkar60@gmail.com'); // Add your email as recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Submission from ' . $name;
        $mail->Body = "<h3>Contact Information</h3>
                        <p><strong>Name:</strong> $name</p>
                        <p><strong>Phone:</strong> $phone</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Message:</strong> $message</p>";

        // Send the email
        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}
?>
