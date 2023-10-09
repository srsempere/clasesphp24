<?php

function obtener_parametro($parametro, $array)
{
    return isset($array[$parametro]) ? $array[$parametro] : null;
}

function conectar($sgbd, $server, $dbname, $user, $password)
{
    return new PDO("$sgbd:host=$server;dbname=$dbname", $user, $password);
}

function añade_error($mensaje)
{
    if (!isset($_SESSION['errores'])) {
        $_SESSION['errores'] = [];
    }
    $_SESSION['errores'][] = $mensaje;
}

// FUNCIONES DE SANEADO

function sanea($string)
{
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

function sanea_email($email)
{
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}

// FUNCIONES DE VALIDACIÓN

function valida_texto($string)
{
    return !empty($string) && preg_match('/^[\p{L}\s]+$/u', $string);
}

function valida_enteros($num)
{
    return filter_var($num, FILTER_VALIDATE_INT) !== false;
}

# para este caso solamente voy a aceptar números de 13 dígigos
function valida_isbn($isbn)
{
    return preg_match('/\d{13}/', $isbn);
}
