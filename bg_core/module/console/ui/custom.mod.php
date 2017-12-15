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

$ctrl_custom = new CONTROL_CONSOLE_UI_CUSTOM(); //初始化设置对象

switch ($GLOBALS['route']['bg_act']) {
    case 'form':
        $ctrl_custom->ctrl_form();
    break;

    case 'order':
        $ctrl_custom->ctrl_order();
    break;

    default:
        $ctrl_custom->ctrl_list();
    break;
}
