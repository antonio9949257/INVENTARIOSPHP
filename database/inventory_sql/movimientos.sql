USE bdprueba;

CREATE TABLE IF NOT EXISTS movimientos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida') NOT NULL,
    cantidad INT NOT NULL,
    fecha_movimiento DATETIME DEFAULT CURRENT_TIMESTAMP,
    observaciones TEXT,
    id_usuario INT,
    FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL
);

INSERT INTO movimientos (id_producto, tipo_movimiento, cantidad, observaciones, id_usuario) VALUES
(1, 'entrada', 200, 'Pedido inicial a PharmaGlobal', 1),
(2, 'entrada', 300, 'Pedido inicial a SaludVital', 1),
(3, 'entrada', 50, 'Pedido inicial a MedEquip', 1),
(4, 'entrada', 1000, 'Stock de contingencia', 1),
(1, 'salida', 10, 'Venta a cliente minorista', 1),
(2, 'salida', 25, 'Venta a cliente minorista', 1),
(5, 'entrada', 150, 'Nuevo lote de PharmaGlobal', 1);
