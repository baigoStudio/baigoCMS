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
    'db'            => true,
);

$obj_runtime->run($arr_set);

$ctrl_spec = new CONTROL_API_API_SPEC();

switch ($GLOBALS['route']['bg_act']) {
    case 'read':
    case 'get':
        $ctrl_spec->ctrl_read();
    break;

    default:
        $ctrl_spec->ctrl_list();
    break;
}
