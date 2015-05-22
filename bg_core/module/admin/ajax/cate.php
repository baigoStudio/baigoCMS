<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin_ajax.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL_ADMIN . "ajax/cate.class.php"); //载入登录控制器

$ajax_cate = new AJAX_CATE();

switch ($GLOBALS["act_post"]) {
	case "order":
		$ajax_cate->ajax_order();
	break;

	case "submit":
		$ajax_cate->ajax_submit();
	break;

	case "cache":
		$ajax_cate->ajax_cache();
	break;

	case "del":
		$ajax_cate->ajax_del();
	break;

	case "hide":
	case "show":
		$ajax_cate->ajax_status();
	break;

	default:
		switch ($GLOBALS["act_get"]) {
			case "chkname":
				$ajax_cate->ajax_chkname();
			break;
			case "chkalias":
				$ajax_cate->ajax_chkalias();
			break;
		}
	break;
}
