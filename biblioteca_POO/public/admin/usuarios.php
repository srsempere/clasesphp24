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



    ?>

    <a href="index.php" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Volver a index</a>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <img class="w-10 h-10 rounded-full" src="../images/admin.png" alt="Foto de admin">
                        <div class="pl-3">
                            <div class="text-base font-semibold">Admin</div>
                            <div class="font-normal text-gray-500">admin@admin.com</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Online
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit user</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <img class="w-10 h-10 rounded-full" src="../images/pepe.png" alt="Foto de Pepe">
                        <div class="pl-3">
                            <div class="text-base font-semibold">Pepe</div>
                            <div class="font-normal text-gray-500">bonnie@flowbite.com</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Online
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit user</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>



    <?php require '../../src/_footer.php' ?>
    <script src="js/flowbite/flowbite.min.js"></script>
</body>

</html>
