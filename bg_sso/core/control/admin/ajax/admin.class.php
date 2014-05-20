<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "admin.func.php"); //载入开放平台类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "log.class.php"); //载入管理帐号模型

/*-------------管理员控制器-------------*/
class AJAX_ADMIN {

	private $adminLogged;
	private $obj_ajax;
	private $log;
	private $mdl_admin;
	private $mdl_log;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //已登录商家信息
		$this->obj_ajax       = new CLASS_AJAX(); //初始化 AJAX 基对象
		$this->log            = $this->obj_ajax->log; //初始化 AJAX 基对象
		$this->mdl_admin      = new MODEL_ADMIN(); //设置管理组模型
		$this->mdl_log        = new MODEL_LOG(); //设置管理员模型
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}


	/**
	 * ajax_my function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_my() {
		$_arr_adminMy = fn_adminMy();
		if ($_arr_adminMy["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminMy["str_alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_loginChk($this->adminLogged["admin_id"]);
		if ($_arr_adminRow["str_alert"] != "y020102") {
			return $_arr_adminRow;
			exit;
		}

		if (fn_baigoEncrypt($_arr_adminMy["admin_pass"], $_arr_adminRow["admin_rand"]) != $_arr_adminRow["admin_pass"]) {
			$this->obj_ajax->halt_alert("x020207");
		}

		if ($_arr_adminMy["admin_pass_new"]) {
			$_str_adminRand      = fn_rand(6);
			$_str_adminPassDo    = fn_baigoEncrypt($_arr_adminMy["admin_pass_new"], $_str_adminRand);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_my($this->adminLogged["admin_id"], $_str_adminPassDo, $_str_adminRand, $_arr_adminMy["admin_note"]);

		$this->obj_ajax->halt_alert($_arr_adminRow["str_alert"]);
	}


	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		$_arr_adminPost = fn_adminPost();

		if ($_arr_adminPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminPost["str_alert"]);
		}

		//检验用户名是否重复
		$_arr_adminRow = $this->mdl_admin->mdl_read($_arr_adminPost["admin_name"], "admin_name", $_arr_adminPost["admin_id"]);
		if ($_arr_adminRow["str_alert"] == "y020102") {
			$this->obj_ajax->halt_alert("x020204");
		}

		if ($_arr_adminPost["admin_id"] > 0) {
			if ($this->adminLogged["admin_allow"]["admin"]["edit"] != 1) {
				$this->obj_ajax->halt_alert("x020303");
			}
			//检验用户是否存在
			$_arr_adminRow = $this->mdl_admin->mdl_read($_arr_adminPost["admin_id"]);
			if ($_arr_adminRow["str_alert"] != "y020102") {
				$this->obj_ajax->halt_alert($_arr_adminRow["str_alert"]);
			}
			$_str_adminPass = $_POST["admin_pass"];
			if ($_str_adminPass) {
				$_str_adminRand     = fn_rand(6);
				$_str_adminPassDo   = fn_baigoEncrypt($_str_adminPass, $_str_adminRand);
			}
		} else {
			if ($this->adminLogged["admin_allow"]["admin"]["add"] != 1) {
				$this->obj_ajax->halt_alert("x020302");
			}
			$_arr_adminPass = validateStr($_POST["admin_pass"], 1, 0);
			switch ($_arr_adminPass["status"]) {
				case "too_short":
					$this->obj_ajax->halt_alert("x020205");
				break;

				case "ok":
					$_str_adminPass = $_arr_adminPass["str"];
				break;
			}
			$_str_adminRand      = fn_rand(6);
			$_str_adminPassDo    = fn_baigoEncrypt($_str_adminPass, $_str_adminRand);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_submit($_arr_adminPost["admin_id"], $_arr_adminPost["admin_name"], $_str_adminPassDo, $_str_adminRand, $_arr_adminPost["admin_note"], $_arr_adminPost["admin_status"], $_arr_adminPost["admin_allow"]);

		if ($_arr_adminRow["str_alert"] == "y020101" || $_arr_adminRow["str_alert"] == "y020103") {
			$_arr_targets[] = array(
				"admin_id" => $_arr_adminRow["admin_id"],
			);
			$_str_targets = json_encode($_arr_targets);
			if ($_arr_adminRow["str_alert"] == "y020101") {
				$_type = "add";
			} else {
				$_type = "edit";
			}
			$_str_adminRow = json_encode($_arr_adminRow);
			$this->mdl_log->mdl_submit($_str_targets, "admin", $this->log["admin"][$_type], $_str_adminRow, "admin", $this->adminLogged["admin_id"]);
		}

		$this->obj_ajax->halt_alert($_arr_adminRow["str_alert"]);
	}


	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		if ($this->adminLogged["admin_allow"]["admin"]["edit"] != 1) {
			$this->obj_ajax->halt_alert("x020303");
		}

		$_str_status = fn_getSafe($_POST["act_post"], "txt", "");

		$_arr_adminDo = fn_adminDo();
		if ($_arr_adminDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminDo["str_alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_status($_arr_adminDo["admin_ids"], $_str_status);

		if ($_arr_adminRow["str_alert"] == "y020103") {
			foreach ($_arr_adminDo["admin_ids"] as $_value) {
				$_arr_targets[] = array(
					"admin_id" => $_value,
				);
				$_str_targets = json_encode($_arr_targets);
			}
			$_str_adminRow = json_encode($_arr_adminRow);
			$this->mdl_log->mdl_submit($_str_targets, "admin", $this->log["admin"]["edit"], $_str_adminRow, "admin", $this->adminLogged["admin_id"]);
		}

		$this->obj_ajax->halt_alert($_arr_adminRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["admin_allow"]["admin"]["del"] != 1) {
			$this->obj_ajax->halt_alert("x020304");
		}

		$_arr_adminDo = fn_adminDo();
		if ($_arr_adminDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminDo["str_alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_del($_arr_adminDo["admin_ids"]);

		if ($_arr_adminRow["str_alert"] == "y020104") {
			foreach ($_arr_adminDo["admin_ids"] as $_value) {
				$_arr_targets[] = array(
					"admin_id" => $_value,
				);
				$_str_targets = json_encode($_arr_targets);
			}
			$_str_adminRow = json_encode($_arr_adminRow);
			$this->mdl_log->mdl_submit($_str_targets, "admin", $this->log["admin"]["del"], $_str_adminRow, "admin", $this->adminLogged["admin_id"]);
		}

		$this->obj_ajax->halt_alert($_arr_adminRow["str_alert"]);
	}


	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_adminName   = fn_getSafe($_GET["admin_name"], "txt", "");
		$_num_adminId     = fn_getSafe($_GET["admin_id"], "int", 0);

		$_arr_adminRow = $this->mdl_admin->mdl_read($_str_adminName, "admin_name", $_num_adminId);

		if ($_arr_adminRow["str_alert"] == "y020102") {
			$this->obj_ajax->halt_re("x020204");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
?>