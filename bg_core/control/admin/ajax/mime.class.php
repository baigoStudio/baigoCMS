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
include_once(BG_PATH_MODEL . "mime.class.php");

/*-------------用户类-------------*/
class AJAX_MIME {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_mime;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->mdl_mime       = new MODEL_MIME();
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
		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["mime"] != 1) {
			$this->obj_ajax->halt_alert("x080302");
		}

		$_arr_mimeSubmit = $this->mdl_mime->input_submit();

		if ($_arr_mimeSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_mimeSubmit["str_alert"]);
		}

		$_arr_mimeRow = $this->mdl_mime->mdl_submit();

		$this->obj_ajax->halt_alert($_arr_mimeRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["mime"] != 1) {
			$this->obj_ajax->halt_alert("x080304");
		}

		$_arr_mimeIds = $this->mdl_mime->input_ids();
		if ($_arr_mimeIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_mimeIds["str_alert"]);
		}

		$_arr_mimeRow = $this->mdl_mime->mdl_del();

		$this->obj_ajax->halt_alert($_arr_mimeRow["str_alert"]);
	}



	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_mimeName    = fn_getSafe(fn_get("mime_name"), "txt", "");
		$_num_mimeId      = fn_getSafe(fn_get("mime_id"), "int", 0);
		$_arr_mimeRow     = $this->mdl_mime->mdl_read($_str_mimeName, "mime_name", $_num_mimeId);
		if ($_arr_mimeRow["str_alert"] == "y080102") {
			$this->obj_ajax->halt_re("x080206");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
