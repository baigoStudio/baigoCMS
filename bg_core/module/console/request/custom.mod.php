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

$ctrl_custom = new CONTROL_CONSOLE_REQUEST_CUSTOM();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'order':
                $ctrl_custom->ctrl_order();
            break;

            case 'submit':
                $ctrl_custom->ctrl_submit();
            break;

            case 'cache':
                $ctrl_custom->ctrl_cache();
            break;

            case 'del':
                $ctrl_custom->ctrl_del();
            break;

            case 'enable':
            case 'disable':
                $ctrl_custom->ctrl_status();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'chkname':
                $ctrl_custom->ctrl_chkname();
            break;
        }
    break;
}
