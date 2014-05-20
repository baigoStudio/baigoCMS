<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "common_global.inc.php"); //载入数据库类
include_once(BG_PATH_CLASS . "mysql.class.php"); //载入数据库类
include_once(BG_PATH_CLASS . "base.class.php"); //载入基类

$GLOBALS["obj_db"]      = new CLASS_MYSQL(); //设置数据库对象
$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化基类

include_once(BG_PATH_CLASS . "tplPub.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "cate.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "tagPub.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "call.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "upfile.class.php"); //载入文章模型类
include_once(BG_PATH_FUNC . "callDisplay.func.php"); //载入模板类
?>