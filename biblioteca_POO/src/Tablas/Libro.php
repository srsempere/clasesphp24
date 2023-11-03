<?php

namespace App\Tablas;

use PDO;

class Libro extends Modelo
{
    protected static string $tabla = 'libros';

    private $id;
    private $codigo;
    private $titulo;
    private $descripcion;
    private $autor;
    private $precio;
    private $stock;

    public function __construct(array $campos)
    {
        $this->id = $campos['id'];
        $this->codigo = $campos['codigo'];
        $this->titulo = $campos['titulo'];
        $this->descripcion = $campos['descripcion'];
        $this->autor = $campos['autor'];
        $this->precio = $campos['precio'];
        $this->stock = $campos['stock'];
    }

    public function existe(int $id, ?PDO $pdo = null): bool
    {
        return static::obtener($id, $pdo) !== null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function borrar(?PDO $pdo = null)
    {
        if (!isset($pdo)) {
            $pdo = conectar();
        }
        $sent = $pdo->prepare('DELETE FROM libros WHERE id= :id');
        $sent->execute([':id' => $this->id]);
        if ($sent->rowCount() === 0) {
            $_SESSION['error'] = 'No se ha encontrado el libro indicado en la base de datos';
            return false;
        }
        $_SESSION['exito'] = 'El libro se ha borrado correctamente';
        return true;
    }
}
