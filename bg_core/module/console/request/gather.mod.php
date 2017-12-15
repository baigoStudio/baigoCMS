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

$ctrl_gather = new CONTROL_CONSOLE_REQUEST_GATHER();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'submit':
                $ctrl_gather->ctrl_submit();
            break;

            case 'store':
                $ctrl_gather->ctrl_store();
            break;

            case 'del':
                $ctrl_gather->ctrl_del();
            break;
        }
    break;
}
