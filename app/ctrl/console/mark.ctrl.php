<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Mark extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_mark        = Loader::model('Mark');
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['article']['mark']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x140301');
        }

        $_arr_markRows  = $this->mdl_mark->lists(1000); //列出

        $_arr_tplData = array(
            'markRows'  => $_arr_markRows,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_markRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_markId = 0;

        if (isset($this->param['id'])) {
            $_num_markId = $this->obj_request->input($this->param['id'], 'int', 0);
        }


        if ($_num_markId > 0) {
            if (!isset($this->groupAllow['article']['mark']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x140303');
            }

            $_arr_markRow = $this->mdl_mark->read($_num_markId);

            if ($_arr_markRow['rcode'] != 'y140102') {
                return $this->error($_arr_markRow['msg'], $_arr_markRow['rcode']);
            }
        } else {
            if (!isset($this->groupAllow['article']['mark']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x140302');
            }

            $_arr_markRow = array(
                'mark_id'      => 0,
                'mark_name'    => '',
            );
        }

        $_arr_tplData = array(
            'markRow'  => $_arr_markRow,
            'token'    => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_markRows);

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

        $_arr_inputSubmit = $this->mdl_mark->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y140201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['mark_id'] > 0) {
            if (!isset($this->groupAllow['article']['mark']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x140303');
            }
        } else {
            if (!isset($this->groupAllow['article']['mark']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x140302');
            }
        }

        $_arr_submitResult = $this->mdl_mark->submit();

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

        if (!isset($this->groupAllow['article']['mark']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x140304');
        }

        $_arr_inputDelete = $this->mdl_mark->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y140201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_deleteResult = $this->mdl_mark->delete();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
    }
}
