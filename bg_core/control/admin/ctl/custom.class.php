<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl_admin.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "custom.class.php");

/*-------------允许类-------------*/
class CONTROL_CUSTOM {

	public $obj_tpl;
	public $mdl_custom;
	public $adminLogged;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"];
		$this->mdl_custom       = new MODEL_CUSTOM();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]); //初始化视图对象
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["custom"])) {
			return array(
				"str_alert" => "x200301",
			);
			exit;
		}

		$_act_get         = fn_getSafe($GLOBALS["act_get"], "txt", "");
		$_str_key         = fn_getSafe(fn_get("key"), "txt", "");
		$_str_status      = fn_getSafe(fn_get("status"), "txt", "");
		$_str_type        = fn_getSafe(fn_get("type"), "txt", "");
		$_num_customId    = fn_getSafe(fn_get("custom_id"), "int", 0);

		$_arr_search = array(
			"act_get"    => $_act_get,
			"key"        => $_str_key,
			"status"     => $_str_status,
			"type"       => $_str_type,
		);

		$_num_customCount = $this->mdl_custom->mdl_count($_str_key, $_str_type, $_str_status);
		$_arr_page        = fn_page($_num_customCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_customRows  = $this->mdl_custom->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_key, $_str_type, $_str_status);

		if ($_num_customId > 0) {
			$_arr_customRow = $this->mdl_custom->mdl_read($_num_customId);
			if ($_arr_customRow["str_alert"] != "y200102") {
				return $_arr_customRow;
				exit;
			}
		} else {
			$_arr_customRow = array(
				"custom_id"     => 0,
				"custom_name"   => "",
				"custom_type"   => "",
				"custom_status" => "enable",
			);
		}

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"customRow"  => $_arr_customRow,
			"customRows" => $_arr_customRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("custom_list.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y200301",
		);
	}

}
