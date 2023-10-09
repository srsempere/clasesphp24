<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Crear usuario</title>
</head>

<body>
    <h1>Creación de usuarios de la biblioteca</h1>
    <div class="crea-formulario">
        <form action="procesa_crea_usuario.php" method="post">
            <label for="nombre">Nombre del usuario</label>
            <input type="text" name="nombre" id="nombre">
            <label for="email">Introduce el email</label>
            <input type="text" name="email" id="email">
            <label for="password">Introduce la contraseña</label>
            <input type="text" name="password" id="password">
            <button type="submit">Crear usuario</button>
        </form>
    </div>

</body>

</html>
