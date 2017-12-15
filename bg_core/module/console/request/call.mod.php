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

$ctrl_call = new CONTROL_CONSOLE_REQUEST_CALL();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'duplicate':
                $ctrl_call->ctrl_duplicate();
            break;

            case 'submit':
                $ctrl_call->ctrl_submit();
            break;

            case 'del':
                $ctrl_call->ctrl_del();
            break;

            case 'enable':
            case 'disable':
                $ctrl_call->ctrl_status();
            break;
        }
    break;
}
