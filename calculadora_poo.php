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
    $calculadora = new Calculadora();
    $validador = new Validador();
    $vista = new VistaCalculadora();
    $utilidad = new Utilidad();
    $errores = [];

    $op1 = Utilidad::obtenerGet('op1');
    $op2 = Utilidad::obtenerGet('op2');
    $operador = Utilidad::obtenerGet('op');

    $vista->mostrarFormulario($op1, $op2, $operador);



    if (isset($op1, $op2, $operacion)) {
        $validador->valida($op1, $op2, $operacion, $errores);
        if (empty($errores)) {
            try {
                $resultado = $calculadora->calcular($op1, $op2, $op);
                $vista->mostrarResultado($resultado);
            } catch (\Throwable $th) {
                $vista->mostrarErrores($errores);
            }
        }
    }

    ?>
</body>

</html>
