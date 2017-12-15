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

$ctrl_spec = new CONTROL_CONSOLE_REQUEST_SPEC();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'show':
            case 'hide':
                $ctrl_spec->ctrl_status();
            break;

            case 'submit':
                $ctrl_spec->ctrl_submit();
            break;

            case 'del':
                $ctrl_spec->ctrl_del();
            break;

            case 'belongDel':
                $ctrl_spec->ctrl_belongDel();
            break;

            case 'belongAdd':
                $ctrl_spec->ctrl_belongAdd();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'list':
                $ctrl_spec->ctrl_list();
            break;
        }
    break;
}
