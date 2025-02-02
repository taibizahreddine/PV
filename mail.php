<?php
// Import PHPMailer classes into the global namespace


// Include PHPMailer classes
require 'tppaw/PHPMailer/src/PHPMailer.php';
require 'tppaw/PHPMailer/src/SMTP.php';
require 'tppaw/PHPMailer/src/Exception.php';

// ... (the rest of your code)

$mail = new PHPMailer(true);

// ... (the rest of your code)

?>

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer();

// Server settings
$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
$mail->isSMTP(); // Send using SMTP
$mail->Host       = 'smtp.example.com'; // Set the SMTP server to send through
$mail->SMTPAuth   = true; // Enable SMTP authentication
$mail->Username   = 'ananini@gmail.com'; // SMTP username
$mail->Password   = 'sodn recr cmog lvos'; // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
$mail->Port       = 465; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

// Content format
$mail->isHTML(true); // Set email format to HTML
$mail->CharSet = 'UTF-8';

// Recipient
$mail->addAddress('recipient@example.com', 'Recipient Name');

// Email content
$mail->Subject = 'Subject of the Email';
$mail->Body    = 'Body of the Email';

// Send the email
if ($mail->send()) {
    echo 'Email sent successfully';
} else {
    echo 'Error: ' . $mail->ErrorInfo;
}
?>
