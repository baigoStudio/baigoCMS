<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Config;
use ginkgo\Json;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Mime extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_mime    = Loader::model('Mime');
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x080301');
        }

        $_arr_mimeRows   = $this->mdl_mime->lists(array(1000, 'limit')); //列出

        $_arr_tplData = array(
            'mimeRows'   => $_arr_mimeRows,
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_mimeRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x080301');
        }

        $_num_mimeId = 0;

        if (isset($this->param['id'])) {
            $_num_mimeId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_mimeId < 1) {
            return $this->error('Missing ID', 'x080202');
        }

        $_arr_mimeRow = $this->mdl_mime->read($_num_mimeId);

        if ($_arr_mimeRow['rcode'] != 'y080102') {
            return $this->error($_arr_mimeRow['msg'], $_arr_mimeRow['rcode']);
        }

        $_arr_tplData = array(
            'mimeRow'  => $_arr_mimeRow,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_mimeRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_mimeId = 0;

        if (isset($this->param['id'])) {
            $_num_mimeId = $this->obj_request->input($this->param['id'], 'int', 0);
        }


        if ($_num_mimeId > 0) {
            if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x080303');
            }

            $_arr_mimeRow = $this->mdl_mime->read($_num_mimeId);

            if ($_arr_mimeRow['rcode'] != 'y080102') {
                return $this->error($_arr_mimeRow['msg'], $_arr_mimeRow['rcode']);
            }
        } else {
            if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x080302');
            }

            $_arr_mimeRow = array(
                'mime_id'       => 0,
                'mime_ext'      => '',
                'mime_content'  => array(),
                'mime_note'     => '',
            );
        }

        $_arr_mimeRows   = $this->mdl_mime->lists(array(1000, 'limit'));
        $_arr_mimes      = array();

        foreach ($_arr_mimeRows as $_key=>$_value) {
            $_arr_mimes[] = $_value['mime_ext'];
        }

        $_arr_mimeOften  = Config::get('mime', 'console');

        foreach ($_arr_mimeOften as $_key=>$_value) {
            if (in_array($_key, $_arr_mimes)) {
                unset($_arr_mimeOften[$_key]);
            } else {
                $_arr_mimeOften[$_key]['note'] = $this->obj_lang->get($_value['note']);
            }
        }

        $_arr_tplData = array(
            'mimeOftenJson' => Json::encode($_arr_mimeOften),
            'mimeOften'     => $_arr_mimeOften,
            'mimeRow'       => $_arr_mimeRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_mimeRows);

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

        $_arr_inputSubmit = $this->mdl_mime->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y080201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['mime_id'] > 0) {
            if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x080303');
            }
        } else {
            if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x080302');
            }
        }

        $_arr_submitResult = $this->mdl_mime->submit();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x080304');
        }

        $_arr_inputDelete = $this->mdl_mime->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y080201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_deleteResult = $this->mdl_mime->delete();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
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
            'mime_id'   => array('int', 0),
            'mime_ext'  => array('str', ''),
        );

        $_arr_inputCheck = $this->obj_request->get($_arr_inputParam);

        if (!Func::isEmpty($_arr_inputCheck['mime_ext'])) {
            $_arr_mimeRow   = $this->mdl_mime->read($_arr_inputCheck['mime_ext'], 'mime_ext', $_arr_inputCheck['mime_id']);

            if ($_arr_mimeRow['rcode'] == 'y080102') {
                $_arr_return = array(
                    'rcode' => 'x080404',
                    'error_msg' => $this->obj_lang->get('MIME already exists'),
                );
            }
        }

        return $this->json($_arr_return);
    }
}
