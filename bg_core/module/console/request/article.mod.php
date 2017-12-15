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

if (defined('BG_MODULE_GEN') && BG_MODULE_GEN > 0 && defined('BG_VISIT_TYPE') && BG_VISIT_TYPE == 'static') {
    $arr_set['pub'] = true;
}

$obj_runtime->run($arr_set);

$ctrl_article = new CONTROL_CONSOLE_REQUEST_ARTICLE();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'move':
                $ctrl_article->ctrl_move();
            break;

            case 'submit':
                $ctrl_article->ctrl_submit();
            break;

            case 'primary':
                $ctrl_article->ctrl_primary();
            break;

            case 'top':
            case 'untop':
                $ctrl_article->ctrl_top();

            case 'hide':
            case 'pub':
            case 'wait':
                $ctrl_article->ctrl_status();

            case 'normal':
            case 'draft':
            case 'recycle':
                $ctrl_article->ctrl_box();
            break;

            case 'empty':
                $ctrl_article->ctrl_empty();
            break;

            case 'del':
                $ctrl_article->ctrl_del();
            break;
        }
    break;
}
