USE bdprueba;

CREATE TABLE IF NOT EXISTS productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio_compra DECIMAL(10, 2) NOT NULL,
    precio_venta DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    id_categoria INT,
    id_proveedor INT,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id) ON DELETE SET NULL
);

INSERT INTO productos (nombre, descripcion, precio_compra, precio_venta, stock, id_categoria, id_proveedor) VALUES
('Laptop Gamer', 'Potente laptop para juegos', 800.00, 1200.00, 15, 1, 1),
('Camiseta Algodón', 'Camiseta básica de algodón', 5.00, 15.00, 100, 2, 2),
('Arroz 1kg', 'Arroz blanco de grano largo', 1.50, 2.50, 200, 3, 3),
('Smart TV 55"', 'Televisor inteligente 4K', 400.00, 700.00, 20, 1, 1);