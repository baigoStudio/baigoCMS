<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "user.func.php"); //载入开放平台类
include_once(BG_PATH_FUNC . "http.func.php"); //载入开放平台类
include_once(BG_PATH_FUNC . "baigocode.func.php"); //载入开放平台类
include_once(BG_PATH_CLASS . "api.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "user.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "log.class.php"); //载入管理帐号模型

/*-------------用户类-------------*/
class API_USER {

	private $obj_api;
	private $log;
	private $mdl_user;
	private $appAllow;
	private $appRows;
	private $appGet;

	function __construct() { //构造函数
		$this->obj_api    = new CLASS_API();
		$this->log        = $this->obj_api->log; //初始化 AJAX 基对象
		$this->mdl_user   = new MODEL_USER(); //设置管理组模型
		$this->mdl_app    = new MODEL_APP(); //设置管理组模型
		$this->mdl_log    = new MODEL_LOG(); //设置管理员模型
	}


	/**
	 * api_chkapp function.
	 *
	 * @access private
	 * @param mixed $num_appId
	 * @param string $str_method (default: "get")
	 * @return void
	 */
	private function api_chkapp($str_method = "get") {
		$this->appGet = $this->obj_api->app_get($str_method);
		$_arr_logTarget[] = array(
			"app_id" => $this->appGet["app_id"]
		);

		if ($this->appGet["str_alert"] != "ok") {
			$_arr_logType = array("app", "get");
			$this->log_do($_arr_logTarget, "app", $this->appGet, $_arr_logType);
			$this->obj_api->halt_re($this->appGet);
		}

		$_arr_appRow = $this->mdl_app->mdl_read($this->appGet["app_id"]);
		if ($_arr_appRow["str_alert"] != "y050102") {
			$_arr_logType = array("app", "read");
			$this->log_do($_arr_logTarget, "app", $_arr_appRow, $_arr_logType);
			$this->obj_api->halt_re($_arr_appRow);
		}
		$this->appAllow = json_decode($_arr_appRow["app_allow"], true);

		$_arr_appChk = $this->obj_api->app_chk($this->appGet, $_arr_appRow);
		if ($_arr_appChk["str_alert"] != "ok") {
			$_arr_logType = array("app", "check");
			$this->log_do($_arr_logTarget, "app", $_arr_appChk, $_arr_logType);
			$this->obj_api->halt_re($_arr_appChk);
		}

		$this->appRows = $this->mdl_app->mdl_list(100, 0, "", "enable", "on", true);
	}


	/**
	 * log_do function.
	 *
	 * @access private
	 * @param mixed $arr_logResult
	 * @param mixed $str_logType
	 * @return void
	 */
	private function log_do($arr_logTarget, $str_targetType, $arr_logResult, $arr_logType) {
		$_str_targets = json_encode($arr_logTarget);
		$_str_result  = json_encode($arr_logResult);
		$this->mdl_log->mdl_submit($_str_targets, $str_targetType, $this->log[$arr_logType[0]][$arr_logType[1]], $_str_result, "app", $this->appGet["app_id"]);
	}


