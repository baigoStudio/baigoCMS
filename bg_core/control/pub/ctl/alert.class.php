<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------提示类-------------*/
class CONTROL_ALERT {

	public $obj_tpl;

	function __construct() { //构造函数
		if(defined("BG_SITE_TPL")) {
			$_str_tpl = BG_SITE_TPL;
		} else {
			$_str_tpl = "default";
		}
		$this->mdl_cate   = new MODEL_CATE(); //设置文章对象
		$this->obj_tpl    = new CLASS_TPL(BG_PATH_TPL_PUB . $_str_tpl); //初始化视图对象
	}

	/*============登录界面============
	无返回
	*/
	function ctl_display() {
		$_str_alert       = fn_getSafe(fn_get("alert"), "txt", "");
		if (!file_exists(BG_PATH_CACHE . "cate_trees.php")) {
			$this->mdl_cate->mdl_cache();
		}

		$_arr_cateRows    = include(BG_PATH_CACHE . "cate_trees.php");

		$arr_data = array(
			"alert"      => $_str_alert,
			"status"     => substr($_str_alert, 0, 1),
			"cateRows"   => $_arr_cateRows,
		);

		$this->obj_tpl->tplDisplay("alert.tpl", $arr_data, false);
	}

}
