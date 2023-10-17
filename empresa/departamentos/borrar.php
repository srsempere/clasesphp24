<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar departamento</title>
</head>

<body>
    <?php
    require_once '../aux.php';

    $pdo = conectar();
    $id = obtener_parametro('id', $_GET);
    $denominacion = obtener_parametro('denominacion', $_GET);

    // TODO: Aquí falta comprrobar si existe el id y si no está, redirigir a index.php
    // TODO: Comprobar primero si el departamento existe con una consulta SELECT.

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //TODO: Comprobar primero si en ese departamento existe algún empleado dado de alta y si es así, indicar al usuario que no se puede borrar dicho departamento.

        if (isset($id)) {
            $sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
            $sent->execute([':id' => $id]);
            header('Location: index.php');
            error_log("Llego aquí");
        }
    }

    if (!isset($id)) {
        header('Location: index.php');
    } else {
    ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label for="">¿Estás seguro que deseas borrar el registro de <?= $denominacion ?>?</label><br><br>
            <button type="submit">Sí</button>
            <a href="index.php">No</a>
        </form>
    <?php
    }
    ?>
</body>

</html>
