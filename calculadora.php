<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>

<body>
    <?php

    $errores = [];

    $op1 = isset($_GET['op1']);
    $op2 = isset($_GET['op2']);
    $op = isset($_GET['op']);

    if (empty($errores)) {
        switch ($op) {
            case '+':
                $res = $op1 + $op2;
                break;
            case '*':
                $res = $op1 * $op2;
                break;
            case '-':
                $res = $op1 - $op2;
                break;
            case '/':
                $res = $op1 / $op2;
                break;
        }
    } else {
        $errores = [];
    }


    ?>
    "El resultado es <?= $res ?>;


</body>

</html>
