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
include_once(BG_PATH_MODEL . "mark.class.php");

/*-------------用户类-------------*/
class AJAX_MARK {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_mark;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->mdl_mark       = new MODEL_MARK();
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
		if ($this->adminLogged["groupRow"]["group_allow"]["article"]["mark"] != 1) {
			$this->obj_ajax->halt_alert("x140302");
		}

		$_arr_markSubmit = $this->mdl_mark->input_submit();

		if ($_arr_markSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_markSubmit["str_alert"]);
		}

		$_arr_markRow = $this->mdl_mark->mdl_submit();

		$this->obj_ajax->halt_alert($_arr_markRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["groupRow"]["group_allow"]["article"]["mark"] != 1) {
			$this->obj_ajax->halt_alert("x140304");
		}

		$_arr_markIds = $this->mdl_mark->input_ids();
		if ($_arr_markIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_markIds["str_alert"]);
		}

		$_arr_markRow = $this->mdl_mark->mdl_del();

		$this->obj_ajax->halt_alert($_arr_markRow["str_alert"]);
	}


	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_markName    = fn_getSafe($_GET["mark_name"], "txt", "");
		$_num_markId      = fn_getSafe($_GET["mark_id"], "int", 0);
		$_arr_markRow     = $this->mdl_mark->mdl_read($_str_markName, "mark_name", $_num_markId);
		if ($_arr_markRow["str_alert"] == "y140102") {
			$this->obj_ajax->halt_re("x140203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
?>