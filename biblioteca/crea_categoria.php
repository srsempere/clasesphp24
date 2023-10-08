<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Crear nueva categoria</title>
</head>

<body>
    <?php
    session_start();
    require_once 'aux.php';

    $pdo = conectar('pgsql', 'localhost', 'biblioteca', 'biblioteca', 'biblioteca');
    $sent = $pdo->query('SELECT nombre_categoria FROM categorias');
    $errores = obtener_parametro('errores', $_SESSION);

    ?>
    <h1>Creación de nueva categoría</h1>
    <div class="crea-categoria">
        <form action="procesa_crea_categoria.php" method="post">
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
                    <p><?= $error ?></p>
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
                <li><?= $categoria['nombre_categoria'] ?></li>
            </ol>
        <?php endforeach; ?>
    </div>
</body>

</html>
