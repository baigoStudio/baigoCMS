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
		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["thumb"] != 1) {
			$this->obj_ajax->halt_alert("x090302");
		}

		$_arr_thumbSubmit = $this->mdl_thumb->input_submit();

		if ($_arr_thumbSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_thumbSubmit["str_alert"]);
		}

		$_arr_thumbRow = $this->mdl_thumb->mdl_submit();

		$this->obj_ajax->halt_alert($_arr_thumbRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["thumb"] != 1) {
			$this->obj_ajax->halt_alert("x090304");
		}

		$_arr_thumbIds = $this->mdl_thumb->input_ids();
		if ($_arr_thumbIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_thumbIds["str_alert"]);
		}

		$_arr_thumbRow = $this->mdl_thumb->mdl_del();

		$this->obj_ajax->halt_alert($_arr_thumbRow["str_alert"]);
	}


	function ajax_chk() {
		$_num_thumbId     = fn_getSafe($_GET["thumb_id"], "int", 0);
		$_num_thumbWidth  = fn_getSafe($_GET["thumb_width"], "int", 0);
		$_num_thumbHeight = fn_getSafe($_GET["thumb_height"], "int", 0);
		$_str_thumbType   = fn_getSafe($_GET["thumb_type"], "txt", "");

		$_arr_tagRow  = $this->mdl_tag->mdl_check($_num_thumbWidth, $_num_thumbHeight, $_str_thumbType);
		if ($_arr_tagRow["str_alert"] == "y130102") {
			$this->obj_ajax->halt_re("x130203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		echo json_encode($arr_re);
	}
}
?>