<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
    session_start();
    require_once 'aux.php';
    $pdo = conectar('pgsql', 'localhost', 'biblioteca', 'biblioteca', 'biblioteca');
    $codigo = obtener_parametro('codigo', $_GET);
    $desde = obtener_parametro('desde', $_GET);
    $hasta = obtener_parametro('hasta', $_GET);
    $mensaje = obtener_parametro('mensaje', $_GET);
    $exito_libro = obtener_parametro('exito_libro', $_SESSION);
    $exito_categoria = obtener_parametro('exito_categoria', $_SESSION);
    $errores = obtener_parametro('errores', $_SESSION);


    $pdo->beginTransaction();
    $sent = $pdo->query('LOCK TABLE libros IN SHARE MODE');

    $sql = 'SELECT * FROM libros';
    $parametros = [];

    if ($codigo || $desde || $hasta) {
        $sql .= ' WHERE ';
        $condiciones = [];

        if ($codigo) {
            $condiciones[] = 'codigo = :codigo';
            $parametros[':codigo'] = $codigo;
        }


        if ($desde) {
            $condiciones[] = 'anyo_publicacion >= :desde';
            $parametros[':desde'] = $desde;
        }

        if ($hasta) {
            $condiciones[] = 'anyo_publicacion <= :hasta';
            $parametros[':hasta'] = $hasta;
        }

        $sql .= implode(' AND ', $condiciones);
    }


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
                                            libros_categorias.id_categoria = categorias.id;');

    $array_categorias = $sent_categorias->fetchAll(); // Array Multidimensional
    $array_categorias_unidimensional = [];

    foreach ($array_categorias as $fila)
    {
        $array_categorias_unidimensional[$fila['titulo']] = $fila['nombre_categoria'];
    }

    ?>

    <h1>Bienvenido a la biblioteca</h1>

    <form action="" method="get">
        <label for="codigo">Introduce el código a buscar</label>
        <input type="text" name="codigo" id="codigo" value="<?= isset($codigo) ? $codigo : ''; ?>">
        <button type="submit">Buscar por código</button>
    </form>
    <br>
    <form action="" method="get">
        <label for="codigo">Introduce el año a buscar</label>
        <input type="text" name="desde" id="desde" placeholder="desde el año..." value="<?= isset($desde) ? $desde : ''; ?>">
        <input type="text" name="hasta" id="hasta" placeholder="hasta el año..." value="<?= isset($hasta) ? $hasta : ''; ?>">
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
                    <td><?= $array_categorias_unidimensional[$fila['titulo']] ?></td>
                    <td><?= $fila['cantidad'] ?></td>
                    <th><a href="borrar.php?id=<?= $fila['id'] ?>&titulo=<?= $fila['titulo']; ?>">Eliminar</a></th>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($mensaje) : ?>
        <div class="ok_borrado">
            <p><?= $mensaje ?></p>
        </div>
    <?php endif; ?>
    <div class="ir-crealibro">
        <a href="crea_libro.php">Insertar un nuevo libro</a>
    </div>
    <div class="ir-creacategoria">
        <a href="crea_categoria.php">Insertar una nueva categoría</a>
    </div>
    <?php

    if (isset($errores)) {
        if (count($errores) > 0) {
            unset($_SESSION['errores']);



            foreach ($errores as $error) :
    ?>
                <div class="error">
                    <p><?= $error; ?></p>
                </div>
        <?php
            endforeach;
        }
    }

    if (isset($exito_libro)) {
        unset($_SESSION['exito_libro']);


        ?>
        <div class="exito">
            <p><?= $exito_libro ?></p>
        </div>
    <?php
    }

    if (isset($exito_categoria)) {
        unset($_SESSION['exito_categoria']);


    ?>
        <div class="exito">
            <p><?= $exito_categoria ?></p>
        </div>
    <?php
    }
    ?>
</body>

</html>
