<?php header("Content-Type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html lang="<?php echo substr($this->config["lang"], 0, 2); ?>">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>
        <?php if (isset($cfg["title"]) && !fn_isEmpty($cfg["title"])) {
            echo $cfg["title"]; ?> -
        <?php }
        echo BG_SITE_NAME; ?>
    </title>

    <!--jQuery 库-->
    <script src="<?php echo BG_URL_STATIC; ?>lib/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/base64/base64.min.js" type="text/javascript"></script>
    <link href="<?php echo BG_URL_STATIC; ?>lib/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BG_URL_STATIC; ?>pub/<?php echo BG_SITE_TPL; ?>/css/common.css" type="text/css" rel="stylesheet">

</head>
<body>