<?php

function conectar()
{

    return new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
}


function obtener_parametro($par, $array)
{
    return isset($array[$par]) ? trim($array[$par]) : null;
}
