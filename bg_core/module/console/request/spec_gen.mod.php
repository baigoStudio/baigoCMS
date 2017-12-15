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
    'pub'   => true,
);

$obj_runtime->run($arr_set);

$ctrl_spec = new CONTROL_CONSOLE_REQUEST_SPEC_GEN();

switch ($GLOBALS['route']['bg_act']) {
    case 'list':
        $ctrl_spec->ctrl_list();
    break;

    case '1by1':
        $ctrl_spec->ctrl_1by1();
    break;

    case 'single':
        $ctrl_spec->ctrl_single();
    break;
}
