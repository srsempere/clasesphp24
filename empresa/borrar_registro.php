<?php

require_once 'aux.php';


$pdo = conectar('pgsql', 'localhost', 'empresa', 'empresa', 'empresa');
$id = obtener_parametro('id', $_POST);


if (isset($id)) {
    $sql = 'DELETE FROM departamentos WHERE id = :id';
    $sent = $pdo->prepare($sql);
    $sent->execute([':id' => $id]);
    header('Location: departamentos.php?mensaje=Registro borrado con éxito.');
} else {
    header('Location: departamentos.php?mensaje=Error al borrar el registro.');
}
