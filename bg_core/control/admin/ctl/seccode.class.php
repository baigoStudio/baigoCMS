<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "seccode.class.php"); //载入验证码类

class CONTROL_SECCODE {

	function ctl_make() {
		$obj_seccode = new CLASS_SECCODE();
		$obj_seccode->secSet();
		$obj_seccode->secDo();
	}
}
?>