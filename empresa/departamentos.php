<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Departamentos</title>
</head>

<body>
    <?php
    require_once 'aux.php';

    $pdo = conectar('pgsql', 'localhost', 'empresa', 'empresa', 'empresa');
    $codigo = obtener_parametro('codigo', $_GET);
    $mensaje = obtener_parametro('mensaje', $_GET);
    $sql = 'SELECT * FROM departamentos';

    if ($codigo !== '') { // el usuario ha introducido algún código

         // Comprueba si existe algún registro que coincida con el código.
        $sent = $pdo->prepare('SELECT codigo FROM departamentos WHERE codigo = :codigo LIMIT 1');
        $sent->execute([':codigo' => $codigo]);
        $cantidad = $sent->fetchColumn();


        if ($cantidad > 0  && isset($codigo)) {
            // El registro introducido existe
            $sql .=  ' WHERE codigo = :codigo';
            $sent = $pdo->prepare($sql);
            $sent->execute([':codigo' => $codigo]);
        }


        if (!$cantidad && is_null($codigo)) {
            // Por ejemplo recién cargada la página.
            $sent = $pdo->query($sql);
        } else {
            if (!$cantidad) {
                ?>
                <center><h1>El código introducido no existe.</h1></center>
                <?php
            }
        }

    } else { // el usuario pulsa sin meter código o envía código inexistente.

        $sent = $pdo->query($sql);
    }

    ?>

    <form action="" method="get">
        <label for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" value="<?= $codigo ?>">
        <button type="submit">Buscar</button>
    </form>

    <br>
    <table border="1">
        <thead>
            <th>Código</th>
            <th>Denominación</th>
            <th>Localidad</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($sent as $fila) : ?>
                <tr>
                    <td><?= $fila['codigo'] ?></td>
                    <td><?= $fila['denominacion'] ?></td>
                    <td><?= $fila['localidad'] ?></td>
                    <td><a href="borrar.php?id=<?= $fila['id']; ?>& denominacion=<?= $fila['denominacion']; ?>">Borrar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (isset($mensaje)): ?>
        <div class="mensaje">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>
</body>

</html>
