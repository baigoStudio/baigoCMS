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

class Thumb extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_thumb    = Loader::model('Thumb');

        $this->generalData['type']      = $this->mdl_thumb->arr_type;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['thumb']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x090301');
        }

        $_arr_thumbRows   = $this->mdl_thumb->lists(array(1000, 'limit')); //列出

        $_arr_tplData = array(
            'thumbRows'  => $_arr_thumbRows,
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_thumbRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['thumb']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x090301');
        }

        $_num_thumbId = 0;

        if (isset($this->param['id'])) {
            $_num_thumbId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_thumbId < 1) {
            return $this->error('Missing ID', 'x090202');
        }

        $_arr_thumbRow = $this->mdl_thumb->read($_num_thumbId);

        if ($_arr_thumbRow['rcode'] != 'y090102') {
            return $this->error($_arr_thumbRow['msg'], $_arr_thumbRow['rcode']);
        }

        $_arr_tplData = array(
            'thumbRow'  => $_arr_thumbRow,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_thumbRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_thumbId = 0;

        if (isset($this->param['id'])) {
            $_num_thumbId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_thumbId > 0) {
            if (!isset($this->groupAllow['attach']['thumb']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x090303');
            }

            $_arr_thumbRow = $this->mdl_thumb->read($_num_thumbId);

            if ($_arr_thumbRow['rcode'] != 'y090102') {
                return $this->error($_arr_thumbRow['msg'], $_arr_thumbRow['rcode']);
            }
        } else {
            if (!isset($this->groupAllow['attach']['thumb']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x090302');
            }
            $_arr_thumbRow = array(
                'thumb_id'      => 0,
                'thumb_width'   => '',
                'thumb_height'  => '',
                'thumb_type'    => $this->mdl_thumb->arr_type[0],
                'thumb_quality' => 90,
            );
        }

        $_arr_tplData = array(
            'thumbRow'  => $_arr_thumbRow,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_thumbRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function submit() {
        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputSubmit = $this->mdl_thumb->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y090201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['thumb_id'] > 0) {
            if (!isset($this->groupAllow['attach']['thumb']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x090303');
            }
        } else {
            if (!isset($this->groupAllow['attach']['thumb']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x090302');
            }
        }

        $_arr_submitResult = $this->mdl_thumb->submit();

        $this->cacheProcess();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function setDefault() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['thumb']['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x090303');
        }

        $_arr_inputDefault = $this->mdl_thumb->inputDefault();

        if ($_arr_inputDefault['rcode'] != 'y090201') {
            return $this->fetchJson($_arr_inputDefault['msg'], $_arr_inputDefault['rcode']);
        }

        $_arr_defaultResult   = $this->mdl_thumb->setDefault();

        return $this->fetchJson($_arr_defaultResult['msg'], $_arr_defaultResult['rcode']);
    }


    function delete() {
        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['attach']['thumb']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x090304');
        }

        $_arr_inputDelete = $this->mdl_thumb->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y090201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_deleteResult = $this->mdl_thumb->delete();
        $this->cacheProcess();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
    }


    function cache() {
        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputCommon = $this->mdl_thumb->inputCommon();

        if ($_arr_inputCommon['rcode'] != 'y090201') {
            return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
        }

        $_arr_cacheResult = $this->cacheProcess();

        return $this->fetchJson($_arr_cacheResult['msg'], $_arr_cacheResult['rcode']);
    }


    private function cacheProcess() {
        $_mdl_thumb    = Loader::model('Thumb', '', 'index');

        $_num_cacheSize = $_mdl_thumb->cacheProcess();

        if ($_num_cacheSize > 0) {
            $_str_rcode = 'y090110';
            $_str_msg   = 'Refresh cache successfully';
        } else {
            $_str_rcode = 'x090110';
            $_str_msg   = 'Refresh cache failed';
        }

        return array(
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }
}
