<?php

function conectar($sgbd, $server, $db_name, $user, $password)
{

    return new PDO("$sgbd:host=$server;dbname=$db_name, $user, $password");
}
