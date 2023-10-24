<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
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
    require_once 'aux.php';
    $pdo = conectar();
    $codigo = obtener_parametro('codigo', $_POST);
    $desde = obtener_parametro('desde', $_POST);
    $hasta = obtener_parametro('hasta', $_POST);
    $mensaje = obtener_parametro('mensaje', $_GET);
    $exitos = isset($_SESSION['exitos']) ? $_SESSION['exitos'] : null;


    $pdo->beginTransaction();
    $sent = $pdo->query('LOCK TABLE libros IN SHARE MODE');

    $sql = 'SELECT * FROM libros';
    $parametros = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        comprueba_codigo($codigo);
        comprueba_anyo_publicacion($desde);
        comprueba_anyo_publicacion($hasta);
        $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : null;

        // Si hay errores en algún campo, se ejecutará una consulta select normal mostrando todos los campos.
        if (!$errores) {

            if ($codigo || $desde || $hasta) {
                $sql .= ' WHERE ';
                $condiciones = [];

                if ($codigo) {
                    $condiciones[] = 'codigo = :codigo';
                    $parametros[':codigo'] = $codigo;
                }

                if ($desde && $hasta) {
                    $condiciones[] = 'anyo_publicacion BETWEEN :desde AND :hasta';
                    $parametros[':desde'] = $desde;
                    $parametros[':hasta'] = $hasta;
                } else {
                    if ($desde) {
                        $condiciones[] = 'anyo_publicacion >= :desde';
                        $parametros[':desde'] = $desde;
                    }

                    if ($hasta) {
                        $condiciones[] = 'anyo_publicacion <= :hasta';
                        $parametros[':hasta'] = $hasta;
                    }
                }

                $sql .= implode(' AND ', $condiciones);
            }
        }
    }

    $sql .= ' ORDER BY codigo';
    $sent = $pdo->prepare($sql);
    $sent->execute($parametros);
    $pdo->commit();

    // Obtener libros y sus categorías

    $sent_categorias = $pdo->query('SELECT
                                            libros.titulo,
                                            categorias.nombre_categoria
                                        FROM
                                            libros
                                        JOIN
                                            libros_categorias
                                        ON
                                            libros.id = libros_categorias.id_libro
                                        JOIN
                                            categorias
                                        ON
                                            libros_categorias.id_categoria = categorias.id');

    $array_categorias = $sent_categorias->fetchAll(); // Array Multidimensional
    $array_categorias_unidimensional = [];

    foreach ($array_categorias as $fila) {
        $array_categorias_unidimensional[$fila['titulo']] = $fila['nombre_categoria'];
    }

    ?>

    <div class="volver"> <a href="/tienda/index.php">Tienda Online</a></div>
    <h1>Bienvenido a la biblioteca</h1>

    <form action="" method="post">
        <label for="codigo">Introduce el código a buscar</label>
        <input type="text" name="codigo" id="codigo" value="<?= hh($codigo) ?>">
        <button type="submit">Buscar por código</button>
    </form>
    <br>
    <form action="" method="post">
        <label for="codigo">Introduce el año a buscar</label>
        <input type="text" name="desde" id="desde" placeholder="desde el año..." value="<?= hh($desde) ?>">
        <input type="text" name="hasta" id="hasta" placeholder="hasta el año..." value="<?= hh($hasta) ?>">
        <button type="submit">Buscar por año</button>
    </form>
    <table>
        <thead>
            <th>Código</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Año de publicación</th>
            <th>ISBN</th>
            <th>Categoría</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php
            $fmt = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
            ?>
            <?php foreach ($sent as $fila) : ?>
                <tr>
                    <td><?= hh($fila['codigo']) ?></td>
                    <td><?= hh($fila['titulo']) ?></td>
                    <td><?= hh($fila['autor']) ?></td>
                    <td><?= hh($fila['editorial']) ?></td>
                    <td><?= hh($fila['anyo_publicacion']) ?></td>
                    <td><?= hh($fila['isbn']) ?></td>
                    <td><?= hh($array_categorias_unidimensional[$fila['titulo']]) ?></td>
                    <?php
                    $precio = isset($fila['precio']) ? $fmt->formatCurrency($fila['precio'], 'EUR') : '';
                    ?>
                    <td> <?= hh($precio) ?> </td>
                    <td><?= hh($fila['cantidad']) ?></td>
                    <th>
                        <a href="borrar.php?id=<?= hh($fila['id']) ?>&titulo=<?= hh($fila['titulo']); ?>">Eliminar</a>
                        <a href="modificar.php">Modificar</a>
                    </th>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($mensaje) : ?>
        <div class="ok_borrado">
            <p><?= hh($mensaje) ?></p>
        </div>
    <?php endif; ?>
    <div class="ir-a">
        <a href="crea_libro.php">Insertar un nuevo libro</a>
    </div>
    <div class="ir-a">
        <a href="crea_categoria.php">Insertar una nueva categoría</a>
    </div>
    <div class="ir-a">
        <a href="crea_usuario.php">Crear un nuevo usuario</a>
    </div>
    <div class="ir-a">
        <a href="crea_prestamo.php">Crear un nuevo préstamo</a>
    </div>
    <?php

    if (isset($errores)) {
        if (count($errores) > 0) {
            unset($_SESSION['errores']);

            foreach ($errores as $error) :
    ?>
                <div class="error">
                    <p><?= hh($error); ?></p>
                </div>
            <?php
            endforeach;
        }
    }

    if (isset($exitos)) {
        if (count($_SESSION['exitos']) > 0) {
            unset($_SESSION['exitos']);
            foreach ($exitos as $exito) {
            ?>
                <div class="exitos">
                    <p><?= hh($exito); ?></p>
                </div>
    <?php
            }
        }
    }



    ?>
</body>

</html>
