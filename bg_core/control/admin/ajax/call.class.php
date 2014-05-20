<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "call.func.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "call.class.php"); //载入后台用户类

/*-------------用户类-------------*/
class AJAX_CALL {

	private $adminLogged;
	private $mdl_call;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_call       = new MODEL_CALL(); //设置管理员对象
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
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
		$_arr_callPost = fn_callPost();
		if ($_arr_callPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_callPost["str_alert"]);
		}

		if ($_arr_callPost["call_id"] > 0) {
			if ($this->adminLogged["admin_allow_sys"]["call"]["edit"] != 1) {
				$this->obj_ajax->halt_alert("x170303");
			}
			$_arr_callRow = $this->mdl_call->mdl_read($_arr_callPost["call_id"]);
			if ($_arr_callRow["str_alert"] != "y170102") {
				$this->obj_ajax->halt_alert($_arr_callRow["str_alert"]);
			}
		} else {
			if ($this->adminLogged["admin_allow_sys"]["call"]["add"] != 1) {
				$this->obj_ajax->halt_alert("x170302");
			}
		}

		$_arr_callRow = $this->mdl_call->mdl_submit($_arr_callPost["call_id"], $_arr_callPost["call_name"], $_arr_callPost["call_type"], $_arr_callPost["call_file"], $_arr_callPost["call_status"], $_arr_callPost["call_amount"], $_arr_callPost["call_trim"], $_arr_callPost["call_css"], $_arr_callPost["call_cate_ids"], $_arr_callPost["call_cate_id"], $_arr_callPost["call_upfile"], $_arr_callPost["call_mark_ids"], $_arr_callPost["call_show"]);

		$this->obj_ajax->halt_alert($_arr_callRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["admin_allow_sys"]["call"]["del"] != 1) {
			$this->obj_ajax->halt_alert("x170304");
		}

		$_arr_callDo = fn_callDo();
		if ($_arr_callDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_callDo["str_alert"]);
		}

		$_arr_callRow = $this->mdl_call->mdl_del($_arr_callDo["call_ids"]);

		$this->obj_ajax->halt_alert($_arr_callRow["str_alert"]);
	}


	/**
	 * ajax_chkGroup function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_callName   = fn_getSafe($_GET["call_name"], "txt", "");
		$_num_callId     = fn_getSafe($_GET["call_id"], "int", 0);

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
?>