<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
</head>

<body>
    <?php
    require 'aux.php';
    $pdo = conectar();
    $sent = $pdo->query('SELECT * FROM empleados');
    ?>
    <h1>Bienvenido a empleados</h1>
    <table border="1">
        <thead>
            <th>Nº</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Salario</th>
            <th>Fecha de alta</th>
        </thead>
        <tbody>
            <?php foreach ($sent as $empleado) : ?>
                <tr>
                    <td><?= $empleado['numero'] ?></td>
                    <td><?= $empleado['nombre'] ?></td>
                    <td><?= $empleado['apellidos'] ?></td>
                    <td><?= $empleado['salario'] ?></td>
                    <td><?= $empleado['fecha_alta'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
