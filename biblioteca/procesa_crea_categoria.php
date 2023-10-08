<?php
session_start();
require_once 'aux.php';


$nueva_categoria = obtener_parametro('nueva_categoria', $_POST);

// Saneado

$nueva_categoria = sanea($nueva_categoria);

// Validado

if (!valida_texto($nueva_categoria)) {
    añade_error('La categoría introducida no es correcta');
    header('Location: crea_categoria.php');
}

$errores = obtener_parametro('errores', $_SESSION);

if (!$errores) {
    $pdo = conectar('pgsql', 'localhost', 'biblioteca', 'biblioteca', 'biblioteca');

    // Comprobar que la categoría no existe ya.

    $sent = $pdo->query('SELECT nombre_categoria FROM categorias');
    $categorias = $sent->fetchAll(PDO::FETCH_ASSOC); # Array multidimensional.
    $categorias_unidimensional = array_column($categorias, 'nombre_categoria'); # Array unidimensional.

    if (!in_array($nueva_categoria, $categorias_unidimensional)) {

        // Inserción de la nueva categoría en la database.

        $sent = $pdo->prepare('INSERT INTO categorias (nombre_categoria)
                                VALUES (:nueva_categoria)');
        $sent->execute([':nueva_categoria' => $nueva_categoria]);



        if (!isset($_SESSION['exito_categoria'])) {
            $_SESSION['exito_categoria'] = 'La categoria se ha creado correctamente';
            header('Location: biblioteca.php');
        }
    } else {
        añade_error('La categoría insertada ya existe en la base de datos');
        header('Location: crea_categoria.php');
    }
}
