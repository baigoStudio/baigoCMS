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

$ctrl_gsite_source = new CONTROL_CONSOLE_UI_GSITE_SOURCE();

switch ($GLOBALS['route']['bg_act']) {
    case 'pageContent':
        $ctrl_gsite_source->ctrl_page_content();
    break;

    case 'content':
        $ctrl_gsite_source->ctrl_content();
    break;

    case 'list':
    case 'form':
        $ctrl_gsite_source->ctrl_form();
    break;
}
