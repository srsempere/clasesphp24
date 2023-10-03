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
        return isset($_GET[$par]) ? $_GET[$par]  : '';
    }

    function validaFecha($mes, $dia, $anyo)
    {
        return checkdate($mes, $dia, $anyo);
    }

    $fecha = obtenerParametros('fecha');
    $fecha_formateada = DateTime::createFromFormat('d/m/Y', $fecha);
    $dia = $fecha_formateada->format('d');
    $mes = $fecha_formateada->format('m');
    $anyo = $fecha_formateada->format('Y');

    var_dump($dia);
    var_dump($mes);
    var_dump($anyo);

    $res = '';
    var_dump(validaFecha($mes, $dia, $anyo));
    if (validaFecha($mes, $dia, $anyo)) {
        $res = 'La fecha es correcta.';
    } else {
        $res = "La fecha NO es correcta.";
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
