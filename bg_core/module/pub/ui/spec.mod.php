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
    'base'      => true,
    'db'        => true,
    'pub'       => true,
);

$obj_runtime->run($arr_set);

$ctrl_spec = new CONTROL_PUB_UI_SPEC();

switch ($GLOBALS['route']['bg_act']) {
    case 'show':
        $ctrl_spec->ctrl_show();
    break;

    default:
        $ctrl_spec->ctrl_list();
    break;
}
