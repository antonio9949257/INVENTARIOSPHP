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
('Tech Solutions Inc.', 'Juan Perez', '555-1234', 'juan.perez@techsol.com', '123 Tech Ave, Ciudad'),
('Fashion Trends Co.', 'Maria Garcia', '555-5678', 'maria.garcia@fashion.com', '456 Style Blvd, Ciudad'),
('Food Supply SA', 'Carlos Lopez', '555-9012', 'carlos.lopez@foodsupply.com', '789 Food St, Ciudad');