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
    'db'            => true,
);

$obj_runtime->run($arr_set);

$ctrl_article = new CONTROL_API_API_ARTICLE();

switch ($GLOBALS['route']['bg_act']) {
    case 'hits':
        $ctrl_article->ctrl_hits();
    break;

    case 'read':
    case 'get':
        $ctrl_article->ctrl_read();
    break;

    default:
        $ctrl_article->ctrl_list();
    break;
}
