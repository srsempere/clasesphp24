<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <title>Prestar libro</title>
</head>

<body>
    <?php
    session_start();
    require 'aux.php';
    $pdo = conectar();
    $sent = $pdo->query('SELECT id, codigo, titulo, cantidad FROM libros ORDER BY codigo asc');
    $libros = $sent->fetchAll(PDO::FETCH_ASSOC);

    $sent = $pdo->query('SELECT id, nombre FROM usuarios');
    $usuarios = $sent->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id_libro'])) {
            $id_libro_seleccionado = obtener_parametro('id_libro', $_POST);
            $_SESSION['id_libro_seleccionado'] = $id_libro_seleccionado;
        }



        foreach ($libros as $libro) {
            if ($libro['id'] == $_SESSION['id_libro_seleccionado']) {
                $libro_seleccionado = ["Código: {$libro['codigo']}", "Título: {$libro['titulo']}"];
                $cantidad_libro_seleccionado = $libro['cantidad'];
                $_SESSION['cantidad_libro_seleccionado'] = $cantidad_libro_seleccionado;
                break;
            }
        }

        $inicia_prestamo = obtener_parametro('inicia_prestamo', $_POST);

        if (existe($inicia_prestamo)) {
            if (isset($_SESSION['id_libro_seleccionado'])) {
                $id_libro_seleccionado = $_SESSION['id_libro_seleccionado'];
            }

            // COMPROBACIÓN QUE EXISTE STOCK PARA PRESTAR.
            if (isset($_SESSION['cantidad_libro_seleccionado'])) {
                $cantidad_libro_seleccionado = $_SESSION['cantidad_libro_seleccionado'];
            }

            if (isset($cantidad_libro_seleccionado) && $cantidad_libro_seleccionado > 0) {

                // Actualización de la cantidad disponible en la base de datos
                $sent = $pdo->prepare('UPDATE libros
                                SET cantidad = cantidad -1
                                WHERE id = :id_libro_seleccionado');

                $sent->execute([':id_libro_seleccionado' => $id_libro_seleccionado]);
                $id_usuario_prestamo = obtener_parametro('id_usuario', $_POST);
                $dia = obtener_parametro('dia', $_POST);
                $mes = obtener_parametro('mes', $_POST);
                $anyo = obtener_parametro('anyo', $_POST);

                // Saneado
                $inicia_prestamo = sanea($inicia_prestamo);
                $id_libro_seleccionado = sanea($id_libro_seleccionado);
                $id_usuario_prestamo = sanea($id_usuario_prestamo);
                $dia = sanea($dia);
                $mes = sanea($mes);
                $anyo = sanea($anyo);

                // Validacion
                if (valida_entero_positivo($id_libro_seleccionado) && valida_entero_positivo($id_usuario_prestamo) && valida_fecha($dia, $mes, $anyo)) {
                    $fecha = new DateTime("$anyo-$mes-$dia");
                    $fecha = $fecha->format('Y-m-d');

                    // Inserta el préstamo en la tabla préstamo
                    $sent = $pdo->prepare('INSERT INTO prestamos (id_libro, id_usuario, fecha_devolucion)
                                    VALUES (:id_libro_seleccionado, :id_usuario_prestamo, :fecha_devolucion)');
                    $sent->execute([
                        ':id_libro_seleccionado' => $id_libro_seleccionado,
                        ':id_usuario_prestamo' => $id_usuario_prestamo,
                        ':fecha_devolucion' => $fecha
                    ]);
                    $_SESSION['exito_prestamo'] = 'El prestamo se ha realizado con éxito';
                    header('Location: biblioteca.php');
                }
            } else {
                añade_error('Lo sentimos, actualmente no disponemos de stock suficiente para realizar el préstamo.');
                header('Location: biblioteca.php');
            }
        }
    }


    ?>
    <div class="volver"><a href="biblioteca.php">Home</a></div>
    <h1>Préstamos de libros</h1>

    <!-- Formulario 1 -->
    <form action="" method="post">
        <label for="libro">Selecciona el libro que deseas prestar</label>
        <select name="id_libro" id="id_libro">
            <?php foreach ($libros as $libro) : ?>
                <option value="<?= hh($libro['id']) ?>" <?= isset($_POST['id_libro']) &&  hh($libro['id']) == hh($_POST['id_libro']) ? 'selected' : '' ?>><?= hh($libro['codigo']) . ' - ' . hh($libro['titulo']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Seleccionar</button>
    </form>

    <?php
    if (isset($libro_seleccionado)) {
        $libro_seleccionado = implode(' - ', $libro_seleccionado);
    ?>
        <h2>Libro seleccionado para el préstamo</h2>
        <p><?= hh($libro_seleccionado) ?> Cantidad disponible: <?= hh($cantidad_libro_seleccionado) ?></p>
        <h2>Selecciona el usuario del préstamo</h2>

        <!-- Formulario 2 -->
        <form action="" method="post">
            <input type="hidden" name="inicia_prestamo" value="1">
            <label for="usuarios">Selecciona al usuario del préstamo</label>
            <select name="id_usuario" id="usuarios">
                <?php
                var_dump($usuarios);
                if (isset($usuarios)) {
                    foreach ($usuarios as $usuario) {
                ?>
                        <option value="<?= hh($usuario['id']) ?>"><?= hh($usuario['nombre']) ?></option>
                <?php
                    }
                }
                ?>
            </select>
            <label for="">Introduce la fecha de devolución</label>
            <label for="dia">Dia</label>
            <select name="dia">
                <?php for ($i = 1; $i <= 31; $i++) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <label for="mes">Mes</label>
            <select name="mes">
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <label for="anyo">Año</label>
            <select name="anyo">
                <?php for ($i = 2023, $j = 50; $j >= 0; $j--, $i--) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit">Iniciar solicitud de préstamo</button>
        </form>
    <?php
    }
    ?>
</body>

</html>
