<?php

//include library utama
include_once 'control.php';

// Buat Instance baru
$app = new operator();

// Baca query dari alamat
$app->query_string = $_SERVER['QUERY_STRING'];

// Cek apakah ada query bernama mode?
if ($app->is_url_query('mode')) {

    // Bagi menjadi beberapa operasi
    switch ($app->get_url_query_value('mode')) {

        default:
        ?>
        <script>
        window.location = '../index.phpn';
        </script>
        <?php


        case 'save':
            if ($app->is_url_query('iuid'))
            {
                $uid = $app->get_url_query_value('iuid');
                $app->create_data($uid );
            } else {
                $error = [
                    'iuid'=>'required',
                ];
                echo $app->error_handler($error);
            }
        break;
    }
} else {
    ?>
    <script>
    window.location = '../index.php';
    </script>
    <?php
}
?>

