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
include_once(BG_PATH_MODEL . "attach.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入后台用户类


/*-------------文章类-------------*/
class API_ATTACH {

	private $obj_api;
	private $mdl_app;
	private $mdl_attach;
	private $mdl_thumb;

	function __construct() { //构造函数
		$this->obj_api    = new CLASS_API();
		$this->mdl_app    = new MODEL_APP(); //设置管理组模型
		$this->mdl_attach = new MODEL_ATTACH();
		$this->mdl_thumb  = new MODEL_THUMB(); //设置上传信息对象
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function api_get() {
		$this->app_check("get");

		$_num_attachId = fn_getSafe(fn_get("attach_id"), "int", 0);

		if ($_num_attachId == 0) {
			$_arr_return = array(
				"str_alert" => "x070201",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_attachThumb = $this->mdl_thumb->mdl_list(100);
		$_arr_attachRow   = $this->mdl_attach->mdl_url($_num_attachId, $_arr_attachThumb);

		if ($_arr_attachRow["str_alert"] != "y070102") {
			$this->obj_api->halt_re($_arr_attachRow);
		}

		//print_r($_arr_attachRow);

		//unset($_arr_attachRow["urlRow"]);

		$this->obj_api->halt_re($_arr_attachRow, true);
	}


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
