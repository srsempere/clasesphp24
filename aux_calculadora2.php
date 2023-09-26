<?php

function validaOp1($op1, &$errores)
{
    if (!is_numeric($op1) && $op1 !== '') {
        $errores[] = "El primer operador no es válido";
    }

    if (!is_numeric($op1) && $op1 === '') {
        $errores[] = "El primer primer operador está vacío";
    }
}

function validaOp2($op2, &$errores)
{
    if (!is_numeric($op2) && $op2 !== '') {
        $errores[] = "El segundo operador no es válido";
    }

    if (!is_numeric($op2) && $op2 === '') {
        $errores[] = "El primer segundo operador está vacío";
    }
}

function validaOperacion($op, &$errores)
{
    if (!in_array($op, ['+', '-', '*', '/']) && $op !== '') {
        $errores[] = 'La operación no está permitida';
    }

    if ($op === "") {
        $errores[]= 'El campo para insertar la operación está vacío.';
    }
}

function compruebaDivision($op, $op2, &$errores)
{
    if (isset($op, $op2) && $op == '/' && $op2 == '0') {
        $errores[] = "No se puede dividir entre cero.";
    }
}

function calcular($op1, $op2, $op)
{
    switch ($op) {
        case '+':
            return $op1 + $op2;
        case '-':
            return $op1 - $op2;
        case '*':
            return $op1 * $op2;
        case '/':
            return $op1 / $op2;
    }
}

function mostrarErrores($errores)
{
    if (!empty($errores)) { ?>
        <ul>
            <?php foreach($errores as $error): ?>
            <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
        <?php
    }

    }

    function mostrarResultado($res)
    {
        ?>
            El <strong>resutlado</strong> es <strong><?= $res ?></strong>
        <?php
    }
