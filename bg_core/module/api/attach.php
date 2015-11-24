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
fn_include(true, true, "Content-type: application/json; charset=utf-8", true, "ajax");

include_once(BG_PATH_CONTROL . "api/attach.class.php"); //载入商家控制器

$api_attach = new API_ATTACH();

switch ($GLOBALS["act_get"]) {
	default:
		$api_attach->api_get();
	break;
}
