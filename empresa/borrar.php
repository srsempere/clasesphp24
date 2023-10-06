<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar departamento</title>
</head>
<body>
    <?php
    require_once 'aux.php';
        $id = obtener_parametro('id', $_GET);
        $denominacion = obtener_parametro('denominacion', $_GET);

        if (!isset($id)) {
            header('Location: departamentos.php');
        } else {
            ?>
            <form action="borrar_registro.php" method="post">
                <input type="hidden" name="id" value="<?= $id ?>">
            <label for="">¿Estás seguro que deseas borrar el registro de <?= $denominacion ?>?</label><br><br>
            <button type="submit">Sí</button>
            <a href="departamentos.php">No</a>
            </form>
            <?php
        }
    ?>
</body>
</html>
