<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALCULAR LA DIFERENCIA ENTRE DOS FECHAS</title>
</head>

<body>
    <?php
    // Enunciado: Toma una fecha en formato Y-m-d y conviértela a un formato legible, como jS F, Y.

    function obtenerParametros($par)
    {
        return isset($_GET[$par]) ? $_GET[$par]  : null;
    }

    function convierteFormato($fecha, &$res)
    {
        if (isset($fecha)) {
            $fecha_formateada = DateTime::createFromFormat('Y-m-d', $fecha);
            $res = $fecha_formateada->format('jS F, Y');
        }
    }

    $res = '';
    $fecha = obtenerParametros('fecha');
    convierteFormato($fecha, $res);





    ?>
    <center>
        <h1>Validador de fechas.</h1>
    </center>
    <form action="" method="get">
        <label for="fecha">Introduce tu fecha:</label>
        <input type="text" name="fecha" id="fecha" placeholder="aaaa-mm-dd">
        <button type="submit">Convertir</button>
    </form>
    <p><?= isset($res) ? $res : ""; ?></p>
</body>

</html>
