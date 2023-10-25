<?php
// Iniciando la sesión
session_start();

// Restableciendo la variable de sesión global a un array vacío, esencialmente vaciando la sesión
$_SESSION = [];

// Obteniendo los parámetros de la cookie de sesión
$params = session_get_cookie_params();

// Estableciendo una cookie de sesión vacía para invalidar la sesión en el navegador
setcookie(
    session_name(),  // Nombre de la cookie de sesión
    '',              // Valor vacío
    1,               // Tiempo de expiración en el pasado
    $params['path'], // Ruta de la cookie
    $params['domain'], // Dominio de la cookie
    $params['secure'], // Si la cookie es segura (HTTPS)
    $params['httponly'] // Si la cookie es accesible sólo a través de HTTP (no JavaScript)
);

// Destruyendo la sesión en el servidor
session_destroy();

// Redirigiendo al usuario a la página de login
header('Location: /usuarios/login.php');
