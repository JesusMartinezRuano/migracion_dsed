<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_init', function () {

    if (!current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['import_minerales'])) {
        return;
    }

    $csv = '/data/minerales-etl/wp_minerales.csv';

    $f = fopen($csv, 'r');

    if (!$f) {
        wp_die('No se pudo abrir el CSV');
    }

    $header = fgetcsv($f);

    $importados = 0;
    $omitidos = 0;
    $errores = 0;

    while (($row = fgetcsv($f)) !== false) {

        $row = array_combine($header, $row);

        $legacy_id = (int) floatval($row['IdMineralGen']);

        $existente = get_posts([
            'post_type'   => 'mineral',
            'meta_key'    => 'legacy_id',
            'meta_value'  => $legacy_id,
            'numberposts' => 1
        ]);

        if ($existente) {
            $omitidos++;
            continue;
        }

        $post_id = wp_insert_post([
            'post_type'    => 'mineral',
            'post_status'  => 'publish',
            'post_title'   => $row['Titulo'],
            'post_content' => html_entity_decode(
                $row['Descripcion'],
                ENT_QUOTES | ENT_HTML5,
                'UTF-8'
            )
        ], true);

        if (is_wp_error($post_id)) {
            $errores++;
            continue;
        }

        update_post_meta($post_id, 'legacy_id', $legacy_id);
        update_post_meta($post_id, 'legacy_usuario', (int) floatval($row['IdUsuario']));

        update_post_meta($post_id, 'name', $row['name']);
        update_post_meta($post_id, 'formula', $row['Formula']);
        update_post_meta($post_id, 'clasificacion', $row['Clasificacion']);
        update_post_meta($post_id, 'aplicacion', $row['Aplicacion']);
        update_post_meta($post_id, 'peso', $row['peso']);
        update_post_meta($post_id, 'dureza', $row['Dureza']);
        update_post_meta($post_id, 'etimologia', html_entity_decode($row['Etimologia']));
        update_post_meta($post_id, 'variedades', $row['Variedades']);
        update_post_meta($post_id, 'yacimiento', $row['Yacimiento']);

        update_post_meta($post_id, 'del_ejemplar', $row['DelEjemplar']);
        update_post_meta($post_id, 'cha_ejemplar', $row['ChaEjemplar']);
        update_post_meta($post_id, 'read_ejemplar', $row['ReadEjemplar']);
        update_post_meta($post_id, 'pend_publicar', $row['PendPublicar']);

        $importados++;
    }

    fclose($f);

    echo "<pre>";
    echo "IMPORTADOS : {$importados}\n";
    echo "OMITIDOS   : {$omitidos}\n";
    echo "ERRORES    : {$errores}\n";
    exit;
});

add_action('admin_init', function () {

    if (!current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['import_recursos'])) {
        return;
    }

    set_time_limit(0);

    $csv = '/data/minerales-etl/wp_recursos.csv';

    $f = fopen($csv, 'r');

    if (!$f) {
        wp_die('No se pudo abrir wp_recursos.csv');
    }

    $header = fgetcsv($f);

    $importados = 0;
    $omitidos = 0;
    $errores = 0;

    while (($row = fgetcsv($f)) !== false) {

        $row = array_combine($header, $row);

        $legacy_id = (int) floatval($row['legacy_id']);

        $existente = get_posts([
            'post_type'   => 'recurso',
            'meta_key'    => 'legacy_id',
            'meta_value'  => $legacy_id,
            'numberposts' => 1
        ]);

        if ($existente) {
            $omitidos++;
            continue;
        }

        $post_id = wp_insert_post([
            'post_type'    => 'recurso',
            'post_status'  => 'publish',
            'post_title'   => $row['titulo'],
            'post_content' => html_entity_decode(
                $row['descripcion'],
                ENT_QUOTES | ENT_HTML5,
                'UTF-8'
            )
        ], true);

        if (is_wp_error($post_id)) {
            $errores++;
            continue;
        }

        update_post_meta($post_id,'legacy_id',$legacy_id);
        update_post_meta($post_id,'foto_id',$row['foto_id']);
        update_post_meta($post_id,'id_usuario',$row['id_usuario']);

        update_post_meta($post_id,'fecha_creacion',$row['fecha_creacion']);

        update_post_meta($post_id,'lugar',$row['lugar']);
        update_post_meta($post_id,'sic_resumen',$row['sic_resumen']);

        update_post_meta($post_id,'fecha_foto',$row['fecha_foto']);
        update_post_meta($post_id,'autor_foto',$row['autor_foto']);
        update_post_meta($post_id,'procedencia',$row['procedencia']);

        $importados++;
    }

    fclose($f);

    echo "<pre>";
    echo "IMPORTADOS : {$importados}\n";
    echo "OMITIDOS   : {$omitidos}\n";
    echo "ERRORES    : {$errores}\n";
    exit;
});