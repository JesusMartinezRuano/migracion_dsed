<?php

if (!defined('ABSPATH')) {
    exit;
}

function dsed_indice_minerales()
{
    $minerales = get_posts([
        'post_type'      => 'mineral',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC'
    ]);

    $html  = '<div class="dsed-indice">';
    $html .= '<h1>Minerales</h1>';

    $actual = '';

    foreach ($minerales as $m) {

        $letra = strtoupper(
            mb_substr($m->post_title, 0, 1)
        );

        if ($letra !== $actual) {

            if ($actual !== '') {
                $html .= '</ul>';
            }

            $actual = $letra;

            $html .= '<h2>' . esc_html($letra) . '</h2>';
            $html .= '<ul>';
        }

        $html .= sprintf(
            '<li><a href="%s">%s</a></li>',
            get_permalink($m->ID),
            esc_html($m->post_title)
        );
    }

    if ($actual !== '') {
        $html .= '</ul>';
    }

    $html .= '</div>';

    return $html;
}