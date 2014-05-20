<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
{* html_head.tpl html 头部通用 *}
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$config.lang}" xml:lang="{$config.lang}">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>{$cfg.title} - {$lang.page.admin} - {$smarty.const.BG_SITE_NAME}</title>

<!--jQuery 库-->
<script src="{$smarty.const.BG_URL_JS}jquery.min.js" type="text/javascript"></script>
<link href="{$smarty.const.BG_URL_STATIC_ADMIN}default/css/{$cfg.css}.css" type="text/css" rel="stylesheet" />

{if $cfg.menu_active}
	<style type="text/css">
	#menu_{$cfg.menu_active} a { background-position: 0px -40px; color: #0477c8; }
	#sub_{$cfg.menu_active} { display: block; }
	#sub_{$cfg.menu_active}_{$cfg.sub_active} a { background-position: 0px -120px; color: #c30; }
	</style>
{/if}

{if $cfg.colorbox}
	<!--colorbox 样式-->
	<link href="{$smarty.const.BG_URL_JS}colorbox/colorbox.css" type="text/css" rel="stylesheet" />
	<script src="{$smarty.const.BG_URL_JS}colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
{/if}

{if $cfg.baigoValidator}
	<!--表单验证 js-->
	<link href="{$smarty.const.BG_URL_JS}baigoValidator/baigoValidator.css" type="text/css" rel="stylesheet" />
{/if}

{if $cfg.baigoSubmit}
	<!--表单 ajax 提交 js-->
	<link href="{$smarty.const.BG_URL_JS}baigoSubmit/baigoSubmit.css" type="text/css" rel="stylesheet" />
{/if}

</head>
