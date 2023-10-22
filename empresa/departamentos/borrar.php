<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar departamento</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';

    $pdo = conectar();
    $id_departamento = isset($_GET['id']) ? trim($_GET['id']) : null;
    $denominacion = isset($_GET['denominacion']) ? trim($_GET['denominacion']) : null;
    $_SESSION['id_departamento'] = $id_departamento;
    $_SESSION['denominacion'] = $denominacion;

    // Comprobar si existe el id_departamento y si no está, redirigir a index.php
    $sent = $pdo->prepare('SELECT * FROM departamentos WHERE id= :id_departamento');
    $sent->execute([':id_departamento' => $id_departamento]);

    if ($sent->rowCount() === 0) {
        # El departamento no existe. Redirigir a index.
        add_error('El departamento introducido no existe.');
        header('Location: index.php');
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_departamento = $_SESSION['id_departamento'];
        $denominacion = $_SESSION['denominacion'];

        if (isset($id_departamento)) {
            $id_departamento = trim($id_departamento);
            if (!ctype_digit($id_departamento)) {
                return ir_index();
            }
        }

        if (!validar_csrf()) {
            add_error('La acción no está permitida ya que la petición no proviene del formulario original');
            return ir_index();
        }

        // TODO: Implementar validaciones y saneados???

        // Comprobación si el departamento tiene a algún empleado.
        $sent = $pdo->prepare('SELECT * FROM empleados WHERE departamento_id= :id_departamento');
        $sent->execute(['id_departamento' => $id_departamento]);
        $coincidencias = $sent->fetchColumn();

        if (!$coincidencias) {
            error_log("El valor de coincidencias es falso. Procedo a borrar el departamento.");

            if (isset($id_departamento)) {
                $sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id_departamento');
                $sent->execute([':id_departamento' => $id_departamento]);
                error_log('He borrado el departamento');
                add_success('El departamento se ha borrado correctamente');
                header('Location: index.php');
            }
        } else {
            error_log("Hay empleados en el departamento.");
            add_error('No se puede borrar el departamento. Hay empleados registrados en él.');
            header('Location: index.php');
        }
    }

    if (!isset($id_departamento)) {
        header('Location: index.php');
    } else {
    ?>
        <form action="" method="post">
            <input type="hidden" name="id_departamento" value="<?= hh($id_departamento) ?>">
            <?php campo_csrf() ?>
            <label for="">¿Estás seguro que deseas borrar el registro de <?= hh($denominacion) ?>?</label><br><br>
            <button type="submit">Sí</button>
            <a href="index.php">No</a>
        </form>
    <?php
    }
    ?>
</body>

</html>
