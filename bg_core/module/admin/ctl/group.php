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
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL_ADMIN . "ctl/group.class.php"); //载入模板类

$ctl_group = new CONTROL_GROUP();

switch ($GLOBALS["act_get"]) {
	case "show":
		$arr_groupRow = $ctl_group->ctl_show();
		if ($arr_groupRow["str_alert"] != "y040102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_groupRow["str_alert"]);
			exit;
		}
	break;

	case "form":
		$arr_groupRow = $ctl_group->ctl_form();
		if ($arr_groupRow["str_alert"] != "y040102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_groupRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_groupRow = $ctl_group->ctl_list();
		if ($arr_groupRow["str_alert"] != "y040301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_groupRow["str_alert"]);
			exit;
		}
	break;
}
?>