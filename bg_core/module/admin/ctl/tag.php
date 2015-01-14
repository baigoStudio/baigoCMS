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
include_once(BG_PATH_CONTROL_ADMIN . "ctl/tag.class.php"); //载入模板类

$ctl_tag = new CONTROL_TAG(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
	default:
		$arr_tagRow = $ctl_tag->ctl_list();
		if ($arr_tagRow["str_alert"] != "y130301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_tagRow["str_alert"]);
			exit;
		}
	break;
}
?>