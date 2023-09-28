<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php

$Cad_original = isset($_GET['cadena']) && $_GET['cadena'] != '' ? $_GET['cadena'] : '';;
$array_cadena = mb_str_split($Cad_original);
$cadena_conjunto = array_unique($array_cadena);
$res = '';

?>

<body>
    <h1>ISOGRAMA</h1>
    <form action="" method="get">
        <label for="cadena">Introduce la cadena a analizar: </label>
        <input type="text" name="cadena" id="cadena">
        <button type="submit">Comprobar</button>
    </form>

    <?php
    if ($Cad_original != '') {
        if (count($array_cadena) == count($cadena_conjunto)) {
            $res = "SÍ es un isograma.";
    ?>
            <?= $res; ?>
        <?php
        } else {
            $res = "NO es un isograma.";
        ?>
            <?= $res; ?>
    <?php
        }
    }

    ?>
</body>

</html>
