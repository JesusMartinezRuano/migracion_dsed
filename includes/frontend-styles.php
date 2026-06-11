<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_head', function () {
?>
<style>

.dsed-ficha-mineral{
    margin:30px 0;
}

.dsed-ficha-mineral h2{
    margin-bottom:15px;
}

.dsed-ficha-mineral table{
    border-collapse:collapse;
    width:100%;
    max-width:700px;
    box-shadow:0 1px 3px rgba(0,0,0,.08);
}

.dsed-ficha-mineral th,
.dsed-ficha-mineral td{
    border:1px solid #ddd;
    padding:8px;
    text-align:left;
}

.dsed-ficha-mineral th{
    width:200px;
    background:#f5f5f5;
}

.dsed-relaciones{
    margin-top:30px;
}

.dsed-texto-mineral{
    margin-top:25px;
}

.dsed-texto-mineral p{
    margin-bottom:1em;
}

Es la mejora natural después de la landing. Ahora mismo tienes:

A
  ACANTITA
  ACTINOLITA
  ALABANDINA

B
  BARITINA

Funcional, pero poco atractiva.

Yo transformaría /minerales en un catálogo visual reutilizando los estilos que ya has creado para las relaciones.

Diseño propuesto
┌─────────────────────────┐
│ [foto principal]        │
│ CALCITA                 │
│ Calcite                 │
│ Carbonato               │
└─────────────────────────┘

┌─────────────────────────┐
│ [foto principal]        │
│ ACANTITA                │
│ Acanthite               │
│ Sulfuro                 │
└─────────────────────────┘
Datos disponibles

Ya existen en WordPress:

post_title            // CALCITA
name                  // Calcite
clasificacion         // Carbonato
_thumbnail_id         // imagen principal
CSS

En includes/frontend-styles.php añadir:

.dsed-grid-minerales{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
    gap:20px;
    margin:20px 0;
}

.dsed-card-mineral{
    border:1px solid #ddd;
    border-radius:8px;
    overflow:hidden;
    background:#fff;
}

.dsed-card-mineral img{
    width:100%;
    height:220px;
    object-fit:cover;
    display:block;
}

.dsed-card-mineral-body{
    padding:12px;
}

.dsed-card-mineral h3{
    margin:0 0 6px 0;
}

.dsed-card-mineral h3 a{
    text-decoration:none;
}

.dsed-mineral-english{
    color:#666;
    font-style:italic;
    margin-bottom:6px;
}

.dsed-mineral-class{
    font-size:0.9em;
}
</style>
<?php
});