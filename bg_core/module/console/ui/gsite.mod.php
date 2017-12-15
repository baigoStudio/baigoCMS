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

$ctrl_gsite = new CONTROL_CONSOLE_UI_GSITE();

switch ($GLOBALS['route']['bg_act']) {
    case 'show':
        $ctrl_gsite->ctrl_show();
    break;

    case 'stepList':
    case 'stepContent':
    case 'stepPageList':
    case 'stepPageContent':
        $ctrl_gsite->ctrl_step();
    break;

    case 'form':
        $ctrl_gsite->ctrl_form();
    break;

    default:
        $ctrl_gsite->ctrl_list();
    break;
}
