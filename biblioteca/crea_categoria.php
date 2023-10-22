<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <title>Crear nueva categoria</title>
</head>

<body>
    <?php
    session_start();
    require_once 'aux.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nueva_categoria = obtener_parametro('nueva_categoria', $_POST);

        // Saneado

        $nueva_categoria = sanea($nueva_categoria);

        // Validado

        if (!valida_texto($nueva_categoria)) {
            añade_error('La categoría introducida no es correcta');
            header('Location: crea_categoria.php');
        }

        $errores = obtener_parametro('errores', $_SESSION);

        if (!$errores) {
            $pdo = conectar();

            // Comprobar que la categoría no existe ya.

            $sent = $pdo->query('SELECT nombre_categoria FROM categorias');
            $categorias = $sent->fetchAll(PDO::FETCH_COLUMN);


            if (!in_array($nueva_categoria, $categorias)) {

                // Inserción de la nueva categoría en la database.

                $sent = $pdo->prepare('INSERT INTO categorias (nombre_categoria)
                                VALUES (:nueva_categoria)');
                $sent->execute([':nueva_categoria' => $nueva_categoria]);



                if (!isset($_SESSION['exito_categoria'])) {
                    $_SESSION['exito_categoria'] = 'La categoria se ha creado correctamente';
                    header('Location: biblioteca.php');
                }
            } else {
                añade_error('La categoría insertada ya existe en la base de datos');
                header('Location: biblioteca.php');
                exit;
            }
        }
    }




    $pdo = conectar();
    $sent = $pdo->query('SELECT nombre_categoria FROM categorias');
    $errores = obtener_parametro('errores', $_SESSION);

    ?>
    <div class="volver"><a href="biblioteca.php">Home</a></div>
    <h1>Creación de nueva categoría</h1>
    <div class="crea-categoria">
        <form action="" method="post">
            <label for="categoria">Introduce el nombre de la nueva categoría</label>
            <input type="text" name="nueva_categoria" id="nueva_categoria">
            <button type="submit">Crear categoria</button>
        </form>
    </div>
    <?php
    if (isset($errores)) {
        if (count($errores) > 0) {
            unset($_SESSION['errores']);

            foreach ($errores as $error) :
    ?>
                <div class="error">
                    <p><?= hh($error) ?></p>
                </div>
    <?php
            endforeach;
        }
    }
    ?>
    <div class="lista-categorias">
        <h2>Categorias existentes:</h2>
        <?php foreach ($sent as $categoria) : ?>
            <ol>
                <li><?= hh($categoria['nombre_categoria']) ?></li>
            </ol>
        <?php endforeach; ?>
    </div>
</body>

</html>
