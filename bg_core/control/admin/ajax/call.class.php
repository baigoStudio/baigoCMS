<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "call.class.php");

/*-------------用户类-------------*/
class AJAX_CALL {

	private $adminLogged;
	private $mdl_call;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->mdl_call       = new MODEL_CALL();

		if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //验证是否已经安装
			include_once(BG_PATH_CONFIG . "is_install.php");
			if (!defined("BG_INSTALL_PUB") || PRD_CMS_PUB > BG_INSTALL_PUB) {
				$this->obj_ajax->halt_alert("x030416");
			}
		} else {
			$this->obj_ajax->halt_alert("x030415");
		}

		if ($this->adminLogged["str_alert"] != "y020102") {
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}


	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		$_arr_callSubmit = $this->mdl_call->input_submit();
		if ($_arr_callSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_callSubmit["str_alert"]);
		}

		if ($_arr_callSubmit["call_id"] > 0) {
			if ($this->adminLogged["groupRow"]["group_allow"]["call"]["edit"] != 1) {
				$this->obj_ajax->halt_alert("x170303");
			}
		} else {
			if ($this->adminLogged["groupRow"]["group_allow"]["call"]["add"] != 1) {
				$this->obj_ajax->halt_alert("x170302");
			}
		}

		$_arr_callRow = $this->mdl_call->mdl_submit();

		$this->obj_ajax->halt_alert($_arr_callRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["groupRow"]["group_allow"]["call"]["del"] != 1) {
			$this->obj_ajax->halt_alert("x170304");
		}

		$_arr_callIds = $this->mdl_call->input_ids();
		if ($_arr_callIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_callIds["str_alert"]);
		}

		$_arr_callRow = $this->mdl_call->mdl_del();

		$this->obj_ajax->halt_alert($_arr_callRow["str_alert"]);
	}


	/**
	 * ajax_chkGroup function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_callName   = fn_getSafe(fn_get("call_name"), "txt", "");
		$_num_callId     = fn_getSafe(fn_get("call_id"), "int", 0);

		$_arr_callRow = $this->mdl_call->mdl_read($_str_callName, "call_name", $_num_callId);

		if ($_arr_callRow["str_alert"] == "y170102") {
			$this->obj_ajax->halt_re("x170203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
