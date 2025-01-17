<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';
$citizenship = isset($_POST['citizenship']) ? $_POST['citizenship'] : '';
$language = isset($_POST['language']) ? $_POST['language'] : '';
$whatsapp = isset($_POST['whatsapp']) ? $_POST['whatsapp'] : '';
$telegram = isset($_POST['telegram']) ? $_POST['telegram'] : '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; 
    $mail->Username = $_ENV['HOSTINGER_EMAIL']; 
    $mail->Password = $_ENV['HOSTINGER_PASSWORD'];

    $mail->setFrom($_ENV['HOSTINGER_EMAIL'], 'Your Name'); 
    $mail->addAddress($_ENV['HOSTINGER_EMAIL_TO'], 'Client Name'); 

    $mail->isHTML(true);
    $mail->Subject = 'Test Email from movetogeorgia.ge';
    $mail->Body = "
        <strong>Name:</strong> $name<br>
        <strong>Email:</strong> $email<br>
        <strong>Citizenship:</strong> $citizenship<br>
        <strong>Language:</strong> $language<br>
        <strong>WhatsApp:</strong> $whatsapp<br>
        <strong>Telegram:</strong> $telegram<br>
        <strong>Message:</strong><br>$message
    ";

    if ($mail->send()) {
        header("Location: thanks.php");
        exit();
    } else {
        echo 'Message could not be sent.';
    }

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
