<?php

function conectar()
{

    return new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
}


function add_error(string $msg)
{
    if (!isset($_SESSION['errores'])) {
        $_SESSION['errores'] = [];
    }
    $_SESSION['errores'][] = $msg;
}


function add_success(string $msg)
{
    if (!isset($_SESSION['success'])) {
        $_SESSION['success'] = [];
    }
    $_SESSION['success'][] = $msg;
}

function obtener_get($par)
{
    return isset($_GET[$par]) ? $_GET[$par] : NULL;
}

function obtener_post($par)
{
    return isset($_POST[$par]) ? $_POST[$par] : NULL;
}

function ir_index()
{
    return header('Location: index.php');
}

function buscar_departamento_por_codigo($codigo, ?PDO $pdo = null)
{
    if ($pdo === null) {
        $pdo = conectar();
    }
    $sent = $pdo->prepare('SELECT * FROM departamentos WHERE codigo= :codigo');
    $sent->execute([':codigo' => $codigo]);
    return $sent->fetch();
}

// FUNCIONES DE FILTRADO

function comprueba_codigo($codigo, ?PDO $pdo = null, $id = null)
{
    if ($codigo === '') {
        add_error('El código no puede estar vacío.');
    }

    if ($codigo === null) {
        add_error('El valor del código no puede ser nulo.');
    }

    if (mb_strlen($codigo) > 2) {
        add_error('El número es demasiado largo');
    }

    if (!ctype_digit($codigo)) {
        add_error('El código tiene un formato incorrecto. Debe ser un número entero');
    }

    $errores = $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : false;
    if (!$errores) {
        $departamento = buscar_departamento_por_codigo($codigo, $pdo);
        if ($departamento) {
            if ($id == null || $id != null && $departamento['id'] != $id) {
                add_error('Ya existe un departamento con ese código');
            }
        }
    }
}


function comprueba_denominacion($denominacion)
{

    if ($denominacion === null) {
        add_error('El tipo de dato de denominación no es válido');
    }

    if ($denominacion === '') {
        add_error('La denominación no puede estar vacía');
    }

    $longitud = mb_strlen($denominacion);
    if ($longitud > 255) {
        add_error('La longitud de la denominación es demasiado larga');
    }
}


function comprueba_localidad(&$localidad)
{
    if ($localidad != null && mb_strlen($localidad) > 255) {
        add_error('La longitud de la localidad es demasiado larga');
    }

    if ($localidad === '') {
        $localidad = null;
    }
}
