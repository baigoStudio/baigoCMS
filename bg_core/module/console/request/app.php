<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

require(BG_PATH_INC . "common.inc.php");
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "db"            => true,
);
fn_chkPHP($arr_set);

require(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
fn_init($arr_set);

$ctrl_app = new CONTROL_CONSOLE_REQUEST_APP(); //初始化应用对象

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "auth":
                $ctrl_app->ctrl_auth(); //授权用户
            break;

            case "deauth":
                $ctrl_app->ctrl_deauth(); //取消授权用户
            break;

            case "reset":
                $ctrl_app->ctrl_reset(); //重置 APP KEY
            break;

            case "submit":
                $ctrl_app->ctrl_submit(); //创建、编辑
            break;

            case "enable":
            case "disable":
                $ctrl_app->ctrl_status(); //状态
            break;

            case "del":
                $ctrl_app->ctrl_del(); //删除
            break;

            case "notify":
                $ctrl_app->ctrl_notify(); //通知测试
            break;
        }
    break;
}
