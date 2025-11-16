USE bdprueba;

CREATE TABLE IF NOT EXISTS proveedores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(20),
    email VARCHAR(100),
    direccion VARCHAR(255)
);

INSERT INTO proveedores (nombre, contacto, telefono, email, direccion) VALUES
('PharmaGlobal Distribuciones', 'Ana Torres', '555-0101', 'ana.torres@pharmaglobal.com', 'Av. Principal 100, FarmaCiudad'),
('SaludVital S.A.', 'Luis Méndez', '555-0202', 'luis.mendez@saludvital.com', 'Calle de la Salud 25, FarmaCiudad'),
('MedEquip Suministros', 'Sofia Castro', '555-0303', 'sofia.castro@medequip.com', 'Plaza del Hospital 3, FarmaCiudad');
