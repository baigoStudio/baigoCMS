<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL_ADMIN . "ajax/spec.class.php"); //载入登录控制器
$ajax_spec = new AJAX_SPEC();

switch ($act_post) {
	case "show":
	case "hide":
		$ajax_spec->ajax_status();
	break;

	case "submit":
		$ajax_spec->ajax_submit();
	break;

	case "del":
		$ajax_spec->ajax_del();
	break;

	case "to":
	case "exc":
		$ajax_spec->ajax_toSpec();
	break;

	default:
		switch ($act_get) {
			case "list":
				$ajax_spec->ajax_list();
			break;
		}
	break;
}
?>