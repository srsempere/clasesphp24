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

    function validaFecha($mes, $dia, $anyo)
    {
        return checkdate($mes, $dia, $anyo);
    }

    $fecha = obtenerParametros('fecha');

    if (isset($fecha)) {
        list($dia, $mes, $anyo) = explode('/', $fecha);
    }


    $res = '';

    if (isset($mes, $dia, $anyo)) {
        if (validaFecha($mes, $dia, $anyo)) {
            $res = 'La fecha es correcta.';
        } else {
            $res = "La fecha NO es correcta.";
        }
    }



    ?>
    <center>
        <h1>Validador de fechas.</h1>
    </center>
    <form action="" method="get">
        <label for="fecha">Introduce la fecha a validar:</label>
        <input type="text" name="fecha" id="fecha" placeholder="dd/mm/aaaa">
        <button type="submit">Calcular</button>
    </form>
    <p><?= isset($res) ? $res : ""; ?></p>
</body>

</html>
