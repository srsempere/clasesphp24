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



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $pdo = conectar();
        $codigo = obtener_parametro('codigo', $_POST);
        $titulo = obtener_parametro('titulo', $_POST);
        $autor = obtener_parametro('autor', $_POST);
        $editorial = obtener_parametro('editorial', $_POST);
        $anyo_publicacion = obtener_parametro('anyo_publicacion', $_POST);
        $isbn = obtener_parametro('isbn', $_POST);
        $id_categoria = obtener_parametro('categoria', $_POST);
        $cantidad = obtener_parametro('cantidad', $_POST);



        // Saneado.

        $codigo = sanea($codigo);
        $titulo = sanea($titulo);
        $autor = sanea($autor);
        $editorial = sanea($editorial);
        $anyo_publicacion = sanea($anyo_publicacion);
        $isbn = sanea($isbn);
        $cantidad = sanea($cantidad);


        // Validación.

        if (!valida_enteros($codigo)) {
            añade_error('El código introducido es incorrecto.');
        }

        if (!valida_texto($titulo)) {
            añade_error('El título introducido no es válido.');
        }

        if (!valida_texto($autor)) {
            añade_error('El autor introducido no es válido.');
        }

        if (!valida_texto($editorial)) {
            añade_error('La editorial introducida no es válida.');
        }

        if (!valida_enteros($anyo_publicacion)) {
            añade_error('El año de publiación introducido no es válido.');
        }

        if (!valida_isbn($isbn)) {
            añade_error('El ISBN introducido no es válido.');
        }

        if (!valida_enteros($cantidad)) {
            añade_error('La cantidad introducida no es válida.');
        }

        $errores = obtener_parametro('errores', $_SESSION);

        // Comprobar si existen errores.
        if (isset($errores)) {
            if ($errores > 0) {
                header('Location: biblioteca.php');
            }
        }

        if (!$errores) {

            $campos = [
                ':codigo' => $codigo,
                ':titulo' => $titulo,
                ':autor' => $autor,
                ':editorial' => $editorial,
                ':anyo_publicacion' => $anyo_publicacion,
                ':isbn' => $isbn,
                ':cantidad' => $cantidad,
            ];

            // Para sacar el último id.
            $sent = $pdo->prepare('INSERT INTO libros (codigo, titulo, autor, editorial, anyo_publicacion, isbn, cantidad)
                            VALUES (:codigo, :titulo, :autor, :editorial, :anyo_publicacion, :isbn, :cantidad)
                            RETURNING id');

            $sent->execute($campos);

            $ultimo_id = $sent->fetchColumn();

            // Extraer el id_categoría


            // Insertar el nuevo libro en la tabla libros_categorias (id_libro, id_categoria)
            $sent = $pdo->prepare('INSERT INTO libros_categorias (id_libro, id_categoria)
                                    VALUES (:ultimo_id, :id_categoria)');

            var_dump($ultimo_id);
            var_dump($id_categoria);


            $sent->execute([
                ':ultimo_id' => $ultimo_id,
                ':id_categoria' => $id_categoria
            ]);

            if (!isset($_SESSION['exito_libro'])) {
                $_SESSION['exito_libro'] = 'El libro se ha creado correctamente.';
                header('Location: biblioteca.php');
            }
        }
    }




    $pdo = conectar();
    $sent = $pdo->query('SELECT DISTINCT * FROM categorias');
    $categorias = $sent->fetchAll();
    $categorias_unidimensional = [];

    foreach ($categorias as $fila) {
        $categorias_unidimensional[$fila['id']] = $fila['nombre_categoria'];
    }


    ?>
    <div class="volver"><a href="biblioteca.php">Home</a></div>
    <h1>Inserta un nuevo libro</h1>
    <div class="crea-formulario">
        <form action="" method="post">
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
                <?php foreach ($categorias as $categoria) : ?>
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
