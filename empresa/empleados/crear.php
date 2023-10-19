<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta empleado</title>
</head>

<body>
    <?php
    session_start();
    require '../aux.php';
    $pdo = conectar();
    $departamentos = $pdo->query('SELECT * FROM DEPARTAMENTOS');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $numero = obtener_post('numero');
        $nombre = obtener_post('nombre');
        $apellidos = obtener_post('apellidos');
        $salario = obtener_post('salario');
        $departamento_seleccionado = obtener_post('departamento');


        if ($numero && $nombre && $apellidos && $salario) {
            // TODO: Realizar validaciones.

            // Comprobar que no existe ya ese número.
            $sent = $pdo->prepare('SELECT COUNT(numero) FROM empleados WHERE numero= :numero');
            $sent->execute([':numero' => $numero]);
            $coincidencias = $sent->fetchColumn();

            if ($coincidencias === 0) {

                $sent = $pdo->prepare('INSERT INTO empleados (numero, nombre, apellidos, salario, departamento_id)
                                    VALUES (:numero, :nombre, :apellidos, :salario, :departamento_seleccionado)');
                $sent->execute([
                    ':numero' => $numero,
                    ':nombre' => $nombre,
                    ':apellidos' => $apellidos,
                    ':salario' => $salario,
                    ':departamento_seleccionado' => $departamento_seleccionado
                ]);
                add_success('El empleado se ha creado correctamente');
                return ir_index();
            } else {
                add_error('El número de empleado introducido ya existe');
                return ir_index();
            }
        } else {
            add_error('No se ha podido crear el usuario. Revise que los campos estén correctos');
            return ir_index();
        }
    }

    ?>
    <h1>Crear un nuevo empleado</h1>

    <form action="" method="post">
        <label for="numero">Nº empleado</label>
        <input type="text" name="numero" id="numero" value="">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="">
        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" id="apellidos" value="">
        <label for="salario">Salario</label>
        <input type="text" name="salario" id="salario" value="">
        <select name="departamento" id="departamento">
            <?php foreach ($departamentos as $departamento) : ?>
                <option value="<?= $departamento['id'] ?>" <?= isset($departamento_seleccionado) && $departamento_seleccionado == $departamento['id'] ? 'selected' : '' ?>><?= $departamento['denominacion'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Alta empleado</button>
    </form>
    <a href="index.php">Volver a empleados</a>
</body>

</html>
