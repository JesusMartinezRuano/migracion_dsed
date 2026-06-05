<?php

if (!defined('ABSPATH')) {
    exit;
}

function dsed_render_recursos_relacionados()
{
    if (!is_singular('mineral')) {
        return;
    }

    global $post;

    $recursos = get_post_meta(
        $post->ID,
        'recurso_relacionado',
        false
    );

    if (empty($recursos)) {
        return;
    }

    $recursos = array_unique($recursos);

    echo '<section class="dsed-relaciones">';
    echo '<h2>Recursos relacionados</h2>';
    echo '<ul>';

    foreach ($recursos as $recurso_id) {

        $titulo = get_the_title($recurso_id);

        if (!$titulo) {
            continue;
        }

        echo sprintf(
            '<li><a href="%s">%s</a></li>',
            esc_url(get_permalink($recurso_id)),
            esc_html($titulo)
        );
    }

    echo '</ul>';
    echo '</section>';
}

add_action(
    'wp_footer',
    'dsed_render_recursos_relacionados'
);