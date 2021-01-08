<?php

$to = "sven.remond.sti2@gmail.com";

$object = $_POST['object'];

$message = $_POST['message'] . "\n\n de " . strtoupper($_POST['lastname']) . " " . $_POST['firstname'] . "\nMail : " . $_POST['email'];

mail($to, $object, $message);

header('Location: ./index.html');
exit();
