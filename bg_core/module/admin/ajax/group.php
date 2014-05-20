<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin.inc.php"); //载入全局通用
include_once(BG_PATH_CONTROL_ADMIN . "ajax/group.class.php"); //载入模板类

$ajax_group = new AJAX_GROUP();

switch ($act_post) {
	case "submit":
		$ajax_group->ajax_submit();
	break;

	case "del":
		$ajax_group->ajax_del();
	break;

	default:
		switch ($act_get) {
			case "chkname":
				$ajax_group->ajax_chkname();
			break;
		}
	break;
}
?>