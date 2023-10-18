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
