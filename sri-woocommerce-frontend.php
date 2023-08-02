// sri-woocommerce-frontend.php

/**
 * Clase SRI_WooCommerce_Frontend
 * Maneja las solicitudes a la API de facturación electrónica.
 */
class SRI_WooCommerce_Frontend {

    // Constructor de la clase
    public function __construct() {
        // Agregar el shortcode para mostrar el formulario de configuración
        add_shortcode('sri_woocommerce_settings_form', array($this, 'show_settings_form'));

        // Procesar el formulario cuando se envíe
        add_action('init', array($this, 'process_settings_form'));
    }

    /**
     * Función para mostrar el formulario en la página de configuración del plugin
     */
    public function show_settings_form() {
        // Verificar si el usuario está autenticado
        if (!is_user_logged_in()) {
            // Puedes agregar aquí un mensaje para indicar que el usuario debe iniciar sesión
            return;
        }

        // Obtener los datos actuales de configuración
        $fecha_comprobante = get_option('fecha_comprobante');
        $tipo_comprobante = get_option('tipo_comprobante');
        $ruc_emisor = get_option('ruc_emisor');

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="">
                <?php wp_nonce_field('sri_settings_nonce', 'sri_settings_nonce'); ?>
                <label for="fecha_comprobante">Fecha del comprobante:</label>
                <input type="date" id="fecha_comprobante" name="fecha_comprobante" value="<?php echo esc_attr($fecha_comprobante); ?>" required>
                <br>
                <label for="tipo_comprobante">Tipo de comprobante:</label>
                <input type="text" id="tipo_comprobante" name="tipo_comprobante" value="<?php echo esc_attr($tipo_comprobante); ?>" required>
                <br>
                <label for="ruc_emisor">RUC emisor:</label>
                <input type="text" id="ruc_emisor" name="ruc_emisor" value="<?php echo esc_attr($ruc_emisor); ?>" required>
                <br>
                <?php submit_button('Guardar', 'primary', 'submit'); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Función para procesar el formulario cuando se envía
     */
    public function process_settings_form() {
        // Verificar si se ha enviado el formulario
        if (isset($_POST['submit'])) {
            // Verificar el nonce para evitar ataques CSRF
            if (isset($_POST['sri_settings_nonce']) && wp_verify_nonce($_POST['sri_settings_nonce'], 'sri_settings_nonce')) {
                // Obtener los datos ingresados en el formulario
                $fecha_comprobante = sanitize_text_field($_POST['fecha_comprobante']);
                $tipo_comprobante = sanitize_text_field($_POST['tipo_comprobante']);
                $ruc_emisor = sanitize_text_field($_POST['ruc_emisor']);

                // Guardar los datos en la configuración del plugin
                update_option('fecha_comprobante', $fecha_comprobante);
                update_option('tipo_comprobante', $tipo_comprobante);
                update_option('ruc_emisor', $ruc_emisor);

                // Redireccionar para evitar el reenvío del formulario al actualizar la página
                wp_redirect(admin_url('options-general.php?page=sri-woocommerce-settings'));
                exit();
            }
        }
    }
}

// Iniciar la clase al cargar el plugin
$sri_woocommerce_frontend = new SRI_WooCommerce_Frontend();

// Resto del código de la clase y otras funciones
// ...
