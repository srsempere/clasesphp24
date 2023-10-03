<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha en 45 días</title>
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

    $res = '';
    $fecha = obtenerParametros('fecha');

    if (isset($fecha)) {
        $f_fecha = DateTime::createFromFormat('d/m/Y', $fecha);
        $fecha_final = clone $f_fecha;
        $intervalo = new DateInterval('P45D');
        $fecha_final->add($intervalo);
        $res = $fecha_final->format('d-m-Y');
    }






    ?>
    <center>
        <h1>Calcula tu fecha dentro de 45 días.</h1>
    </center>
    <form action="" method="get">
        <label for="fecha">Introduce la fecha a validar:</label>
        <input type="text" name="fecha" id="fecha" placeholder="dd/mm/aaaa">
        <button type="submit">Validar</button>
    </form>
    <p><?= isset($res) ? $res : ""; ?></p>
</body>

</html>
