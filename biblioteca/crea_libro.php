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
    ?>
    <h1>Inserta un nuevo libro</h1>
    <div class="crea-libro">
        <form action="procesa_crea_libro.php" method="post">
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
            <label for="cantidad">Cantidad</label>
            <input type="text" name="cantidad" id="cantidad" placeholder="Introduce la cantidad de libros a añadir">
            <button type="submit">Crear</button>
        </form>
    </div>
</body>

</html>
