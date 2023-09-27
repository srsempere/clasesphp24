<?php

const OPS = ['+', '-', '*', '/'];

function valida_op1($op1, &$errores)
{
    if (!is_numeric($op1) && $op1 !== '') {
        $errores[] = "El primer operador no es válido";
    }

    if (!is_numeric($op1) && $op1 === '') {
        $errores[] = "El primer primer operador está vacío";
    }
}

function valida_op2($op2, &$errores)
{
    if (!is_numeric($op2) && $op2 !== '') {
        $errores[] = "El segundo operador no es válido";
    }

    if (!is_numeric($op2) && $op2 === '') {
        $errores[] = "El primer segundo operador está vacío";
    }
}

function valida_operacion($op, &$errores)
{
    if (!in_array($op, OPS) && $op !== '') {
        $errores[] = 'La operación no está permitida';
    }

    if ($op === "") {
        $errores[]= 'El campo para insertar la operación está vacío.';
    }
}

function comprueba_division($op, $op2, &$errores)
{
    if ($op == '/' && $op2 == '0') {
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

function mostrar_Errores($errores)
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

    function mostrar_Resultado($res)
    {
        ?>
            El <strong>resutlado</strong> es <strong><?= $res ?></strong>
        <?php
    }

    function obtener_get($argumento)
    {
        return isset($_GET[$argumento]) ? trim($_GET[$argumento]) : null;
    }

    function selecciona_option($op, $option)
    {
        if ($op == $option) {
            return $op == $option ? 'selected' : '';
        }
    }
