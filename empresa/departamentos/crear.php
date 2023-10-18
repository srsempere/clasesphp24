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
        if ($codigo && $denominacion && $localidad) {
            error_log('Estoy dentro');
            // TODO: Realizar filtrado.

            // Comprobar si el código insertado existe en la base de datos.
            $sent = $pdo->prepare('SELECT COUNT(codigo) FROM departamentos WHERE codigo= :codigo');
            $sent->execute([
                ':codigo' => $codigo
            ]);

            $coincidencias = $sent->fetchColumn();
            error_log("Coincidencias: $coincidencias");

            if ($coincidencias === 0) {
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
                add_error('El código introducido ya existe');
                header('Location: index.php');
                exit();
            }
        } else {
            add_error('El departamento no se ha podido crear,');
            header('Location: index.php');
            exit();
        }
    }


    ?>
    <h1>Crear nuevo departamento</h1>
    <form action="" method="post">
        <label for="codigo">Código del nuevo departamento</label>
        <input type="text" name="codigo" id="codigo" value="<?= isset($codigo) ? $codigo : '' ?>">
        <label for="denominacion">Denominación del nuevo departamento</label>
        <input type="text" name="denominacion" id="denominacion" value="<?= isset($denominacion) ? $denominacion : '' ?>">
        <label for="localidad">Localización del nuevo departamento</label>
        <input type="text" name="localidad" id="localidad" value="<?= isset($localidad) ? $localidad : '' ?>">
        <button type="submit">Crear departamento</button>
    </form>
    <a href="index.php">Volver a departamentos</a>
</body>

</html>
