<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require './mailer/phpMailer/src/Exception.php';
require './mailer/phpMailer/src/PHPMailer.php';
require './mailer/phpMailer/src/SMTP.php';

/* $datas = [
    'HOST' => ['host' => 'host SMTP', 'username' => 'user SMTP', 'password' => 'password SMTP'],
    'FROM' => ['mail' => '@mail', 'name' => 'name'],
    'TO' => ['mail' => '@mail', 'name' => 'name']
];

$info = ['Subject' => 'Objet', 'Message' => 'mail']; */

function sendMail($datas, $info)
{
    $mail = new PHPMailer(true);

    //Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = $datas['HOST']['host'];                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $datas['HOST']['username'];                     // SMTP username
    $mail->Password   = $datas['HOST']['password'];                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($datas['FROM']['mail'], $datas['FROM']['name']);
    $mail->addAddress($datas['TO']['mail'], $datas['TO']['name']);     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $info['Subject'];
    $mail->Body    = $info['Message'];

    $mail->send();
}