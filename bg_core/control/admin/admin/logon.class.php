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
include_once(BG_PATH_FUNC . "admin.func.php");
include_once(BG_PATH_CLASS . "sso.class.php"); //载入 SSO
include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型

/*-------------用户类-------------*/
class CONTROL_LOGON {

	private $obj_base;
	private $config;
	private $obj_sso;
	private $obj_tpl;
	private $mdl_admin;


	function __construct() { //构造函数
		$this->obj_base   = $GLOBALS["obj_base"]; //获取界面类型
		$this->config     = $this->obj_base->config;
		$this->obj_sso    = new CLASS_SSO(); //SSO
		$this->mdl_admin  = new MODEL_ADMIN(); //设置管理员对象
	}

	/*============登录============
	返回数组
		admin_id UC ID
		str_alert 提示信息
	*/
	function ctl_login() {
		$_arr_adminLogin = fn_adminLogin();
		if ($_arr_adminLogin["str_alert"] != "ok") {
			return $_arr_adminLogin;
			exit;
		}

		$_arr_ssoLogin = $this->obj_sso->sso_login($_arr_adminLogin["admin_name"], $_arr_adminLogin["admin_pass"]); //sso验证
		if ($_arr_ssoLogin["str_alert"] != "y010401") {
			$_arr_ssoLogin["forward"] = $_arr_adminLogin["forward"];
			return $_arr_ssoLogin;
			exit;
		}

		$_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoLogin["user_id"]); //本地数据库处理

		if ($_arr_adminRow["str_alert"] != "y020102") {
			$_arr_adminRow["forward"] = $_arr_adminLogin["forward"];
			return $_arr_adminRow;
			exit;
		}

		if ($_arr_adminRow["admin_status"] == "disable") {
			return array(
				"forward"   => $_arr_adminLogin["forward"],
				"str_alert" => "x020401",
			);
			exit;
		}

		$_str_rand = fn_rand(6);
		$this->mdl_admin->mdl_login($_arr_ssoLogin["user_id"], $_str_rand);


		$_SESSION["admin_id_" . BG_SITE_SSIN]         = $_arr_ssoLogin["user_id"];
		$_SESSION["admin_ssintime_" . BG_SITE_SSIN]   = time();
		$_SESSION["admin_hash_" . BG_SITE_SSIN]       = fn_baigoEncrypt($_arr_adminRow["admin_time"], $_str_rand);

		return array(
			"admin_id"   => $_arr_ssoLogin["user_id"],
			"forward"    => $_arr_adminLogin["forward"],
			"str_alert"  => "y020401",
		);
	}


	/*============登录界面============
	无返回
	*/
	function ctl_logon() {
		$this->obj_tpl = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]); //初始化视图对象
		$_str_forward = fn_getSafe($_GET["forward"], "txt", "");

		$_arr_tplData = array(
			"forward"    => $_str_forward,
			"view"       => $GLOBALS["view"],
		);

		$this->obj_tpl->tplDisplay("logon.tpl", $_arr_tplData);
	}

	/*============登出============
	无返回
	*/
	function ctl_logout() {
		$_str_forward  = fn_getSafe($_GET["forward"], "txt", "");
		if (!$_str_forward) {
			$_str_forward = base64_encode(BG_URL_ADMIN . "admin.php");
		}

		fn_adminEnd();

		return array(
			"forward" => $_str_forward,
		);
	}
}
?>