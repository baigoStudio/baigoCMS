<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "thumb.func.php"); //载入 http
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入后台用户类

/*-------------用户类-------------*/
class AJAX_THUMB {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_thumb;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_thumb       = new MODEL_THUMB(); //设置管理员对象
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
		if ($this->adminLogged["admin_allow_sys"]["upfile"]["thumb"] != 1) {
			$this->obj_ajax->halt_alert("x090302");
		}

		$_arr_thumbPost = fn_thumbPost();

		if ($_arr_thumbPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_thumbPost["str_alert"]);
		}

		$_arr_thumbRow = $this->mdl_thumb->mdl_read($_arr_thumbPost["thumb_width"], $_arr_thumbPost["thumb_height"], $_arr_thumbPost["thumb_type"]);

		if ($_arr_thumbRow["str_alert"] == "y090102") {
			$this->obj_ajax->halt_alert("x090206");
		}

		$_arr_thumbRow = $this->mdl_thumb->mdl_submit($_arr_thumbPost["thumb_width"], $_arr_thumbPost["thumb_height"], $_arr_thumbPost["thumb_type"]);

		$this->obj_ajax->halt_alert($_arr_thumbRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["admin_allow_sys"]["upfile"]["thumb"] != 1) {
			$this->obj_ajax->halt_alert("x090304");
		}

		$_arr_thumbDo = fn_thumbDo();
		if ($_arr_thumbDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_thumbDo["str_alert"]);
		}

		$_arr_thumbRow = $this->mdl_thumb->mdl_del($_arr_thumbDo["thumb_ids"]);

		$this->obj_ajax->halt_alert($_arr_thumbRow["str_alert"]);
	}
}
?>