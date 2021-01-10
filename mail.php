<?php

$to = "sven@sven-remond.fr";

$object = $_POST['object'];

$message = $_POST['message'] . "\n\n de " . strtoupper($_POST['lastname']) . " " . $_POST['firstname'] . "\nMail : " . $_POST['email'];

mail($to, $object, $message);

header('Location: ./index.html');
exit();
