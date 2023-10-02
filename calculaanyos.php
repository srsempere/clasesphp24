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

    */

        function obtener($arg)
        {
            return isset($_GET[$arg]) ? $_GET[$arg] : null;
        }

        function selected($valor, $option)
        {
            if ($valor == $option) {
                return $valor == $option ? 'selected' : '';
            }
        }

        $datetime = new DateTime();
        $anyo_actual = $datetime->format('Y');
        const MESES = [1 => 'enero',
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


    ?>



    <center><h1>Calculadora de años.</h1></center>
    <form action="" method="get">
        <label for="dia">Selecciona tu día de nacimiento:</label>
        <select name="dia" id="dia">
            <?php
                for ($i=1; $i <31 ; $i++) {
                    ?>
                    <option value="<?= $i ?>" <?= selected($dia, $i) ?>><?= $i ?></option>
                    <?php
                }
            ?>
        </select>
        <label for="mes">Selecciona tu mes de nacimiento:</label>
        <select name="mes" id="mes">
            <?php
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
                for ($i=$anyo_actual; $i > ($anyo_actual - 50 )  ; $i--) {
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

    <p><?= isset($dia) ? $dia: ''; ?></p>
    <p><?= isset($mes) ? $mes: ''; ?></p>
    <p><?= isset($anyo) ? $anyo: ''; ?></p>
</body>
</html>
