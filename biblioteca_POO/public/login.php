<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Ingresa usuario</title>
</head>

<body>
    <?php
    require '../vendor/autoload.php';
    $clases_input_ok = "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500";
    $error = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = obtener_post('login');
        $password = obtener_post('password');

        if (isset($login, $password)) {
            if ($usuario = \App\Tablas\Usuario::comprobar($login, $password)) {
                if (!$usuario->validado) {
                    $_SESSION['error'] = 'El usuario no está validado';
                    return volver_index_inicio();
                }
                // Loguear al usuario
                $_SESSION['login'] = serialize($usuario);
                return $usuario->es_admin() ? volver_admin() : volver_principal();
            } else {
                // Mostrar error de validación
                $error = true;
                $clases_label = "text-red-700 dark:text-red-500";
                $clases_input_fail = "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500";
            }
        }
    }





    ?>

    <?php require '../src/_cabecera.php'; ?>
    <?php require '../src/_alerts.php'; ?>

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <form action="" method="post" class="bg-white p-6 rounded shadow-lg w-1/2">
            <div class="mb-6">
                <label for="login" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu usuario</label>
                <input type="login" id="login" name="login" class="<?= isset($clases_input_fail) ? $clases_input_fail : $clases_input_ok ?>" required>
                <?php if ($error) : ?>
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> Nombre de usuario o contraseña incorrectos</p>
                <?php endif ?>
            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu contraseña</label>
                <input type="password" id="password" name="password" class="<?= isset($clases_input_fail) ? $clases_input_fail : $clases_input_ok ?>" required>
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Iniciar sesión</button>
        </form>

    </div>
    </div>





    <?php require '../src/_footer.php' ?>
    <script src="js/flowbite/flowbite.min.js"></script>
</body>

</html>
