USE bdprueba;

CREATE TABLE IF NOT EXISTS movimientos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida') NOT NULL,
    cantidad INT NOT NULL,
    fecha_movimiento DATETIME DEFAULT CURRENT_TIMESTAMP,
    observaciones TEXT,
    id_usuario INT, -- Added id_usuario column
    FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL -- Foreign key to users table
);

-- Assuming 'Armin' (the default user) has id = 1 in the 'usuarios' table
INSERT INTO movimientos (id_producto, tipo_movimiento, cantidad, observaciones, id_usuario) VALUES
(1, 'entrada', 10, 'Compra inicial de laptops', 1),
(2, 'entrada', 50, 'Compra inicial de camisetas', 1),
(1, 'salida', 2, 'Venta a cliente X', 1),
(3, 'entrada', 100, 'Reposición de stock de arroz', 1);