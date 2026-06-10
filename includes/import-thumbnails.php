<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_init', function () {

    if (!isset($_GET['import_thumbnail_minerales'])) {
        return;
    }

    global $wpdb;

    $minerales = $wpdb->get_col("
        SELECT DISTINCT post_id
        FROM {$wpdb->postmeta}
        WHERE meta_key='foto_relacionada'
    ");

    $actualizados = 0;

    foreach ($minerales as $mineral_id) {

        $foto = $wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT meta_value
                FROM {$wpdb->postmeta}
                WHERE post_id=%d
                  AND meta_key='foto_relacionada'
                ORDER BY meta_id
                LIMIT 1
                ",
                $mineral_id
            )
        );

        if (!$foto) {
            continue;
        }

        update_post_meta(
            $mineral_id,
            '_thumbnail_id',
            $foto
        );

        echo $mineral_id.' -> '.$foto.'<br>';

        $actualizados++;
    }

    echo '<hr>';
    echo 'MINERALES ACTUALIZADOS: '.$actualizados;

    exit;
});