<?php

function obtener_parametro($parametro, $array)
{
    return isset($array[$parametro]) ? $array[$parametro] : false;
}

function conectar()
{
    return new PDO("pgsql:host=localhost;dbname=biblioteca", 'biblioteca', 'biblioteca');
}

function volver_biblioteca()
{
    return header('Location: biblioteca.php');
}

function añade_error($mensaje)
{
    if (!isset($_SESSION['errores'])) {
        $_SESSION['errores'] = [];
    }
    $_SESSION['errores'][] = $mensaje;
}

function añade_exitos($mensaje)
{
    if (isset($_SESSION['exitos'])) {
        $_SESSION['exitos'] = [];
    }
    $_SESSION['exitos'][] = $mensaje;
}

function hay_errores()
{
    if (isset($_SESSION['errores']) && count(obtener_parametro('errores', $_SESSION)) > 0) {
        return true;
    }
    return false;
}

function hh($cadena)
{
    if ($cadena === null) {
        return null;
    }
    return htmlspecialchars($cadena, ENT_QUOTES | ENT_SUBSTITUTE);
}

// FUNCIONES DE VALIDACIÓN Y SANEADO


function comprueba_codigo($codigo)
{
    if ($codigo === null) {
        añade_error('El tipo de dato del campo código no es correcto');
        return;
    }

    if ($codigo === '') {
        añade_error('El codigo no puede estar vacío');
        return;
    }

    if (!ctype_digit($codigo)) {
        añade_error('El codigo debe ser un número entero positivo');
    }
}

function comprueba_anyo_publicacion($anyo)
{
    if ($anyo === null) {
        añade_error('El tipo de datos del año no es correcto.');
        return;
    }

    if ($anyo === '') {
        añade_error('El campo año no puede estar vacío');
        return;
    }

    if (gettype($anyo) != 'boolean' && !ctype_digit($anyo)) {
        añade_error('El campo año debe ser un número entero positivo.');
    }
}

function comprobar_id($id, $tabla = null, ?PDO $pdo = null)
{
    if ($id === null) {
        return volver_biblioteca();
    }

    if ($id === '') {
        return volver_biblioteca();
    }

    if ($tabla !== null) {
        if ($pdo === null) {
            $pdo = conectar();
        }
        $sent = $pdo->prepare('SELECT COUNT(*) FROM :tabla WHERE id= :id');
        $sent->execute([
            ':tabla' => $tabla,
            ':id' => $id
        ]);
        $coincidencias = $sent->fetchColumn();
        if ($coincidencias === '0') {
            añade_error('No existe ningún departamento que coincida con el seleccionado');
        }
    }
}
