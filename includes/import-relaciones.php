<?php

if (!defined('ABSPATH')) {
    exit;
}

function dsed_importar_relaciones()
{
    global $wpdb;

    $csv = '/data/minerales-etl/rel_mineral_foto.csv';

    if (!file_exists($csv)) {
        return 'CSV no encontrado';
    }

    $fh = fopen($csv, 'r');

    $cabecera = fgetcsv($fh);

    $total = 0;

    while (($row = fgetcsv($fh)) !== false) {

        $legacy_mineral = trim($row[0]);
        $legacy_recurso = trim($row[1]);

        $wp_mineral = $wpdb->get_var($wpdb->prepare("
            SELECT post_id
            FROM {$wpdb->postmeta}
            WHERE meta_key='legacy_id'
            AND meta_value=%s
            LIMIT 1
        ", $legacy_mineral));

        $wp_recurso = $wpdb->get_var($wpdb->prepare("
            SELECT post_id
            FROM {$wpdb->postmeta}
            WHERE meta_key='legacy_id'
            AND meta_value=%s
            LIMIT 1
        ", $legacy_recurso));

        if (!$wp_mineral || !$wp_recurso) {
            continue;
        }

        add_post_meta(
            $wp_mineral,
            'recurso_relacionado',
            $wp_recurso,
            false
        );

        add_post_meta(
            $wp_recurso,
            'mineral_relacionado',
            $wp_mineral,
            false
        );

        $total++;
    }

    fclose($fh);

    return $total;
}

add_action('admin_init', function () {

    if (!current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['import_relaciones'])) {
        return;
    }

    $total = dsed_importar_relaciones();

    echo "<pre>";
    echo "RELACIONES IMPORTADAS: {$total}\n";
    exit;
});