<?php

function obtener_parametro($parametro, $array)
{
    return isset($array[$parametro]) ? trim($array[$parametro]) : null;
}

function conectar($sgbd, $server, $dbname, $user, $password)
{
    return new PDO("$sgbd:host=$server;dbname=$dbname", $user, $password);
}
