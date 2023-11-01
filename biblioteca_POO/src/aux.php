<?php

function conectar()
{
    return new PDO("pgsql:host=localhost;dbname=biblioteca", 'biblioteca', 'biblioteca');
}
