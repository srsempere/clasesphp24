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
        $this->id = isset($campos['id']) ? $campos['id'] : null;
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

    ##  CRUD  ##

    // READ
    // Se hereda con el método obtener de modelo

    // UPDATE Y CREATE (uso el constructor para el create)

    public function guardar(?PDO $pdo = null)
    {

        if ($pdo === null) {
            $pdo = conectar();
        }

        $libro = $this->getId() ? $this::obtener($this->getId()) : null;

        if (isset($libro)) {
            # Existe en la BD. UPDATE
            $query = "UPDATE libros
                        SET codigo= :codigo,
                            titulo= :titulo,
                            descripcion= :descripcion,
                            autor= :autor,
                            precio= :precio,
                            stock= :stock
                        WHERE id= :id";
        } else {
            # No existe en la BD. Insert Into
            $query = "INSERT INTO libros (codigo, titulo, descripcion, autor, precio, stock)
                        VALUES (:codigo, :titulo, :descripcion, :autor, :precio, :stock)";
        }

        $sent = $pdo->prepare($query);
        $params = [
            ':codigo' => $this->getCodigo(),
            ':titulo' => $this->getTitulo(),
            ':descripcion' => $this->getDescripcion(),
            ':autor' => $this->getAutor(),
            ':precio' => $this->getPrecio(),
            ':stock' => $this->getStock()
        ];

        if (isset($libro)) {
            $params[':id'] = $this->getId();
        }
        return $sent->execute($params);
    }

    // DELETE

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
