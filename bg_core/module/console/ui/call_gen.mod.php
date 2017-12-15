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
    'base'  => true,
    'ssin'  => true,
    'db'    => true,
);

$obj_runtime->run($arr_set);

$ctrl_call = new CONTROL_CONSOLE_UI_CALL_GEN();

switch ($GLOBALS['route']['bg_act']) {
    case 'list':
        $ctrl_call->ctrl_list();
    break;

    case 'single':
        $ctrl_call->ctrl_single();
    break;
}
