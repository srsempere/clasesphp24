<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de años</title>
</head>

<body>
    <?php
    /*
        Apuntes:
        - Se puede calcular la diferencia entre dos fecha usando el método diff de datetime.
        - Se puede modificar objetos de fecha y hora usando el método modify. (para sumar años por ejemplo).

        TODO: Introducir comprobaciones para dia, mes y año y una comprobar fecha.
        TODO: Puedo crear otra versión en la cual el input sea una lista desplegable, de tal modo que el formato de entrada va a ser otro.

    */

    function obtener($arg)
    {
        return isset($_GET[$arg]) ? $_GET[$arg] : null;
    }

    function selected($valor, $option)
    {
            return $valor == $option ? 'selected' : '';
    }

    function numero_mes($meses, $mes)
    {
        return array_search($mes, $meses) + 1;
    }

    $datetime = new DateTime();
    $anyo_actual = $datetime->format('Y');
    const MESES = [
        1 => 'enero',
        'febrero',
        'marzo',
        'abril',
        'mayo',
        'junio',
        'julio',
        'agosto',
        'septiembre',
        'octubre',
        'noviembre',
        'diciembre',
    ];


    $dia =  obtener('dia');
    $mes = obtener('mes');
    $anyo = obtener('anyo');

    if ($dia && $mes && $anyo) {
        $num_mes = numero_mes(MESES, $mes);
        $fecha_nacimiento = DateTime::createFromFormat('d-m-Y', "$dia-$num_mes-$anyo");
        if (checkdate($num_mes, $dia, $anyo)) {
            $intervalo = $datetime->diff($fecha_nacimiento);
            $res = $intervalo->y;
        } else {
        }
    }

    ?>



    <center>
        <h1>Calculadora de años.</h1>
    </center>
    <form action="" method="get">
        <label for="dia">Selecciona tu día de nacimiento:</label>
        <select name="dia" id="dia">
            <?php
            for ($i = 1; $i < 31; $i++) {
            ?>
                <option value="<?= $i ?>" <?= selected($dia, $i) ?>><?= $i ?></option>
            <?php
            }
            ?>
        </select>
        <label for="mes">Selecciona tu mes de nacimiento:</label>
        <select name="mes" id="mes">
            <?php //TODO: Tener en cuenta esta parte para sacar la clave y mandar una cosa y mostrar en la lista desplegable otra.
            foreach (MESES as $mesfor) {
            ?>
                <option value="<?= $mesfor ?>" <?= selected($mes, $mesfor) ?>><?= $mesfor ?></option>
            <?php
            }
            ?>
        </select>
        <label for="anyo">Selecciona tu año:</label>
        <select name="anyo" id="anyo">
            <?php
            for ($i = $anyo_actual; $i > ($anyo_actual - 50); $i--) {
            ?>
                <option value="<?= $i ?>" <?= selected($anyo, $i) ?>><?= $i ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <br>
        <button type="submit">Calcular</button>
    </form>

    <p>Tu edad actual es: <?= isset($res) ? $res : ''; ?></p>
</body>

</html>
