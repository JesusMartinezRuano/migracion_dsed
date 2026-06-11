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

    $html .= '<div class="dsed-filtros">';

    $html .= '
    <input
        type="text"
        id="dsed-search"
        class="dsed-search"
        placeholder="Buscar mineral..."
    >';

    $html .= '
    <select
        id="dsed-clasificacion"
        class="dsed-search"
    >
        <option value="">Todas las clasificaciones</option>
    </select>';

    $html .= '</div>';


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

        $html .= sprintf(
            '<div class="dsed-card-mineral" data-clasificacion="%s">',
            esc_attr(strtolower($clasificacion))
        );

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

    $html .= '
<script>
document.addEventListener("DOMContentLoaded", function() {

    const input = document.getElementById("dsed-search");
    const select = document.getElementById("dsed-clasificacion");

    const clases = new Set();

    document
        .querySelectorAll(".dsed-card-mineral")
        .forEach(function(card) {

            const c = card.dataset.clasificacion;

            if (c) {
                clases.add(c);
            }
        });

    Array.from(clases)
        .sort()
        .forEach(function(c) {

            const option =
                document.createElement("option");

            option.value = c;
            option.textContent = c;

            select.appendChild(option);
        });

    function aplicarFiltros() {

        const texto =
            input.value.toLowerCase();

        const clasificacion =
            select.value;

        document
            .querySelectorAll(".dsed-card-mineral")
            .forEach(function(card) {

                const contenido =
                    card.textContent.toLowerCase();

                const clase =
                    card.dataset.clasificacion;

                const coincideTexto =
                    contenido.includes(texto);

                const coincideClase =
                    !clasificacion ||
                    clase === clasificacion;

                card.style.display =
                    (coincideTexto && coincideClase)
                    ? ""
                    : "none";
            });
    }

    input.addEventListener(
        "keyup",
        aplicarFiltros
    );

    select.addEventListener(
        "change",
        aplicarFiltros
    );

});
</script>';

    $html .= '</div>';

    return $html;
}