<!DOCTYPE html>
<html lang="{$config.lang}">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>{$cfg.title} - {$lang.page.admin} - {$smarty.const.BG_SITE_NAME}</title>

	<!--jQuery 库-->
	<script src="{$smarty.const.BG_URL_JS}jquery.min.js" type="text/javascript"></script>
	<link href="{$smarty.const.BG_URL_STATIC_ADMIN}default/css/admin_common.css" type="text/css" rel="stylesheet">
	<link href="{$smarty.const.BG_URL_JS}bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">

	{if isset($cfg.tagmanager)}
		<link rel="stylesheet" href="{$smarty.const.BG_URL_JS}typeahead/typeahead.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="{$smarty.const.BG_URL_JS}tagmanager/tagmanager.css" type="text/css" rel="stylesheet">
	{/if}

	{if isset($cfg.upload)}
		<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
		<link rel="stylesheet" href="{$smarty.const.BG_URL_JS}jQuery-File-Upload/jquery.fileupload.css" type="text/css" rel="stylesheet">
	{/if}

	{if isset($cfg.datepicker)}
		<link href="{$smarty.const.BG_URL_JS}datetimepicker/jquery.datetimepicker.css" type="text/css" rel="stylesheet">
	{/if}

	{if isset($cfg.baigoValidator)}
		<!--表单验证 js-->
		<link href="{$smarty.const.BG_URL_JS}baigoValidator/baigoValidator.css" type="text/css" rel="stylesheet">
	{/if}

	{if isset($cfg.baigoSubmit)}
		<!--表单 ajax 提交 js-->
		<link href="{$smarty.const.BG_URL_JS}baigoSubmit/baigoSubmit.css" type="text/css" rel="stylesheet">
	{/if}

	{if isset($cfg.tinymce)}
		<!--html 编辑器-->
		<script src="{$smarty.const.BG_URL_JS}tinymce/tinymce.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		tinyMCE.init({
			selector: "textarea.tinymce",
			language: "{$config.lang}",
			plugins: ["table image insertdatetime lists advlist anchor link autolink autoresize charmap code textcolor colorpicker contextmenu media paste searchreplace visualblocks visualchars hr"],
			toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | link image",
			convert_urls: false,
			remove_script_host: false
		});
		</script>
	{/if}

</head>
