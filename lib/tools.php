<?php
require_once __DIR__ . '/../conexion.php';

function obtener_stock_producto($nombre) {
    global $con;
    $nombre_like = "%$nombre%";
    $stmt = $con->prepare("SELECT stock FROM productos WHERE nombre LIKE ?");
    $stmt->bind_param("s", $nombre_like);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

function listar_proveedores() {
    global $con;
    $stmt = $con->prepare("SELECT id, nombre FROM proveedores");
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function obtener_ultimos_movimientos($limite = 5) {
    global $con;
    $stmt = $con->prepare("SELECT * FROM movimientos ORDER BY fecha DESC LIMIT ?");
    $stmt->bind_param("i", $limite);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function obtener_productos_por_categoria($nombre_categoria) {
    global $con;
    $categoria_like = "%$nombre_categoria%";
    $stmt = $con->prepare("SELECT p.nombre, p.stock, p.precio_venta FROM productos p JOIN categorias c ON p.id_categoria = c.id WHERE c.nombre LIKE ?");
    $stmt->bind_param("s", $categoria_like);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function obtener_productos_bajo_stock() {
    global $con;
    $stmt = $con->prepare("SELECT nombre, stock, stock_minimo FROM productos WHERE stock <= stock_minimo");
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function obtener_info_proveedor($nombre_proveedor) {
    global $con;
    $proveedor_like = "%$nombre_proveedor%";
    $stmt = $con->prepare("SELECT nombre, contacto, telefono, email, direccion FROM proveedores WHERE nombre LIKE ?");
    $stmt->bind_param("s", $proveedor_like);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

function obtener_valor_inventario_total($tipo_valor = 'compra') {
    global $con;
    $columna_precio = ($tipo_valor === 'venta') ? 'precio_venta' : 'precio_compra';
    if (!in_array($columna_precio, ['precio_compra', 'precio_venta'])) {
        return ['error' => 'Tipo de valor inválido.'];
    }
    $stmt = $con->prepare("SELECT SUM(stock * $columna_precio) AS valor_total FROM productos");
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}
