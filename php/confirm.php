<?php
require_once("./module/Database.php");

$verificationId = $_GET["verificationid"];

$database = new Database();
$database -> ConfirmUserRegistration($verificationId);

echo "Success fully confirmed the e-mail address.";
?>