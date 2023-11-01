<?php
session_start();

require '../vendor/autoload.php';

$_SESSION = [];
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
session_destroy();
return volver_principal();
