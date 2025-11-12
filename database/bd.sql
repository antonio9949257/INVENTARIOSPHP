
CREATE DATABASE IF NOT EXISTS bdprueba;
USE bdprueba;

CREATE TABLE IF NOT EXISTS usuarios (
    usuario VARCHAR(50) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL
);
insert into usuarios (usuario, clave) values ('Armin', 'armin1234');

