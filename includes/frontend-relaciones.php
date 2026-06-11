<?php

if (!defined('ABSPATH')) {
    exit;
}


function dsed_bloque_relacionados(
    $post_id,
    $meta_key,
    $titulo
) {
    $ids = get_post_meta(
        $post_id,
        $meta_key,
        false
    );

    if (empty($ids)) {
        return '';
    }

    $ids = array_unique($ids);

    $html  = '<section class="dsed-relaciones">';
    $html .= '<h2>' . esc_html($titulo) . ' (' . count($ids) . ')</h2>';
    $html .= '<div class="dsed-grid-relaciones">';

    foreach ($ids as $id) {

        $nombre = get_the_title($id);

        if (!$nombre) {
            continue;
        }

        if (get_post_status($id) !== 'publish') {
            continue;
        }

        $url = get_permalink($id);
        $target = '';

        if (get_post_type($id) === 'enlace') {

            $url_externa = get_post_meta(
                $id,
                'url',
                true
            );

            if (!empty($url_externa)) {
                $url = $url_externa;
                $target = ' target="_blank" rel="noopener noreferrer"';
            }
        }

        $html .= sprintf(
    	    '<div class="dsed-card-relacion">
            <a href="%s"%s>%s</a>
     	    </div>',
    	    esc_url($url),
    	    $target,
    	    esc_html($nombre)
	);
    }

    $html .= '</div>';
    $html .= '</section>';

    return $html;
}

function dsed_galeria_fotos($post_id)
{
    $fotos = get_post_meta(
        $post_id,
        'foto_relacionada',
        false
    );

    if (empty($fotos)) {
        return '';
    }

    $fotos = array_unique($fotos);

    $html  = '<section class="dsed-galeria">';
    $html .= '<h2>Fotografías (' . count($fotos) . ')</h2>';
    $html .= '<div class="dsed-grid-fotos">';

    foreach ($fotos as $foto_id) {

        /*if (get_post_status($foto_id) !== 'inherit') {
            continue;
        }*/

        $thumb = wp_get_attachment_image(
            $foto_id,
            'medium',
            false,
            [
                'loading' => 'lazy'
            ]
        );

        $full = wp_get_attachment_url($foto_id);

        if (!$thumb || !$full) {
            continue;
        }

        $html .= sprintf(
            '<a class="dsed-foto" href="%s" target="_blank">%s</a>',
            esc_url($full),
            $thumb
        );
    }

    $html .= '</div>';
    $html .= '</section>';

    return $html;
}

function dsed_ficha_mineral($post_id)
{
    $campos = [

        'name'                => 'Nombre en inglés',
        'clasificacion'       => 'Clasificación',
        'formula'             => 'Fórmula',
        'dureza'              => 'Dureza',
        'peso'                => 'Densidad',
        'sistema_cristalino'  => 'Sistema cristalino',
        'aplicacion'          => 'Aplicación'

    ];

    $html  = '<section class="dsed-ficha-mineral">';
    $html .= '<h2>Características</h2>';
    $html .= '<table>';

    foreach ($campos as $meta => $label) {

        $valor = get_post_meta(
            $post_id,
            $meta,
            true
        );

        if (!$valor) {
            continue;
        }

        $html .= '<tr>';
        $html .= '<th>' . esc_html($label) . '</th>';
        $html .= '<td>' . esc_html($valor) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';
    $html .= '</section>';

    return $html;
}

function dsed_texto_mineral(
    $post_id,
    $meta_key,
    $titulo
) {
    $texto = get_post_meta(
        $post_id,
        $meta_key,
        true
    );

    if (!$texto) {
        return '';
    }

    $html  = '<section class="dsed-texto-mineral">';
    $html .= '<h2>' . esc_html($titulo) . '</h2>';
    $html .= wpautop(wp_kses_post($texto));
    $html .= '</section>';

    return $html;
}

function dsed_relaciones_mineral_content($content)
{
    if (!is_singular('mineral')) {
        return $content;
    }

    global $post;

    $content .= dsed_ficha_mineral(
        $post->ID
    );

    $content .= dsed_texto_mineral(
        $post->ID,
        'etimologia',
        'Etimología'
    );

    $content .= dsed_texto_mineral(
        $post->ID,
        'variedades',
        'Variedades'
    );

    $content .= dsed_texto_mineral(
        $post->ID,
        'yacimiento',
        'Yacimiento'
    );

    $content .= dsed_galeria_fotos(
        $post->ID
    );

    $content .= dsed_bloque_relacionados(
        $post->ID,
        'recurso_relacionado',
        'Recursos relacionados'
    );

    $content .= dsed_bloque_relacionados(
        $post->ID,
        'ejemplar_relacionado',
        'Ejemplares relacionados'
    );

    $content .= dsed_bloque_relacionados(
        $post->ID,
        'enlace_relacionado',
        'Enlaces relacionados'
    );

    return $content;
}

add_filter(
    'the_content',
    'dsed_relaciones_mineral_content'
);

add_action('wp_head', function () {
?>
<style>

.dsed-ficha-mineral table{
    border-collapse:collapse;
    width:100%;
    max-width:700px;
}

.dsed-ficha-mineral th,
.dsed-ficha-mineral td{
    border:1px solid #ddd;
    padding:8px;
    text-align:left;
}

.dsed-ficha-mineral th{
    width:220px;
    background:#f5f5f5;
}

.dsed-relaciones,
.dsed-texto-mineral,
.dsed-galeria{
    margin-top:30px;
}

.dsed-grid-fotos{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
    gap:15px;
}

.dsed-grid-fotos img{
    width:100%;
    height:auto;
    display:block;
    border-radius:4px;
}

.dsed-foto{
    display:block;
}

.dsed-grid-relaciones{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:15px;
}

.dsed-card-relacion{
    border:1px solid #ddd;
    border-radius:8px;
    padding:12px 15px;
    background:#fff;
    box-shadow:0 1px 3px rgba(0,0,0,.08);
    transition:.2s;
}

.dsed-card-relacion:hover{
    box-shadow:0 3px 8px rgba(0,0,0,.15);
}

.dsed-card-relacion a{
    display:block;
    text-decoration:none;
    font-weight:600;
}

.dsed-card-relacion a:hover{
    text-decoration:underline;
}

</style>
<?php
});