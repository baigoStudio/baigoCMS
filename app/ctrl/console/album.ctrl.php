<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\File;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Album extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_attach       = Loader::model('Attach');
        $this->mdl_album        = Loader::model('Album');
        $this->mdl_albumIndex   = Loader::model('Album', '', 'Index');

        $this->generalData['status']    = $this->mdl_album->arr_status;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x060301');
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'status'    => array('str', ''),
        );

        $_arr_search   = $this->obj_request->param($_arr_searchParam);
        $_arr_getData  = $this->mdl_album->lists($this->config['var_default']['perpage'], $_arr_search); //列出

        $_arr_tplData = array(
            'search'     => $_arr_search,
            'pageRow'    => $_arr_getData['pageRow'],
            'albumRows'  => $_arr_getData['dataRows'],
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function choose() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x060301');
        }

        $_arr_tplData = array(
            'token' => $this->obj_request->token(),
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

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x060301');
        }

        $_arr_searchParam = array(
            'key' => array('str', ''),
        );

        $_arr_search  = $this->obj_request->param($_arr_searchParam);

        //$_arr_search['status'] = 'enable';

        $_arr_albumRows   = $this->mdl_album->lists(array(1000, 'limit'), $_arr_search); //列出

        return $this->json($_arr_albumRows);
    }


    function lists() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x060301');
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
        );

        $_arr_search    = $this->obj_request->param($_arr_searchParam);
        $_arr_getData   = $this->mdl_album->lists(12, $_arr_search); //列出

        foreach ($_arr_getData['dataRows'] as $_key=>&$_value) {
            $_arr_attachRow = $this->mdl_attach->read($_value['album_attach_id']);
            $_value['album_url'] = $this->mdl_albumIndex->urlProcess($_value);
            $_value['attachRow'] = $_arr_attachRow;
        }

        $_arr_tplData = array(
            'search'    => $_arr_search,
            'pageRow'   => $_arr_getData['pageRow'],
            'albumRows' => $_arr_getData['dataRows'],
        );

        return $this->json($_arr_tplData);
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x060301');
        }

        $_num_albumId = 0;

        if (isset($this->param['id'])) {
            $_num_albumId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_albumId < 1) {
            return $this->error('Missing ID', 'x060202');
        }

        $_arr_albumRow = $this->mdl_album->read($_num_albumId);

        if ($_arr_albumRow['rcode'] != 'y060102') {
            return $this->error($_arr_albumRow['msg'], $_arr_albumRow['rcode']);
        }

        $_arr_attachRow = $this->mdl_attach->read($_arr_albumRow['album_attach_id']);

        $_arr_tplData = array(
            'attachRow' => $_arr_attachRow,
            'albumRow'  => $_arr_albumRow,
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

        $_num_albumId = 0;

        if (isset($this->param['id'])) {
            $_num_albumId = $this->obj_request->input($this->param['id'], 'int', 0);
        }


        if ($_num_albumId > 0) {
            if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x060303');
            }

            $_arr_albumRow = $this->mdl_album->read($_num_albumId);

            if ($_arr_albumRow['rcode'] != 'y060102') {
                return $this->error($_arr_albumRow['msg'], $_arr_albumRow['rcode']);
            }

            $_arr_attachRow = $this->mdl_attach->read($_arr_albumRow['album_attach_id']);
        } else {
            if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x060302');
            }

            $_arr_albumRow = array(
                'album_id'        => 0,
                'album_name'      => '',
                'album_status'    => $this->mdl_album->arr_status[0],
                'album_content'   => '',
                'album_tpl'       => '',
                'album_attach_id' => 0,
            );

            $_arr_attachRow = array(
                'attach_thumb' => '',
            );
        }

        $_arr_tplRows  = File::instance()->dirList(BG_TPL_ALBUM);

        foreach ($_arr_tplRows as $_key=>$_value) {
            $_arr_tplRows[$_key]['name_s'] = basename($_value['name'], GK_EXT_TPL);
        }

        $_arr_tplData = array(
            'tplRows'   => $_arr_tplRows,
            'attachRow' => $_arr_attachRow,
            'albumRow'  => $_arr_albumRow,
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

        $_arr_inputSubmit = $this->mdl_album->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y060201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['album_id'] > 0) {
            if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x060303');
            }
        } else {
            if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x060302');
            }
        }

        $_arr_submitResult = $this->mdl_album->submit();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function cover() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputCover = $this->mdl_album->inputCover();

        if ($_arr_inputCover['rcode'] != 'y060201') {
            return $this->fetchJson($_arr_inputCover['msg'], $_arr_inputCover['rcode']);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x060303');
        }

        $_arr_attachRow = $this->mdl_attach->check($_arr_inputCover['attach_id']);

        if ($_arr_attachRow['rcode'] != 'y070102') {
            return $this->fetchJson($_arr_attachRow['msg'], $_arr_attachRow['rcode']);
        }

        $_arr_coverResult   = $this->mdl_album->cover();

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

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x060304');
        }

        $_arr_inputDelete = $this->mdl_album->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y060201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_return = array(
            'album_ids'      => $_arr_inputDelete['album_ids'],
        );

        $_arr_deleteResult = $this->mdl_album->delete();

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

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x060303');
        }

        $_arr_inputStatus = $this->mdl_album->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y060201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_return = array(
            'album_ids'      => $_arr_inputStatus['album_ids'],
            'album_status'   => $_arr_inputStatus['act'],
        );

        $_arr_statusResult = $this->mdl_album->status();

        $_arr_langReplace = array(
            'count' => $_arr_statusResult['count'],
        );

        return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
    }
}
