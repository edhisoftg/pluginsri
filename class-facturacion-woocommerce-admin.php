// Clase para gestionar las configuraciones y funciones específicas del panel de administración
class Facturacion_WooCommerce_Admin {
    // Constructor de la clase
    public function __construct() {
        // Agregar acciones y filtros necesarios para el panel de administración
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    // Método para agregar la página de configuración al menú del panel de administración
    public function add_admin_menu() {
        add_submenu_page(
            'options-general.php',
            'Configuración Facturación Electrónica',
            'Facturación Electrónica',
            'manage_options',
            'facturacion-electronica-settings',
            array($this, 'settings_page')
        );
    }

    // Método para mostrar la página de configuración en el panel de administración
    public function settings_page() {
        // Verificar si se ha enviado el formulario y actualizar la configuración en la base de datos
        if (isset($_POST['facturacion_settings_submit'])) {
            // Verificar el nonce para evitar ataques CSRF
            if (isset($_POST['facturacion_settings_nonce']) && wp_verify_nonce($_POST['facturacion_settings_nonce'], 'facturacion_settings_nonce')) {
                // Sanitizar y guardar los datos de configuración en la base de datos
                $opciones_configuracion = array(
                    'nombre_empresa' => sanitize_text_field($_POST['facturacion_settings']['nombre_empresa']),
                    'ruc_empresa' => sanitize_text_field($_POST['facturacion_settings']['ruc_empresa']),
                    'p12_file' => sanitize_text_field($_POST['facturacion_settings']['p12_file']),
                    'p12_password' => sanitize_text_field($_POST['facturacion_settings']['p12_password']),
                );

                update_option('facturacion_electronica_settings', $opciones_configuracion);

                // Guardar datos en la tabla1
                global $wpdb;
                $tabla1 = $wpdb->prefix . 'tabla1';
                $wpdb->insert(
                    $tabla1,
                    array(
                        'FechaEmision' => sanitize_text_field($_POST['facturacion_settings']['fecha_comprobante']),
                        'TipoComprobante' => sanitize_text_field($_POST['facturacion_settings']['tipo_comprobante']),
                        'NumeroRUC' => sanitize_text_field($_POST['facturacion_settings']['ruc_emisor']),
                        // ... insertar más campos según la tabla1
                    )
                );
            }
        }

        // Obtener las opciones de configuración guardadas en la base de datos
        $opciones_configuracion = get_option('facturacion_electronica_settings', array());

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="" enctype="multipart/form-data">
                <?php wp_nonce_field('facturacion_settings_nonce', 'facturacion_settings_nonce'); ?>
                <table class="form-table">
                    <!-- Agregar los campos del formulario según tus necesidades -->
                    <tr>
                        <th><label for="nombre_empresa">Nombre de la Empresa</label></th>
                        <td>
                            <input type="text" id="nombre_empresa" name="facturacion_settings[nombre_empresa]" value="<?php echo esc_attr($opciones_configuracion['nombre_empresa']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="ruc_empresa">RUC</label></th>
                        <td>
                            <input type="text" id="ruc_empresa" name="facturacion_settings[ruc_empresa]" value="<?php echo esc_attr($opciones_configuracion['ruc_empresa']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="p12_file">Archivo .p12</label></th>
                        <td>
                            <input type="file" id="p12_file" name="facturacion_settings[p12_file]" />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="p12_password">Contraseña del archivo .p12</label></th>
                        <td>
                            <input type="password" id="p12_password" name="facturacion_settings[p12_password]" value="<?php echo esc_attr($opciones_configuracion['p12_password']); ?>" />
                        </td>
                    </tr>
                    <!-- Agregar más campos de configuración según tus necesidades -->
                    <tr>
                        <th><label for="fecha_comprobante">Fecha del comprobante</label></th>
                        <td>
                            <input type="date" id="fecha_comprobante" name="facturacion_settings[fecha_comprobante]" required>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="tipo_comprobante">Tipo de comprobante</label></th>
                        <td>
                            <input type="text" id="tipo_comprobante" name="facturacion_settings[tipo_comprobante]" required>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="ruc_emisor">RUC emisor</label></th>
                        <td>
                            <input type="text" id="ruc_emisor" name="facturacion_settings[ruc_emisor]" required>
                        </td>
                    </tr>
                    <!-- Agregar más campos para la tabla1 -->
                </table>
                <p>
                    <input type="submit" name="facturacion_settings_submit" class="button button-primary" value="Guardar cambios" />
                </p>
            </form>
        </div>
        <?php
    }
}

// Crear una instancia de la clase
new Facturacion_WooCommerce_Admin();
