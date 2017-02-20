<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

$arr_mod = array("index", "cate", "article", "search", "tag", "spec");

if (isset($_GET["mod"])) {
    $mod = $_GET["mod"];
} else {
    $mod = $arr_mod[0];
}

if (!in_array($mod, $arr_mod)) {
    exit("Access Denied");
}

$base = dirname(__FILE__) . DIRECTORY_SEPARATOR;

require($base . "bg_config/config.class.php");

$obj_init = new CLASS_CONFIG();

$obj_init->config_gen();

require($obj_init->str_pathRoot . "bg_config/config.inc.php"); //载入配置

require(BG_PATH_MODULE . "pub/ui/" . $mod . ".php");