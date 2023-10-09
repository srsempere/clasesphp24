<?php
session_start();
require 'aux.php';

$nombre = obtener_parametro('nombre', $_POST);
$email = obtener_parametro('email' , $_POST);
$password = obtener_parametro('password', $_POST);

// Saneado
$nombre = sanea($nombre);
$email = sanea_email($email);

// Validaciń
