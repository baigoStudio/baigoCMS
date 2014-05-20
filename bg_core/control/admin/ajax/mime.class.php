<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "mime.func.php"); //载入 http
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "mime.class.php"); //载入后台用户类

/*-------------用户类-------------*/
class AJAX_MIME {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_mime;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_mime       = new MODEL_MIME(); //设置管理员对象
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
		if ($this->adminLogged["admin_allow_sys"]["upfile"]["mime"] != 1) {
			$this->obj_ajax->halt_alert("x080302");
		}

		$_arr_mimePost = fn_mimePost();

		if ($_arr_mimePost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_mimePost["str_alert"]);
		}

		$_arr_mimeRow = $this->mdl_mime->mdl_read($_arr_mimePost["mime_name"], "mime_name");

		if ($_arr_mimeRow["str_alert"] == "y080102") {
			$this->obj_ajax->halt_alert("x080206");
		}

		$_arr_mimeRow = $this->mdl_mime->mdl_submit($_arr_mimePost["mime_name"], $_arr_mimePost["mime_ext"], $_arr_mimePost["mime_note"]);

		$this->obj_ajax->halt_alert($_arr_mimeRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["admin_allow_sys"]["upfile"]["mime"] != 1) {
			$this->obj_ajax->halt_alert("x080304");
		}

		$_arr_mimeDo = fn_mimeDo();
		if ($_arr_mimeDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_mimeDo["str_alert"]);
		}

		$_arr_mimeRow = $this->mdl_mime->mdl_del($_arr_mimeDo["mime_ids"]);

		$this->obj_ajax->halt_alert($_arr_mimeRow["str_alert"]);
	}



	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_mimeName = fn_getSafe($_GET["mime_name"], "txt", "");
		$_arr_mimeRow = $this->mdl_mime->mdl_read($_str_mimeName, "mime_name");
		if ($_arr_mimeRow["str_alert"] == "y080102") {
			$this->obj_ajax->halt_re("x080206");
		}

		$arr_re = array(
			"re" => "ok"
		);

		echo json_encode($arr_re);
	}
}
?>