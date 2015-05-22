<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "group.class.php"); //载入管理帐号模型


/**
 * fn_ssin_begin function.
 *
 * @access public
 * @return void
 */
function fn_ssin_begin() {
	$_mdl_admin  = new MODEL_ADMIN(); //设置管理员对象
	$_mdl_group  = new MODEL_GROUP(); //设置管理员对象

	$_num_adminTimeDiff = fn_session("admin_ssin_time") + BG_DEFAULT_SESSION; //session有效期

	if (!fn_session("admin_id") || !fn_session("admin_ssin_time") || !fn_session("admin_hash") || $_num_adminTimeDiff < time()) {
		fn_ssin_end();
		$_arr_adminRow["str_alert"] = "x020402";
		return $_arr_adminRow;
		exit;
	}

	$_arr_adminRow = $_mdl_admin->mdl_read(fn_session("admin_id"));

	if (fn_baigoEncrypt($_arr_adminRow["admin_time"], $_arr_adminRow["admin_rand"]) != fn_session("admin_hash")){
		fn_ssin_end();
		$_arr_adminRow["str_alert"] = "x020403";
		return $_arr_adminRow;
		exit;
	}

	$_arr_groupRow = $_mdl_group->mdl_read($_arr_adminRow["admin_group_id"]);

	if (isset($_arr_groupRow["group_status"]) && $_arr_groupRow["group_status"] == "disable") {
		fn_ssin_end();
		$_arr_adminRow["str_alert"] = "x040401";
		return $_arr_adminRow;
		exit;
	}

	$_arr_adminRow["groupRow"] = $_arr_groupRow;
	fn_session("admin_ssin_time", "mk", time());

	return $_arr_adminRow;
}


/**
 * fn_ssin_end function.
 *
 * @access public
 * @return void
 */
function fn_ssin_end() {
	fn_session("admin_id", "unset");
	fn_session("admin_ssin_time", "unset");
	fn_session("admin_hash", "unset");
}
