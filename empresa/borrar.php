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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($id)) {
            $pdo = conectar('pgsql', 'localhost', 'empresa', 'empresa', 'empresa');
            $sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
            $sent->execute([':id' => $id]);
            header('Location: departamentos.php');
        }
    }


    if (!isset($id)) {
        header('Location: departamentos.php');
    } else {
    ?>
        <form action="" method="post">
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
