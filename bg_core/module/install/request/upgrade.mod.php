<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

$arr_set = array(
    'base'          => true,
    'ssin'          => true,
);

switch ($GLOBALS['route']['bg_act']) {
    case 'dbconfig':
        $arr_set['ssin_file'] = true; //可能 session 数据表表尚未创建，故临时采用文件形式的 session
    break;

    default:
        $arr_set['db'] = true;
    break;
}

$obj_runtime->run($arr_set);

$ctrl_upgrade = new CONTROL_INSTALL_REQUEST_UPGRADE(); //初始化商家

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'dbconfig':
                $ctrl_upgrade->ctrl_dbconfig();
            break;

            case 'auth':
                $ctrl_upgrade->ctrl_auth();
            break;

            case 'admin':
                $ctrl_upgrade->ctrl_admin();
            break;

            case 'over':
                $ctrl_upgrade->ctrl_over();
            break;

            case 'sso':
            case 'upload':
            case 'visit':
            case 'base':
                $ctrl_upgrade->ctrl_submit();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'chkname':
                $ctrl_upgrade->ctrl_chkname();
            break;

            case 'chkauth':
                $ctrl_upgrade->ctrl_chkauth();
            break;
        }
    break;
}
