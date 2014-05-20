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
include_once(BG_PATH_MODEL . "call.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "cate.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "mark.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入管理帐号模型
/*-------------用户类-------------*/
class CONTROL_CALL {

	public $obj_tpl;
	public $mdl_call;
	public $adminLogged;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"];
		$this->mdl_call       = new MODEL_CALL(); //设置管理员对象
		$this->mdl_cate       = new MODEL_CATE(); //设置管理员对象
		$this->mdl_mark       = new MODEL_MARK(); //设置管理员对象
		$this->mdl_thumb      = new MODEL_THUMB(); //设置管理员对象
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
		if ($this->adminLogged["admin_allow_sys"]["call"]["browse"] != 1) {
			return array(
				"str_alert" => "x170301",
			);
			exit;
		}

		$_num_callId = fn_getSafe($_GET["call_id"], "int", 0);

		if ($_num_callId == 0) {
			return array(
				"str_alert" => "x170213",
			);
		}

		$_arr_callRow = $this->mdl_call->mdl_read($_num_callId);
		if ($_arr_callRow["str_alert"] != "y170102") { //UC 中不存在该用户
			return $_arr_callRow;
			exit;
		}
		$_arr_callRow["call_cate_ids"] = json_decode($_arr_callRow["call_cate_ids"], true); //json解码

		$_arr_tpl = array(
			"callRow" => $_arr_callRow, //管理员信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("call_show.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y170102",
		);
	}


	/**
	 * ctl_form function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_form() {
		$_num_callId = fn_getSafe($_GET["call_id"], "int", 0);

		if ($_num_callId > 0) {
			if ($this->adminLogged["admin_allow_sys"]["call"]["edit"] != 1) {
				return array(
					"str_alert" => "x170303",
				);
				exit;
			}
			$_arr_callRow = $this->mdl_call->mdl_read($_num_callId);
			if ($_arr_callRow["str_alert"] != "y170102") { //UC 中不存在该用户
				return $_arr_callRow;
				exit;
			}
			$_arr_callRow["call_amount"] = json_decode($_arr_callRow["call_amount"], true); //json解码
			$_arr_callRow["call_show"]   = json_decode($_arr_callRow["call_show"], true); //json解码
			if ($_arr_callRow["call_cate_ids"] && $_arr_callRow["call_cate_ids"] != "null") {
				$_arr_callRow["call_cate_ids"] = json_decode($_arr_callRow["call_cate_ids"], true); //json解码
			} else {
				$_arr_callRow["call_cate_ids"] = array();
			}
			if ($_arr_callRow["call_mark_ids"] && $_arr_callRow["call_mark_ids"] != "null") {
				$_arr_callRow["call_mark_ids"] = json_decode($_arr_callRow["call_mark_ids"], true); //json解码
			} else {
				$_arr_callRow["call_mark_ids"] = array();
			}
		} else {
			if ($this->adminLogged["admin_allow_sys"]["call"]["edit"] != 1) {
				return array(
					"str_alert" => "x170302",
				);
				exit;
			}
			$_arr_callRow = array(
				"call_file" => array(
					"auto" => "auto",
					"ext"  => "html",
				),
				"call_amount" => array(
					"top"      => 10,
					"except"   => 0,
				),
				"call_trim"     => 100,
				"call_cate_ids" => array(),
				"call_mark_ids" => array(),
				"call_status"   => "enable",
			);
		}

		$_arr_cateRows    = $this->mdl_cate->mdl_list(1000, 0, "show");
		$_arr_markRows    = $this->mdl_mark->mdl_list(1000);
		$_arr_thumbRows   = $this->mdl_thumb->mdl_list(1000);

		$_arr_tpl = array(
			"callRow"    => $_arr_callRow, //管理员信息
			"cateRows"   => $_arr_cateRows, //管理员信息
			"markRows"   => $_arr_markRows, //管理员信息
			"thumbRows"  => $_arr_thumbRows, //管理员信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("call_form.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y170102",
		);
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		if ($this->adminLogged["admin_allow_sys"]["call"]["browse"] != 1) {
			return array(
				"str_alert" => "x170301",
			);
			exit;
		}

		$_num_page    = fn_getSafe($_GET["page"], "int", 1);
		$_act_get     = fn_getSafe($_GET["act_get"], "txt", "");
		$_str_key     = fn_getSafe($_GET["key"], "txt", "");
		$_str_type    = fn_getSafe($_GET["type"], "txt", "");

		$_arr_search = array(
			"page"       => $_num_page,
			"act_get"    => $_act_get,
			"key"        => $_str_key,
			"type"       => $_str_type,
		);

		$_num_callCount  = $this->mdl_call->mdl_count($_str_key, $_str_status);
		$_arr_page        = fn_page($_num_adminCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_callRows   = $this->mdl_call->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_key, $_str_type);

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"callRows"  => $_arr_callRows, //管理员列表
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("call_list.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y170301",
		);

	}
}
?>