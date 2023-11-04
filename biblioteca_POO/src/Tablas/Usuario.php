<?php

namespace App\Tablas;

use PDO;

class Usuario extends Modelo
{
    protected static string $tabla = 'usuarios';

    private $id;
    private $usuario;
    private $must_reset_password;
    private $validado;

    public function __construct(array $campos)
    {
        $this->id = $campos['id'];
        $this->usuario = $campos['usuario'];
        $this->must_reset_password = $campos['must_reset_password'];
        $this->validado = $campos['validado'];
    }

    public function es_admin(): bool
    {
        return $this->usuario == 'admin';
    }

    public static function esta_logeado(): bool
    {
        return isset($_SESSION['login']);
    }

    public static function logueado(): ?static
    {
        return isset($_SESSION['login']) ? unserialize($_SESSION['login']) : null;
    }

    public static function comprobar($login, $password, ?PDO $pdo = null)
    {
        $pdo = $pdo ?? conectar();

        $sent = $pdo->prepare('SELECT *
                                 FROM usuarios
                                WHERE usuario = :login');
        $sent->execute([':login' => $login]);
        $fila = $sent->fetch(PDO::FETCH_ASSOC);

        if ($fila === false) {
            return false;
        }

        return password_verify($password, $fila['password'])
            ? new static($fila)
            : false;
    }

    public static function existe($login, ?PDO $pdo = null): bool
    {
        return $login == '' ? false :
            !empty(static::todos(
                ['usuario = :usuario'],
                [':usuario' => $login],
                $pdo
            ));
    }

    public static function registrar($login, $password, ?PDO $pdo = null)
    {
        $sent = $pdo->prepare('INSERT INTO usuarios (usuario, password, validado)
                               VALUES (:login, :password, false)');
        $sent->execute([
            ':login' => $login,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->usuario;
    }

    public function getValidado()
    {
        return $this->validado;
    }

    public function getMustReset()
    {
        return $this->must_reset_password;
    }
}
