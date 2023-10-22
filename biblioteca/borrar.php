<?php

require_once 'aux.php';

$id = obtener_parametro('id', $_GET);
$titulo = obtener_parametro('titulo', $_GET);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <title>¿Desea borrarlo?</title>
</head>
<body>
    <form action="borrar_registro.php" method="post">
        <input type="hidden" name="id" value="<?= hh($id) ?>">
        <label for="">¿Está seguro que desea borrar el título <?= hh($titulo) ?>?</label>
        <button type="submit">Sí</button>
        <a href="biblioteca.php">No</a>
    </form>
</body>
</html>
