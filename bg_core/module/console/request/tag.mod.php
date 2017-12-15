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

$ctrl_tag = new CONTROL_CONSOLE_REQUEST_TAG();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'submit':
                $ctrl_tag->ctrl_submit();
            break;

            case 'show':
            case 'hide':
                $ctrl_tag->ctrl_status();
            break;

            case 'del':
                $ctrl_tag->ctrl_del();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'chkname':
                $ctrl_tag->ctrl_chkname();
            break;

            case 'list':
                $ctrl_tag->ctrl_list();
            break;
        }
    break;
}
