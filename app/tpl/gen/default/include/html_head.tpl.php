<!DOCTYPE html>
<html lang="<?php echo $lang->getCurrent(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="-1">
    <title>
        <?php if (isset($cfg['title'])) {
            echo $cfg['title'], ' - ';
        }

        echo $lang->get('Console', 'gen.common');

        if (isset($config['var_extra']['base']['site_name'])) {
            echo ' - ', $config['var_extra']['base']['site_name'];
        } ?>
    </title>

    <!--jQuery 库-->
    <script src="{:DIR_STATIC}lib/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
    <link href="{:DIR_STATIC}lib/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="{:DIR_STATIC}lib/font-awesome/5.9.0/css/fontawesome.min.css" type="text/css" rel="stylesheet">
    <link href="{:DIR_STATIC}lib/font-awesome/5.9.0/css/solid.min.css" type="text/css" rel="stylesheet">
    <link href="{:DIR_STATIC}css/common.css" type="text/css" rel="stylesheet">
    <link href="{:DIR_STATIC}cms/css/console.css" type="text/css" rel="stylesheet">
</head>
<body>
