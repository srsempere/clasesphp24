<?php
session_start();

use App\Tablas\Libro;

require '../../vendor/autoload.php';

$id = obtener_post('id');

if (!isset($id)) {
    return volver_admin();
}

$pdo = conectar();

$libro = Libro::obtener($id);

if (isset($libro)) {
    $libro->borrar($pdo);
}

return volver_admin();
