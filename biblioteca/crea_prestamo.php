<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Prestar libro</title>
</head>

<body>
    <?php
    session_start();
    require 'aux.php';
    $pdo = conectar();
    $sent = $pdo->query('SELECT id, codigo, titulo FROM libros ORDER BY codigo asc');
    $libros = $sent->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h1>Préstamos de libros</h1>
    <form action="" method="post">
        <label for="libro">Selecciona el libro que deseas prestar</label>
        <select name="libro" id="libro">
            <?php foreach ($libros as $libro) : ?>
                <option value="<?= $libro['id'] ?>"><?= $libro['codigo'] . ' - ' .$libro['titulo']; ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</body>

</html>
