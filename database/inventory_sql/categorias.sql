USE bdprueba;

CREATE TABLE IF NOT EXISTS categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255)
);

INSERT INTO categorias (nombre, descripcion) VALUES
('Medicamentos sin receta', 'Analgésicos, antiinflamatorios y otros de venta libre.'),
('Cuidado Personal', 'Productos de higiene, cuidado de la piel y cabello.'),
('Equipamiento Médico', 'Tensiómetros, termómetros y otros equipos.'),
('Primeros Auxilios', 'Vendas, desinfectantes, gasas y otros productos para curaciones.');
