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
include_once(BG_PATH_CONTROL_ADMIN . "ajax/thumb.class.php"); //载入登录控制器

$ajax_thumb = new AJAX_THUMB();

switch ($GLOBALS["act_post"]) {
	case "submit":
		$ajax_thumb->ajax_submit();
	break;

	case "del":
		$ajax_thumb->ajax_del();
	break;

	default:
		switch ($GLOBALS["act_get"]) {
			case "chk":
				$ajax_thumb->ajax_chk();
			break;
		}
	break;
}
?>