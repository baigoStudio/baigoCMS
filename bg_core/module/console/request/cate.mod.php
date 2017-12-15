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

$ctrl_cate = new CONTROL_CONSOLE_REQUEST_CATE();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'duplicate':
                $ctrl_cate->ctrl_duplicate();
            break;

            case 'order':
                $ctrl_cate->ctrl_order();
            break;

            case 'submit':
                $ctrl_cate->ctrl_submit();
            break;

            case 'cache':
                $ctrl_cate->ctrl_cache();
            break;

            case 'del':
                $ctrl_cate->ctrl_del();
            break;

            case 'hide':
            case 'show':
                $ctrl_cate->ctrl_status();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'chkname':
                $ctrl_cate->ctrl_chkname();
            break;
            case 'chkalias':
                $ctrl_cate->ctrl_chkalias();
            break;
        }
    break;
}
