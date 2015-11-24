<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

function fn_callAttach($arr_call, $template) {
	$_mdl_attach  = new MODEL_ATTACH();
	$_mdl_thumb   = new MODEL_THUMB(); //设置上传信息对象

	if (!file_exists(BG_PATH_CACHE . "sys/thumb_list.php")) {
		$_mdl_thumb->mdl_cache();
	}
	$_mdl_attach->thumbRows = include(BG_PATH_CACHE . "sys/thumb_list.php");

	$_arr_attachRow = $_mdl_attach->mdl_url($arr_call["attach_id"]);

	//print_r($_arr_return);
	$attachRow[$arr_call["attach_id"]] = $_arr_attachRow;
	$template->assign("attachRows", $attachRow);
}