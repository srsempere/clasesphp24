DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros(
    id          BIGSERIAL    PRIMARY KEY,
    codigo      INTEGER      NOT NULL,
    titulo      VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    autor       VARCHAR(255) NOT NULL,
    precio      NUMERIC(6,2) NOT NULL,
    stock       INTEGER
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id       BIGSERIAL    PRIMARY KEY,
    usuario  VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    validado bool         NOT NULL
);



DROP TABLE IF EXISTS facturas CASCADE;

CREATE TABLE facturas (
    id BIGSERIAL PRIMARY KEY,
    created_at TIMESTAMP NOT NULL DEFAULT localtimestamp(0),
    usuario_id BIGINT NOT NULL REFERENCES usuarios (id)
);


DROP TABLE IF EXISTS libros_facturas CASCADE;

CREATE TABLE libros_facturas (
    libro_id BIGINT NOT NULL REFERENCES libros (id),
    factura_id BIGINT NOT NULL REFERENCES facturas (id) ,
    cantidad int NOT NULL,
    PRIMARY KEY(libro_id, factura_id)
);

-- Datos de prueba

INSERT INTO libros (codigo, titulo, descripcion, autor, precio, stock) VALUES
    (1001, 'Amanecer Rojo', 'Un futuro distante en Marte.', 'Pierce Brown', 14.99, 50),
    (1002, 'El Camino Menos Transitado', 'Reflexiones sobre la vida.', 'M. Scott Peck', 19.99, 40),
    (1003, 'Cien Años de Soledad', 'La historia de la familia Buendía.', 'Gabriel García Márquez', 24.99, 35),
    (1004, 'El Nombre del Viento', 'La vida de Kvothe.', 'Patrick Rothfuss', 20.99, 55),
    (1005, 'Dune', 'Conflicto por el control del melange.', 'Frank Herbert', 22.99, 60),
    (1006, '1984', 'Una distopía sobre el control totalitario.', 'George Orwell', 15.99, 50),
    (1007, 'La Chica del Tren', 'Un thriller misterioso.', 'Paula Hawkins', 18.99, 45),
    (1008, 'La Sombra del Viento', 'Un libro dentro de un libro.', 'Carlos Ruiz Zafón', 21.99, 40),
    (1009, 'Jurassic Park', 'El renacimiento de los dinosaurios.', 'Michael Crichton', 16.99, 55),
    (1010, 'Los Hombres que no Amaban a las Mujeres', 'Un misterio oscuro.', 'Stieg Larsson', 23.99, 50);


INSERT INTO usuarios (usuario, password, validado)
    VALUES ('admin', crypt('admin', gen_salt('bf', 10)), true),
           ('pepe', crypt('pepe', gen_salt('bf', 10)), false);
