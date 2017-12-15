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

$ctrl_gsite = new CONTROL_CONSOLE_REQUEST_GSITE();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'duplicate':
                $ctrl_gsite->ctrl_duplicate();
            break;

            case 'submit':
                $ctrl_gsite->ctrl_submit();
            break;

            case 'stepPageContent':
                $ctrl_gsite->ctrl_step_page_content();
            break;

            case 'stepPageList':
                $ctrl_gsite->ctrl_step_page_list();
            break;

            case 'stepContent':
                $ctrl_gsite->ctrl_step_content();
            break;

            case 'stepList':
                $ctrl_gsite->ctrl_step_list();
            break;

            case 'enable':
            case 'disable':
                $ctrl_gsite->ctrl_status();
            break;

            case 'del':
                $ctrl_gsite->ctrl_del();
            break;
        }
    break;
}
