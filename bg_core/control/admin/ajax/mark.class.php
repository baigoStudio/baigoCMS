<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "mark.func.php"); //载入 http
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "mark.class.php"); //载入后台用户类

/*-------------用户类-------------*/
class AJAX_MARK {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_mark;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_mark       = new MODEL_MARK(); //设置管理员对象
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
		if ($this->adminLogged["admin_allow_sys"]["article"]["mark"] != 1) {
			$this->obj_ajax->halt_alert("x140302");
		}

		$_arr_markPost = fn_markPost();

		if ($_arr_markPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_markPost["str_alert"]);
		}

		if ($_arr_markPost["mark_id"] > 0) {
			$_arr_markRow = $this->mdl_mark->mdl_read($_arr_markPost["mark_id"]);
			if ($_arr_markRow["str_alert"] != "y140102") {
				$this->obj_ajax->halt_alert($_arr_markRow["str_alert"]);
			}
			$_arr_markRow = $this->mdl_mark->mdl_read($_arr_markPost["mark_name"], "mark_name", $_arr_markPost["mark_id"]);
			if ($_arr_markRow["str_alert"] == "y140102") {
				$this->obj_ajax->halt_alert("x140203");
			}
		} else {
			$_arr_markRow = $this->mdl_mark->mdl_read($_arr_markPost["mark_name"], "mark_name");
			if ($_arr_markRow["str_alert"] == "y140102") {
				$this->obj_ajax->halt_alert("x140203");
			}
		}


		$_arr_markRow = $this->mdl_mark->mdl_submit($_arr_markPost["mark_id"], $_arr_markPost["mark_name"]);

		$this->obj_ajax->halt_alert($_arr_markRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["admin_allow_sys"]["article"]["mark"] != 1) {
			$this->obj_ajax->halt_alert("x140304");
		}

		$_arr_markDo = fn_markDo();
		if ($_arr_markDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_markDo["str_alert"]);
		}

		$_arr_markRow = $this->mdl_mark->mdl_del($_arr_markDo["mark_ids"]);

		$this->obj_ajax->halt_alert($_arr_markRow["str_alert"]);
	}


	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_markName = fn_getSafe($_GET["mark_name"], "txt", "");
		$_num_markId = fn_getSafe($_GET["mark_id"], "int", 0);
		$_arr_markRow = $this->mdl_mark->mdl_read($_str_markName, "mark_name", $_num_markId);
		if ($_arr_markRow["str_alert"] == "y140102") {
			$this->obj_ajax->halt_re("x140203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		echo json_encode($arr_re);
	}
}
?>