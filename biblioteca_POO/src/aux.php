<?php

function conectar()
{
    return new PDO("pgsql:host=localhost;dbname=biblioteca", 'biblioteca', 'biblioteca');
}


function obtener_post($campo)
{
    return isset($_POST[$campo]) ? $_POST[$campo] : null;
}

function volver_principal()
{
    return header('Location: principal.php');
}

function volver_admin()
{
    return header('Location: /admin/');
}

function volver_index_inicio()
{
    return header('Location: index.php');
}
