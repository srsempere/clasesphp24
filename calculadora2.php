<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora - Final</title>
</head>

<body>
    <?php require 'aux_calculadora2.php';
    $op1 = obtener_get('op1');
    $op2 = obtener_get('op2');
    $op = obtener_get('op');
    ?>

    <form action="" method="get">
        <label for="op1">Operador 1</label>
        <input type="text" name="op1" id="op1" value="<?= $op1; ?>"><br>
        <label for="op2">Operador 2</label>
        <input type="text" name="op2" id="op2" value="<?= $op2; ?>"><br>
        <label for="op">Elija una operación</label>
        <select name="op" id="op">
            <?php foreach(OPS as $operador): ?>
            <option value='<?= $operador ?>' <?= selecciona_option($op, $operador) ?>><?= $operador ?></option>
            <?php endforeach; ?>
        </select>
        <button>Calcular</button>
    </form>

    <?php
    $errores = [];

    if (isset($op1, $op2, $op2)) {
        valida_op1($op1, $errores);
        valida_op2($op2, $errores);
        valida_operacion($op, $errores);
        comprueba_division($op, $op2, $errores);
        if (empty($errores)) {
            $res = calcular($op1, $op2, $op);
            ?>
            <p><?= mostrar_Resultado($res); ?></p>
            <?php
        } else {
            mostrar_Errores($errores);
        }
    }

    ?>
</body>

</html>
