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

$ctrl_cate = new CONTROL_API_API_CATE();

switch ($GLOBALS['route']['bg_act']) {
    case 'read':
    case 'get':
        $ctrl_cate->ctrl_read();
    break;

    default:
        $ctrl_cate->ctrl_list();
    break;
}
