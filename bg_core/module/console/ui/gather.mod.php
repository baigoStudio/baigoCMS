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
    'db'            => true,
);

$obj_runtime->run($arr_set);

$ctrl_gather = new CONTROL_CONSOLE_UI_GATHER();

switch ($GLOBALS['route']['bg_act']) {
    case 'store':
    case 'storeAll':
        $ctrl_gather->ctrl_store();
    break;

    case 'show_content':
    case 'show':
        $ctrl_gather->ctrl_show();
    break;

    case 'list':
        $ctrl_gather->ctrl_list();
    break;

    case '1by1':
        $ctrl_gather->ctrl_1by1();
    break;

    case 'single':
        $ctrl_gather->ctrl_single();
    break;

    default:
        $ctrl_gather->ctrl_gather();
    break;
}
