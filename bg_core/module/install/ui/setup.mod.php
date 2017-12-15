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
);

switch ($GLOBALS['route']['bg_act']) {
    case 'dbtable':
    case 'auth':
    case 'admin':
    case 'base':
    case 'sso':
    case 'upload':
    case 'visit':
    case 'ssoAuto':
    case 'ssoAdmin':
    case 'over':
    case 'spec':
        $arr_set['db'] = true;
    break;

    default:
        $arr_set['ssin_file'] = true;
    break;
}

$obj_runtime->run($arr_set);

$ctrl_setup = new CONTROL_INSTALL_UI_SETUP(); //初始化商家

switch ($GLOBALS['route']['bg_act']) {
    case 'dbconfig':
        $ctrl_setup->ctrl_dbconfig();
    break;

    case 'dbtable':
        $ctrl_setup->ctrl_dbtable();
    break;

    case 'auth':
        $ctrl_setup->ctrl_auth();
    break;

    case 'admin':
        $ctrl_setup->ctrl_admin();
    break;

    case 'ssoAuto':
        $ctrl_setup->ctrl_ssoAuto();
    break;

    case 'ssoAdmin':
        $ctrl_setup->ctrl_ssoAdmin();
    break;

    case 'base':
    case 'sso':
    case 'upload':
    case 'visit':
    case 'spec':
        $ctrl_setup->ctrl_form();
    break;

    case 'over':
        $ctrl_setup->ctrl_over();
    break;

    default:
        $ctrl_setup->ctrl_phplib();
    break;
}
