// sri-woocommerce-settings.php

// Función para mostrar el formulario de configuración
function sri_integration_settings_page() {
    // Verificar si se ha enviado el formulario y guardar los datos de configuración
    if (isset($_POST['submit'])) {
        // Obtener los datos ingresados en el formulario para TABLA1
        $fechaEmision = intval($_POST['fecha_emision']);
        $tipoComprobante = intval($_POST['tipo_comprobante']);
        $numeroRUC = intval($_POST['numero_ruc']);
        $tipoAmbiente = intval($_POST['tipo_ambiente']);
        $serie = intval($_POST['serie']);
        $numeroComprobante = intval($_POST['numero_comprobante']);
        $codigoNumerico = intval($_POST['codigo_numerico']);
        $tipoEmision = intval($_POST['tipo_emision']);
        $digitoVerificador = intval($_POST['digito_verificador']);

        // Guardar los datos en la tabla TABLA1
        global $wpdb;
        $tabla1 = $wpdb->prefix . 'TABLA1';
        $wpdb->insert(
            $tabla1,
            array(
                'FechaEmision' => $fechaEmision,
                'TipoComprobante' => $tipoComprobante,
                'NumeroRUC' => $numeroRUC,
                'TipoAmbiente' => $tipoAmbiente,
                'Serie' => $serie,
                'NumeroComprobante' => $numeroComprobante,
                'CodigoNumerico' => $codigoNumerico,
                'TipoEmision' => $tipoEmision,
                'DigitoVerificador' => $digitoVerificador,
            )
        );
    }

    // Formulario para ingresar datos en la tabla TABLA1
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="">
            <!-- Campos del formulario para TABLA1 -->
            <label for="fecha_emision">Fecha de Emisión:</label>
            <input type="text" id="fecha_emision" name="fecha_emision" required>
            <br>
            <label for="tipo_comprobante">Tipo de Comprobante:</label>
            <input type="text" id="tipo_comprobante" name="tipo_comprobante" required>
            <br>
            <!-- Agregar más campos para TABLA1 -->

            <?php wp_nonce_field('sri_settings_nonce', 'sri_settings_nonce'); ?>
            <?php submit_button('Guardar', 'primary', 'submit'); ?>
        </form>
    </div>
    <?php
}

// Resto del código del archivo
// ...
