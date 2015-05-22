<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
$base = str_replace("\\", "/", str_replace("//", "/", $_SERVER["DOCUMENT_ROOT"] . "/" . basename(dirname($_SERVER["PHP_SELF"])) . "/"));
include_once($base . "bg_config/config.inc.php"); //载入配置

$arr_mod = array("index", "cate", "article", "search", "tag", "spec", "alert");

if (isset($_GET["mod"])) {
	$mod = $_GET["mod"];
} else {
	$mod = $arr_mod[0];
}

if (!in_array($mod, $arr_mod)) {
	exit("Access Denied");
}

include_once(BG_PATH_MODULE_PUB . "ctl/" . $mod . ".php");
