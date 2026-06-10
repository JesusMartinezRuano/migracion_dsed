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

</style>
<?php
});