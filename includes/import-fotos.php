<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| PRUEBA UNITARIA
|--------------------------------------------------------------------------
*/

add_action('admin_init', function () {

    if (!isset($_GET['import_foto_test'])) {
        return;
    }

    require_once ABSPATH.'wp-admin/includes/image.php';
    require_once ABSPATH.'wp-admin/includes/file.php';
    require_once ABSPATH.'wp-admin/includes/media.php';

    $origen='/tmp/azufre.JPG';

    if (!file_exists($origen)) {
        die('No existe fichero origen');
    }

    $upload_dir=wp_upload_dir();

    $destino=$upload_dir['path'].'/'.basename($origen);

    if (!copy($origen,$destino)) {
        die('Error copiando fichero');
    }

    $filetype=wp_check_filetype(
        basename($destino),
        null
    );

    $attachment=[
        'post_mime_type'=>$filetype['type'],
        'post_title'=>'AZUFRE',
        'post_content'=>'',
        'post_status'=>'inherit'
    ];

    $attach_id=wp_insert_attachment(
        $attachment,
        $destino
    );

    if (is_wp_error($attach_id)) {
        die($attach_id->get_error_message());
    }

    $metadata=wp_generate_attachment_metadata(
        $attach_id,
        $destino
    );

    wp_update_attachment_metadata(
        $attach_id,
        $metadata
    );

    update_post_meta(
        $attach_id,
        'legacy_foto_id',
        2244
    );

    update_post_meta(
        $attach_id,
        'foto_idarchivo',
        6625
    );

    echo 'ATTACHMENT ID: '.$attach_id;
    exit;
});


/*
|--------------------------------------------------------------------------
| IMPORTACION MASIVA 
|--------------------------------------------------------------------------
*/

add_action('admin_init', function () {

    if (!isset($_GET['import_fotos'])) {
        return;
    }

   @set_time_limit(0);
   @ini_set('max_execution_time', 0);

    global $wpdb;

    require_once ABSPATH.'wp-admin/includes/image.php';
    require_once ABSPATH.'wp-admin/includes/file.php';
    require_once ABSPATH.'wp-admin/includes/media.php';

    $csv='/data/minerales-etl/fotos_resueltas.csv';

    if (!file_exists($csv)) {
        die('CSV no encontrado: '.$csv);
    }

    $f=fopen($csv,'r');

    if (!$f) {
        die('No se puede abrir CSV');
    }

    $cabecera=fgetcsv($f);

    $importadas=0;
    $ya_existen=0;
    $errores=0;

    while (($row=fgetcsv($f))!==false) {

        $legacy_foto_id=(int)$row[0];
        $foto_idarchivo=(int)$row[1];
        $titulo=$row[2];
        $descripcion=$row[3];
        $url=$row[4];

        /*
        |--------------------------------------------------------------
        | Evitar duplicados
        |--------------------------------------------------------------
        */

        $existe=$wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT post_id
                FROM {$wpdb->postmeta}
                WHERE meta_key='legacy_foto_id'
                  AND meta_value=%d
                ",
                $legacy_foto_id
            )
        );

        if ($existe) {
            $ya_existen++;
            continue;
        }

        /*
        |--------------------------------------------------------------
        | Localizar fichero origen
        |--------------------------------------------------------------
        */

        $origen=
            '/data/minerales-etl/RepoMinerales/'.$url;

        if (!file_exists($origen)) {

    		if ($errores_mostrados < 50) {
        		echo "NO EXISTE: ".$url."<br>";
        		$errores_mostrados++;
    		}

   		$errores++;
    		continue;
	}
        /*
        |--------------------------------------------------------------
        | Copiar a uploads
        |--------------------------------------------------------------
        */

        $upload_dir=wp_upload_dir();

        $destino=
            $upload_dir['path'].'/'.
            basename($origen);

        if (!copy($origen,$destino)) {
            $errores++;
            continue;
        }

        /*
        |--------------------------------------------------------------
        | Crear attachment
        |--------------------------------------------------------------
        */

        $filetype=wp_check_filetype(
            basename($destino),
            null
        );

        $attachment=[
            'post_mime_type'=>$filetype['type'],
            'post_title'=>$titulo,
            'post_content'=>$descripcion,
            'post_status'=>'inherit'
        ];

        $attach_id=wp_insert_attachment(
            $attachment,
            $destino
        );

        if (is_wp_error($attach_id)) {
            $errores++;
            continue;
        }

        /*
        |--------------------------------------------------------------
        | Generar miniaturas
        |--------------------------------------------------------------
        */

        $metadata=wp_generate_attachment_metadata(
            $attach_id,
            $destino
        );

        wp_update_attachment_metadata(
            $attach_id,
            $metadata
        );

        /*
        |--------------------------------------------------------------
        | Metadatos migracion
        |--------------------------------------------------------------
        */

        update_post_meta(
            $attach_id,
            'legacy_foto_id',
            $legacy_foto_id
        );

        update_post_meta(
            $attach_id,
            'foto_idarchivo',
            $foto_idarchivo
        );

        $importadas++;

echo $legacy_foto_id.
     ' -> '.$attach_id.
     ' -> '.$titulo.
     '<br>';

flush();
        /*
        |--------------------------------------------------------------
        | Lote inicial de prueba
        |--------------------------------------------------------------
        */

        
    }

    fclose($f);

    echo '<h2>IMPORTADOR FOTOS</h2>';

    echo 'IMPORTADAS: '.$importadas.'<br>';
    echo 'YA EXISTIAN: '.$ya_existen.'<br>';
    echo 'ERRORES: '.$errores.'<br>';

    exit;
});