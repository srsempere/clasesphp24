<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALCULAR LA DIFERENCIA ENTRE DOS FECHAS</title>
</head>

<body>
    <?php
    function obtenerParametros($par)
    {
        return isset($_GET[$par]) ? $_GET[$par]  : null;
    }


    $fecha1 = obtenerParametros('fecha1');
    $fecha2 = obtenerParametros('fecha2');
    $res = '';

    if ($fecha1 && $fecha2) {
        $fecha1 = DateTime::createFromFormat('d/m/Y', $fecha1);
        $fecha2 = DateTime::createFromFormat('d/m/Y', $fecha2);
        $intervalo = $fecha1->diff($fecha2);
        $res = $intervalo->format('%d dias, %m meses, %y años');
    }


    ?>
    <center>
        <h1>Calcular la diferencia entre dos fechas.</h1>
    </center>
    <form action="" method="get">
        <label for="fecha1">Introduce la primera fecha:</label>
        <input type="text" name="fecha1" id="fecha1" placeholder="dd/mm/aaaa">
        <label for="fecha2">Introduce la segunda fecha:</label>
        <input type="text" name="fecha2" id="fecha2" placeholder="dd/mm/aaaa">
        <button type="submit">Calcular</button>
    </form>
    <p><?= isset($res) ? $res : ""; ?></p>
</body>

</html>
