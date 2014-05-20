<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "dir.class.php"); //载入模板类
include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "cate.class.php"); //载入管理帐号模型

/*-------------用户类-------------*/
class CONTROL_CATE {

	private $obj_tpl;
	private $mdl_cate;
	private $adminLogged;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"];
		$this->config         = $this->obj_base->config;
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->obj_dir        = new CLASS_DIR(); //初始化目录对象
		$this->mdl_cate       = new MODEL_CATE(); //设置栏目对象
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]);; //初始化视图对象
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}


	function ctl_order() {
		if ($this->adminLogged["admin_allow_sys"]["cate"]["edit"] != 1) {
			return array(
				"str_alert" => "x110303"
			);
			exit;
		}

		$_num_cateId = fn_getSafe($_GET["cate_id"], "int", 0);

		if ($_num_cateId == 0) {
			return array(
				"str_alert" => "x110217"
			);
		}

		$_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);
		if ($_arr_cateRow["str_alert"] != "y110102") {
			return $_arr_cateRow;
			exit;
		}

		$_arr_tpl = array(
			"cateRow"    => $_arr_cateRow, //栏目信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("cate_order.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y110102"
		);
	}


	/**
	 * ctl_form function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_form() {
		$_num_cateId = fn_getSafe($_GET["cate_id"], "int", 0);

		if ($_num_cateId > 0) {
			if ($this->adminLogged["admin_allow_sys"]["cate"]["edit"] != 1) {
				return array(
					"str_alert" => "x110303"
				);
				exit;
			}
			$_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);
			if ($_arr_cateRow["str_alert"] != "y110102") {
				return $_arr_cateRow;
				exit;
			}
		} else {
			if ($this->adminLogged["admin_allow_sys"]["cate"]["add"] != 1) {
				return array(
					"str_alert" => "x110302"
				);
				exit;
			}
			$_arr_cateRow = array(
				"cate_type"         => "normal",
				"cate_status"       => "show",
				"cate_parent_id"    => -1,
			);
		}

		$_arr_cateRows    = $this->mdl_cate->mdl_list(1000, 0, "show");
		$_arr_tplRows     = $this->obj_dir->list_dir(BG_PATH_TPL_PUB);

		$_arr_tpl = array(
			"cateRow"    => $_arr_cateRow, //栏目信息
			"cateRows"   => $_arr_cateRows, //栏目列表
			"tplRows"    => $_arr_tplRows, //栏目列表
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("cate_form.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y110102"
		);

	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		if ($this->adminLogged["admin_allow_sys"]["cate"]["browse"] != 1) {
			return array(
				"str_alert" => "x110301"
			);
			exit;
		}

		$_num_page    = fn_getSafe($_GET["page"], "int", 1);
		$_act_get     = fn_getSafe($_GET["act_get"], "txt", "");
		$_str_key     = fn_getSafe($_GET["key"], "txt", "");
		$_str_type    = fn_getSafe($_GET["type"], "txt", "");
		$_str_status  = fn_getSafe($_GET["status"], "txt", "");

		$_arr_search = array(
			"page"       => $_num_page,
			"act_get"    => $_act_get,
			"key"        => $_str_key,
			"type"       => $_str_type,
			"status"     => $_str_status,
		);

		$_num_cateCount   = $this->mdl_cate->mdl_count($_str_status, $_str_type);
		$_arr_page        = fn_page($_num_cateCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_cateRows    = $this->mdl_cate->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_status, $_str_type);

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"cateRows"   => $_arr_cateRows, //栏目信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("cate_list.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y110301"
		);
	}

}
?>