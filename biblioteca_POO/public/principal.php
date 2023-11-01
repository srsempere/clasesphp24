<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Página principal</title>
</head>

<body>

    <?php
    use App\Tablas\Libro;
    require '../vendor/autoload.php';
    require '../src/_cabecera.php';

    $pdo = conectar();
    $libros = Libro::todos([], [], $pdo);

    var_dump($_SESSION['login']);

    ?>


    <h1 class="text-5xl font-extrabold dark:text-white">Libros</h1>
    <br>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Título
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripción
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Autor
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Stock
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?= $libro->getCodigo() ?>
                        </th>
                        <td class="px-6 py-4">
                            <?= $libro->getTitulo() ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $libro->getDescripcion() ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $libro->getAutor() ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $libro->getPrecio() ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $libro->getStock() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <?php require '../src/_footer.php' ?>
    <script src="js/flowbite/flowbite.min.js"></script>
</body>

</html>
