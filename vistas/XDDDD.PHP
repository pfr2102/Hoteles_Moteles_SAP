<?php

$password = "2102";
//$hash = password_hash($password, PASSWORD_DEFAULT);
$hash = hash("SHA256", $password);
echo "La contraseña '2102' en hash es: ".$hash;

?>