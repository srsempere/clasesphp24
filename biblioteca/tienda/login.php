<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/style.css">
    <title>Login de usuario</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';
    $pdo = conectar();

    if (isset($_SESSION['login'])) {
        $_SESSION['login'] = [];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        comprobar_password($password);
        comprobar_email($email);
        $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : false;

        if (!$errores) {
            $sent = $pdo->prepare('SELECT * FROM usuarios WHERE email= :email');
            $sent->execute([':email' => $email]);
            $usuario = $sent->fetch();
            if ($usuario) {
                $hash = $usuario['password_hash'];
                if (password_verify($password, $hash)) {
                    $_SESSION['login'] = $email;
                   return header('Location: index.php');
                }
            } else {
                añade_error('No existen esas credenciales en nuestro sistema');
            }
        }
    }
    ?>
    <div class="volver"><a href="index.php">Tienda</a></div>
    <form action="" method="post" class="login-formulario">
        <label for="email">Email</label><br>
        <input type="text" name="email" id="email">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">
        <button type="submit">Iniciar sesión</button>
    </form>
    <?php
    if (isset($_SESSION['errores'])) {
        foreach ($_SESSION['errores'] as $error) {
    ?>
            <p class="error"><?= $error ?></p>
    <?php
        }
        unset($_SESSION['errores']);
    }
    ?>
</body>

</html>
