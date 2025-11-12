USE bdprueba;

CREATE TABLE IF NOT EXISTS movimientos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida') NOT NULL,
    cantidad INT NOT NULL,
    fecha_movimiento DATETIME DEFAULT CURRENT_TIMESTAMP,
    observaciones TEXT,
    FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE
);

INSERT INTO movimientos (id_producto, tipo_movimiento, cantidad, observaciones) VALUES
(1, 'entrada', 10, 'Compra inicial de laptops'),
(2, 'entrada', 50, 'Compra inicial de camisetas'),
(1, 'salida', 2, 'Venta a cliente X'),
(3, 'entrada', 100, 'Reposición de stock de arroz');