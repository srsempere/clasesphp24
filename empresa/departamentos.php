<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>

<body>
    <?php
    $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
    $codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : null;
    // Comprueba si existe algún registro

    $sent = $pdo->prepare('SELECT COUNT(*) FROM departamentos WHERE codigo = :codigo');
    $sent->execute([':codigo' => $codigo]);
    $cantidad = $sent->fetchColumn();

    if ($cantidad == 0  && isset($codigo)) : ?>
        <?php
        if ($codigo == '') {

        }

        ?>
        <h3>No se ha encontrado ese departamento.</h3>
    <?php

    else :

        $sql = 'SELECT * FROM departamentos';


        $parametros = [];
        if ($codigo) {
            $sql .= ' WHERE codigo = :codigo';
            $parametros[':codigo'] = $codigo;
        }

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
            </thead>
            <tbody>
                <?php foreach ($sent as $fila) : ?>
                    <tr>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= $fila['denominacion'] ?></td>
                        <td><?= $fila['localidad'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
</body>

</html>
