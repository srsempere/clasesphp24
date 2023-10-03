<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compara fechas</title>
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

    if (isset($fecha1,$fecha2)) {
        $f_fecha1 = DateTime::createFromFormat('d/m/Y', $fecha1);
        $f_fecha2 = DateTime::createFromFormat('d/m/Y', $fecha2);
        if ($f_fecha1 < $f_fecha2) {
            $res = "{$f_fecha2->format('d/m/Y')} es más reciente.";
        } else {
            $res = "{$f_fecha1->format('d/m/Y')} es más reciente.";
        }
    }




    ?>
    <center>
        <h1>Indica qué fecha es más reciente.</h1>
    </center>
    <form action="" method="get">
        <label for="fecha1">Introduce la primera fecha:</label>
        <input type="text" name="fecha1" id="fecha1" placeholder="dd/mm/aaaa">
        <label for="fecha2">Introduce la segunda fecha:</label>
        <input type="text" name="fecha2" id="fecha2" placeholder="dd/mm/aaaa">
        <button type="submit">Comparar</button>
    </form>
    <p><?= isset($res) ? $res : ""; ?></p>
</body>

</html>
