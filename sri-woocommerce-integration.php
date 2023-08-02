<?php
/**
 * Plugin Name: Sri WooCommerce Integration
 * Description: Plugin para integrar Woocommerce con el servicio de rentas internas (SRI) de Ecuador.
 */

// Require the necessary files
require_once plugin_dir_path(__FILE__) . 'includes/facturacion-database.php';
require_once plugin_dir_path(__FILE__) . 'includes/facturacion-functions.php';
require_once plugin_dir_path(__FILE__) . 'class-facturacion-woocommerce-admin.php';

// Initialize the plugin
add_action('plugins_loaded', 'sri_integration_init');
function sri_integration_init() {
    new SRI_WooCommerce_Admin();
}

// Add settings link on plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sri_integration_plugin_action_links');
function sri_integration_plugin_action_links($links) {
    $settings_link = '<a href="options-general.php?page=sri-woocommerce-settings">Configuración</a>';
    array_unshift($links, $settings_link);
    return $links;
}
