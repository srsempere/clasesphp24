<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modifcación departamento</title>
</head>
<body>
    <?php
        session_start();
        require '../aux.php';
        $id_departamento = isset($_GET['id']) ? $_GET['id'] : null;
        $pdo = conectar();

        $sent = $pdo->prepare('SELECT * FROM departamentos WHERE id= :id_departamento');
        $sent->execute([':id_departamento' => $id_departamento]);


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            # code...
        }
    ?>
    <h1>Modificación de departamentos</h1>
    <?php foreach($sent as $fila): ?>
    <form action="" method="post">
        <label for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" value="<?= $fila['codigo'] ?>"><br>
        <label for="codigo">Denominación</label>
        <input type="text" name="denominacion" id="denominacion" value="<?= $fila['denominacion'] ?>"><br>
        <label for="localidad">Localidad</label>
        <input type="text" name="localidad" id="localidad" value="<?= $fila['localidad'] ?>"><br>
        <button type="submit">Modificar</button>
    </form>
    <?php endforeach; ?>
</body>
</html>