	/**
	 * api_reg function.
	 *
	 * @access public
	 * @return void
	 */
	function api_reg() {
		$this->api_chkapp("post");

		if ($this->appAllow["user"]["reg"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050305",
			);
			$_arr_logType = array("user", "reg");
			$_arr_logTarget[] = array(
				"app_id" => $this->appGet["app_id"]
			);
			$this->log_do($_arr_logTarget, "app", $_arr_return, $_arr_logType);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_userReg = fn_userReg(); //获取数据
		if ($_arr_userReg["str_alert"] != "ok") {
			$this->obj_api->halt_re($_arr_userReg);
		}

		$_arr_userRow = $this->mdl_user->mdl_read($_arr_userReg["user_name"], "user_name");
		if ($_arr_userRow["str_alert"] == "y010102") {
			$_arr_return = array(
				"str_alert" => "x010205",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		if (BG_REG_ONEMAIL == "false" && BG_REG_NEEDMAIL == "on") {
			$_arr_userRow = $this->mdl_user->mdl_read($_arr_userReg["user_mail"], "user_mail"); //检查Email
			if ($_arr_userRow["str_alert"] == "y010102") {
				$_arr_return = array(
					"str_alert" => "x010211",
				);
				$this->obj_api->halt_re($_arr_return);
			}
		}

		$_str_userRand    = fn_rand(6);
		$_str_userPass    = fn_baigoEncrypt($_arr_userReg["user_pass"], $_str_userRand, true);
		$_arr_userRow     = $this->mdl_user->mdl_submit(0, $_arr_userReg["user_name"], $_arr_userReg["user_mail"], $_str_userPass, $_str_userRand, $_arr_userReg["user_nick"], $_arr_userReg["user_nick"], "enable");
		$_str_code        = $this->obj_api->api_encode($_arr_userRow, $_str_userRand);

		$_arr_return = array(
			"code"   => $_str_code,
			"key"    => $_str_userRand,
		);

		//通知
		$_arr_notice              = $_arr_return;
		$_arr_notice["action"]    = "reg";
		$this->obj_api->api_notice($_arr_notice, $this->appRows);

		$_arr_return["str_alert"] = $_arr_userRow["str_alert"];

		$this->obj_api->halt_re($_arr_return);
	}


	/**
	 * api_login function.
	 *
	 * @access public
	 * @return void
	 */
	function api_login() {
		$this->api_chkapp("post");

		if ($this->appAllow["user"]["login"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050306",
			);
			$_arr_logType = array("user", "login");
			$_arr_logTarget[] = array(
				"app_id" => $this->appGet["app_id"]
			);
			$this->log_do($_arr_logTarget, "app", $_arr_return, $_arr_logType);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_userLogin = fn_userLogin();
		if ($_arr_userLogin["str_alert"] != "ok") {
			$this->obj_api->halt_re($_arr_userLogin);
		}

		$_arr_userRow = $this->mdl_user->mdl_loginChk($_arr_userLogin["user_str"], $_arr_userLogin["user_by"]);
		if ($_arr_userRow["str_alert"] != "y010102") {
			$this->obj_api->halt_re($_arr_userRow);
		}

		if (fn_baigoEncrypt($_arr_userLogin["user_pass"], $_arr_userRow["user_rand"], true) != $_arr_userRow["user_pass"]) {
			$_arr_return = array(
				"str_alert" => "x010213",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		if ($_arr_userRow["user_status"] != "enable") {
			return array(
				"str_alert" => "x010401",
			);
			exit;
		}

		$_str_userRand = fn_rand(6);
		$this->mdl_user->mdl_loginSubmit($_arr_userRow["user_id"], fn_baigoEncrypt($_arr_userLogin["user_pass"], $_str_userRand, true), $_str_userRand);

		unset($_arr_userRow["user_rand"], $_arr_userRow["user_pass"], $_arr_userRow["user_status"]);

		$_str_code = $this->obj_api->api_encode($_arr_userRow, $_str_userRand);

		$_arr_return = array(
			"code"   => $_str_code,
			"key"    => $_str_userRand,
		);

		$_arr_return["str_alert"]  = "y010401";

		$this->obj_api->halt_re($_arr_return);
	}


	/**
	 * api_get function.
	 *
	 * @access public
	 * @return void
	 */
	function api_get() {
		$this->api_chkapp("get");

		if ($this->appAllow["user"]["get"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050307",
			);
			$_arr_logTarget[] = array(
				"app_id" => $this->appGet["app_id"]
			);
			$_arr_logType = array("user", "get");
			$this->log_do($_arr_logTarget, "app", $_arr_return, $_arr_logType);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_userGet = fn_userGetBy("get");

		if ($_arr_userGet["str_alert"] != "ok") {
			$this->obj_api->halt_re($_arr_userGet);
		}

		$_arr_userRow = $this->mdl_user->mdl_read($_arr_userGet["user_str"], $_arr_userGet["user_by"]);
		if ($_arr_userRow["str_alert"] != "y010102") {
			$this->obj_api->halt_re($_arr_userRow);
		}

		$_str_userRand = $_arr_userRow["user_rand"];
		unset($_arr_userRow["user_note"], $_arr_userRow["user_rand"]);

		$_str_code = $this->obj_api->api_encode($_arr_userRow, $_str_userRand);

		$_arr_return = array(
			"code"       => $_str_code,
			"key"        => $_str_userRand,
			"str_alert"  => $_arr_userRow["str_alert"],
		);

		$this->obj_api->halt_re($_arr_return);
	}


	/**
	 * api_edit function.
	 *
	 * @access public
	 * @return void
	 */
	function api_edit() {
		$this->api_chkapp("post");

		if ($this->appAllow["user"]["edit"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050308",
			);
			$_arr_logTarget[] = array(
				"app_id" => $this->appGet["app_id"]
			);
			$_arr_logType = array("user", "edit");
			$this->log_do($_arr_logTarget, "app", $_arr_return, $_arr_logType);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_userEdit = fn_userEdit();
		if ($_arr_userEdit["str_alert"] != "ok") {
			$this->obj_api->halt_re($_arr_userEdit);
		}

		$_arr_userRow = $this->mdl_user->mdl_loginChk($_arr_userEdit["user_str"], $_arr_userEdit["user_by"]);
		if ($_arr_userRow["str_alert"] != "y010102") {
			$this->obj_api->halt_re($_arr_userRow);
		}

		if ($_arr_userEdit["user_check_pass"] == true) {
			if (fn_baigoEncrypt($_arr_userEdit["user_pass"], $_arr_userRow["user_rand"], true) != $_arr_userRow["user_pass"]) {
				$_arr_return = array(
					"str_alert" => "x010213",
				);
				$this->obj_api->halt_re($_arr_return);
			}
		}

		if ($_arr_userRow["user_status"] != "enable") {
			return array(
				"str_alert" => "x010401",
			);
			exit;
		}

		if ($_arr_userEdit["user_pass_new"]) {
			$_str_userRand = fn_rand(6);
			$_str_userPass = fn_baigoEncrypt($_arr_userEdit["user_pass_new"], $_str_userRand, true);
		} else {
			$_str_userRand = $_arr_userRow["user_rand"];
		}

		if (BG_REG_ONEMAIL == "false" && BG_REG_NEEDMAIL == "on" && $_arr_userEdit["user_mail"]) {
			$_arr_userRow = $this->mdl_user->mdl_read($_arr_userEdit["user_mail"], "user_mail", $_arr_userRow["user_id"]);
			if ($_arr_userRow["str_alert"] == "y010102") {
				$_arr_return = array(
					"str_alert" => "x010211",
				);
				$this->obj_api->halt_re($_arr_return);
			}
		}

		//file_put_contents(BG_PATH_ROOT . "test.txt", $_arr_userEdit["user_pass_new"]);

		$_arr_userRow = $this->mdl_user->mdl_my($_arr_userRow["user_id"], $_arr_userEdit["user_mail"], $_str_userPass, $_str_userRand, $_arr_userEdit["user_nick"]);
		$_str_code    = $this->obj_api->api_encode($_arr_userRow, $_str_userRand);

		$_arr_return = array(
			"code"   => $_str_code,
			"key"    => $_str_userRand,
		);

		//通知
		$_arr_notice              = $_arr_return;
		$_arr_notice["action"]    = "edit";
		$this->obj_api->api_notice($_arr_notice, $this->appRows);

		$_arr_return["str_alert"]  = $_arr_userRow["str_alert"];

		$this->obj_api->halt_re($_arr_return);
	}


	/**
	 * api_del function.
	 *
	 * @access public
	 * @return void
	 */
	function api_del() {
		$this->api_chkapp("post");

		if ($this->appAllow["user"]["del"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050309",
			);
			$_arr_logTarget[] = array(
				"app_id" => $this->appGet["app_id"]
			);
			$_arr_logType = array("user", "edit");
			$this->log_do($_arr_logTarget, "app", $_arr_return, $_arr_logType);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_userIds = $_POST["user_id"];

		if ($_arr_userIds && is_array($_arr_userIds)) {
			foreach ($_arr_userIds as $_key=>$_value) {
				$_arr_userIds[$_key] = fn_getSafe($_value, "int", 0);
			}
		}

		$_arr_userDel = $this->mdl_user->mdl_del($_arr_userIds);

		if ($_arr_userRow["str_alert"] == "y010104") {
			foreach ($_arr_userDo["user_ids"] as $_value) {
				$_arr_targets[] = array(
					"user_id" => $_value,
				);
				$_str_targets = json_encode($_arr_targets);
			}
			$_str_userRow = json_encode($_arr_userRow);
			$this->mdl_log->mdl_submit($_str_targets, "user", $this->log["user"]["del"], $_str_userRow, "app", $this->appGet["app_id"]);
		}

		$_arr_notice              = $_arr_userDel;
		$_arr_notice["action"]    = "del";

		$this->obj_api->api_notice($_arr_notice, $this->appRows);

		$this->obj_api->halt_re($_arr_userDel);
	}


	/**
	 * api_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function api_chkname() {
		$this->api_chkapp("get");

		if ($this->appAllow["user"]["chkname"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050310",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_userName = fn_userChkName();
		if ($_arr_userName["str_alert"] != "ok") {
			$this->obj_api->halt_re($_arr_userName);
		}

		$_arr_userRow = $this->mdl_user->mdl_read($_arr_userName["user_name"], "user_name");
		if ($_arr_userRow["str_alert"] == "y010102") {
			$_str_alert = "x010205";
		} else {
			$_str_alert = "y010205";
		}
		$_arr_return = array(
			"str_alert" => $_str_alert,
		);
		$this->obj_api->halt_re($_arr_return);
	}


	/**
	 * api_chkmail function.
	 *
	 * @access public
	 * @return void
	 */
	function api_chkmail() {
		if (BG_REG_ONEMAIL == "false" && BG_REG_NEEDMAIL == "on") {
			$this->api_chkapp("get");

			if ($this->appAllow["user"]["chkmail"] != 1) {
				$_arr_return = array(
					"str_alert" => "x050311",
				);
				$this->obj_api->halt_re($_arr_return);
			}

			$_arr_userMail = fn_userChkMail();
			if ($_arr_userMail["str_alert"] != "ok") {
				$this->obj_api->halt_re($_arr_userMail);
			}

			$_arr_userRow = $this->mdl_user->mdl_read($_arr_userName["user_mail"], "user_mail", $_arr_userName["user_id"]);
			if ($_arr_userRow["str_alert"] == "y010102") {
				$_str_alert = "x010211";
			} else {
				$_str_alert = "y010211";
			}
		} else {
			$_str_alert = "y010211";
		}

		$_arr_return = array(
			"str_alert" => $_str_alert,
		);
		$this->obj_api->halt_re($_arr_return);
	}
}
?>