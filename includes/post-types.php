<?php

if (!defined('ABSPATH')) {
    exit;
}

function migracion_dsed_register_post_types() {

    register_post_type('mineral', [
        'label' => 'Minerales',
        'public' => true,
        'show_in_menu' => true,
        'supports' => ['title']
    ]);

    register_post_type('ejemplar', [
        'label' => 'Ejemplares',
        'public' => true,
        'show_in_menu' => true,
        'supports' => ['title']
    ]);

    register_post_type('documento', [
        'label' => 'Documentos',
        'public' => true,
        'show_in_menu' => true,
        'supports' => ['title']
    ]);

    register_post_type('enlace', [
        'label' => 'Enlaces',
        'public' => true,
        'show_in_menu' => true,
        'supports' => ['title']
    ]);
}

add_action('init', 'migracion_dsed_register_post_types');
