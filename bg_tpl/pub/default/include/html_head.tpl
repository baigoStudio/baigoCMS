{* html_head.tpl html 头部通用 *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$config.lang}" xml:lang="{$config.lang}">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<title>{if $cfg.title}{$cfg.title} - {/if}{$smarty.const.BG_SITE_NAME}</title>

<!--jQuery 库-->
<script src="http://res.iwee.cn/static/js/jquery.min.js" type="text/javascript"></script>
<link href="{$smarty.const.BG_URL_STATIC_PUB}default/css/{$cfg.css}.css" type="text/css" rel="stylesheet">

</head>
<body>