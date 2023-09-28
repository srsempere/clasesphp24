<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php

function compruebaIsograma($array_cadena, $cadena_conjunto, $cad_original)
{
    if ($cad_original != '') {
        if (count($array_cadena) == count($cadena_conjunto)) {
            ?>
            <p>SÍ es un isograma.</p>
            <?php
        } else {
            ?>
            <p>NO es un isograma.</p>
        <?php
        }
    }
}

function borrar(&$cad_original)
{
    $cad_original = '';
}


$cad_original = isset($_GET['cadena']) && $_GET['cadena'] != '' ? $_GET['cadena'] : '';
$array_cadena = mb_str_split($cad_original);
$cadena_conjunto = array_unique($array_cadena);
$res = '';
$borrar = isset($_GET['borrar']) && $_GET['borrar'] != '' ? $_GET['borrar'] : '';

if ($borrar != '') {
    borrar($cad_original);
}


?>

<body>
    <h1>ISOGRAMA</h1>
    <form action="" method="get">
        <label for="cadena">Introduce la cadena a analizar: </label>
        <input type="text" name="cadena" id="cadena">
        <button type="submit">Comprobar</button>
        <input type="submit" value="borrar">
    </form>
    <p><?= compruebaIsograma($array_cadena, $cadena_conjunto, $cad_original) ?></p>
</body>

</html>
