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
    $html .= '<p>Total minerales: ' . count($minerales) . '</p>';

    $actual = '';

    foreach ($minerales as $m) {

        $letra = strtoupper(
            mb_substr($m->post_title, 0, 1)
        );

        if ($letra !== $actual) {

            if ($actual !== '') {
                $html .= '</div>';
            }

            $actual = $letra;

            $html .= '<h2>' . esc_html($letra) . '</h2>';
            $html .= '<div class="dsed-grid-minerales">';
        }

        $ingles = get_post_meta(
            $m->ID,
            'name',
            true
        );

        $clasificacion = get_post_meta(
            $m->ID,
            'clasificacion',
            true
        );

        $thumb = get_the_post_thumbnail(
            $m->ID,
            'medium'
        );

        $html .= '<div class="dsed-card-mineral">';

        if ($thumb) {

            $html .= sprintf(
                '<a href="%s">%s</a>',
                get_permalink($m->ID),
                $thumb
            );

        }

        $html .= '<div class="dsed-card-mineral-body">';

        $html .= sprintf(
            '<h3><a href="%s">%s</a></h3>',
            get_permalink($m->ID),
            esc_html($m->post_title)
        );

        if (!empty($ingles)) {

            $html .= '<div class="dsed-mineral-english">'
                  . esc_html($ingles)
                  . '</div>';

        }

        if (!empty($clasificacion)) {

            $html .= '<div class="dsed-mineral-class">'
                  . esc_html($clasificacion)
                  . '</div>';

        }

        $html .= '</div>';
        $html .= '</div>';
    }

    if ($actual !== '') {
        $html .= '</div>';
    }

    $html .= '</div>';

    return $html;
}