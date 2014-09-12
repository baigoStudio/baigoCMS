<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类

/*-------------用户类-------------*/
class CONTROL_GROUP {

	public $obj_tpl;
	public $mdl_group;
	public $adminLogged;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"];
		$this->mdl_group      = new MODEL_GROUP(); //设置管理员对象
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]);; //初始化视图对象
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}


	/**
	 * ctl_form function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_show() {
		if ($this->adminLogged["groupRow"]["group_allow"]["group"]["browse"] != 1) {
			return array(
				"str_alert" => "x040301",
			);
			exit;
		}

		$_num_groupId = fn_getSafe($_GET["group_id"], "int", 0);

		if ($_num_groupId == 0) {
			return array(
				"str_alert" => "x040206",
			);
		}

		$_arr_groupRow = $this->mdl_group->mdl_read($_num_groupId);
		if ($_arr_groupRow["str_alert"] != "y040102") { //UC 中不存在该用户
			return $_arr_groupRow;
			exit;
		}

		$_arr_tpl = array(
			"groupRow" => $_arr_groupRow, //管理员信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("group_show.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y040102",
		);
	}


	/**
	 * ctl_form function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_form() {
		$_num_groupId = fn_getSafe($_GET["group_id"], "int", 0);

		if ($_num_groupId > 0) {
			if ($this->adminLogged["groupRow"]["group_allow"]["group"]["edit"] != 1) {
				return array(
					"str_alert" => "x040303",
				);
				exit;
			}
			$_arr_groupRow = $this->mdl_group->mdl_read($_num_groupId);
			if ($_arr_groupRow["str_alert"] != "y040102") { //UC 中不存在该用户
				return $_arr_groupRow;
				exit;
			}
		} else {
			if ($this->adminLogged["groupRow"]["group_allow"]["group"]["edit"] != 1) {
				return array(
					"str_alert" => "x040302",
				);
				exit;
			}
			$_arr_groupRow = array(
				"group_type"    => "admin",
				"group_status"  => "enable",
			);
		}


		$_arr_tpl = array(
			"groupRow" => $_arr_groupRow, //管理员信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("group_form.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y040102",
		);
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		if ($this->adminLogged["groupRow"]["group_allow"]["group"]["browse"] != 1) {
			return array(
				"str_alert" => "x040301",
			);
			exit;
		}

		$_act_get     = fn_getSafe($_GET["act_get"], "txt", "");
		$_str_key     = fn_getSafe($_GET["key"], "txt", "");
		$_str_type    = fn_getSafe($_GET["type"], "txt", "");

		$_arr_search = array(
			"act_get"    => $_act_get,
			"key"        => $_str_key,
			"type"       => $_str_type,
		);

		$_num_groupCount  = $this->mdl_group->mdl_count($_str_key, $_str_status);
		$_arr_page        = fn_page($_num_adminCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_groupRows   = $this->mdl_group->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_key, $_str_type);

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"groupRows"  => $_arr_groupRows, //管理员列表
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("group_list.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y040301",
		);

	}
}
?>