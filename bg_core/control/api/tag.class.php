<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "api.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "tag.class.php"); //载入后台用户类


/*-------------文章类-------------*/
class API_TAG {

	private $obj_api;
	private $mdl_app;
	private $mdl_tag;

	function __construct() { //构造函数
		$this->obj_api        = new CLASS_API();
		$this->mdl_app        = new MODEL_APP(); //设置管理组模型
		$this->mdl_tag        = new MODEL_TAG();

		if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //验证是否已经安装
			include_once(BG_PATH_CONFIG . "is_install.php");
			if (!defined("BG_INSTALL_PUB") || PRD_CMS_PUB > BG_INSTALL_PUB) {
				$_arr_return = array(
					"str_alert" => "x030416"
				);
				$this->obj_api->halt_re($_arr_return);
			}
		} else {
			$_arr_return = array(
				"str_alert" => "x030415"
			);
			$this->obj_api->halt_re($_arr_return);
		}
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function api_get() {
		$this->app_check("get");

		$_str_tagName = fn_getSafe(fn_get("tag_name"), "txt", "");

		if (!$_str_tagName) {
			$_arr_return = array(
				"str_alert" => "x130201",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_tagRow = $this->mdl_tag->mdl_read($_str_tagName, "tag_name");

		if ($_arr_tagRow["str_alert"] != "y130102") {
			$this->obj_api->halt_re($_arr_tagRow);
		}

		if ($_arr_tagRow["tag_status"] != "show") {
			$_arr_return = array(
				"str_alert" => "x130102",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		unset($_arr_tagRow["urlRow"]);

		$this->obj_api->halt_re($_arr_tagRow, true);
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	/*function api_list() {
		$_num_perPage     = fn_getSafe(fn_get("per_page"), "int", BG_SITE_PERPAGE);
		$_str_key         = fn_getSafe(fn_get("key"), "txt", "");

		$_num_tagCount    = $this->mdl_tag->mdl_count($_str_key, "show");
		$_arr_page        = fn_page($_num_tagCount, $_num_perPage); //取得分页数据
		$_arr_tagRows     = $this->mdl_tag->mdl_list($_num_perPage, $_arr_page["except"], $_str_key, "show");

		foreach ($_arr_tagRows as $_key=>$_value) {
			unset($_arr_tagRows[$_key]["urlRow"]);
		}

		$_arr_return = array(
			"pageRow"    => $_arr_page,
			"tagRows"    => $_arr_tagRows,
		);

		//print_r($_arr_return);

		$this->obj_api->halt_re($_arr_return, true);
	}*/


	/**
	 * app_check function.
	 *
	 * @access private
	 * @param mixed $num_appId
	 * @param string $str_method (default: "get")
	 * @return void
	 */
	private function app_check($str_method = "get") {
		$this->appGet = $this->obj_api->app_get($str_method);

		if ($this->appGet["str_alert"] != "ok") {
			$this->obj_api->halt_re($this->appGet);
		}

		$_arr_appRow = $this->mdl_app->mdl_read($this->appGet["app_id"]);
		if ($_arr_appRow["str_alert"] != "y190102") {
			$this->obj_api->halt_re($_arr_appRow);
		}
		$this->appAllow = $_arr_appRow["app_allow"];

		$_arr_appChk = $this->obj_api->app_chk($this->appGet, $_arr_appRow);
		if ($_arr_appChk["str_alert"] != "ok") {
			$this->obj_api->halt_re($_arr_appChk);
		}
	}
}
