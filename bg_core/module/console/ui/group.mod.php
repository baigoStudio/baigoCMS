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

$ctrl_group = new CONTROL_CONSOLE_UI_GROUP();

switch ($GLOBALS['route']['bg_act']) {
    case 'show':
        $ctrl_group->ctrl_show();
    break;

    case 'form':
        $ctrl_group->ctrl_form();
    break;

    default:
        $ctrl_group->ctrl_list();
    break;
}
