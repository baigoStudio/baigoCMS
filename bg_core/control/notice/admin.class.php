<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入 http
include_once(BG_PATH_CLASS . "notice.class.php");
include_once(BG_PATH_CLASS . "sso.class.php");
include_once(BG_PATH_MODEL . "admin.class.php"); //载入后台用户类

/*-------------文章类-------------*/
class NOTICE_ADMIN {

	private $mdl_admin;

	function __construct() { //构造函数
		$this->obj_notice = new CLASS_NOTICE();
		$this->obj_notice->chk_install();
		$this->obj_sso    = new CLASS_SSO();
		$this->mdl_admin  = new MODEL_ADMIN(); //设置文章对象
	}


	/**
	 * notice_list function.
	 *
	 * @access public
	 * @return void
	 */
	function notice_login() {
		$_arr_noticeGet = $this->obj_notice->notice_get("get");

		if ($_arr_noticeGet["alert"] != "ok") {
			$this->obj_notice->halt_re($_arr_noticeGet);
		}

		$_tm_now = time();

		if (($_arr_noticeGet["time"] - $_tm_now) > 300) {
			$_arr_return = array(
				"alert"     => "x220213",
			);
			$this->obj_notice->halt_re($_arr_return);
		}

		$_arr_signature = $this->obj_sso->sso_verify($_arr_noticeGet["time"], $_arr_noticeGet["random"], $_arr_noticeGet["signature"]);
		if ($_arr_signature["alert"] != "y050403") {
			$this->obj_notice->halt_re($_arr_signature);
		}

		$_arr_decode      = $this->obj_sso->sso_decode($_arr_noticeGet["code"], $_arr_noticeGet["key"]);
		$_arr_adminRow    = $this->mdl_admin->mdl_read($_arr_decode["user_id"]);

		if ($_arr_adminRow["alert"] != "y020102") {
			$this->obj_notice->halt_re($_arr_adminRow);
		}

		if ($_arr_adminRow["admin_status"] == "disable") {
			$_arr_return = array(
				"alert"     => "x020401",
			);
			$this->obj_notice->halt_re($_arr_return);
		}

		$_str_rand = fn_rand(6);
		$this->mdl_admin->mdl_login($_arr_decode["user_id"], $_str_rand);

		fn_session("admin_id", "mk", $_arr_decode["user_id"]);
		fn_session("admin_ssin_time", "mk", time());
		fn_session("admin_hash", "mk", fn_baigoEncrypt($_arr_adminRow["admin_time"], $_str_rand));

		$this->obj_notice->halt_re($_arr_adminRow);
	}
}
