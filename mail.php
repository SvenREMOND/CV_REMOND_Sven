<?php
require './mailer/mailFunction.php';

$datas = [
    'HOST' => ['host' => 'mail.sven-remond.fr', 'username' => 'site.cv@sven-remond.fr', 'password' => 'Sven27**'],
    'FROM' => ['mail' => 'site.cv@sven-remond.fr', 'name' => 'Site CV'],
    'TO' => ['mail' => 'sven@sven-remond.fr', 'name' => 'Sven']
];

$object = $_POST['object'];

$message = $_POST['message'] . "\n\n de " . strtoupper($_POST['lastname']) . " " . $_POST['firstname'] . "\nMail : " . $_POST['email'];

$mail = ['Subject' => $object, 'Message' => $message];

sendMail($datas, $mail);

header('Location: ./index.html');
exit();
