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

$ctrl_custom = new CONTROL_API_API_CUSTOM();

switch ($GLOBALS['route']['bg_act']) {
    default:
        $ctrl_custom->ctrl_list();
    break;
}
