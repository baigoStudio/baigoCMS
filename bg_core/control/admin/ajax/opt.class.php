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
include_once(BG_PATH_MODEL . "opt.class.php");
include_once(BG_PATH_MODEL . "cate.class.php"); //载入栏目类

/*-------------管理员控制器-------------*/
class AJAX_OPT {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_opt;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //已登录商家信息
		$this->obj_ajax       = new CLASS_AJAX(); //初始化 AJAX 基对象
		$this->obj_ajax->chk_install();
		$this->mdl_opt        = new MODEL_OPT();
		$this->mdl_cate       = new MODEL_CATE();

		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["alert"]);
		}
	}

	/**
	 * ajax_upload function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_upload() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["upload"])) {
			$this->obj_ajax->halt_alert("x060302");
		}

		$_arr_return = $this->mdl_opt->mdl_const("upload");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y060402");
	}


	/**
	 * ajax_sso function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_sso() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["sso"])) {
			$this->obj_ajax->halt_alert("x060303");
		}

		$_arr_return = $this->mdl_opt->mdl_const("sso");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y060403");
	}


	/**
	 * ajax_visit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_visit() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["visit"])) {
			$this->obj_ajax->halt_alert("x060304");
		}

		$_arr_return = $this->mdl_opt->mdl_const("visit");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$_arr_post = fn_post("opt");

		if ($_arr_post["BG_VISIT_TYPE"] == "pstatic") {

			$_arr_return = $this->mdl_opt->mdl_htaccess();

			if ($_arr_return["alert"] != "y060101") {
				$this->obj_ajax->halt_alert($_arr_return["alert"]);
			}

		} else {
			if (file_exists(BG_PATH_ROOT . ".htaccess")) {
				unlink(BG_PATH_ROOT . ".htaccess");
			}
		}

		$this->obj_ajax->halt_alert("y060404");
	}


	/**
	 * ajax_base function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_base() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["base"])) {
			$this->obj_ajax->halt_alert("x060301");
		}

		$_arr_return = $this->mdl_opt->mdl_const("base");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$_arr_cache = $this->mdl_cate->mdl_cache();

		$this->obj_ajax->halt_alert("y060401");
	}


	/**
	 * ajax_db function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_db() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["db"])) {
			$this->obj_ajax->halt_alert("x060306");
		}

		$_arr_return = $this->mdl_opt->mdl_dbconfig();

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y060406");
	}
}