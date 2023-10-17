DROP TABLE IF EXISTS departamentos CASCADE;

CREATE TABLE departamentos (
    id           BIGSERIAL    PRIMARY KEY,
    codigo       NUMERIC(2)   NOT NULL UNIQUE,
    denominacion VARCHAR(255) NOT NULL,
    localidad    VARCHAR(255)
);

INSERT INTO departamentos (codigo, denominacion, localidad)
    VALUES (10, 'Informática',    'Sanlúcar'),
           (20, 'Administrativo', 'Jerez'),
           (30, 'Prevención',     'Trebujena'),
           (40, 'Laboratorio',    'Chipiona'),
           (50, 'Robótica',       'San Fernando');


DROP TABLE IF EXISTS empleados CASCADE;

CREATE TABLE empleados (
    id BIGSERIAL PRIMARY KEY,
    numero NUMERIC(4) NOT NULL UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255),
    salario NUMERIC(6,2),
    fecha_alta TIMESTAMP DEFAULT now(),
    departamento_id BIGINT NOT NULL REFERENCES departamentos(id)
);


INSERT INTO empleados (numero, nombre, apellidos, salario, fecha_alta,
                       departamento_id)
    VALUES (1000, 'Pepe', 'García', 1800.25, '2022-04-03 00:00:00', 2),
           (2000, 'María', 'Rodríguez', 2200.00, '2021-08-05 00:00:00', 1),
           (3000, 'Rosa', 'González', NULL, '2020-10-14 00:00:00', 3);

DROP INDEX IF EXISTS idx_empleados_departamento_id CASCADE;

CREATE INDEX idx_empleados_departamento_id ON empleados (departamento_id);
