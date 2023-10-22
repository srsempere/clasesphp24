<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nuevo departamento</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';
    $pdo = conectar();

    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
    $denominacion = isset($_POST['denominacion']) ? $_POST['denominacion'] : null;
    $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!validar_csrf()) {
            return ir_index();
        }

        if ($codigo && $denominacion) {
            comprueba_codigo($codigo,$pdo);
            comprueba_denominacion($denominacion);
            comprueba_localidad($localidad);

            $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : false;

            if (isset($errores) && !$errores) {
                // Inserción
                $sent = $pdo->prepare('INSERT INTO departamentos (codigo, denominacion, localidad)
                                            VALUES (:codigo, :denominacion, :localidad)');
                $sent->execute([
                    ':codigo' => $codigo,
                    'denominacion' => $denominacion,
                    'localidad' => $localidad
                ]);
                add_success('El departamento se ha creado correctamente.');
                header('Location: index.php');
                exit();
            } else {
                return ir_index();
            }
        }
    }


    ?>
    <h1>Crear nuevo departamento</h1>
    <form action="" method="post">
        <?php campo_csrf() ?>
        <label for="codigo">Código del nuevo departamento</label>
        <input type="text" name="codigo" id="codigo" value="<?= isset($codigo) ? hh($codigo) : '' ?>">
        <label for="denominacion">Denominación del nuevo departamento</label>
        <input type="text" name="denominacion" id="denominacion" value="<?= isset($denominacion) ? hh($denominacion) : '' ?>">
        <label for="localidad">Localización del nuevo departamento</label>
        <input type="text" name="localidad" id="localidad" value="<?= isset($localidad) ? hh($localidad) : '' ?>">
        <button type="submit">Crear departamento</button>
    </form>
    <a href="index.php">Volver a departamentos</a>
</body>

</html>
