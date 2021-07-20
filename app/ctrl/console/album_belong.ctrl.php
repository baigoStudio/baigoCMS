<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Db;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Album_Belong extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_album            = Loader::model('Album');
        $this->mdl_attachAlbumView  = Loader::model('Attach_Album_View');
        $this->mdl_albumBelong      = Loader::model('Album_Belong');

        $this->generalData['box'] = $this->mdl_attachAlbumView->arr_box;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x060305');
        }

        $_arr_searchParam = array(
            'id'    => array('int', 0),
            'key'   => array('str', ''),
            'box'   => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        if ($_arr_search['id'] < 1) {
            return $this->error('Missing ID', 'x060202');
        }

        $_arr_albumRow = $this->mdl_album->read($_arr_search['id']);

        if ($_arr_albumRow['rcode'] != 'y060102') {
            return $this->error($_arr_albumRow['msg'], $_arr_albumRow['rcode']);
        }

        $_arr_search['not_in'] = Db::table('album_belong')->where('belong_album_id', '=', $_arr_albumRow['album_id'])->fetchSql()->select('belong_attach_id');

        $_arr_attachRows   = $this->mdl_attachAlbumView->lists($this->config['var_default']['perpage'], $_arr_search); //列出

        $_arr_searchBelong = array(
            'album_id' => $_arr_albumRow['album_id'],
        );

        $_str_pageParamBelong     = 'page_belong';

        $_arr_pagination = array(
            0 => $this->config['var_default']['perpage'],
            3 => $_str_pageParamBelong,
        );

        $_arr_getData    = $this->mdl_attachAlbumView->lists($_arr_pagination, $_arr_searchBelong); //列出

        $_arr_tplData = array(
            'albumRow'          => $_arr_albumRow,

            'search'            => $_arr_search,
            'pageRowAlbum'      => $_arr_attachRows['pageRow'],
            'attachRows'        => $_arr_attachRows['dataRows'],

            'pageParamBelong'   => $_str_pageParamBelong,
            'pageRowBelong'     => $_arr_getData['pageRow'],
            'attachRowsBelong'  => $_arr_getData['dataRows'],

            'token'             => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_albumRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function choose() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x060305');
        }

        $_arr_inputChoose = $this->mdl_albumBelong->inputChoose();

        if ($_arr_inputChoose['rcode'] != 'y290201') {
            return $this->fetchJson($_arr_inputChoose['msg'], $_arr_inputChoose['rcode']);
        }

        //print_r($_arr_inputChoose);

        $_arr_albumRow = $this->mdl_album->check($_arr_inputChoose['album_id']);

        //print_r($_arr_albumRow);

        if ($_arr_albumRow['rcode'] != 'y060102') {
            return $this->fetchJson($_arr_albumRow['msg'], $_arr_albumRow['rcode']);
        }

        $_arr_chooseResult   = $this->mdl_albumBelong->choose();

        $_arr_langReplace = array(
            'count' => $_arr_chooseResult['count'],
        );

        return $this->fetchJson($_arr_chooseResult['msg'], $_arr_chooseResult['rcode'], '', $_arr_langReplace);
    }


    function remove() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x060305');
        }

        $_arr_inputRemove = $this->mdl_albumBelong->inputRemove();

        if ($_arr_inputRemove['rcode'] != 'y290201') {
            return $this->fetchJson($_arr_inputRemove['msg'], $_arr_inputRemove['rcode']);
        }

        //print_r($_arr_inputRemove);

        $_arr_albumRow = $this->mdl_album->check($_arr_inputRemove['album_id']);

        //print_r($_arr_albumRow);

        if ($_arr_albumRow['rcode'] != 'y060102') {
            return $this->fetchJson($_arr_albumRow['msg'], $_arr_albumRow['rcode']);
        }

        $_arr_removeResult   = $this->mdl_albumBelong->remove();

        $_arr_langReplace = array(
            'count' => $_arr_removeResult['count'],
        );

        return $this->fetchJson($_arr_removeResult['msg'], $_arr_removeResult['rcode'], '', $_arr_langReplace);
    }


    function clear() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['attach']['album']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x060305');
        }

        $_arr_inputClear = $this->mdl_albumBelong->inputClear();

        if ($_arr_inputClear['rcode'] != 'y290201') {
            return $this->fetchJson($_arr_inputClear['msg'], $_arr_inputClear['rcode']);
        }

        $_num_maxId = $_arr_inputClear['max_id'];

        $_arr_search = array(
            'max_id' => $_arr_inputClear['max_id'],
        );

        $_arr_getData  = $this->mdl_albumBelong->clear(array(10, 'post'), $_arr_search);

        if (Func::isEmpty($_arr_getData['dataRows'])) {
            $_str_status    = 'complete';
            $_str_msg       = 'Complete';
        } else {
            $_arr_belongRow = end($_arr_getData['dataRows']);
            $_str_status    = 'loading';
            $_str_msg       = 'Submitting';
            $_num_maxId     = $_arr_belongRow['belong_id'];
        }

        $_arr_return = array(
            'msg'       => $this->obj_lang->get($_str_msg),
            'count'     => $_arr_getData['pageRow']['total'],
            'max_id'    => $_num_maxId,
            'status'    => $_str_status,
        );

        return $this->json($_arr_return);
    }
}
