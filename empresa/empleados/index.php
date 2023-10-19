<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Empleados</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';
    $pdo = conectar();
    $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : null;
    $successes = isset($_SESSION['success']) ? $_SESSION['success'] : null;


    $sent = $pdo->query('SELECT e.*, d.denominacion
                            FROM empleados e
                            JOIN departamentos d
                            ON e.departamento_id = d.id
                            ORDER BY numero');
    ?>
    <h1>Bienvenido a empleados</h1>
    <table border="1">
        <thead>
            <th>Nº</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Salario</th>
            <th>Fecha de alta</th>
            <th>Departamento</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php
            $fmt = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
            ?>
            <?php foreach ($sent as $empleado) : ?>
                <tr>
                    <td><?= $empleado['numero'] ?></td>
                    <td><?= $empleado['nombre'] ?></td>
                    <td><?= $empleado['apellidos'] ?></td>
                    <?php
                        $salario = isset($empleado['salario'])
                                    ? $fmt->formatCurrency($empleado['salario'], 'EUR')
                                    : '' ;
                    ?>
                    <td><?= $salario ?></td>
                    <td><?= $empleado['fecha_alta'] ?></td>
                    <td><?= $empleado['denominacion'] ?></td>
                    <td>
                        <a href="borrar.php?id=<?= $empleado['id'] ?>">Eliminar</a>
                        <a href="modificar.php?id=<?= $empleado['id'] ?>">Modificar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="crear.php">Insertar nuevo empleado</a><br>
    <a href="../departamentos/index.php">Volver a departamentos</a>
    <?php
    if (isset($errores)) {
        unset($_SESSION['errores']);
        foreach ($errores as $error) : ?>
            <div class="errores">
                <?= $error ?>
            </div>
    <?php
        endforeach;
    }
    ?>
    <?php
    if (isset($successes)) {
        unset($_SESSION['success']);
        foreach ($successes as $success) : ?>
            <div class="success">
                <?= $success ?>
            </div>
    <?php
        endforeach;
    }
    ?>
</body>

</html>
