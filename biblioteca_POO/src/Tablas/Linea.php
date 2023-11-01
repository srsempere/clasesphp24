<?php

namespace App\Tablas;

use App\Tablas\Libro;

class Linea extends Modelo
{
    private Libro $libro;
    private int $cantidad;

    public function __construct(array $campos)
    {
        $this->libro = Libro::obtener($campos['articulo_id']);
        $this->cantidad = $campos['cantidad'];
    }

    public function getArticulo(): Libro
    {
        return $this->libro;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }
}
