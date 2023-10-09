<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registra nuevo libro</title>
</head>

<body>
    <?php
    session_start();
    require_once 'aux.php';
    $pdo = conectar('pgsql', 'localhost', 'biblioteca', 'biblioteca', 'biblioteca');
    $sent = $pdo->query('SELECT DISTINCT * FROM categorias');
    $categorias = $sent->fetchAll();
    $categorias_unidimensional = [];

    foreach ($categorias as $fila) {
        $categorias_unidimensional[$fila['id']] = $fila['nombre_categoria'];
    }

    // var_dump($categorias_unidimensional);
    // die();

    ?>
    <h1>Inserta un nuevo libro</h1>
    <div class="crea-formulario">
        <form action="procesa_crea_libro.php" method="post">
            <input type="hidden" name="id_categoria" value="">
            <label for="codigo">Código</label>
            <input type="text" name="codigo" id="codigo" placeholder="Introduce el código">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" placeholder="Introduce el título">
            <label for="autor">Autor</label>
            <input type="text" name="autor" id="autor" placeholder="Introduce el autor">
            <label for="editorial">Editorial</label>
            <input type="text" name="editorial" id="editorial" placeholder="Introduce la editorial">
            <label for="anyo_publicacion">Año de publicación</label>
            <input type="text" name="anyo_publicacion" id="anyo_publicacion" placeholder="Introduce el año de publiación">
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn" placeholder="Introduce el isbn">
            <label for="categoria">Categoría</label>
            <select name="categoria" id="categoria">
                <?php foreach($categorias as $categoria): ?>
                    <option value="<?= $categoria[0] ?>"><?= $categoria[1] ?></option>
                <?php endforeach; ?>
            </select>
            <label for="cantidad">Cantidad</label>
            <input type="text" name="cantidad" id="cantidad" placeholder="Introduce la cantidad de libros a añadir">
            <button type="submit">Crear</button>
        </form>
    </div>
</body>

</html>
