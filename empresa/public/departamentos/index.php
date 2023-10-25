<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
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
        $sql .= ' ORDER BY codigo ';
        $sent = $pdo->prepare($sql);
        $sent->execute($parametros);
    } else {
        if (isset($codigo)) {
            $code_not_found = 'El código especificado no existe';
        }
    }



    ?>

    <form action="" method="get">
        <div class="mb-6">
        <label for="codigo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código</label>
            <input type="text" name="codigo" id="codigo" value="<?= hh($codigo) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <button type="submit">Buscar</button>
    </form>

    <br>

    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <span class="font-medium">Info alert!</span> Change a few things up and try submitting again.
    </div>


    <div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <th scope="col" class="px-6 py-3">Código</th>
            <th scope="col" class="px-6 py-3">Denominación</th>
            <th scope="col" class="px-6 py-3">Localidad</th>
            <th scope="col" class="px-6 py-3">Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($sent as $fila) : ?>
                <tr>
                    <td><?= hh($fila['codigo']) ?></td>
                    <td><?= hh($fila['denominacion']) ?></td>
                    <td><?= hh($fila['localidad']) ?></td>
                    <td>
                        <a href="borrar.php?id=<?= hh($fila['id']); ?>& denominacion=<?= hh($fila['denominacion']); ?>">Borrar</a>
                        <a href="modificar.php?id=<?= hh($fila['id']); ?>">Modificar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <br>
    <a href="crear.php">Crear departamento</a><br>
    <a href="/empleados/index.php">Ir a Empleados</a>
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
            <?= hh($code_not_found) ?>
        </div>
    <?php endif; ?>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>
