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
include_once(BG_PATH_CONTROL_ADMIN . "ctl/thumb.class.php"); //载入模板类

$ctl_thumb = new CONTROL_THUMB(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
	case "form":
		$arr_thumbRow = $ctl_thumb->ctl_form();
		if ($arr_thumbRow["alert"] != "y060204") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_thumbRow["alert"] . "&view=iframe");
			exit;
		}
	break;

	default:
		$arr_thumbRow = $ctl_thumb->ctl_list();
		if ($arr_thumbRow["alert"] != "y090301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_thumbRow["alert"]);
			exit;
		}
	break;
}
