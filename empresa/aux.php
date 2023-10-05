<?php

function conectar($sgbd, $server, $db_name, $user, $password)
{

    return new PDO("$sgbd:host=$server;dbname=$db_name", $user, $password);
}


function obtener_parametro($par, $array)
{
    return isset($array[$par]) ? trim($array[$par]) : null;
}
