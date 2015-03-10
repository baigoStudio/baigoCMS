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
include_once(BG_PATH_MODEL . "spec.class.php");
include_once(BG_PATH_MODEL . "article.class.php");

/*-------------用户类-------------*/
class AJAX_SPEC {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_spec;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->mdl_spec       = new MODEL_SPEC();
		$this->mdl_article    = new MODEL_ARTICLE();
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
		if ($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"] != 1) {
			$this->obj_ajax->halt_alert("x180302");
		}

		$_arr_specSubmit = $this->mdl_spec->input_submit();

		if ($_arr_specSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_specSubmit["str_alert"]);
		}

		$_arr_specRow = $this->mdl_spec->mdl_submit();

		$this->obj_ajax->halt_alert($_arr_specRow["str_alert"]);
	}


	function ajax_status() {
		if ($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"] != 1) {
			$this->obj_ajax->halt_alert("x180302");
		}

		$_arr_specIds = $this->mdl_spec->input_ids();
		if ($_arr_specIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_specIds["str_alert"]);
		}

		$_str_specStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
		if (!$_str_specStatus) {
			$this->obj_ajax->halt_alert("x020213");
		}

		$_arr_specRow = $this->mdl_spec->mdl_status($_str_specStatus);

		$this->obj_ajax->halt_alert($_arr_specRow["str_alert"]);
	}


	function ajax_toSpec() {
		if ($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"] != 1) {
			$this->obj_ajax->halt_alert("x180302");
		}

		$_arr_articleIds = $this->mdl_article->input_ids();
		if ($_arr_articleIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleIds["str_alert"]);
		}

		$_str_act     = fn_getSafe($GLOBALS["act_post"], "txt", "");
		$_nun_specId  = fn_getSafe(fn_post("spec_id"), "int", 0);

		$_arr_articleRow = $this->mdl_article->mdl_toSpec($_str_act, $_nun_specId);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"] != 1) {
			$this->obj_ajax->halt_alert("x180304");
		}

		$_arr_specIds = $this->mdl_spec->input_ids();
		if ($_arr_specIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_specIds["str_alert"]);
		}

		$_arr_specRow = $this->mdl_spec->mdl_del();

		$this->obj_ajax->halt_alert($_arr_specRow["str_alert"]);
	}


	/**
	 * ajax_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_list() {
		$_str_key         = fn_getSafe(fn_get("key"), "txt", "");
		$_num_perPage     = 10;
		$_num_specCount   = $this->mdl_spec->mdl_count($_str_key);
		$_arr_page        = fn_page($_num_specCount, $_num_perPage); //取得分页数据
		$_arr_specRows    = $this->mdl_spec->mdl_list($_num_perPage, $_arr_page["except"], $_str_key);

		$_arr_tpl = array(
			"pageRow"    => $_arr_page,
			"specRows"   => $_arr_specRows, //上传信息
		);

		exit(json_encode($_arr_tpl));
	}
}
