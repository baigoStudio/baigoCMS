<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "include.func.php");
fn_include(true, true, "Content-Type: text/html; charset=utf-8", true, "ctl", true);

include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL . "admin/ctl/call.class.php"); //载入模板类

$ctl_call = new CONTROL_CALL();

switch ($GLOBALS["act_get"]) {
	case "show":
		$arr_callRow = $ctl_call->ctl_show();
		if ($arr_callRow["alert"] != "y170102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_callRow["alert"]);
			exit;
		}
	break;

	case "form":
		$arr_callRow = $ctl_call->ctl_form();
		if ($arr_callRow["alert"] != "y170102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_callRow["alert"]);
			exit;
		}
	break;

	default:
		$arr_callRow = $ctl_call->ctl_list();
		if ($arr_callRow["alert"] != "y170301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_callRow["alert"]);
			exit;
		}
	break;
}
