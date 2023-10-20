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


function buscar_empleado_por_numero($numero, ?PDO $pdo = null)
{
    if ($pdo == null) {
        $pdo = conectar();
    }

    $sent = $pdo->prepare('SELECT * FROM empleados WHERE numero= :numero');
    $sent->execute([':numero' => $numero]);
    return $sent->fetch();
}

function hh($cadena)
{
    return ($cadena === null) ? null : htmlspecialchars($cadena, ENT_QUOTES | ENT_SUBSTITUTE);
}

// FUNCIONES DE FILTRADO


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


function comprueba_numero($numero, ?PDO $pdo = null, $id = null)
{
    if ($numero === null) {
        add_error('El tipo de datos del campo número no es correcto.');
    }

    if ($numero === '') {
        add_error('El campo número no puede estar vacío');
    }

    if (mb_strlen($numero) > 4) {
        add_error('La longitud del número es demasiado grande');
    }

    $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : false;
    if (!$errores) {
        $empleado = buscar_empleado_por_numero($numero, $pdo);
        # Parte izquierda es para la creación y la derecha es para la modificación (update).
        if (($id == null && $empleado) || ($id != null && $empleado['id'] != $id)) {
            add_error('Ya existe un empleado con ese código');
        }
    }
}

function comprueba_nombre($nombre)
{
    if ($nombre === null) {
        add_error('El tipo de dato del campo nombre no es correcto');
    }

    if ($nombre === '') {
        add_error('El campo nombre no puede estar vacío');
    }

    if (mb_strlen($nombre) > 255) {
        add_error('El nombre es demasiado largo');
    }
}

function comprueba_apellidos(&$apellidos=null)
{
    if ($apellidos === '') {
        $apellidos = null;
        return;
    }

    if (mb_strlen($apellidos) > 255) {
        add_error('El apellido es demasiado largo');
    }
}

function comprueba_salario(&$salario)
{
    if ($salario === '') {
        $salario = null;
        return;
    }

    // Normalización
    if (str_contains($salario, ',')) {
        $salario = str_replace(',', '.', $salario);
    }



    if (filter_var($salario, FILTER_VALIDATE_FLOAT) === false) {
        add_error('El salario solamente puede contener números y un separador decimal');
        return;
    }

    $salario = floatval($salario);

    $partes = explode('.', (string)$salario);

    if (isset($partes[1]) && mb_strlen($partes[1]) > 2) {
        add_error('El salario solamente puede contener dos decimales');
    }

    if ($salario > 9999.999) {
        add_error('El salario es demasiado grande. Solamente puede contener cuatro dígitos enteros y dos decimales');
    }
}
