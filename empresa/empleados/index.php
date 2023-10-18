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
            <?php foreach ($sent as $empleado) : ?>
                <tr>
                    <td><?= $empleado['numero'] ?></td>
                    <td><?= $empleado['nombre'] ?></td>
                    <td><?= $empleado['apellidos'] ?></td>
                    <td><?= $empleado['salario'] ?></td>
                    <td><?= $empleado['fecha_alta'] ?></td>
                    <td><?= $empleado['denominacion'] ?></td>
                    <td><a href="borrar.php?id=<?= $empleado['id'] ?>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
