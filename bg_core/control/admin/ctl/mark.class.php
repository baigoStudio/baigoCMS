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
include_once(BG_PATH_MODEL . "mark.class.php");

/*-------------允许类-------------*/
class CONTROL_MARK {

	public $obj_tpl;
	public $mdl_mark;
	public $adminLogged;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"];
		$this->mdl_mark       = new MODEL_MARK();
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
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["mark"])) {
			return array(
				"str_alert" => "x140301",
			);
			exit;
		}

		$_act_get     = fn_getSafe($GLOBALS["act_get"], "txt", "");
		$_str_key     = fn_getSafe(fn_get("key"), "txt", "");
		$_num_markId  = fn_getSafe(fn_get("mark_id"), "int", 0);

		$_arr_search = array(
			"act_get"    => $_act_get,
			"key"        => $_str_key,
		);

		$_num_markCount   = $this->mdl_mark->mdl_count($_str_key);
		$_arr_page        = fn_page($_num_markCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_markRows    = $this->mdl_mark->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_key);

		if ($_num_markId > 0) {
			$_arr_markRow = $this->mdl_mark->mdl_read($_num_markId);
			if ($_arr_markRow["str_alert"] != "y140102") {
				return $_arr_markRow;
				exit;
			}
		} else {
			$_arr_markRow = array(
				"mark_id"   => 0,
				"mark_name" => "",
			);
		}

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"markRow"    => $_arr_markRow,
			"markRows"   => $_arr_markRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("mark_list.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y140301",
		);
	}

}
