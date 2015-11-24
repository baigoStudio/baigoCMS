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
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入上传模型

/*-------------缩略图类-------------*/
class CONTROL_THUMB {

	private $obj_tpl;
	private $mdl_thumb;
	private $adminLogged;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"];
		$this->mdl_thumb      = new MODEL_THUMB(); //设置上传信息对象
		$_arr_cfg["admin"] = true;
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
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
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["thumb"])) {
			return array(
				"alert" => "x090301",
			);
			exit;
		}

		$_num_thumbId = fn_getSafe(fn_get("thumb_id"), "int", 0);

		$_arr_search = array(
			"act_get"    => $GLOBALS["act_get"],
		);

		$_num_thumbCount  = $this->mdl_thumb->mdl_count();
		$_arr_page        = fn_page($_num_thumbCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_thumbRows   = $this->mdl_thumb->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"]);

		if ($_num_thumbId > 0) {
			$_arr_thumbRow = $this->mdl_thumb->mdl_read($_num_thumbId);
			if ($_arr_thumbRow["alert"] != "y090102") {
				return $_arr_thumbRow;
				exit;
			}
		} else {
			$_arr_thumbRow = array(
				"thumb_id"      => 0,
				"thumb_type"    => "ratio",
				"thumb_width"   => "",
				"thumb_height"  => "",
			);
		}

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"thumbRows"  => $_arr_thumbRows, //上传信息信息
			"thumbRow"   => $_arr_thumbRow, //上传信息信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("thumb_list.tpl", $_arr_tplData);

		return array(
			"alert" => "y090301",
		);
	}
}
