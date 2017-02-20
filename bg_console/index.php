<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
$arr_mod = array("article", "tag", "mark", "spec", "cate", "attach", "mime", "thumb", "call", "user", "admin", "group", "opt", "app", "custom", "link", "profile", "pm", "login", "logon", "forgot", "seccode", "help");

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

$obj_init->config_gen();

require($obj_init->str_pathRoot . "bg_config/config.inc.php"); //载入配置

if ($mod == "logon") {
    $mod = "login";
}
require(BG_PATH_MODULE . "console/ui/" . $mod . ".php");