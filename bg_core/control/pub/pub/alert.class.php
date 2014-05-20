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
		$this->obj_tpl = new CLASS_TPL(BG_PATH_TPL_PUB . $_str_tpl); //初始化视图对象
	}

	/*============登录界面============
	无返回
	*/
	function ctl_alert() {
		$this->obj_tpl->tplDisplay("alert.tpl", $this->tplData);
	}

}
?>