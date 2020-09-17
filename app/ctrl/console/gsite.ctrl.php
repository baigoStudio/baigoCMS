<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Config;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Gsite extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_cate         = Loader::model('Cate');

        $this->mdl_gsite        = Loader::model('Gsite');

        $this->generalData['status']     = $this->mdl_gsite->arr_status;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x270301');
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'status'    => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_gsiteRows   = $this->mdl_gsite->lists(array(1000, 'limit'), $_arr_search); //列出

        $_arr_tplData = array(
            'search'    => $_arr_search,
            'gsiteRows' => $_arr_gsiteRows,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_gsiteRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x270301');
        }

        $_num_gsiteId = 0;

        if (isset($this->param['id'])) {
            $_num_gsiteId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        $_arr_gsiteRow = $this->mdl_gsite->read($_num_gsiteId);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode']);
        }

        $_arr_cateRow   = $this->mdl_cate->read($_arr_gsiteRow['gsite_cate_id']);

        $_arr_tplData = array(
            'cateRow'       => $_arr_cateRow,
            'gsiteRow'      => $_arr_gsiteRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_gsiteRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_gsiteId = 0;

        if (isset($this->param['id'])) {
            $_num_gsiteId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_gsiteId > 0) {
            if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x270303');
            }

            $_arr_gsiteRow = $this->mdl_gsite->read($_num_gsiteId);

            if ($_arr_gsiteRow['rcode'] != 'y270102') {
                return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode']);
            }
        } else {
            if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x270302');
            }

            $_arr_gsiteRow = array(
                'gsite_id'      => 0,
                'gsite_name'    => '',
                'gsite_note'    => '',
                'gsite_status'  => $this->mdl_gsite->arr_status[0],
                'gsite_url'     => '',
                'gsite_charset' => '',
                'gsite_cate_id' => 0,
            );
        }

        $_arr_searchCate = array(
            'parent_id' => 0,
        );
        $_arr_cateRows  = $this->mdl_cate->listsTree($_arr_searchCate);

        $_arr_cateRow   = $this->mdl_cate->read($_arr_gsiteRow['gsite_cate_id']);

        $_str_configCharset    = BG_PATH_CONFIG . 'console' . DS . 'charset' . GK_EXT_INC;
        $_arr_charsetRows      = Config::load($_str_configCharset, 'charset', 'console');

        $_str_current          = $this->obj_lang->getCurrent();
        $_str_langCharset      = GK_APP_LANG . $_str_current . DS . 'console' . DS . 'charset' . GK_EXT_LANG;
        $this->obj_lang->load($_str_langCharset, 'console.charset');

        $_arr_tplData = array(
            'keepTag'       => $this->mdl_gsite->keepTag,
            'keepAttr'      => $this->mdl_gsite->keepAttr, //系统保留属性
            'charsetRows'   => $_arr_charsetRows,
            'cateRows'      => $_arr_cateRows,
            'cateRow'       => $_arr_cateRow,
            'gsiteRow'      => $_arr_gsiteRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_gsiteRows);

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

        $_arr_inputSubmit = $this->mdl_gsite->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y270201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['gsite_id'] > 0) {
            if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x270303');
            }
        } else {
            if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x270302');
            }
        }

        $_arr_submitResult = $this->mdl_gsite->submit();

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

        if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x270302');
        }

        $_arr_inputDuplicate = $this->mdl_gsite->inputDuplicate();

        if ($_arr_inputDuplicate['rcode'] != 'y270201') {
            return $this->fetchJson($_arr_inputDuplicate['msg'], $_arr_inputDuplicate['rcode']);
        }

        $_arr_duplicateResult = $this->mdl_gsite->duplicate();

        return $this->fetchJson($_arr_duplicateResult['msg'], $_arr_duplicateResult['rcode']);
    }


    function status() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x270304');
        }

        $_arr_inputStatus = $this->mdl_gsite->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y270201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_statusResult = $this->mdl_gsite->status();

        $_arr_langReplace = array(
            'count' => $_arr_statusResult['count'],
        );

        return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }
        if (!$this->isAjaxPost) {

            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x270304');
        }

        $_arr_inputDelete = $this->mdl_gsite->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y270201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_deleteResult = $this->mdl_gsite->delete();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
    }
}
