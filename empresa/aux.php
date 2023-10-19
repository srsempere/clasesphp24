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
