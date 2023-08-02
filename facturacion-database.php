<?php
// Crear las tablas de la base de datos necesarias para el plugin
function facturacion_create_tables() {
    global $wpdb;

    $tabla_comprobantes = $wpdb->prefix . 'facturacion_comprobantes';
    $tabla_productos = $wpdb->prefix . 'facturacion_productos';

    // Código para crear las tablas utilizando la función dbDelta
    $charset_collate = $wpdb->get_charset_collate();

    // Consulta SQL para crear la tabla $tabla_comprobantes
    $sql_comprobantes = "CREATE TABLE IF NOT EXISTS $tabla_comprobantes (
        id INT(11) NOT NULL AUTO_INCREMENT,
        fecha_factura DATE NOT NULL,
        numero_factura VARCHAR(20) NOT NULL,
        cliente_id INT(11) NOT NULL,
        total_factura DECIMAL(10, 2) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Consulta SQL para crear la tabla $tabla_productos
    $sql_productos = "CREATE TABLE IF NOT EXISTS $tabla_productos (
        id INT(11) NOT NULL AUTO_INCREMENT,
        nombre_producto VARCHAR(100) NOT NULL,
        precio_producto DECIMAL(10, 2) NOT NULL,
        stock INT(11) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Ejecutar las consultas
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_comprobantes);
    dbDelta($sql_productos);
}
