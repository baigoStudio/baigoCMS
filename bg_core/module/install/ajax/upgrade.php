<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_global.inc.php"); //载入通用
include_once(BG_PATH_CLASS . "mysql.class.php"); //载入数据库类
include_once(BG_PATH_CLASS . "base.class.php"); //载入基类
include_once(BG_PATH_CONTROL_INSTALL . "ajax/upgrade.class.php"); //载入栏目控制器

$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化基类
$ajax_upgrade           = new AJAX_UPGRADE(); //初始化商家

switch ($GLOBALS["act_post"]) {
	case "sso":
		$ajax_upgrade->ajax_sso();
	break;

	case "upload":
		$ajax_upgrade->ajax_upload();
	break;

	case "visit":
		$ajax_upgrade->ajax_visit();
	break;

	case "base":
		$ajax_upgrade->ajax_base();
	break;

	case "dbtable":
		$ajax_upgrade->ajax_dbtable();
	break;

	case "over":
		$ajax_upgrade->ajax_over();
	break;
}
?>