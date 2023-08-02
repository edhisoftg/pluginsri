<?php
/**
 * Plugin Name: Facturación Electrónica
 * Description: Plugin para integrar la facturación electrónica con WooCommerce.
 * Version: 1.0.0
 */

// Incluir los archivos necesarios
require_once plugin_dir_path(__FILE__) . 'includes/facturacion-database.php';
require_once plugin_dir_path(__FILE__) . 'includes/facturacion-functions.php';
require_once plugin_dir_path(__FILE__) . 'class-facturacion-woocommerce-admin.php';

// Activar el plugin
function facturacion_electronica_plugin_activate() {
    facturacion_create_tables();
}
register_activation_hook(__FILE__, 'facturacion_electronica_plugin_activate');

// Desactivar el plugin
function facturacion_electronica_plugin_deactivate() {
    // Código para limpiar y eliminar cualquier configuración o datos del plugin si es necesario
}
register_deactivation_hook(__FILE__, 'facturacion_electronica_plugin_deactivate');

// Inicializar la clase de administración del plugin
if (class_exists('Facturacion_WooCommerce_Admin')) {
    $facturacion_admin = new Facturacion_WooCommerce_Admin();
}

// Resto del código del plugin
// ...
