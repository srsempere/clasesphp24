<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora - Final</title>
</head>

<body>
    <?php require 'aux_calculadora2.php'; ?>

    <form action="" method="get">
        <label for="op1">Operador 1</label>
        <input type="text" name="op1" id="op1" value="<?= isset($_GET['op1']) ? $_GET['op1'] : "";  ?>"><br>
        <label for="op2">Operador 2</label>
        <input type="text" name="op2" id="op2" value="<?= isset($_GET['op2']) ? $_GET['op2'] : "";  ?>"><br>
        <label for="op">Elija una operación</label>
        <!-- <input type="text" name="op" id="op" value="<?= isset($_GET['op']) ? $_GET['op'] : "";  ?>"><br> -->
        <select name="op" id="op">
            <option value='+'<?= isset($_GET['op']) && $_GET['op'] == '+' ? 'selected' : ''; ?>>+</option>
            <option value='-'<?= isset($_GET['op']) && $_GET['op'] == '-' ? 'selected' : ''; ?>>-</option>
            <option value='*'<?= isset($_GET['op']) && $_GET['op'] == '*' ? 'selected' : ''; ?>>*</option>
            <option value='/'<?= isset($_GET['op']) && $_GET['op'] == '/' ? 'selected' : ''; ?>>/</option>
        </select>
        <button>Calcular</button>
    </form>

    <?php
    $errores = [];

    if (isset($_GET['op1'], $_GET['op2'], $_GET['op2'])) {
        $op1 = $_GET['op1'];
        $op2 = $_GET['op2'];
        $op = $_GET['op'];
        validaOp1($op1, $errores);
        validaOp2($op2, $errores);
        validaOperacion($op, $errores);
        compruebaDivision($op, $op2, $errores);
    }

    if (isset($op1, $op2, $op) && empty($errores)) {
        $res = calcular($op1, $op2, $op);
        mostrarResultado($res);
    } else {
        mostrarErrores($errores);
    }

    ?>
</body>

</html>
