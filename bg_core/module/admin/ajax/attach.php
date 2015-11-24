<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "include.func.php"); //验证是否已登录
fn_include(true, true, "Content-type: application/json; charset=utf-8", true, "ajax", true);

include_once(BG_PATH_CONTROL . "admin/ajax/attach.class.php"); //载入登录控制器

$ajax_attach = new AJAX_ATTACH();

switch ($GLOBALS["act_post"]) {
	case "normal":
	case "recycle":
		$ajax_attach->ajax_box();
	break;

	case "gen":
		$ajax_attach->ajax_gen();
	break;

	case "empty":
		$ajax_attach->ajax_empty();
	break;

	case "clear":
		$ajax_attach->ajax_clear();
	break;

	case "submit":
		$ajax_attach->ajax_submit();
	break;

	case "del":
		$ajax_attach->ajax_del();
	break;

	default:
		switch ($GLOBALS["act_get"]) {
			case "article":
				$ajax_attach->ajax_article();
			break;

			case "list":
				$ajax_attach->ajax_list();
			break;
		}
	break;
}
