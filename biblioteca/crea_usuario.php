<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Crear usuario</title>
</head>

<body>
    <?php
    session_start();
    require_once 'aux.php';
    $nombre = obtener_parametro('nombre', $_POST);
    $email = obtener_parametro('email', $_POST);
    $password = obtener_parametro('password', $_POST);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Saneado
        $nombre = sanea($nombre);
        $email = sanea_email($email);

        // Validación

        if (valida_nombre($nombre) && valida_email($email) && valida_password($password)) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $campos = [
                ':nombre' => $nombre,
                ':email' => $email,
                ':password_hash' => $password,
            ];
            $pdo = conectar();
            $sent = $pdo->prepare('INSERT INTO usuarios (nombre, email, password_hash)
                                    VALUES (:nombre, :email, :password_hash)');
            $sent->execute($campos);
        }
        $_SESSION['exito_usuario'] = 'El usuario se ha creado con éxito';
        header('Location: biblioteca.php');
    }
    $errores = obtener_parametro('errores', $_SESSION);

    ?>
    <div class="volver"><a href="biblioteca.php">Home</a></div>
    <h1>Creación de usuarios de la biblioteca</h1>
    <div class="crea-formulario">
        <form action="" method="post">
            <label for="nombre">Nombre del usuario</label>
            <input type="text" name="nombre" id="nombre" value="<?= $nombre; ?>">
            <label for="email">Introduce el email</label>
            <input type="text" name="email" id="email" value="<?= $email; ?>">
            <label for="password">Introduce la contraseña</label>
            <input type="password" name="password" id="password" value="">
            <button type="submit">Crear usuario</button>
        </form>
    </div>
    <?php
    if (isset($errores)) {
        foreach ($errores as $error) {
    ?>
            <ol>
                <li><?= $error ?></li>
            </ol>
    <?php
        }
        unset($_SESSION['errores']);
    }
    ?>
</body>

</html>
