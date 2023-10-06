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
    $parametros = [];

    if ($codigo) { // Preparada para implementar varios parámentros.
        $sql .= ' WHERE ';
        $parametros[':codigo'] = $codigo;
    }

    $sql .= implode('AND', $parametros);
    $sent = $pdo->prepare($sql);
    $sent->execute($parametros);

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
    <?php if (isset($mensaje)) : ?>
        <div class="mensaje">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>
</body>

</html>
