<?php
/**
 * Plugin Name: Migracion DSED
 * Description: Migracion SIC/DSED
 * Version: 0.1
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MIGRACION_DSED_PATH', plugin_dir_path(__FILE__));

require_once __DIR__.'/includes/importer.php';
require_once __DIR__.'/includes/post-types.php';
require_once __DIR__.'/includes/import-relaciones.php';
require_once __DIR__.'/includes/frontend-relaciones.php';
require_once __DIR__.'/includes/frontend-minerales-relacionados.php';
require_once __DIR__.'/includes/frontend-styles.php';
require_once __DIR__.'/includes/import-fotos.php';
require_once __DIR__.'/includes/import-rel-fotos.php';
require_once __DIR__.'/includes/import-thumbnails.php';

add_action('admin_menu', function () {

    add_menu_page(
        'Migracion DSED',
        'Migracion DSED',
        'manage_options',
        'migracion-dsed',
        'dsed_admin_page'
    );

});

function dsed_admin_page()
{
    echo '<div class="wrap">';
    echo '<h1>Migración DSED</h1>';
	/*
    if (isset($_POST['importar_relaciones'])) {

        $total = dsed_importar_relaciones();

        echo '<div class="notice notice-success">';
        echo '<p>Relaciones importadas: '.$total.'</p>';
        echo '</div>';
    }
	*/
    ?>
/*
    <form method="post">
        <p>
            <input
                type="submit"
                name="importar_relaciones"
                class="button button-primary"
                value="Importar relaciones">
        </p>
    </form>
*/
    <?php

    echo '</div>';
}
