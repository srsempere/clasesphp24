<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #555;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <?php
    $pdo = new PDO('pgsql:host=localhost;dbname=biblioteca', 'biblioteca', 'biblioteca');
    $sent = $pdo->query('SELECT * FROM libros');
    $codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : null;
    ?>
    <h1>Bienvenido a la biblioteca</h1>
</body>
<form action="" method="get">
    <label for="codigo">Introduce el código a buscar</label>
    <input type="text" name="codigo" id="codigo" value="<?= $codigo ?>">
    <button type="submit">Buscar</button>
</form>
<table>
    <thead>
        <th>Código</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Editorial</th>
        <th>Año de publicación</th>
        <th>ISBN</th>
        <th>Cantidad</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php foreach ($sent as $fila) : ?>
            <tr>
            <td><?= $fila['codigo'] ?></td>
            <td><?= $fila['titulo'] ?></td>
                <td><?= $fila['autor'] ?></td>
                <td><?= $fila['editorial'] ?></td>
                <td><?= $fila['anyo_publicacion'] ?></td>
                <td><?= $fila['isbn'] ?></td>
                <td><?= $fila['cantidad'] ?></td>
                <th><a href="eliminar.php">Eliminar</a></th>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</html>
