<?php

// Mantener la sesión
session_start();
// Eliminar todas las variables de la sesión
$_SESSION = [];
// Gestión de la cookie
$params = session_get_cookie_params();
setcookie(
    session_name(),
    '',
    1,
    $params['path'],
    $params['domain'],
    $params['secure'],
    $params['httponly']
);
//Destruir la sesión
session_destroy();
header('Location: login.php');
