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

include_once(BG_PATH_CONTROL_ADMIN . "ctl/mime.class.php"); //载入模板类

$ctl_mime = new CONTROL_MIME(); //初始化设置对象

switch ($act_get) {
	default:
		$arr_mimeRow = $ctl_mime->ctl_list();
		if ($arr_mimeRow["str_alert"] != "y080301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_mimeRow["str_alert"]);
			exit;
		}
	break;
}
?>