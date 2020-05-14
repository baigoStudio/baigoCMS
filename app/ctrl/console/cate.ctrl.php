<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\File;
use ginkgo\Func;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Cate extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_cate    = Loader::model('Cate');

        $this->generalData['status']    = $this->mdl_cate->arr_status;
        $this->generalData['pasv']      = $this->mdl_cate->arr_pasv;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['cate']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x250301');
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'status'    => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        if (Func::isEmpty($_arr_search['key']) && Func::isEmpty($_arr_search['status'])) {
            $_arr_search['parent_id'] = 0;
            $_arr_cateRows   = $this->mdl_cate->listsTree(1000, 0, $_arr_search); //列出
        } else {
            $_arr_cateRows   = $this->mdl_cate->lists(1000, 0, $_arr_search); //列出
        }


        $_arr_tplData = array(
            'search'     => $_arr_search,
            'cateRows'   => $_arr_cateRows,
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_cateRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['cate']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x250301');
        }

        $_num_cateId = 0;

        if (isset($this->param['id'])) {
            $_num_cateId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_cateId < 1) {
            return $this->error('Missing ID', 'x250202');
        }

        $_arr_cateRow = $this->mdl_cate->read($_num_cateId);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        $_arr_cateParent = $this->mdl_cate->read($_arr_cateRow['cate_parent_id']);

        $_arr_tplData = array(
            'cateParent'    => $_arr_cateParent,
            'cateRow'       => $_arr_cateRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_cateRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_cateId = 0;

        if (isset($this->param['id'])) {
            $_num_cateId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_cateId > 0) {
            if (!isset($this->groupAllow['cate']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_num_cateId]['cate']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x250303');
            }

            $_arr_cateRow = $this->mdl_cate->read($_num_cateId);

            if ($_arr_cateRow['rcode'] != 'y250102') {
                return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
            }
        } else {
            if (!isset($this->groupAllow['cate']['add']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x250302');
            }

            $_arr_cateRow = array(
                'cate_id'           => 0,
                'cate_name'         => '',
                'cate_status'       => $this->mdl_cate->arr_status[0],
                'cate_alias'        => '',
                'cate_parent_id'    => -1,
                'cate_perpage'      => 0,
                'cate_prefix'       => '',
                'cate_content'      => '',
                'cate_link'         => '',
                'cate_ftp_host'     => '',
                'cate_ftp_port'     => '',
                'cate_ftp_user'     => '',
                'cate_ftp_pass'     => '',
                'cate_ftp_path'     => '',
                'cate_ftp_pasv'     => $this->mdl_cate->arr_pasv[0],
            );
        }

        $_arr_search['parent_id'] = 0;

        $_arr_cateRows   = $this->mdl_cate->listsTree(1000, 0, $_arr_search);

        $_arr_tplData = array(
            'tplRows'   => File::instance()->dirList(BG_TPL_INDEX),
            'cateRow'   => $_arr_cateRow,
            'cateRows'  => $_arr_cateRows,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_cateRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function submit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputSubmit = $this->mdl_cate->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y250201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['cate_id'] > 0) {
            if (!isset($this->groupAllow['cate']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_inputSubmit['cate_id']]['cate']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x250303');
            }
        } else {
            if (!isset($this->groupAllow['cate']['add']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x250302');
            }
        }

        $_arr_submitResult = $this->mdl_cate->submit();

        $this->cacheProcess();

        $_arr_submitResult['msg'] = $this->obj_lang->get($_arr_submitResult['msg']);

        return $this->json($_arr_submitResult);
    }


    function order() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['cate']['edit']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x250301');
        }

        $_arr_search['parent_id'] = 0;
        $_arr_cateRow = array();

        if (isset($this->param['id'])) {
            $_arr_search['parent_id'] = $this->obj_request->input($this->param['id'], 'int', 0);

            $_arr_cateRow = $this->mdl_cate->read($_arr_search['parent_id']);

            if ($_arr_cateRow['rcode'] != 'y250102') {
                return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
            }
        }

        $_arr_cateRows   = $this->mdl_cate->lists(1000, 0, $_arr_search); //列出

        $_arr_tplData = array(
            'cateRow'    => $_arr_cateRow,
            'cateRows'   => $_arr_cateRows,
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_cateRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function orderSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['cate']['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x250303');
        }

        $_arr_inputOrder = $this->mdl_cate->inputOrder();

        if ($_arr_inputOrder['rcode'] != 'y250201') {
            return $this->fetchJson($_arr_inputOrder['msg'], $_arr_inputOrder['rcode']);
        }

        $_arr_orderResult = $this->mdl_cate->order();

        $this->cacheProcess();

        return $this->fetchJson($_arr_orderResult['msg'], $_arr_orderResult['rcode']);
    }


    function duplicate() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['cate']['add']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x250302');
        }

        $_arr_inputDuplicate = $this->mdl_cate->inputDuplicate();

        if ($_arr_inputDuplicate['rcode'] != 'y250201') {
            return $this->fetchJson($_arr_inputDuplicate['msg'], $_arr_inputDuplicate['rcode']);
        }

        $_arr_duplicateResult = $this->mdl_cate->duplicate();

        $this->cacheProcess();

        return $this->fetchJson($_arr_duplicateResult['msg'], $_arr_duplicateResult['rcode']);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['cate']['delete']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x250304');
        }

        $_arr_inputDelete = $this->mdl_cate->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y250201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_return = array(
            'article_ids'      => $_arr_inputDelete['article_ids'],
        );

        Plugin::listen('action_console_cate_delete', $_arr_return); //删除链接时触发

        $_arr_deleteResult = $this->mdl_cate->delete();

        $this->cacheProcess();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
    }


    function status() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['cate']['edit']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x250303');
        }

        $_arr_inputStatus = $this->mdl_cate->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y250201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_return = array(
            'cate_ids'      => $_arr_inputStatus['article_ids'],
            'cate_status'   => $_arr_inputStatus['act'],
        );

        Plugin::listen('action_console_cate_status', $_arr_return); //删除链接时触发

        $_arr_statusResult = $this->mdl_cate->status();

        $this->cacheProcess();

        $_arr_langReplace = array(
            'count' => $_arr_statusResult['count'],
        );

        return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
    }


    function cache() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputCommon = $this->mdl_cate->inputCommon();

        if ($_arr_inputCommon['rcode'] != 'y250201') {
            return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
        }

        $_arr_cacheResult = $this->cacheProcess();

        return $this->fetchJson($_arr_cacheResult['msg'], $_arr_cacheResult['rcode']);
    }


    function check() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_return = array(
            'msg' => '',
        );

        $_arr_inputParam = array(
            'cate_id'           => array('int', 0),
            'cate_parent_id'    => array('int', 0),
            'cate_alias'        => array('str', ''),
        );

        $_arr_inputCheck = $this->obj_request->get($_arr_inputParam);

        if (!Func::isEmpty($_arr_inputCheck['cate_alias'])) {
            $_arr_cateRow   = $this->mdl_cate->check($_arr_inputCheck['cate_alias'], 'cate_alias', $_arr_inputCheck['cate_id'], $_arr_inputCheck['cate_parent_id']);

            if ($_arr_cateRow['rcode'] == 'y250102') {
                $_arr_return = array(
                    'rcode' => 'x250404',
                    'error' => $this->obj_lang->get('Alias already exists'),
                );
            } else {
                if (is_numeric($_arr_inputCheck['cate_alias'])) {
                    $_arr_cateRow   = $this->mdl_cate->check($_arr_inputCheck['cate_alias'], 'cate_id', $_arr_inputCheck['cate_id'], $_arr_inputCheck['cate_parent_id']);
                    if ($_arr_cateRow['rcode'] == 'y250102') {
                        $_arr_return = array(
                            'rcode' => 'x250404',
                            'error' => $this->obj_lang->get('Alias already exists'),
                        );
                    }
                }
            }
        }

        return $this->json($_arr_return);
    }


    private function cacheProcess() {
        $_mdl_cate    = Loader::model('Cate', '', 'index');

        $arr_search['status']   = 'show';
        $_arr_cateRows          = $this->mdl_cate->lists(1000, 0, $arr_search);

        $_num_cacheSize = 0;

        foreach ($_arr_cateRows as $_key=>$_value) {
            $_num_cacheSize = $_mdl_cate->cacheProcess($_value['cate_id']);
        }

        $_num_cacheTreeSize = $_mdl_cate->cacheTreeProcess();

        if ($_num_cacheSize > 0 && $_num_cacheTreeSize > 0) {
            $_str_rcode = 'y250110';
            $_str_msg   = 'Refresh cache successfully';
        } else {
            $_str_rcode = 'x250110';
            $_str_msg   = 'Refresh cache failed';
        }

        return array(
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }
}
