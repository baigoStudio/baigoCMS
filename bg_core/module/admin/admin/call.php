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
include_once(BG_PATH_CONTROL_ADMIN . "admin/call.class.php"); //载入模板类

$ctl_call = new CONTROL_CALL();

switch ($act_get) {
	case "show":
		$arr_callRow = $ctl_call->ctl_show();
		if ($arr_callRow["str_alert"] != "y170102") {
			header("Location: " . BG_URL_ADMIN . "admin.php?mod=alert&act_get=display&alert=" . $arr_callRow["str_alert"]);
			exit;
		}
	break;

	case "form":
		$arr_callRow = $ctl_call->ctl_form();
		if ($arr_callRow["str_alert"] != "y170102") {
			header("Location: " . BG_URL_ADMIN . "admin.php?mod=alert&act_get=display&alert=" . $arr_callRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_callRow = $ctl_call->ctl_list();
		if ($arr_callRow["str_alert"] != "y170301") {
			header("Location: " . BG_URL_ADMIN . "admin.php?mod=alert&act_get=display&alert=" . $arr_callRow["str_alert"]);
			exit;
		}
	break;
}
?>