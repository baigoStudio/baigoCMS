<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "tag.func.php"); //载入 http
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "tag.class.php"); //载入后台用户类

/*-------------用户类-------------*/
class AJAX_TAG {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_tag;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_tag        = new MODEL_TAG(); //设置管理员对象
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}

	function ajax_submit() {
		if ($this->adminLogged["admin_allow_sys"]["article"]["tag"] != 1) {
			$this->obj_ajax->halt_alert("x130303");
		}
		$_arr_tagPost = fn_tagPost();
		if ($_arr_tagPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_tagPost["str_alert"]);
		}

		if ($_arr_tagPost["tag_id"] > 0) {
			$_arr_tagRow = $this->mdl_tag->mdl_read($_arr_tagPost["tag_id"]);
			if ($_arr_tagRow["str_alert"] != "y130102") {
				$this->obj_ajax->halt_alert($_arr_tagRow["str_alert"]);
			}
			$_arr_tagRow = $this->mdl_tag->mdl_read($_arr_tagPost["tag_name"], "tag_name", $_arr_tagPost["tag_id"]);
			if ($_arr_tagRow["str_alert"] == "y130102") {
				$this->obj_ajax->halt_alert("x130203");
			}
		} else {
			$_arr_tagRow = $this->mdl_tag->mdl_read($_arr_tagPost["tag_name"], "tag_name");
			if ($_arr_tagRow["str_alert"] == "y130102") {
				$this->obj_ajax->halt_alert("x130203");
			}
		}

		$_arr_tagRow = $this->mdl_tag->mdl_submit($_arr_tagPost["tag_id"], $_arr_tagPost["tag_name"], $_arr_tagPost["tag_status"]);

		$this->obj_ajax->halt_alert($_arr_tagRow["str_alert"]);
	}

	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		if ($this->adminLogged["admin_allow_sys"]["article"]["tag"] != 1) {
			$this->obj_ajax->halt_alert("x130303");
		}

		$_arr_tagDo = fn_tagDo();

		if ($_arr_tagDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_tagDo["str_alert"]);
		}

		$_str_tagStatus = fn_getSafe($_POST["act_post"], "txt", "");
		if (!$_str_tagStatus) {
			$this->obj_ajax->halt_alert("x130204");
		}

		$_arr_tagRow = $this->mdl_tag->mdl_status($_arr_tagDo["tag_ids"], $_str_tagStatus);

		$this->obj_ajax->halt_alert($_arr_tagRow["str_alert"]);
	}

	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["admin_allow_sys"]["article"]["tag"] != 1) {
			$this->obj_ajax->halt_alert("x130304");
		}

		$_arr_tagDo = fn_tagDo();
		if ($_arr_tagDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_tagDo["str_alert"]);
		}

		$_arr_tagRow = $this->mdl_tag->mdl_del($_arr_tagDo["tag_ids"]);

		$this->obj_ajax->halt_alert($_arr_tagRow["str_alert"]);
	}


	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_tagName = fn_getSafe($_GET["tag_name"], "txt", "");
		$_num_tagId = fn_getSafe($_GET["tag_id"], "int", 0);
		$_arr_tagRow = $this->mdl_tag->mdl_read($_str_tagName, "tag_name", $_num_tagId);
		if ($_arr_tagRow["str_alert"] == "y130102") {
			$this->obj_ajax->halt_re("x130203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		echo json_encode($arr_re);
	}


	/**
	 * ajax_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_list() {
		$_str_tagName = fn_getSafe($_GET["tag_name"], "txt", "");
		$_arr_tagRows = $this->mdl_tag->mdl_list(1000, 0, $_str_tagName, "show");
		foreach ($_arr_tagRows as $_value) {
			$_arr_tagRow[] = $_value["tag_name"];
		}

		echo json_encode($_arr_tagRow);
	}
}
?>