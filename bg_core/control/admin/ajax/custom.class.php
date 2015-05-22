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
include_once(BG_PATH_MODEL . "custom.class.php");

/*-------------用户类-------------*/
class AJAX_CUSTOM {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_custom;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->mdl_custom     = new MODEL_CUSTOM();

		if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //验证是否已经安装
			include_once(BG_PATH_CONFIG . "is_install.php");
			if (!defined("BG_INSTALL_PUB") || PRD_CMS_PUB > BG_INSTALL_PUB) {
				$this->obj_ajax->halt_alert("x030416");
			}
		} else {
			$this->obj_ajax->halt_alert("x030415");
		}

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
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["custom"])) {
			$this->obj_ajax->halt_alert("x200302");
		}

		$_arr_customSubmit = $this->mdl_custom->input_submit();

		if ($_arr_customSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_customSubmit["str_alert"]);
		}

		$_arr_customRow = $this->mdl_custom->mdl_submit();

		$this->obj_ajax->halt_alert($_arr_customRow["str_alert"]);
	}


	function ajax_status() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["custom"])) {
			$this->obj_ajax->halt_alert("x170303");
		}

		$_arr_customIds = $this->mdl_custom->input_ids();
		if ($_arr_customIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_customIds["str_alert"]);
		}

		$_str_customStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
		if (!$_str_customStatus) {
			$this->obj_ajax->halt_alert("x200206");
		}

		$_arr_customRow = $this->mdl_custom->mdl_status($_str_customStatus);

		$this->obj_ajax->halt_alert($_arr_customRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["custom"])) {
			$this->obj_ajax->halt_alert("x200304");
		}

		$_arr_customIds = $this->mdl_custom->input_ids();
		if ($_arr_customIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_customIds["str_alert"]);
		}

		$_arr_customRow = $this->mdl_custom->mdl_del();

		$this->obj_ajax->halt_alert($_arr_customRow["str_alert"]);
	}


	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_customName    = fn_getSafe(fn_get("custom_name"), "txt", "");
		$_num_customId      = fn_getSafe(fn_get("custom_id"), "int", 0);
		$_str_customType    = fn_getSafe(fn_get("custom_type"), "txt", "");
		$_arr_customRow     = $this->mdl_custom->mdl_read($_str_customName, "custom_name", $_num_customId, $_str_customType);
		if ($_arr_customRow["str_alert"] == "y200102") {
			$this->obj_ajax->halt_re("x200203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
