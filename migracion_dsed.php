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

require_once MIGRACION_DSED_PATH . 'includes/post-types.php';
// prueba bind mount
