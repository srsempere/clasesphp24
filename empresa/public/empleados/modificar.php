<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar empleado</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';

    if (!isset($_GET['id'])) {
        add_error('No se ha enviado ningún empleado válido.');
        header('Location: index.php');
        exit();
    }
    $pdo = conectar();

    $id_empleado = isset($_GET['id']) ? $_GET['id'] : null;

    if (isset($id_empleado)) {
        $_SESSION['id_empleado'] = $id_empleado;
    }

    // Comprobar que existe un empleado con ese id.
    $sent = $pdo->prepare('SELECT COUNT(*) FROM empleados WHERE id=:id_empleado');
    $sent->execute([':id_empleado' => $id_empleado]);
    $coincidencias = $sent->fetchColumn();

    if ($coincidencias === 0) {
        add_error('El empleado introducido no existe en la base de datos');
        header('Location: index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!validar_csrf()) {
            return ir_index();
        }
        $id_empleado = $_SESSION['id_empleado'];
        unset($_SESSION['id_empleado']);

        $numero = isset($_POST['numero']) ? $_POST['numero'] : null;
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
        $salario = isset($_POST['salario']) ? $_POST['salario'] : null;
        $id_departamento = isset($_POST['id_departamento']) ? $_POST['id_departamento'] : null;

        comprueba_numero($numero, ['id' => $id_empleado]);
        comprueba_nombre($nombre);
        comprueba_apellidos($apellidos);
        comprueba_salario($salario);
        comprueba_departamento($id_departamento);

        $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : false;

        if (!$errores) {
            $sent = $pdo->prepare('UPDATE empleados
                                   SET numero= :numero, nombre= :nombre, apellidos= :apellidos, salario= :salario, departamento_id= :id_departamento
                                   WHERE id = :id_empleado');
            $sent->execute([
                ':numero' => $numero,   //TODO: Se tiene que poder modificar también el departamento.
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':salario' => $salario,
                ':id_departamento' => $id_departamento,
                ':id_empleado' => $id_empleado,
            ]);
            add_success('Registro de empleado actualizado correctamente.');
            ir_index();
        } else {
            ir_index();
        }
    }

    $departamentos = $pdo->query('SELECT * FROM departamentos');
    $sent = $pdo->prepare('SELECT * FROM empleados WHERE id= :id ORDER BY numero');
    $sent->execute([':id' => $id_empleado]);
    ?>

    <?php foreach ($sent as $empleado) : ?>
        <?php
        $fmt = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
        ?>
        <form action="" method="post">
            <?php campo_csrf() ?>
            <label for="numero">Nº de empleado</label>
            <input type="text" name="numero" id="numero" value="<?= hh($empleado['numero']) ?>">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= hh($empleado['nombre']) ?>">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" value="<?= hh($empleado['apellidos']) ?>">
            <label for="salario">Salario</label>
            <?php
            $salario = isset($empleado['salario'])
                ? $fmt->formatCurrency($empleado['salario'], 'EUR')
                : '';
            ?>
            <input type="text" name="salario_formateado" id="salario_formateado" value="<?= hh($salario) ?>" disabled>
            <input type="text" name="salario" id="salario" value="<?= hh($empleado['salario']) ?>">
            <select name="id_departamento" id="id_departamento">
                <?php foreach ($departamentos as $departamento) : ?>
                    <option value="<?= hh($departamento['id']) ?>"><?= hh($departamento['denominacion']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Modificar</button>
        </form>
    <?php endforeach; ?>
    <a href="index.php">Volver a empleados</a>
</body>

</html>
