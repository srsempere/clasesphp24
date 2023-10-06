<?php
require_once 'aux.php';


$id = obtener_parametro('id', $_POST);


if (isset($id)) {
    $sql = 'DELETE FROM libros WHERE id= :id';
    $pdo = conectar('pgsql', 'localhost', 'biblioteca', 'biblioteca', 'biblioteca');
    $sent = $pdo->prepare($sql);
    $sent->execute([':id' => $id]);
    header('Location: biblioteca.php?mensaje=El registro se ha eliminado con éxito.');

} else {
    header('Location: biblioteca.php');
}
