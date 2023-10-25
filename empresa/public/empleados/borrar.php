<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar empleado</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';
    $pdo = conectar();


    $id_empleado = isset($_GET['id']) ? $_GET['id'] : null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!validar_csrf()) {
            return ir_index();
        }

        // Comprobación de que el usuario existe.

        $sent = $pdo->prepare('SELECT COUNT(*) FROM empleados WHERE id= :id_empleado');
        $sent->execute([':id_empleado' => $id_empleado]);
        $coincidencias = $sent->fetchColumn();
        error_log($coincidencias);

        if ($coincidencias === 0) {
            add_error('El empleado introducido no existe');
            header('Location: index.php');
            exit();
        }

        // Borrado de empleado

        $sent = $pdo->prepare('DELETE FROM empleados
                                WHERE id= :id');
        $sent->execute([':id' => $id_empleado]);
        add_success('El empleado ha sido borrado correctamente');
        header('Location: index.php');
        exit();
    }

    ?>
    <h1>Eliminar empleado</h1>
    <form action="" method="post">
        <?php campo_csrf() ?>
        <label for="id">¿Está seguro que desea eliminar el empleado?</label>
        <a href="index.php">NO</a>
        <button type="submit">Sí</button>
    </form>
</body>

</html>
