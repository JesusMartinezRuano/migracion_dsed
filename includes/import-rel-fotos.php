<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_init', function () {

    if (!isset($_GET['import_rel_mineral_foto'])) {
        return;
    }

    global $wpdb;

    $csv='/data/minerales-etl/rel_mineral_foto.csv';

    if (!file_exists($csv)) {
        die('CSV no encontrado');
    }

    $f=fopen($csv,'r');

    if (!$f) {
        die('No se puede abrir CSV');
    }

    fgetcsv($f); // cabecera

    $importadas=0;
    $errores=0;

    while (($row=fgetcsv($f))!==false) {

        $legacy_mineral=(int)$row[0];
        $legacy_foto=(int)$row[1];

        /*
         * Mineral WP
         */

        $mineral_id=$wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT p.ID
                FROM {$wpdb->posts} p
                JOIN {$wpdb->postmeta} pm
                    ON pm.post_id=p.ID
                WHERE p.post_type='mineral'
                  AND pm.meta_key='legacy_id'
                  AND pm.meta_value=%d
                LIMIT 1
                ",
                $legacy_mineral
            )
        );

        if (!$mineral_id) {
            $errores++;
            continue;
        }

        /*
         * Foto WP
         */

        $attachment_id=$wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT p.ID
                FROM {$wpdb->posts} p
                JOIN {$wpdb->postmeta} pm
                    ON pm.post_id=p.ID
                WHERE p.post_type='attachment'
                  AND pm.meta_key='legacy_foto_id'
                  AND pm.meta_value=%d
                LIMIT 1
                ",
                $legacy_foto
            )
        );

        if (!$attachment_id) {
            $errores++;
            continue;
        }

        /*
         * Evitar duplicados
         */

        $existe=$wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT meta_id
                FROM {$wpdb->postmeta}
                WHERE post_id=%d
                  AND meta_key='foto_relacionada'
                  AND meta_value=%d
                LIMIT 1
                ",
                $mineral_id,
                $attachment_id
            )
        );

        if ($existe) {
    	    $ya_existen++;
            continue;
        }
        add_post_meta(
            $mineral_id,
            'foto_relacionada',
            $attachment_id
        );

        echo $legacy_mineral
            .' -> '.$mineral_id
            .' | foto '
            .$legacy_foto
            .' -> '.$attachment_id
            .'<br>';

        $importadas++;

        
    }

    fclose($f);

    echo 'RELACIONES: '.$importadas.'<br>';
    echo 'YA EXISTIAN: '.$ya_existen.'<br>';
    echo 'ERRORES: '.$errores.'<br>';
    exit;
});