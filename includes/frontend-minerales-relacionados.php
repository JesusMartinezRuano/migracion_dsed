<?php

if (!defined('ABSPATH')) {
    exit;
}

function dsed_render_minerales_relacionados()
{
    if (!is_singular('recurso')) {
        return;
    }

    global $post;

    $minerales = get_post_meta(
        $post->ID,
        'mineral_relacionado',
        false
    );

    if (empty($minerales)) {
        return;
    }

    $minerales = array_unique($minerales);

    echo '<section class="dsed-relaciones">';
    echo '<h2>Minerales relacionados</h2>';
    echo '<ul>';

    foreach ($minerales as $mineral_id) {

        $titulo = get_the_title($mineral_id);

        if (!$titulo) {
            continue;
        }

        echo sprintf(
            '<li><a href="%s">%s</a></li>',
            esc_url(get_permalink($mineral_id)),
            esc_html($titulo)
        );
    }

    echo '</ul>';
    echo '</section>';
}

add_action(
    'wp_footer',
    'dsed_render_minerales_relacionados'
);