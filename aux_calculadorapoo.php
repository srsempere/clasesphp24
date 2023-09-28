<?php

interface CalculadoraInterface
{
    public function calcular(float $op1, float $op2, string $operacion): float;
}

class Calculadora implements CalculadoraInterface
{
    const OPS = ['+', '-', '*', '/'];

    public function calcular(float $op1, float $op2, string $operacion): float
    {
        if (!is_numeric($op1) || !is_numeric($op2)) {
            throw new InvalidArgumentException('Los operandos deben ser numéricos.');
        }

        $op1 = floatval($op1);
        $op2 = floatval($op2);

        switch ($operacion) {
            case '+':
                return $op1 + $op2;
            case '-':
                return $op1 - $op2;
            case '*':
                return $op1 * $op2;
            case '/':
                if ($op2 == 0) {
                    throw new DivisionByZeroError('No se puede dividir por cero.');
                }
                return $op1 / $op2;
            default:
                throw new InvalidArgumentException('Operación no soportada');
        }
    }
}

class Validador {
    public function valida($op1, $op2, $operacion, &$errores)
    {
        if (!is_numeric($op1) && $op1 === '') {
            $errores[] = 'El primer operador no puede estar vacío.';
        }

        if (!is_numeric($op1)) {
            $errores[] = 'El primer operador no es un número.';
        }

        if (!is_numeric($op2) && $op2 === '') {
            $errores[] = 'El segundo operador no puede estar vacío.';
        }

        if (!is_numeric($op2)) {
            $errores[] = 'El segundo operador no es un número.';
        }

        if ($operacion === '') {
            $errores[] = 'La operación no puede estar vacía.';
        }

        if ($operacion == '/' && $op2 == '0') {
            $errores[] = 'No se puede dividir entre cero.';
        }

        if (!in_array($operacion, Calculadora::OPS)) {
            $errores[] = 'La operación no está permitida.';
        }
    }
}
