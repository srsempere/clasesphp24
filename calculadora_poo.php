<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylecalc.css">
    <title>Calculadora - POO</title>
</head>
<body>
    <?php
        require 'aux_calculadorapoo.php';
        $errores = [];
    ?>
    <h1>Calculadora</h1>
    <cite>Siguiendo el paradigma de POO.</cite>
    <form action="" method="get">
        <label for="op1">Operador 1</label>
        <input type="number" name="op1" id="op1">
        <label for="op2">Operador 2</label>
        <input type="number" name="op2" id="op2">
        <label for="op">Operación</label>
        <select name="op" id="">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <button type="submit">Calcular</button>
    </form>
</body>
</html>
