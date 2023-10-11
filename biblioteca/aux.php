<?php

function obtener_parametro($parametro, $array)
{
    return isset($array[$parametro]) ? $array[$parametro] : null;
}

function conectar()
{
    return new PDO("pgsql:host=localhost;dbname=biblioteca", 'biblioteca', 'biblioteca');
}

function añade_error($mensaje)
{
    if (!isset($_SESSION['errores'])) {
        $_SESSION['errores'] = [];
    }
    $_SESSION['errores'][] = $mensaje;
    error_log("Error añadido: $mensaje");
}

function hay_errores()
{
    if (isset($_SESSION['errores']) && count(obtener_parametro('errores', $_SESSION)) > 0) {
        return true;
    }
    return false;
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

function email_existe($email, ?PDO $pdo = null)
{
    if ($pdo === null) {
        $pdo = conectar();
    }
    $sent = $pdo->prepare('SELECT 1 FROM usuarios WHERE email = :email');
    $sent->execute([':email' => $email]);
    return $sent->fetchColumn() ? true : false;
}

function valida_texto($string)
{
    return !empty($string) && preg_match('/^[\p{L}\s]+$/u', $string);
}

function valida_longitud(string $cadena, int $longitud)
{
    if (!(mb_strlen($cadena) >= 1 && mb_strlen($cadena) <= $longitud)) {
        return false;
    }
    return true;
}

function es_vacio(string $cadena)
{
    return $cadena === '';
}

function es_nulo(string $cadena)
{
    return $cadena === null;
}

function existe($cadena)
{
    return isset($cadena);
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

function cifra_password($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

// VALIDACIONES DE CAMPOS

function valida_nombre(string $nombre)
{
    if (es_vacio($nombre)) {
        añade_error('El campo nombre no puede estar vacío.');
    }

    if (es_nulo($nombre)) {
        añade_error('El campo nombre no puede ser nulo.');
    }

    if (!valida_longitud($nombre, 255)) {
        añade_error('La longitud del nombre no es correcta.');
    }
    return !hay_errores();
}

function valida_email(string $email)
{
    if (es_vacio($email)) {
        añade_error('El campo email no puede estar vacío.');
    }

    if (es_nulo($email)) {
        añade_error('El campo email no puede ser nulo.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        añade_error('El formato del email no es válido');
    }

    if (!valida_longitud($email, 255)) {
        añade_error('La longitud del email no es correcta.');
    }

    if (email_existe($email)) {
        error_log("Email existe: $email");
        añade_error('El email ya existe');
    }
    return !hay_errores();
}

function valida_password(string $password)
{
    if (es_vacio($password)) {
        añade_error('El campo contraseña no puede estar vacío.');
    }

    if (es_nulo($password)) {
        añade_error('El campo contraseña no puede ser nulo.');
    }

    if (!valida_longitud($password, 255)) {
        añade_error('La longitud de la contraseña no es correcta.');
    }
    return !hay_errores();
}
