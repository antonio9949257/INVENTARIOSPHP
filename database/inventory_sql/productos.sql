USE bdprueba;

CREATE TABLE IF NOT EXISTS productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio_compra DECIMAL(10, 2) NOT NULL,
    precio_venta DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    stock_minimo INT NOT NULL DEFAULT 5,
    id_categoria INT,
    id_proveedor INT,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id) ON DELETE SET NULL
);

INSERT INTO productos (nombre, descripcion, precio_compra, precio_venta, stock, stock_minimo, id_categoria, id_proveedor) VALUES
('Paracetamol 500mg (Caja 20 pastillas)', 'Analgésico y antipirético para alivio del dolor y la fiebre.', 2.50, 4.99, 150, 25, 1, 1),
('Jabón Antibacterial (Barra)', 'Elimina el 99.9% de las bacterias. Uso diario.', 0.80, 1.75, 200, 50, 2, 2),
('Tensiómetro Digital de Brazo', 'Monitor de presión arterial automático y preciso.', 25.00, 45.50, 30, 10, 3, 3),
('Caja de Mascarillas Desechables (50 unidades)', 'Mascarillas quirúrgicas de 3 capas.', 4.00, 9.99, 500, 100, 4, 2),
('Ibuprofeno 400mg (Caja 10 pastillas)', 'Antiinflamatorio no esteroideo (AINE).', 1.50, 3.20, 120, 25, 1, 1);
