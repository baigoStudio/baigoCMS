<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "user.func.php"); //载入模板类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "user.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "log.class.php"); //载入管理帐号模型

/*-------------用户控制器-------------*/
class AJAX_USER {

	private $adminLogged;
	private $obj_ajax;
	private $log;
	private $mdl_user;
	private $mdl_log;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //已登录用户信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->log            = $this->obj_ajax->log; //初始化 AJAX 基对象
		$this->mdl_user       = new MODEL_USER(); //设置用户模型
		$this->mdl_log        = new MODEL_LOG(); //设置管理员模型
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}

	/*============提交用户============
	返回数组
		user_id ID
		str_alert 提示信息
	*/
	function ajax_submit() {
		$_arr_userPost = fn_userPost();

		if ($_arr_userPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_userPost["str_alert"]);
		}

		//检验用户名是否重复
		$_arr_userRow = $this->mdl_user->mdl_read($_arr_userPost["user_name"], "user_name", $_arr_userPost["user_id"]);
		if ($_arr_userRow["str_alert"] == "y010102") {
			$this->obj_ajax->halt_alert("x010205");
		}

		if ($_arr_userPost["user_id"] > 0) {
			if ($this->adminLogged["admin_allow"]["user"]["edit"] != 1) {
				$this->obj_ajax->halt_alert("x010303");
			}
			//检查用户是否存在
			$_arr_userRow = $this->mdl_user->mdl_read($_arr_userPost["user_id"]);
			if ($_arr_userRow["str_alert"] != "y010102") {
				$this->obj_ajax->halt_alert($_arr_userRow["str_alert"]);
			}
			$_str_userPass = $_POST["user_pass"];
			if ($_str_userPass) {
				$_str_userRand      = fn_rand(6);
				$_str_userPassDo    = fn_baigoEncrypt($_str_userPass, $_str_userRand);
			}
		} else {
			if ($this->adminLogged["admin_allow"]["user"]["add"] != 1) {
				$this->obj_ajax->halt_alert("x010302");
			}
			$_arr_userPass = validateStr($_POST["user_pass"], 1, 0);
			switch ($_arr_userPass["status"]) {
				case "too_short":
					$this->obj_ajax->halt_alert("x010212");
				break;

				case "ok":
					$_str_userPass = $_arr_userPass["str"];
				break;
			}
			$_str_userRand   = fn_rand(6);
			$_str_userPassDo = fn_baigoEncrypt($_str_userPass, $_str_userRand);
		}

		$_arr_userStatus = validateStr($_POST["user_status"], 1, 0);
		switch ($_arr_userStatus["status"]) {
			case "too_short":
				$this->obj_ajax->halt_alert("x010216");
			break;

			case "ok":
				$_str_userStatus = $_arr_userStatus["str"];
			break;

		}

		$_arr_userRow = $this->mdl_user->mdl_submit($_arr_userPost["user_id"], $_arr_userPost["user_name"], $_arr_userPost["user_mail"], $_str_userPassDo, $_str_userRand, $_arr_userPost["user_nick"], $_arr_userPost["user_note"], $_str_userStatus);

		$this->obj_ajax->halt_alert($_arr_userRow["str_alert"]);
	}

	/*============更改用户状态============
	@arr_userId 用户 ID 数组
	@str_status 状态

	返回提示信息
	*/
	function ajax_status() {
		if ($this->adminLogged["admin_allow"]["user"]["edit"] != 1) {
			$this->obj_ajax->halt_alert("x010303");
		}

		$_str_status = fn_getSafe($_POST["act_post"], "txt", "");

		$_arr_userDo = fn_userDo();
		if ($_arr_userDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_userDo["str_alert"]);
		}

		$_arr_userRow = $this->mdl_user->mdl_status($_arr_userDo["user_ids"], $_str_status);

		$this->obj_ajax->halt_alert($_arr_userRow["str_alert"]);
	}

	/*============删除用户============
	@arr_userId 用户 ID 数组

	返回提示信息
	*/
	function ajax_del() {
		if ($this->adminLogged["admin_allow"]["user"]["del"] != 1) {
			$this->obj_ajax->halt_alert("x010304");
		}

		$_arr_userDo = fn_userDo();
		if ($_arr_userDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_userDo["str_alert"]);
		}

		$_arr_userRow = $this->mdl_user->mdl_del($_arr_userDo["user_ids"]);

		if ($_arr_userRow["str_alert"] == "y010104") {
			foreach ($_arr_userDo["user_ids"] as $_value) {
				$_arr_targets[] = array(
					"user_id" => $_value,
				);
				$_str_targets = json_encode($_arr_targets);
			}
			$_str_userRow = json_encode($_arr_userRow);
			$this->mdl_log->mdl_submit($_str_targets, "user", $this->log["user"]["del"], $_str_userRow, "admin", $this->adminLogged["admin_id"]);
		}

		$this->obj_ajax->halt_alert($_arr_userRow["str_alert"]);
	}


	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_arr_userName = fn_userChkName();

		if ($_arr_userName["str_alert"] != "ok") {
			$this->obj_ajax->halt_re($_arr_userName["str_alert"]);
		}

		$_arr_userRow = $this->mdl_user->mdl_read($_arr_userName["user_name"], "user_name", $_arr_userName["user_id"]);

		if ($_arr_userRow["str_alert"] == "y010102") {
			$this->obj_ajax->halt_re("x010205");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}

	/**
	 * ajax_chkmail function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkmail() {
		$_arr_userMail = fn_userChkMail();

		if ($_arr_userMail["str_alert"] != "ok") {
			$this->obj_ajax->halt_re($_arr_userMail["str_alert"]);
		}

		if ($_arr_userMail["user_mail"]) {
			$_arr_userRow = $this->mdl_user->mdl_read($_arr_userMail["user_mail"], "user_mail", $_arr_userMail["user_id"]);
			if ($_arr_userRow["str_alert"] == "y010102") {
				$this->obj_ajax->halt_re("x010211");
			}
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
?>