<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

if ($GLOBALS["adminLogged"]["str_alert"] != "y020102") {
	if ($GLOBALS["view"] == "iframe") {
		$_str_url = BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $GLOBALS["adminLogged"]["str_alert"];
	} else {
		$_str_url = BG_URL_ADMIN . "ctl.php?mod=logon&forward=" . base64_encode($_SERVER["REQUEST_URI"]);
	}
	header("Location: " . $_str_url . $_url_attach);
	exit;
}
?>