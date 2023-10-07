<?php
session_start();
require_once 'aux.php';

$codigo = obtener_parametro('codigo', $_POST);
$titulo = obtener_parametro('titulo', $_POST);
$autor = obtener_parametro('autor', $_POST);
$editorial = obtener_parametro('editorial', $_POST);
$anyo_publicacion = obtener_parametro('anyo_publicacion', $_POST);
$isbn = obtener_parametro('isbn', $_POST);
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
    if (!isset($_SESSION['exito_libro'])) {
        $_SESSION['exito_libro'] = 'El libro se ha creado correctamente.';
        header('Location: biblioteca.php');
    }
}
