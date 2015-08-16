<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin_ctl.inc.php"); //载入全局通用
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL_ADMIN . "ctl/custom.class.php"); //载入模板类

$ctl_custom = new CONTROL_CUSTOM(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
	case "order":
		$arr_customRow = $ctl_custom->ctl_order();
		if ($arr_customRow["alert"] != "y200102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_customRow["alert"]);
			exit;
		}
	break;

	default:
		$arr_customRow = $ctl_custom->ctl_list();
		if ($arr_customRow["alert"] != "y200301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_customRow["alert"]);
			exit;
		}
	break;
}
