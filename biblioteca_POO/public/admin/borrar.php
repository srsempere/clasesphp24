<?php

session_start();
require '../../vendor/autoload.php';

$id = obtener_post('id');

if (!isset($id)) {
    return volver_admin();
}

$pdo = conectar();
$sent = $pdo->prepare('DELETE FROM libros WHERE id= :id');
$sent->execute([':id' => $id]);

$_SESSION['exito'] = 'El libro se ha borrado correctamente';

return volver_admin();
