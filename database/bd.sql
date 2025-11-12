
CREATE DATABASE IF NOT EXISTS bdprueba;
USE bdprueba;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL
);
insert into usuarios (usuario, clave, rol) values ('Armin', '$2y$10$mzG0iuQy0VZ2Jy2gENi28.CwG.yPcsMwbP1ssWF9EQxErVrcNXyvK', 'gerente');

