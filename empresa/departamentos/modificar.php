<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Modifcación departamento</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';

    if (!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }

    $id_departamento = isset($_GET['id']) ? $_GET['id'] : null;
    $pdo = conectar();
    $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : null;

    $sent = $pdo->prepare('SELECT COUNT(*) FROM departamentos WHERE id= :id_departamento');
    $sent->execute([':id_departamento' => $id_departamento]);
    $coincidencias = $sent->fetchColumn();
    error_log("Coincidencias: $coincidencias");

    if ($coincidencias) { // El dpto. existe.

        $sent = $pdo->prepare('SELECT * FROM departamentos WHERE id= :id_departamento');
        $sent->execute([':id_departamento' => $id_departamento]);
    } else {
        add_error('El departamento introducido no existe.');
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
       $denominacion = isset($_POST['denominacion']) ? $_POST['denominacion'] : null;
       $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : null;
       $sent = $pdo->prepare('UPDATE departamentos
                                SET codigo= :codigo, denominacion= :denominacion, localidad= :localidad
                                WHERE id= :id');
       $sent->execute([
        ':codigo' => $codigo,
        ':denominacion'=> $denominacion,
        ':localidad' => $localidad,
        ':id' => $id_departamento
       ]);

       add_success('El departamento se ha modificado correctamente');
       header('Location: index.php');
       exit();
    }
    ?>
    <h1>Modificación de departamentos</h1>
    <?php foreach ($sent as $fila) : ?>
        <form action="" method="post">
            <label for="codigo">Código</label>
            <input type="text" name="codigo" id="codigo" value="<?= $fila['codigo'] ?>"><br>
            <label for="codigo">Denominación</label>
            <input type="text" name="denominacion" id="denominacion" value="<?= $fila['denominacion'] ?>"><br>
            <label for="localidad">Localidad</label>
            <input type="text" name="localidad" id="localidad" value="<?= $fila['localidad'] ?>"><br>
            <button type="submit">Modificar</button>
        </form><br>
        <a href="index.php">Volver a departamentos</a>
    <?php endforeach; ?>
    <?php
    if (isset($errores)) :
        unset($_SESSION['errores']);
        foreach ($errores as $error) :
    ?>
            <?= $error ?>
    <?php
        endforeach;
    endif;
    ?>
</body>

</html>
