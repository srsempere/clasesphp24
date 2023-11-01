<?php

session_start();

use App\Tablas\Libro;
use App\Tablas\Usuario;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Principal de administrador</title>
</head>

<body>
    <?php
    require '../../vendor/autoload.php';
    require '../../src/_cabecera.php';
    require '../../src/_alerts.php';

    if ($usuario = Usuario::logueado()) {
        if (!$usuario->es_admin()) {
            $_SESSION['error'] = 'Acceso no autorizado';
            return volver_index_inicio();
        }
    }

    $id = obtener_post('id');

    if (!isset($id)) {
        return volver_admin();
    }

    $pdo = conectar();
    $libros = Libro::todos([], [], $pdo); //TODO: Usar el otro método
    ?>



    <?php require '../../src/_footer.php' ?>
    <script src="js/flowbite/flowbite.min.js"></script>
</body>

</html>
