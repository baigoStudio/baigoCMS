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
	header("Location: " . BG_URL_ADMIN . "admin.php?mod=logon&forward=" . base64_encode($_SERVER["REQUEST_URI"]) . $_url_attach);
	exit;
}
?>