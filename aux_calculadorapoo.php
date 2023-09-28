<?php

interface CalculadoraInterface
{
    public function calcular(float $op1, float $op2, string $operacion): float;
}

class Calculadora implements CalculadoraInterface
{
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
