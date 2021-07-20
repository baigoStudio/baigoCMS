<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Plugin;
use ginkgo\File;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Spec extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->obj_qlist       = Loader::classes('Qlist');

        $this->mdl_attach      = Loader::model('Attach');
        $this->mdl_spec        = Loader::model('Spec');

        $this->generalData['status']    = $this->mdl_spec->arr_status;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['spec']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x180301');
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'status'    => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_getData   = $this->mdl_spec->lists($this->config['var_default']['perpage'], $_arr_search); //列出

        $_arr_tplData = array(
            'search'     => $_arr_search,
            'pageRow'    => $_arr_getData['pageRow'],
            'specRows'   => $_arr_getData['dataRows'],
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function typeahead() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['spec']['browse']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x180301');
        }

        $_arr_searchParam = array(
            'key' => array('str', ''),
        );

        $_arr_search     = $this->obj_request->param($_arr_searchParam);

        $_arr_getData   = $this->mdl_spec->lists(array(1000, 'limit'), $_arr_search); //列出

        return $this->json($_arr_getData);
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['spec']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x180301');
        }

        $_num_specId = 0;

        if (isset($this->param['id'])) {
            $_num_specId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_specId < 1) {
            return $this->error('Missing ID', 'x180202');
        }

        $_arr_specRow = $this->mdl_spec->read($_num_specId);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $this->error($_arr_specRow['msg'], $_arr_specRow['rcode']);
        }

        $_arr_attachRow = $this->mdl_attach->read($_arr_specRow['spec_attach_id']);

        $_arr_tplData = array(
            'specRow'   => $_arr_specRow,
            'attachRow' => $_arr_attachRow,
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

        $_num_specId = 0;

        if (isset($this->param['id'])) {
            $_num_specId = $this->obj_request->input($this->param['id'], 'int', 0);
        }


        if ($_num_specId > 0) {
            if (!isset($this->specAllow['spec']['edit']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x180303');
            }

            $_arr_specRow = $this->mdl_spec->read($_num_specId);

            if ($_arr_specRow['rcode'] != 'y180102') {
                return $this->error($_arr_specRow['msg'], $_arr_specRow['rcode']);
            }

            $_arr_attachRow = $this->mdl_attach->read($_arr_specRow['spec_attach_id']);
        } else {
            if (!isset($this->groupAllow['spec']['add']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x180302');
            }

            $_arr_specRow = array(
                'spec_id'                   => 0,
                'spec_name'                 => '',
                'spec_status'               => $this->mdl_spec->arr_status[0],
                'spec_content'              => '',
                'spec_tpl'                  => '',
                'spec_time_update_format'   => $this->mdl_spec->dateFormat(),
                'spec_attach_id'            => 0,
            );

            $_arr_attachRow = array(
                'attach_thumb' => '',
            );
        }

        $_arr_tplRows  = File::instance()->dirList(BG_TPL_SPEC);

        foreach ($_arr_tplRows as $_key=>$_value) {
            $_arr_tplRows[$_key]['name_s'] = basename($_value['name'], GK_EXT_TPL);
        }

        $_arr_tplData = array(
            'tplRows'   => $_arr_tplRows,
            'specRow'   => $_arr_specRow,
            'attachRow' => $_arr_attachRow,
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

        $_arr_inputSubmit = $this->mdl_spec->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y180201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['spec_id'] > 0) {
            if (!isset($this->groupAllow['spec']['edit']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x180303');
            }
        } else {
            if (!isset($this->groupAllow['spec']['add']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x180302');
            }
        }

        if ($_arr_inputSubmit['spec_attach_id'] < 1) {
            $_arr_attachIds = $this->obj_qlist->getAttachIds($_arr_inputSubmit['spec_content']);

            if ($_arr_attachIds[0] > 0) {
                $this->mdl_spec->inputSubmit['spec_attach_id'] = $_arr_attachIds[0];
            }
        }

        $_arr_submitResult = $this->mdl_spec->submit();

        $_arr_submitResult['msg'] = $this->obj_lang->get($_arr_submitResult['msg']);

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function attach() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_specId = 0;

        if (isset($this->param['id'])) {
            $_num_specId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_specId < 1) {
            return $this->error('Missing ID', 'x180202');
        }

        $_arr_specRow = $this->mdl_spec->read($_num_specId);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $this->error($_arr_specRow['msg'], $_arr_specRow['rcode']);
        }

        if (!isset($this->groupAllow['spec']['edit']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x180301');
        }

        $_arr_search = array(
            'box'           => 'normal',
            'attach_ids'    => $this->obj_qlist->getAttachIds($_arr_specRow['spec_content']),
        );

        if ($_arr_specRow['spec_attach_id'] > 0) {
            $_arr_search['attach_ids'][] = $_arr_specRow['spec_attach_id'];
        }

        $_arr_getData   = $this->mdl_attach->lists(array(1000, 'limit'), $_arr_search); //列出

        $_arr_attachRow = $this->mdl_attach->read($_arr_specRow['spec_attach_id']);

        $_arr_tplData = array(
            'ids'           => implode(',', $_arr_search['attach_ids']),
            'specRow'       => $_arr_specRow,
            'attachRows'    => $_arr_getData,
            'attachRow'     => $_arr_attachRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function cover() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['spec']['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x180303');
        }

        $_arr_inputCover = $this->mdl_spec->inputCover();

        if ($_arr_inputCover['rcode'] != 'y180201') {
            return $this->fetchJson($_arr_inputCover['msg'], $_arr_inputCover['rcode']);
        }

        $_arr_attachRow = $this->mdl_attach->check($_arr_inputCover['attach_id']);

        if ($_arr_attachRow['rcode'] != 'y070102') {
            return $this->fetchJson($_arr_attachRow['msg'], $_arr_attachRow['rcode']);
        }

        $_arr_coverResult   = $this->mdl_spec->cover();

        return $this->fetchJson($_arr_coverResult['msg'], $_arr_coverResult['rcode']);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['spec']['delete']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x180304');
        }

        $_arr_inputDelete = $this->mdl_spec->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y180201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_return = array(
            'spec_ids'      => $_arr_inputDelete['spec_ids'],
        );

        Plugin::listen('action_console_spec_delete', $_arr_return); //删除链接时触发

        $_arr_deleteResult = $this->mdl_spec->delete();

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

        if (!isset($this->groupAllow['spec']['edit']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x180303');
        }

        $_arr_inputStatus = $this->mdl_spec->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y180201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_return = array(
            'spec_ids'      => $_arr_inputStatus['spec_ids'],
            'spec_status'   => $_arr_inputStatus['act'],
        );

        Plugin::listen('action_console_spec_status', $_arr_return); //删除链接时触发

        $_arr_statusResult = $this->mdl_spec->status();

        $_arr_langReplace = array(
            'count' => $_arr_statusResult['count'],
        );

        return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
    }
}
