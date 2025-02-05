<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once("encrypt.class.php");

require 'vendor/autoload.php'; 

$mail = new PHPMailer(true);
$enc = new Encrypt();

// SMTP Configuration
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'michaldrotar14@gmail.com'; 
$mail->Password   = '?xWYpR]x*eOIA3x0u]5-215<];;(EMn45DbwU$270210rmZ:7UN*,S264215HG|Xz?WytDK_WnJ278210=oF<P2PaCI27917vd2D?&u28817@DoS.I%28215:L;(-2842100u]5-dHy-#26516BlD<BD280212}1=cCIxRUr(j288211_O(8x7N+|}T28717T&=m>!B275214ou3oWa%R(S->uM270211b V!T-|rpJO264213T<G)x5Pte!.&R2882115C8(pYn]B)t28216<?1x<n27516SBjil^263171pN{Kr|284TG,31AH:XkNMXbP';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

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
