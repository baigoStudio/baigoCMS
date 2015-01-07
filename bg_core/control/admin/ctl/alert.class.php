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

/*-------------提示信息控制器-------------*/
class CONTROL_ALERT {

	public $obj_tpl;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"];
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]); //初始化视图对象
	}


	/** 显示提示信息
	 * ctl_alert function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_alert() {
		$_str_alert   = fn_getSafe($_GET["alert"], "txt", "");
		$_str_view    = fn_getSafe($_GET["view"], "txt", "");

		$arr_data = array(
			"adminLogged"    => $this->adminLogged,
			"alert"          => $_str_alert,
			"status"         => substr($_str_alert, 0, 1),
			"view"           => $_str_view,
		);

		$this->obj_tpl->tplDisplay("alert.tpl", $arr_data);
	}

}
?>