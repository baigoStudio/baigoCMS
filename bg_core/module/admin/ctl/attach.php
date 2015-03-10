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
include_once(BG_PATH_CONTROL_ADMIN . "ctl/attach.class.php"); //载入模板类

$ctl_attach = new CONTROL_ATTACH(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
	case "form":
		$arr_attachRow = $ctl_attach->ctl_form();
		if ($arr_attachRow["str_alert"] != "y070302") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_attachRow["str_alert"] . $_url_attach);
			exit;
		}
	break;

	default:
		$arr_attachRow = $ctl_attach->ctl_list();
		if ($arr_attachRow["str_alert"] != "y070301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_attachRow["str_alert"] . $_url_attach);
			exit;
		}
	break;
}
