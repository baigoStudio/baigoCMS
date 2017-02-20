<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
$arr_mod = array("setup", "upgrade");

if (isset($_GET["mod"])) {
    $mod = $_GET["mod"];
} else {
    $mod = $arr_mod[0];
}

if (!in_array($mod, $arr_mod)) {
    exit("Access Denied");
}

$base = $_SERVER["DOCUMENT_ROOT"] . str_ireplace(basename(dirname($_SERVER["PHP_SELF"])), "", dirname($_SERVER["PHP_SELF"]));

require($base . "bg_config/config.class.php");

$obj_init = new CLASS_CONFIG();

$obj_init->config_gen(true);

require($obj_init->str_pathRoot . "bg_config/config.inc.php"); //载入配置

require(BG_PATH_MODULE . "install/request/" . $mod . ".php");
