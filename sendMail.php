<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once("encrypt.class.php");

require 'vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer(true);

// SMTP Configuration
$mail->isSMTP();
$mail->Host       = $_ENV['SMTP_HOST'];
$mail->SMTPAuth   = true;
$mail->Username   = $_ENV['SMTP_USER'];
$mail->Password   = $_ENV['SMTP_PASS'];
$mail->SMTPSecure = $_ENV['SMTP_SECURE'];
$mail->Port       = $_ENV['SMTP_PORT'];

// Sender & Recipient
$mail->setFrom('firma@gmail.com', 'Firma');
$mail->addAddress('michaldrotar14@gmail.com', 'Ja');

// Email Content
$mail->isHTML(true);
$mail->Subject = 'Pozretie projektu';
$mail->Body    = '<h1>Niekto si pozrel projekt</p>';

// Send email
setcookie("sent", true, time() + 3600, "/");
$mail->send();


?>
