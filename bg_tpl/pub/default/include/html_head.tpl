<!DOCTYPE html>
<html lang="{$config.lang|truncate:2:''}">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>{if $cfg.title}{$cfg.title} - {/if}{$smarty.const.BG_SITE_NAME}</title>

	<!--jQuery 库-->
	<script src="{$smarty.const.BG_URL_STATIC}js/jquery.min.js" type="text/javascript"></script>
	<script src="{$smarty.const.BG_URL_STATIC}js/base64.js" type="text/javascript"></script>
	<link href="{$smarty.const.BG_URL_STATIC}js/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<link href="{$smarty.const.BG_URL_STATIC_PUB}{$smarty.const.BG_SITE_TPL}/css/common.css" type="text/css" rel="stylesheet">

</head>
<body>