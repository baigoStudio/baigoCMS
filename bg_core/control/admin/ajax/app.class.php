<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入管理帐号模型

/*-------------用户控制器-------------*/
class AJAX_APP {

	private $adminLogged;
	private $obj_ajax;
	private $log;
	private $mdl_app;
	private $mdl_log;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //已登录用户信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_app        = new MODEL_APP(); //设置用户模型
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}


	function ajax_reset() {
		if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"] != 1) {
			$this->obj_ajax->halt_alert("x190303");
		}

		$_num_appId   = fn_getSafe(fn_post("app_id"), "int", 0);

		if ($_num_appId == 0) {
			return array(
				"str_alert" => "x190203",
			);
		}

		$_arr_appRow = $this->mdl_app->mdl_read($_num_appId);
		if ($_arr_appRow["str_alert"] != "y190102") {
			return $_arr_appRow;
			exit;
		}

		$_arr_appRow  = $this->mdl_app->mdl_reset($_num_appId);

		$this->obj_ajax->halt_alert($_arr_appRow["str_alert"]);
	}



	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		$_arr_appSubmit = $this->mdl_app->input_submit();

		if ($_arr_appSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_appSubmit["str_alert"]);
		}

		if ($_arr_appSubmit["app_id"] > 0) {
			if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"] != 1) {
				$this->obj_ajax->halt_alert("x190303");
			}
		} else {
			if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"] != 1) {
				$this->obj_ajax->halt_alert("x190302");
			}
		}

		$_arr_appRow = $this->mdl_app->mdl_submit();

		$this->obj_ajax->halt_alert($_arr_appRow["str_alert"]);
	}


	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"] != 1) {
			$this->obj_ajax->halt_alert("x190303");
		}

		$_str_status = fn_getSafe($GLOBALS["act_post"], "txt", "");

		$_arr_appIds = $this->mdl_app->input_ids();
		if ($_arr_appIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_appIds["str_alert"]);
		}

		$_arr_appRow = $this->mdl_app->mdl_status($_str_status);

		$this->obj_ajax->halt_alert($_arr_appRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"] != 1) {
			$this->obj_ajax->halt_alert("x190304");
		}

		$_arr_appIds = $this->mdl_app->input_ids();
		if ($_arr_appIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_appIds["str_alert"]);
		}

		$_arr_appRow = $this->mdl_app->mdl_del();

		$this->obj_ajax->halt_alert($_arr_appRow["str_alert"]);
	}
}
