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
    $libros = $pdo->query('SELECT * FROM libros')->fetchAll();


    $fmt = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = isset($_POST['id']) ? $_POST['id'] : null;

        $vaciar = isset($_POST['vaciar']) ? $_POST['vaciar'] : false;

        if ($vaciar) {
            $_SESSION['carrito'] = 0;
        }

        if (isset($id)) {

            $add = isset($_POST['add']);
            $remove = isset($_POST['remove']);

            if ($add || $remove) {
                // Añadir a la cesta y restar del stock.
                if (!isset($_SESSION['carrito'][$id])) {
                    $_SESSION['carrito'][$id] = 0;
                }

                if ($add) {
                    $_SESSION['carrito'][$id]++;
                } elseif ($remove && $_SESSION['carrito'][$id] > 0) {
                    $_SESSION['carrito'][$id]--;
                }

                // Si la cantidad es 0, eliminar el artículo del carritgit o
                if ($_SESSION['carrito'][$id] === 0) {
                    unset($_SESSION['carrito'][$id]);
                }

            }
        }
    }

    ?>
    <div class="volver"><a href="../biblioteca.php">Home</a></div>
    <?php

    if (!empty($_SESSION['login'])) {
        cabecera();
    } else {
        cabecera_login();
    }


    ?>
    // ! TABLA PRESENTACIÓN DE PRODUCTOS
    <h1>Bienvenidos a la tienda online</h1>
    <table border="1">
        <thead>
            <th>Código</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Total artículo</th>
        </thead>
        <tbody>
            <?php //! PRUEBAS, LUEGO BORRAR



            ?>
            <?php foreach ($libros as $libro) : ?>
                <tr>
                    <?php
                    $precio = isset($libro['precio']) ? $fmt->formatCurrency($libro['precio'], 'EUR') : '';
                    ?>
                    <td><?= hh($libro['codigo']) ?></td>
                    <td><?= hh($libro['titulo']) ?></td>
                    <td><?= hh($libro['autor']) ?></td>
                    <td><?= hh($precio) ?></td>
                    <td><?= isset($_SESSION['carrito'][$libro['id']]) ?

                            (($libro['stock'] - $_SESSION['carrito'][$libro['id']]) > 0 ? $libro['stock'] - $_SESSION['carrito'][$libro['id']] : 0)

                            : $libro['stock'] ?></td>

                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= hh($libro['id']) ?>">
                            <input type="hidden" name="add" value="add">
                            <button type="submit">Añadir</button>
                        </form>
                        <br>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= hh($libro['id']) ?>">
                            <input type="hidden" name="remove" value="remove">
                            <button type="submit" class="vaciar">Quitar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (!empty($_SESSION['carrito'])) : ?>
    <?php
    $Total_BI = 0;
    $Total_IVA = 0;
    $Total_pedido = 0;
    ?>

    // ! CARRITO DE LA COMPRA
    <h2 class="carrito-titulo">Carrito de la compra</h2>

    <div class="carrito-section">
        <table border="0">
            <thead>
                <th>Artículo</th>
                <th>Cantidad</th>
                <th>Base Imponible</th>
                <th>IVA (4%)</th>
                <th>Total Artículo</th>
            </thead>
            <tbody>
            <?php
            foreach ($_SESSION['carrito'] as $id => $cantidad) :
                $sent = $pdo->prepare('SELECT * FROM libros WHERE id = :id');
                $sent->execute([':id' => $id]);
                $libro = $sent->fetch();
                $bi = $libro['precio'] * $cantidad;
                $iva = $bi * 0.04;
                $total = $bi + $iva;
                $Total_BI += $bi;
                $Total_IVA += $iva;
                $Total_pedido += $total;
                ?>
                <tr>
                    <td><?= hh($libro['titulo']) ?></td>
                    <td><?= hh($cantidad) ?></td>
                    <td><?= hh($fmt->formatCurrency($bi, 'EUR')) ?></td>
                    <td><?= hh($fmt->formatCurrency($iva, 'EUR')) ?></td>
                    <td><?= hh($fmt->formatCurrency($total, 'EUR')) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <h1>Total Base Imponible: <?= hh($fmt->formatCurrency($Total_BI, 'EUR')) ?> Total IVA: <?= hh($fmt->formatCurrency($Total_IVA, 'EUR')) ?> Total Pedido: <?= hh($fmt->formatCurrency($Total_pedido, 'EUR')) ?></h1>

        <form action="" method="post">
            <input type="hidden" name="vaciar" value="<?= true ?>">
            <button type="submit" class="vaciar">Vaciar carrito</button>
        </form>
    </div>
<?php endif; ?>
</body>

</html>
