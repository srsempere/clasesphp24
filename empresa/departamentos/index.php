<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Departamentos</title>
</head>

<body>
    <?php
    session_start();
    require_once '../aux.php';

    $pdo = conectar();
    $condiciones = [];
    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
    $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : null;
    $successes = isset($_SESSION['success']) ? $_SESSION['success'] : null;

    $sql_cuenta = 'SELECT COUNT(*) FROM departamentos';
    $parametros = [];

    if (isset($codigo) && $codigo !== '') {
        $sql_cuenta .= ' WHERE :codigo = codigo';
        $parametros[':codigo'] = $codigo;
    }

    $sent = $pdo->prepare($sql_cuenta);

    $sent->execute($parametros);
    $cantidad = $sent->fetchColumn();

    if ($cantidad) {
        // EL CÓDIGO EXISTE.
        $sql = 'SELECT * FROM departamentos';
        $condiciones = [];
        $parametros = [];

        if ($codigo) {
            $condiciones[] = ' WHERE codigo= :codigo ';
            $parametros[':codigo'] = $codigo;
        }

        $sql .= implode(' AND ', $condiciones);
        $sent = $pdo->prepare($sql);
        $sent->execute($parametros);
    } else {
        if (isset($codigo)) {
            $code_not_found = 'El código especificado no existe';
        }
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
    <?php if (isset($errores)) : unset($_SESSION['errores']) ?>
        <?php foreach ($errores as $error) : ?>
            <div class="errores">
                <?= $error ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (isset($successes)) : unset($_SESSION['success']) ?>
        <?php foreach ($successes as $success) : ?>
            <div class="success">
                <?= $success ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($code_not_found)) : ?>
        <div class="code_not_found">
            <?= htmlspecialchars($code_not_found) ?>
        </div>
    <?php endif; ?>
</body>

</html>
