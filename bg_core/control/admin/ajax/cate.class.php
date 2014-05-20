<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "cate.func.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "cate.class.php"); //载入栏目类

/*-------------用户类-------------*/
class AJAX_CATE {

	private $mdl_cate;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_cate       = new MODEL_CATE(); //设置管理员对象
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}


	/**
	 * ajax_order function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_order() {
		if ($this->adminLogged["admin_allow_sys"]["cate"]["edit"] != 1) {
			$this->obj_ajax->halt_alert("x110303");
		}
		if (!fn_token("chk")) { //令牌
			$this->obj_ajax->halt_alert("x030102");
		}

		$_num_cateId = fn_getSafe($_POST["cate_id"], "int", 0); //ID

		if ($_num_cateId == 0) {
			$this->obj_ajax->halt_alert("x110217");
		}

		$_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);
		if ($_arr_cateRow["str_alert"] != "y110102") {
			$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
		}

		$_num_parentId    = fn_getSafe($_POST["cate_parent_id"], "int", 0);
		$_str_orderType   = fn_getSafe($_POST["order_type"], "txt", "order_first");

		switch ($_str_orderType) {
			case "order_before":
				$_num_targetId = fn_getSafe($_POST["order_target_before"], "int", 0);
			break;

			case "order_after":
				$_num_targetId = fn_getSafe($_POST["order_target_after"], "int", 0);
			break;

			default:
				//$_num_targetId = 0;
			break;
		}

		$_arr_cateRow = $this->mdl_cate->mdl_order($_str_orderType, $_num_cateId, $_num_targetId, $_num_parentId);

		$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
	}


	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		$_arr_cataPost = fn_catePost();

		if ($_arr_cataPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_cataPost["str_alert"]);
		}

		if ($_arr_cataPost["cate_id"] > 0) {
			if ($this->adminLogged["admin_allow_sys"]["cate"]["edit"] != 1) {
				$this->obj_ajax->halt_alert("x110303");
			}
			$_arr_cateRow = $this->mdl_cate->mdl_read($_arr_cataPost["cate_id"]);
			if ($_arr_cateRow["str_alert"] != "y110102") {
				$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
			}
		} else {
			if ($this->adminLogged["admin_allow_sys"]["cate"]["add"] != 1) {
				$this->obj_ajax->halt_alert("x110302");
			}
		}

		$_arr_cateRow = $this->mdl_cate->mdl_read($_arr_cataPost["cate_name"], "cate_name", $_arr_cataPost["cate_id"], $_arr_cataPost["cate_parent_id"]);
		if ($_arr_cateRow["str_alert"] == "y110102") {
			$this->obj_ajax->halt_alert("x110203");
		}

		if ($_arr_cataPost["cate_alias"]) {
			$_arr_cateRow = $this->mdl_cate->mdl_read($_arr_cataPost["cate_alias"], "cate_alias", $_arr_cataPost["cate_id"], $_arr_cataPost["cate_parent_id"]);
			if ($_arr_cateRow["str_alert"] == "y110102") {
				$this->obj_ajax->halt_alert("x110206");
			}
		}

		$_arr_cateRow = $this->mdl_cate->mdl_submit($_arr_cataPost["cate_id"], $_arr_cataPost["cate_name"], $_arr_cataPost["cate_type"], $_arr_cataPost["cate_status"], $_arr_cataPost["cate_tpl"], $_arr_cataPost["cate_alias"], $_arr_cataPost["cate_content"], $_arr_cataPost["cate_link"], $_arr_cataPost["cate_parent_id"], $_arr_cataPost["cate_domain"], $_arr_cataPost["cate_ftp_host"], $_arr_cataPost["cate_ftp_port"], $_arr_cataPost["cate_ftp_user"], $_arr_cataPost["cate_ftp_pass"], $_arr_cataPost["cate_ftp_path"]);

		$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
	}


	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		if ($this->adminLogged["admin_allow_sys"]["cate"]["edit"] != 1) {
			$this->obj_ajax->halt_alert("x110303");
		}

		$_arr_cataDo = fn_cateDo();
		if ($_arr_cataDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_cataDo["str_alert"]);
		}

		$_str_cateStatus = fn_getSafe($_POST["act_post"], "txt", "");
		if (!$_str_cateStatus) {
			$this->obj_ajax->halt_alert("x110216");
		}

		$_arr_cateRow = $this->mdl_cate->mdl_status($_arr_cataDo["cate_ids"], $_str_cateStatus);

		$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["admin_allow_sys"]["cate"]["del"] != 1) {
			$this->obj_ajax->halt_alert("x110304");
		}

		$_arr_cataDo = fn_cateDo();
		if ($_arr_cataDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_cataDo["str_alert"]);
		}

		$_arr_cateRow = $this->mdl_cate->mdl_del($_arr_cataDo["cate_ids"]);

		$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
	}


	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_cateName        = fn_getSafe($_GET["cate_name"], "txt", "");
		$_num_cateId          = fn_getSafe($_GET["cate_id"], "int", 0);
		$_num_cateParentId    = fn_getSafe($_GET["cate_parent_id"], "int", 0);

		$_arr_cateRow = $this->mdl_cate->mdl_read($_str_cateName, "cate_name", $_num_cateId, $_num_cateParentId);

		if ($_arr_cateRow["str_alert"] == "y110102") {
			$this->obj_ajax->halt_re("x110203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}


	/**
	 * ajax_chkalias function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkalias() {
		$_str_cateAlias       = fn_getSafe($_GET["cate_alias"], "txt", "");
		if ($_str_cateAlias) {
			$_num_cateId          = fn_getSafe($_GET["cate_id"], "int", 0);
			$_num_cateParentId    = fn_getSafe($_GET["cate_parent_id"], "int", 0);

			$_arr_cateRow = $this->mdl_cate->mdl_read($_str_cateAlias, "cate_alias", $_num_cateId, $_num_cateParentId);

			if ($_arr_cateRow["str_alert"] == "y110102") {
				$this->obj_ajax->halt_re("x110206");
			}
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
?>