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

    fgetcsv($fh);

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

add_action('admin_init', function () {

    if (!current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['import_rel_mineral_ejemplar'])) {
        return;
    }

    set_time_limit(0);

    $csv = '/data/minerales-etl/rel_mineral_ejemplar.csv';

    if (!file_exists($csv)) {
        wp_die('No existe rel_mineral_ejemplar.csv');
    }

    $fp = fopen($csv, 'r');

    $header = fgetcsv($fp);

    $ok = 0;
    $errores = 0;

    while (($row = fgetcsv($fp)) !== false) {

        $row = array_combine($header, $row);

        $legacy_mineral  = (int)$row['mineral_legacy_id'];
        $legacy_ejemplar = $row['ejemplar_legacy_id'] . '.0';

        $mineral = get_posts([
            'post_type'   => 'mineral',
            'numberposts' => 1,
            'meta_key'    => 'legacy_id',
            'meta_value'  => $legacy_mineral
        ]);

        $ejemplar = get_posts([
            'post_type'   => 'ejemplar',
            'numberposts' => 1,
            'meta_key'    => 'legacy_id',
            'meta_value'  => $legacy_ejemplar
        ]);

        if (!$mineral || !$ejemplar) {
            $errores++;
            continue;
        }

        $mineral_id  = $mineral[0]->ID;
        $ejemplar_id = $ejemplar[0]->ID;

        add_post_meta(
            $mineral_id,
            'ejemplar_relacionado',
            $ejemplar_id,
            false
        );

        add_post_meta(
            $ejemplar_id,
            'mineral_relacionado',
            $mineral_id,
            false
        );

        $ok++;
    }

    fclose($fp);

    echo "<pre>";
    echo "RELACIONES: {$ok}\n";
    echo "ERRORES: {$errores}\n";
    exit;
});

add_action('admin_init', function () {

    if (!current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['import_rel_mineral_documento'])) {
        return;
    }

    $csv = '/data/minerales-etl/rel_mineral_documento.csv';

    if (!file_exists($csv)) {
        wp_die('No existe rel_mineral_documento.csv');
    }

    $fp = fopen($csv, 'r');

    $header = fgetcsv($fp);

    $ok = 0;
    $errores = 0;

    while (($row = fgetcsv($fp)) !== false) {

        $row = array_combine($header, $row);

        $legacy_mineral   = (int)$row['IdMineralGen'];
        $legacy_documento = (int)$row['IdDocumento'];

        $mineral = get_posts([
            'post_type'   => 'mineral',
            'numberposts' => 1,
            'meta_key'    => 'legacy_id',
            'meta_value'  => $legacy_mineral
        ]);

        $documento = get_posts([
            'post_type'   => 'documento',
            'numberposts' => 1,
            'meta_key'    => 'legacy_id',
            'meta_value'  => $legacy_documento
        ]);

        if (!$mineral || !$documento) {
            $errores++;
            continue;
        }

        add_post_meta(
            $mineral[0]->ID,
            'documento_relacionado',
            $documento[0]->ID,
            false
        );

        add_post_meta(
            $documento[0]->ID,
            'mineral_relacionado',
            $mineral[0]->ID,
            false
        );

        $ok++;
    }

    fclose($fp);

    echo "<pre>";
    echo "DOCUMENTOS: {$ok}\n";
    echo "ERRORES: {$errores}\n";
    exit;
});

add_action('admin_init', function () {

    if (!current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['import_rel_mineral_enlace'])) {
        return;
    }

    $csv = '/data/minerales-etl/rel_mineral_enlace.csv';

    if (!file_exists($csv)) {
        wp_die('No existe rel_mineral_enlace.csv');
    }

    $fp = fopen($csv, 'r');

    $header = fgetcsv($fp);

    $ok = 0;
    $errores = 0;

    while (($row = fgetcsv($fp)) !== false) {

        $row = array_combine($header, $row);

        $legacy_mineral = (int)$row['IdMineralGen'];
        $legacy_enlace  = (int)$row['IdEnlace'];

        $mineral = get_posts([
            'post_type'   => 'mineral',
            'numberposts' => 1,
            'meta_key'    => 'legacy_id',
            'meta_value'  => $legacy_mineral
        ]);

        $enlace = get_posts([
            'post_type'   => 'enlace',
            'numberposts' => 1,
            'meta_key'    => 'legacy_id',
            'meta_value'  => $legacy_enlace
        ]);

        if (!$mineral || !$enlace) {
            $errores++;
            continue;
        }

        add_post_meta(
            $mineral[0]->ID,
            'enlace_relacionado',
            $enlace[0]->ID,
            false
        );

        add_post_meta(
            $enlace[0]->ID,
            'mineral_relacionado',
            $mineral[0]->ID,
            false
        );

        $ok++;
    }

    fclose($fp);

    echo "<pre>";
    echo "ENLACES: {$ok}\n";
    echo "ERRORES: {$errores}\n";
    exit;
});
