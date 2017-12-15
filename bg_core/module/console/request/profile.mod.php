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

$ctrl_profile = new CONTROL_CONSOLE_REQUEST_PROFILE();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'mailbox':
                $ctrl_profile->ctrl_mailbox();
            break;

            case 'qa':
                $ctrl_profile->ctrl_qa();
            break;

            case 'pass':
                $ctrl_profile->ctrl_pass();
            break;

            case 'info':
                $ctrl_profile->ctrl_info();
            break;

            case 'prefer':
                $ctrl_profile->ctrl_prefer();
            break;
        }
    break;
}
