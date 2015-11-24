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
fn_include(true, false, "Content-Type: text/html; charset=utf-8", true, "ctl", false, true);

include_once(BG_PATH_CONTROL . "pub/ctl/search.class.php"); //载入文章类

$ctl_search = new CONTROL_SEARCH();

switch ($GLOBALS["act_get"]) {
	/*case "custom":
		$arr_searchRow = $ctl_search->ctl_custom();
	break;*/

	default:
		$arr_searchRow = $ctl_search->ctl_show();
	break;
}
