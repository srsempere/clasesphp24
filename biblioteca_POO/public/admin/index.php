<?php session_start() ?>
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

    var_dump($_SESSION['login']);
    ?>

    INDEX DE ADMIN

    <?php require '../../src/_footer.php' ?>
    <script src="js/flowbite/flowbite.min.js"></script>
</body>

</html>
