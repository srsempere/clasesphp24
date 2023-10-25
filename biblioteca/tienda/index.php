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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $vaciar = isset($_POST['vaciar']) ? $_POST['vaciar'] : false;
        if ($vaciar) {
            $_SESSION['carrito'] = [];
        }
    }


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
            // Comprobar si existe ese id  en la base de datos.
            $sent = $pdo->prepare('SELECT COUNT(*) FROM libros WHERE id= :id');
            $sent->execute([':id' => $id]);
            $coincidencias = $sent->fetchColumn();
            if ($coincidencias === 0) {
                añade_error('No existen referencias al libro introducido');
                return volver_biblioteca();
            }
            $sent = $pdo->prepare('SELECT * FROM libros WHERE id= :id');
            $sent->execute([':id' => $id]);
            $libro = $sent->fetch();
            $_SESSION['carrito'][]  = $libro;
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
            <?php
            if (!isset($_SESSION['stock'])) {
                $_SESSION['stock'] = [];
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($id)) {
                if ($_SESSION['stock'][$libro['titulo']] > 0) {
                    $_SESSION['stock'][$libro['titulo']]--;
                } else {
                    $_SESSION['stock'][$libro['titulo']] = 0;
                }
            }
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
                    <?php
                    if (!isset($_SESSION['stock'][$libro['titulo']])) {
                        $_SESSION['stock'][$libro['titulo']] = $libro['stock'];
                    }

                    ?>
                    <td><?= hh($_SESSION['stock'][$libro['titulo']]) ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= hh($libro['id']) ?>">
                            <button type="submit">Añadir</button> //TODO: Añadir botón para restar artículo
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (!empty($_SESSION['carrito'])) : ?>
        <?php
        $titulos_carrito = [];
        $Total_BI = 0;
        $Total_IVA = 0;
        $Total_pedido = 0;
        ?>
        <h2 class="carrito-titulo">Carrito de la compra</h2>

        <?php foreach ($_SESSION['carrito'] as $value) : ?>
            <?php
            $titulo = $value['titulo'];
            $precio_sin_formato = $value['precio'];
            if (isset($titulos_carrito[$titulo])) {
                $titulos_carrito[$titulo][0]++;
            } else {
                $titulos_carrito[$titulo][0] =  1;
                $titulos_carrito[$titulo][1] = $precio_sin_formato;
            }
            ?>
        <?php endforeach; ?>
        <div class="carrito-section">
            <table border="0">
                <thead>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Base Imponible</th>
                    <th>IVA (4%)</th>
                    <th>Total Artículo</th> //TODO: Añadir botón para vaciar carrito.
                </thead>
                <tbody>
                    <?php foreach ($titulos_carrito as $articulo => $propiedades_libro) : ?>
                        <tr>
                            <td><?= hh($articulo) ?></td>
                            <?php
                            $Cantidad = $titulos_carrito[$articulo][0]
                            ?>
                            <th><?= hh($Cantidad)  ?></th>
                            <?php
                            $BI = ($propiedades_libro[0] * $propiedades_libro[1]);
                            $Total_BI += ($propiedades_libro[0] * $propiedades_libro[1]);
                            ?>
                            <td><?= hh($fmt->formatCurrency($BI, 'EUR')) ?></td>
                            <?php
                            $IVA = ($propiedades_libro[0] * $propiedades_libro[1]) * 0.04;
                            $Total_IVA += $IVA
                            ?>
                            <td><?= hh($fmt->formatCurrency($IVA, 'EUR')) ?></td>
                            <?php
                            $total_articulo = ($propiedades_libro[0] * $propiedades_libro[1]) + $IVA;
                            $Total_pedido += ($propiedades_libro[0] * $propiedades_libro[1]) + $IVA;
                            ?>
                            <td><?= hh($fmt->formatCurrency($total_articulo, 'EUR')) ?></td>
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
