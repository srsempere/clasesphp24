<?php

require_once 'aux.php';


$pdo = conectar('pgsql', 'localhost', 'empresa', 'empresa', 'empresa');
$id = obtener_parametro('id', $_POST);

// TODO: Aquí falta comprrobar si existe el id y si no está, redirigir a departamentos.php
// TODO: Comprobar primero si el departamento existe con una consulta SELECT.


if (isset($id)) {
    $sql = 'DELETE FROM departamentos WHERE id = :id';
    $sent = $pdo->prepare($sql);
    $sent->execute([':id' => $id]);
    header('Location: departamentos.php?mensaje=Registro borrado con éxito.');
} else {
    header('Location: departamentos.php?mensaje=Error al borrar el registro.');
}
