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
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Call extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_cate    = Loader::model('Cate');
        $this->mdl_spec    = Loader::model('Spec');
        $this->mdl_mark    = Loader::model('Mark');

        $this->mdl_call    = Loader::model('Call');

        $this->generalData['status']    = $this->mdl_call->arr_status;
        $this->generalData['type']      = $this->mdl_call->arr_type;
        $this->generalData['file']      = $this->mdl_call->arr_file;
        $this->generalData['attach']    = $this->mdl_call->arr_attach;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['call']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x170301');
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'status'    => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_getData    = $this->mdl_call->lists($this->config['var_default']['perpage'], $_arr_search); //列出

        $_arr_tplData = array(
            'search'     => $_arr_search,
            'pageRow'    => $_arr_getData['pageRow'],
            'callRows'   => $_arr_getData['dataRows'],
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['call']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x170301');
        }

        $_num_callId = 0;

        if (isset($this->param['id'])) {
            $_num_callId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_callId < 1) {
            return $this->error('Missing ID', 'x170202');
        }

        $_arr_callRow = $this->mdl_call->read($_num_callId);

        if ($_arr_callRow['rcode'] != 'y170102') {
            return $this->error($_arr_callRow['msg'], $_arr_callRow['rcode']);
        }

        $_arr_callRow = $this->mdl_call->pathProcess($_arr_callRow);

        $_arr_specRows = array();

        if (!Func::isEmpty($_arr_callRow['call_spec_ids'])) {
            $_arr_searchSpec = array(
                'spec_ids'    => $_arr_callRow['call_spec_ids'],
            );
            $_arr_specRows = $this->mdl_spec->lists(array(1000, 'limit'), $_arr_searchSpec);
        }

        $_arr_search['parent_id']  = 0;
        $_arr_cateRows = $this->mdl_cate->listsTree($_arr_search); //列出
        $_arr_markRows = $this->mdl_mark->lists(array(1000, 'limit'));

        if ($this->genOpen === true) {
            switch ($_arr_callRow['call_file']) {
                case 'js':
                    $_arr_callRow['call_code'] = Html::encode('<script src="' . $this->obj_request->root(true) . $_arr_callRow['call_url'] . '" type="text/javascript"></script>');
                break;

                default:
                    $_arr_callRow['call_code'] = Html::encode('<!--#include virtual="' . $this->obj_request->root() . $_arr_callRow['call_url'] . '" -->');
                break;
            }

            $_arr_callRow['call_url']  = $this->obj_request->root(true) . $_arr_callRow['call_url'];
        } else {
            $_arr_callRow['call_code'] = Html::encode('<?php print_r($call->get(' . $_arr_callRow['call_id'] . ')); ?>');
        }

        $_arr_tplData = array(
            'callRow'   => $_arr_callRow,
            'specRows'  => $_arr_specRows,
            'cateRows'  => $_arr_cateRows,
            'markRows'  => $_arr_markRows,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_callId = 0;

        if (isset($this->param['id'])) {
            $_num_callId = $this->obj_request->input($this->param['id'], 'int', 0);
        }


        $_arr_specRows  = array();

        if ($_num_callId > 0) {
            if (!isset($this->groupAllow['call']['edit']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x170303');
            }

            $_arr_callRow = $this->mdl_call->read($_num_callId);

            if ($_arr_callRow['rcode'] != 'y170102') {
                return $this->error($_arr_callRow['msg'], $_arr_callRow['rcode']);
            }

            if (!Func::isEmpty($_arr_callRow['call_spec_ids'])) {
                $_arr_searchSpec = array(
                    'spec_ids'    => $_arr_callRow['call_spec_ids'],
                );
                $_arr_specRows = $this->mdl_spec->lists(array(1000, 'limit'), $_arr_searchSpec);
            }
        } else {
            if (!isset($this->groupAllow['call']['add']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x170302');
            }

            $_arr_callRow = array(
                'call_id'           => 0,
                'call_name'         => '',
                'call_file'         => '',
                'call_tpl'          => '',
                'call_amount'       => array(
                    'top'       => 10,
                    'except'    => 0,
                ),
                'call_period'       => 0,
                'call_attach'       => '',
                'call_cate_id'      => '',
                'call_cate_ids'     => array(),
                'call_cate_excepts' => array(),
                'call_mark_ids'     => array(),
                'call_type'         => '',
                'call_status'       => $this->mdl_call->arr_status[0],
            );
        }

        $_arr_search['parent_id']  = 0;
        $_arr_cateRows = $this->mdl_cate->listsTree($_arr_search); //列出
        $_arr_markRows = $this->mdl_mark->lists(array(1000, 'limit'));
        $_arr_tplRows  = File::instance()->dirList(BG_TPL_CALL);

        foreach ($_arr_tplRows as $_key=>&$_value) {
            $_value['name_s'] = basename($_value['name'], GK_EXT_TPL);
        }

        $_arr_tplData = array(
            'callRow'   => $_arr_callRow,
            'tplRows'   => $_arr_tplRows,
            'cateRows'  => $_arr_cateRows,
            'markRows'  => $_arr_markRows,
            'specRows'  => $_arr_specRows,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

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

        $_arr_inputSubmit = $this->mdl_call->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y170201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['call_id'] > 0) {
            if (!isset($this->groupAllow['call']['edit']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x170303');
            }
        } else {
            if (!isset($this->groupAllow['call']['add']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x170302');
            }
        }

        $_arr_submitResult = $this->mdl_call->submit();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function duplicate() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['call']['add']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x170302');
        }

        $_arr_inputDuplicate = $this->mdl_call->inputDuplicate();

        if ($_arr_inputDuplicate['rcode'] != 'y170201') {
            return $this->fetchJson($_arr_inputDuplicate['msg'], $_arr_inputDuplicate['rcode']);
        }

        $_arr_duplicateResult = $this->mdl_call->duplicate();

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

        if (!isset($this->groupAllow['call']['delete']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x170304');
        }

        $_arr_inputDelete = $this->mdl_call->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y170201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_deleteResult = $this->mdl_call->delete();

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

        if (!isset($this->groupAllow['call']['status']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x170304');
        }

        $_arr_inputStatus = $this->mdl_call->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y170201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_statusResult = $this->mdl_call->status();

        $_arr_langReplace = array(
            'count' => $_arr_statusResult['count'],
        );

        return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
    }


    function cache() {
        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputCommon = $this->mdl_call->inputCommon();

        if ($_arr_inputCommon['rcode'] != 'y170201') {
            return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
        }

        $_arr_cacheResult = $this->cacheProcess();

        return $this->fetchJson($_arr_cacheResult['msg'], $_arr_cacheResult['rcode']);
    }


    private function cacheProcess() {
        $_mdl_call    = Loader::model('Call', '', 'index');

        $_arr_search['status']   = 'enable';
        $_arr_getData            = $this->mdl_call->lists(array(1000, 'limit'), $_arr_search);

        $_num_cacheSize = 0;

        foreach ($_arr_getData as $_key=>$_value) {
            $_num_cacheSize = $_mdl_call->cacheProcess($_value['call_id']);
        }

        $_num_cacheListsSize = $_mdl_call->cacheListsProcess();

        if ($_num_cacheSize > 0 && $_num_cacheListsSize > 0) {
            $_str_rcode = 'y170110';
            $_str_msg   = 'Refresh cache successfully';
        } else {
            $_str_rcode = 'x170110';
            $_str_msg   = 'Refresh cache failed';
        }

        return array(
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }
}
