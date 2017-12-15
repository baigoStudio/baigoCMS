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

$ctrl_gsite_preview = new CONTROL_CONSOLE_UI_GSITE_PREVIEW();

switch ($GLOBALS['route']['bg_act']) {
    case 'pageContent':
        $ctrl_gsite_preview->ctrl_page_content();
    break;

    case 'pageList':
        $ctrl_gsite_preview->ctrl_page_list();
    break;

    case 'content':
        $ctrl_gsite_preview->ctrl_content();
    break;

    case 'list':
        $ctrl_gsite_preview->ctrl_list();
    break;
}
