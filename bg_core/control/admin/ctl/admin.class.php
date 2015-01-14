<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入 http
include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_CLASS . "sso.class.php");
include_once(BG_PATH_MODEL . "cate.class.php"); //载入栏目模型

/*-------------管理员控制器-------------*/
class CONTROL_ADMIN {

	private $obj_base;
	private $config;
	private $adminLogged;
	private $obj_tpl;
	private $obj_sso;
	private $mdl_admin;
	private $mdl_group;
	private $mdl_cate;
	private $tplData;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"];
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]); //初始化视图对象
		$this->obj_sso        = new CLASS_SSO(); //初始化单点登录
		$this->mdl_admin      = new MODEL_ADMIN(); //设置管理员对象
		$this->mdl_group      = new MODEL_GROUP(); //设置组对象
		$this->mdl_cate       = new MODEL_CATE(); //设置栏目对象
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}


	/** 加入组表单
	 * ctl_toGroup function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_toGroup() {
		if ($this->adminLogged["groupRow"]["group_allow"]["admin"]["toGroup"] != 1) {
			return array(
				"str_alert" => "x020305",
			);
			exit;
		}

		$_num_adminId = fn_getSafe(fn_get("admin_id"), "int", 0);
		$_arr_ssoUser = $this->obj_sso->sso_get($_num_adminId);
		if ($_arr_ssoUser["str_alert"] != "y010102") { //SSO 中不存在该用户
			return $_arr_ssoUser;
			exit;
		}
		$_arr_adminRow = $this->mdl_admin->mdl_read($_num_adminId);
		if ($_arr_adminRow["str_alert"] != "y020102") { //不存在该管理员
			return $_arr_adminRow;
			exit;
		}
		$_arr_adminRow["userRow"] = $_arr_ssoUser;

		$_arr_groupRows = $this->mdl_group->mdl_list(100, 0, "", "admin"); //列出管理组

		$_arr_tpl = array(
			"adminRow"   => $_arr_adminRow, //管理员信息
			"groupRows"  => $_arr_groupRows, //管理员信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_toGroup.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y020302",
		);
	}


	/** 管理员表单
	 * ctl_form function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_form() {
		$_num_adminId = fn_getSafe(fn_get("admin_id"), "int", 0);

		if ($_num_adminId > 0) {
			if ($this->adminLogged["groupRow"]["group_allow"]["admin"]["edit"] != 1) {
				return array(
					"str_alert" => "x020303",
				);
			}
			$_arr_ssoUser = $this->obj_sso->sso_get($_num_adminId);
			if ($_arr_ssoUser["str_alert"] != "y010102") { //SSO 中不存在该用户
				return $_arr_ssoUser;
				exit;
			}
			$_arr_adminRow = $this->mdl_admin->mdl_read($_num_adminId);
			if ($_arr_adminRow["str_alert"] != "y020102") { //不存在该管理员
				return $_arr_adminRow;
				exit;
			}
		} else {
			if ($this->adminLogged["groupRow"]["group_allow"]["admin"]["add"] != 1) {
				return array(
					"str_alert" => "x020302",
				);
			}
			$_arr_adminRow = array(
				"admin_id"      => 0,
				"admin_note"    => "",
				"admin_status"  => "enable",
			);
			$_arr_ssoUser = array(
				"user_mail" => "",
				"user_nick" => "",
			);
		}

		$_arr_cateRows = $this->mdl_cate->mdl_list(1000, 0);

		$_arr_tpl = array(
			"userRow"    => $_arr_ssoUser,
			"adminRow"   => $_arr_adminRow, //管理员信息
			"cateRows"   => $_arr_cateRows, //栏目信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_form.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y020302",
		);
	}


	/** 显示管理员信息表单
	 * ctl_show function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_show() {
		if ($this->adminLogged["groupRow"]["group_allow"]["admin"]["browse"] != 1) {
			return array(
				"str_alert" => "x020301",
			);
		}

		$_num_adminId = fn_getSafe(fn_get("admin_id"), "int", 0);

		$_arr_ssoUser = $this->obj_sso->sso_get($_num_adminId);
		if ($_arr_ssoUser["str_alert"] != "y010102") {
			return $_arr_ssoUser;
			exit;
		}
		$_arr_adminRow = $this->mdl_admin->mdl_read($_num_adminId);
		if ($_arr_adminRow["str_alert"] != "y020102") {
			return $_arr_adminRow;
			exit;
		}

		$_arr_groupRow    = $this->mdl_group->mdl_read($_arr_adminRow["admin_group_id"]);
		$_arr_cateRows    = $this->mdl_cate->mdl_list(1000, 0);

		$_arr_tpl = array(
			"userRow"    => $_arr_ssoUser,
			"adminRow"   => $_arr_adminRow, //管理员信息
			"groupRow"   => $_arr_groupRow,
			"cateRows"   => $_arr_cateRows, //栏目信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_show.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y020302",
		);
	}


	/** 将用户授权为管理员表单
	 * ctl_auth function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_auth() {

		if ($this->adminLogged["groupRow"]["group_allow"]["admin"]["add"] != 1) {
			return array(
				"str_alert" => "x020302",
			);
		}
		$_arr_adminRow["admin_status"] = "enable";

		$_arr_cateRows    = $this->mdl_cate->mdl_list(1000, 0);

		$_arr_tpl = array(
			"adminRow"   => $_arr_adminRow, //管理员信息
			"cateRows"   => $_arr_cateRows, //栏目信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_auth.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y020302",
		);
	}


	/** 列出管理员
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		if ($this->adminLogged["groupRow"]["group_allow"]["admin"]["browse"] != 1) {
			return array(
				"str_alert" => "x020301",
			);
			exit;
		}

		//print_r($this->adminLogged);

		$_act_get     = fn_getSafe($GLOBALS["act_get"], "txt", "");
		$_str_key     = fn_getSafe(fn_get("key"), "txt", "");
		$_str_status  = fn_getSafe(fn_get("status"), "txt", "");
		$_num_groupId = fn_getSafe(fn_get("group_id"), "int", 0);

		$_arr_search = array(
			"act_get"    => $_act_get,
			"key"        => $_str_key,
			"status"     => $_str_status,
			"group_id"   => $_num_groupId,
		);

		$_num_adminCount  = $this->mdl_admin->mdl_count($_str_key, $_str_status, $_num_groupId);
		$_arr_page        = fn_page($_num_adminCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_adminRows   = $this->mdl_admin->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_key, $_str_status, $_num_groupId);

		foreach ($_arr_adminRows as $_key=>$_value) {
			/*$_arr_ssoUser                        = $this->obj_sso->sso_get($_value["admin_id"]); //取得用户组信息
			if ($_arr_ssoUser["str_alert"] != "y010102" && $_value["article_status"] != "disable") {
				$_arr_unknowAdmin[] = $_value["admin_id"];
				$_arr_adminRows[$_key]["admin_name"] = "";
			}*/
			//$_arr_groupRow                       = $this->mdl_group->mdl_read($_value["admin_group_id"]); //取得用户组信息
			$_arr_adminRows[$_key]["groupRow"] = $this->mdl_group->mdl_read($_value["admin_group_id"]);
		}

		/*if ($_arr_unknowAdmin) {
			$this->mdl_admin->mdl_status($_arr_unknowAdmin, "disable");
		}*/

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"adminRows"  => $_arr_adminRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_list.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y020301",
		);
	}
}
?>