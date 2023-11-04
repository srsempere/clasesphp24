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
    <title>Modificar</title>
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

    $usuarios = Usuario::todos();

    ?>

    <a href="index.php" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Volver a index</a>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Validado
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Debe reestablecer contraseña
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario_iter) : ?>
                    <?php
                    $url_foto = "../images/{$usuario_iter->getNombre()}.png";
                    $url_perfil = "usuarios/{$usuario_iter->getNombre()}.php";
                    ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="<?= $url_foto ?>" alt="Foto de usuario">
                            <div class="pl-3">
                                <div class="text-base font-semibold"><?= $usuario_iter->getNombre() ?></div>
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <?php if ($usuario->getNombre() === $usuario_iter->getNombre()) : ?>
                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Online
                                <?php else : ?>
                                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Offline
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <?= $usuario_iter->getValidado() ? "Sí" : "No" ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $usuario_iter->getMustReset() ? "Sí" : "No" ?>
                        </td>
                        <td class="px-6 py-4">
                            <a href="<?= $url_perfil ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar usuario</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



    <?php require '../../src/_footer.php' ?>
    <script src="js/flowbite/flowbite.min.js"></script>
</body>

</html>
