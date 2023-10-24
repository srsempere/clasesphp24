<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/style.css">
    <title>Tienda Online</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';
    $pdo = conectar();
    $libros = $pdo->query('SELECT * FROM Libros');
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    $fmt = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? $_POST['id'] : null;

        //TODO: Realizar comprobación de que el id existe.

        if (isset($id)) {
            $_SESSION['carrito'][] = $id;
        }
    }

    ?>
    <div class="volver"><a href="../biblioteca.php">Home</a></div>
    <h1>Bienvenidos a la tienda online</h1>
    <table>
        <thead>
            <th>Código</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro) : ?>
                <tr>
                    <?php
                    $precio = isset($libro['precio']) ? $fmt->formatCurrency($libro['precio'], 'EUR') : '';
                    ?>
                    <td><?= hh($libro['codigo']) ?></td>
                    <td><?= hh($libro['titulo']) ?></td>
                    <td><?= hh($libro['autor']) ?></td>
                    <td><?= hh($precio) ?></td>
                    <td><?= hh($libro['cantidad']) ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= hh($libro['id']) ?>">
                            <button type="submit">Añadir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (!empty($_SESSION['carrito'])): ?>
        <h2>Carrito de la compra</h2>
        <ul>
            <?php foreach($_SESSION['carrito'] as $key => $value): ?>
                <li><?= $value ?></li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>
</body>

</html>
