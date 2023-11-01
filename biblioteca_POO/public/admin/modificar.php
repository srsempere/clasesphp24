<?php

session_start();

use App\Tablas\Libro;
use App\Tablas\Usuario;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Principal de administrador</title>
</head>

<body>
    <?php
    require '../../vendor/autoload.php';
    require '../../src/_cabecera.php';
    require '../../src/_alerts.php';

    if ($usuario = Usuario::logueado()) {
        if (!$usuario->es_admin()) {
            $_SESSION['error'] = 'Acceso no autorizado';
            return volver_index_inicio();
        }
    }

    $id = obtener_get('id');

    if (!isset($id)) {
        return volver_admin();
    }

    $pdo = conectar();
    $libro = Libro::obtener($id, $pdo);
    $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo 'dentro';
        //TODO: Realizar comprobaciones

        if (!$errores) {
            # code... //TODO: Realizar actualización/modificación.
        }

    }
    ?>

    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <form action="" method="post">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="codigo" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Código</label>
                    <input type="text" id="codigo" name="codigo" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $libro->getCodigo() ?>" required>
                </div>
                <div>
                    <label for="titulo" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Titulo</label>
                    <input type="text" id="titulo" name="titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $libro->getTitulo() ?>" required>
                </div>
                <div>
                    <label for="descripcion" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Descripción</label>
                    <input type="text" id="descripcion" name="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $libro->getDescripcion() ?>" required>
                </div>
                <div>
                    <label for="autor" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Autor</label>
                    <input type="text" id="autor" name="autor" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $libro->getAutor() ?>" required>
                </div>
                <div>
                    <label for="precio" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Precio</label>
                    <input type="text" id="precio" name="precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $libro->getPrecio() ?>" required>
                </div>
                <div>
                    <label for="stock" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Stock</label>
                    <input type="text" id="stock" name="stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $libro->getStock() ?>" required>
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base w-full base:w-auto p3.5 py-3.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Modificar</button>
        </form>
    </div>



    <?php require '../../src/_footer.php' ?>
    <script src="js/flowbite/flowbite.min.js"></script>
</body>

</html>
