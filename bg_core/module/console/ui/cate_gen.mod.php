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

$ctrl_cate = new CONTROL_CONSOLE_UI_CATE_GEN();

switch ($GLOBALS['route']['bg_act']) {
    case '1by1':
        $ctrl_cate->ctrl_1by1();
    break;

    case 'single':
        $ctrl_cate->ctrl_single();
    break;
}
