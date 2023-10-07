DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros (
    id BIGSERIAL PRIMARY KEY,
    codigo INTEGER NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    editorial VARCHAR(255) NOT NULL,
    anyo_publicacion INTEGER NOT NULL,
    isbn VARCHAR(255) NOT NULL UNIQUE,
    cantidad INTEGER
);

INSERT INTO libros (codigo, titulo, autor, editorial, anyo_publicacion, isbn, cantidad)
VALUES  (10, 'El Bosque Encantado', 'Luna Martínez', 'Editorial Sol', 2010, '9781234567890', 5),
        (20, 'Viaje al Centro de la Tierra', 'Jules Verne', 'Montañas Ediciones', 1864, '9781234567891', 3),
        (30, 'Los Misterios del Océano', 'Oscar Mar', 'Editorial Ola', 2018, '9781234567892', 7),
        (40, 'La Ciudad de las Estrellas', 'Irene Cielo', 'Galaxia Editorial', 2022, '9781234567893', 10),
        (50, 'Historias de Dragones', 'Pedro Fuego', 'Editorial Cueva', 2018, '9781234567894', 6),
        (60, 'El Jardín Secreto', 'Rosa Flores', 'Verde Editorial', 1990, '9781234567895', 4),
        (70, 'El Laberinto del Minotauro', 'Héctor Historias', 'Mitos Ediciones', 2005, '9781234567896', 8),
        (80, 'Las Aventuras del Espacio', 'Neil Cosmos', 'Estrellas Editorial', 2021, '9781234567897', 9),
        (90, 'El Río de los Sueños', 'Ana Noche', 'Luna Llena Ediciones', 2019, '9781234567898', 2),
        (100, 'Montañas Mágicas', 'Eva Tierra', 'Editorial Roca', 2008, '9781234567899', 5);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP
);

INSERT INTO usuarios (nombre, email, password_hash, fecha_registro)
VALUES  ('Luisa Fernández', 'luisa.fernandez@email.com', 'hashficticio1234A', '2023-01-10 14:23:45'),
        ('Miguel Álvarez', 'miguel.alvarez@email.com', 'hashficticio1234B', '2023-02-15 12:13:14'),
        ('Carla Rodríguez', 'carla.rodriguez@email.com', 'hashficticio1234C', '2023-03-05 09:08:07'),
        ('Antonio Morales', 'antonio.morales@email.com', 'hashficticio1234D', '2023-04-20 16:45:30'),
        ('Sofía Guzmán', 'sofia.guzman@email.com', 'hashficticio1234E', '2023-05-11 11:11:11'),
        ('Javier Paredes', 'javier.paredes@email.com', 'hashficticio1234F', '2023-06-24 18:34:56'),
        ('María Luna', 'maria.luna@email.com', 'hashficticio1234G', '2023-07-03 10:20:30'),
        ('Carlos Sol', 'carlos.sol@email.com', 'hashficticio1234H', '2023-08-15 14:14:14'),
        ('Daniela Ríos', 'daniela.rios@email.com', 'hashficticio1234I', '2023-09-09 09:09:09'),
        ('Ernesto Vargas', 'ernesto.vargas@email.com', 'hashficticio1234J', '2023-10-01 20:20:20');

DROP TABLE IF EXISTS prestamos CASCADE;

CREATE TABLE prestamos (
    id_PRESTAMO BIGSERIAL PRIMARY KEY,
    id_libro BIGSERIAL REFERENCES libros(id) ON DELETE CASCADE,
    id_usuario BIGSERIAL REFERENCES usuarios(id) ON DELETE CASCADE,
    fecha_prestamo TIMESTAMP,
    fecha_devolucion TIMESTAMP,
    fecha_devuelto TIMESTAMP
);

INSERT INTO prestamos (id_libro, id_usuario, fecha_prestamo, fecha_devolucion, fecha_devuelto)
VALUES  (1, 1, '2023-01-10 14:23:45', '2023-01-17 14:23:45', '2023-01-15 14:23:45'),
        (2, 1, '2023-01-11 10:10:10', '2023-01-18 10:10:10', NULL),
        (3, 2, '2023-01-12 11:11:11', '2023-01-19 11:11:11', '2023-01-18 11:11:11'),
        (1, 3, '2023-01-13 12:12:12', '2023-01-20 12:12:12', NULL),
        (4, 4, '2023-01-14 13:13:13', '2023-01-21 13:13:13', '2023-01-20 13:13:13'),
        (5, 5, '2023-01-15 14:14:14', '2023-01-22 14:14:14', NULL),
        (6, 6, '2023-01-16 15:15:15', '2023-01-23 15:15:15', '2023-01-22 15:15:15'),
        (7, 7, '2023-01-17 16:16:16', '2023-01-24 16:16:16', NULL),
        (8, 8, '2023-01-18 17:17:17', '2023-01-25 17:17:17', '2023-01-24 17:17:17'),
        (9, 9, '2023-01-19 18:18:18', '2023-01-26 18:18:18', NULL);

DROP TABLE IF EXISTS categorias CASCADE;

CREATE TABLE categorias (
    id BIGSERIAL PRIMARY KEY,
    nombre_categoria VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO categorias (nombre_categoria)
VALUES  ('Ciencia Ficción'),
        ('Fantasía'),
        ('Historia'),
        ('Biografías'),
        ('Misterio y Thriller'),
        ('Romance'),
        ('Autoayuda'),
        ('Tecnología'),
        ('Viajes'),
        ('Cocina');

DROP TABLE IF EXISTS libros_categorias CASCADE;

CREATE TABLE libros_categorias (
    id_libro BIGINT REFERENCES libros(id) ON DELETE CASCADE,
    id_categoria BIGINT REFERENCES categorias(id) ON DELETE CASCADE,
    PRIMARY KEY (id_libro, id_categoria)
);

INSERT INTO libros_categorias (id_libro, id_categoria)
VALUES  (1, 1),  -- El libro con ID 1 pertenece a la categoría con ID 1
        (1, 2),  -- El libro con ID 1 también pertenece a la categoría con ID 2
        (2, 1),  -- El libro con ID 2 pertenece a la categoría con ID 1
        (3, 3),  -- El libro con ID 3 pertenece a la categoría con ID 3
        (4, 4),  -- El libro con ID 4 pertenece a la categoría con ID 4
        (5, 5),  -- El libro con ID 5 pertenece a la categoría con ID 5
        (6, 2),  -- El libro con ID 6 pertenece a la categoría con ID 2
        (7, 3),  -- El libro con ID 7 pertenece a la categoría con ID 3
        (8, 4),  -- El libro con ID 8 pertenece a la categoría con ID 4
        (9, 1);  -- El libro con ID 9 pertenece a la categoría con ID 1
