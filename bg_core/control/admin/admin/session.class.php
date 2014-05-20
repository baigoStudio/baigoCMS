<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "admin.func.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "group.class.php"); //载入管理帐号模型

/*-------------用户类-------------*/
class CONTROL_SESSION {

	private $mdl_admin;
	private $mdl_group;
	private $mdl_cate;

	function __construct() { //构造函数
		$this->mdl_admin  = new MODEL_ADMIN(); //设置管理员对象
		$this->mdl_group  = new MODEL_GROUP(); //设置管理员对象
	}


	/**
	 * ctl_session function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_session() {
		$_num_adminTimeDiff = $_SESSION["admin_ssintime_" . BG_SITE_SSIN] + BG_DEFAULT_SESSION; //session有效期

		if (!$_SESSION["admin_id_" . BG_SITE_SSIN] || !$_SESSION["admin_ssintime_" . BG_SITE_SSIN] || !$_SESSION["admin_hash_" . BG_SITE_SSIN] || $_num_adminTimeDiff < time()) {
			fn_adminEnd();
			$_arr_adminRow["str_alert"] = "x020402";
			return $_arr_adminRow;
			exit;
		}

		$_arr_adminRow = $this->mdl_admin->mdl_read($_SESSION["admin_id_" . BG_SITE_SSIN]);

		if (fn_baigoEncrypt($_arr_adminRow["admin_time"], $_arr_adminRow["admin_rand"]) != $_SESSION["admin_hash_" . BG_SITE_SSIN]){
			fn_adminEnd();
			$_arr_adminRow["str_alert"] = "x020403";
			return $_arr_adminRow;
			exit;
		}

		$_arr_adminRow["admin_allow_cate"]            = json_decode($_arr_adminRow["admin_allow_cate"], true); //json解码
		$_arr_groupRow                                = $this->mdl_group->mdl_read($_arr_adminRow["admin_group_id"]);
		$_arr_adminRow["admin_allow_sys"]             = json_decode($_arr_groupRow["group_allow"], true); //json解码

		$_SESSION["admin_ssintime_" . BG_SITE_SSIN]   = time();

		return $_arr_adminRow;
	}
}
?>