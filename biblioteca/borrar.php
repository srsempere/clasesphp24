<?php
session_start();
require 'aux.php';

if (!isset($_GET['id'])) {
    return volver_biblioteca();
}


$id = obtener_parametro('id', $_GET);
comprobar_id($id);
$titulo = obtener_parametro('titulo', $_GET);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('Entro aquí');
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    comprobar_id($id);
    $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : false;

    if (!$errores) {

        if (isset($id)) {
            $sql = 'DELETE FROM libros WHERE id= :id';
            $pdo = conectar('pgsql', 'localhost', 'biblioteca', 'biblioteca', 'biblioteca');
            $sent = $pdo->prepare($sql);
            $sent->execute([':id' => $id]);
            añade_exitos('El libro se ha borrado correctamente');
            return volver_biblioteca();
        } else {
            return volver_biblioteca();
        }
    } else {
        return volver_biblioteca();
    }
}

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
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= hh($id) ?>">
        <label for="">¿Está seguro que desea borrar el título <?= hh($titulo) ?>?</label>
        <button type="submit">Sí</button>
        <a href="biblioteca.php">No</a>
    </form>
</body>

</html>
