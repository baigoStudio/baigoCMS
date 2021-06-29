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
defined('IN_GINKGO') or exit('Access denied');

class Spec_Belong extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_spec             = Loader::model('Spec');
        $this->mdl_articleSpecView  = Loader::model('Article_Spec_View');
        $this->mdl_specBelong       = Loader::model('Spec_Belong');

        $this->generalData['box'] = $this->mdl_articleSpecView->arr_box;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['spec']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x180305');
        }

        $_arr_searchParam = array(
            'id'    => array('int', 0),
            'key'   => array('str', ''),
            'box'   => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        if ($_arr_search['id'] < 1) {
            return $this->error('Missing ID', 'x180202');
        }

        $_arr_specRow = $this->mdl_spec->read($_arr_search['id']);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $this->error($_arr_specRow['msg'], $_arr_specRow['rcode']);
        }

        $_arr_search['not_in'] = Db::table('spec_belong')->where('belong_spec_id', '=', $_arr_specRow['spec_id'])->fetchSql()->select('belong_article_id');

        $_arr_articleRows   = $this->mdl_articleSpecView->lists($this->config['var_default']['perpage'], $_arr_search); //列出

        $_arr_searchBelong = array(
            'spec_id' => $_arr_specRow['spec_id'],
        );

        $_str_pageParamBelong     = 'page_belong';

        $_arr_pagination = array(
            0 => $this->config['var_default']['perpage'],
            3 => $_str_pageParamBelong,
        );

        $_arr_getData     = $this->mdl_articleSpecView->lists($_arr_pagination, $_arr_searchBelong); //列出

        $_arr_tplData = array(
            'specRow'           => $_arr_specRow,

            'search'            => $_arr_search,
            'pageRowSpec'       => $_arr_articleRows['pageRow'],
            'articleRows'       => $_arr_articleRows['dataRows'],

            'pageParamBelong'   => $_str_pageParamBelong,
            'pageRowBelong'     => $_arr_getData['pageRow'],
            'articleRowsBelong' => $_arr_getData['dataRows'],

            'token'             => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_specRows);

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

        if (!isset($this->groupAllow['spec']['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x180305');
        }

        $_arr_inputChoose = $this->mdl_specBelong->inputChoose();

        if ($_arr_inputChoose['rcode'] != 'y230201') {
            return $this->fetchJson($_arr_inputChoose['msg'], $_arr_inputChoose['rcode']);
        }

        //print_r($_arr_inputChoose);

        $_arr_specRow = $this->mdl_spec->check($_arr_inputChoose['spec_id']);

        //print_r($_arr_specRow);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $this->fetchJson($_arr_specRow['msg'], $_arr_specRow['rcode']);
        }

        $_arr_chooseResult   = $this->mdl_specBelong->choose();

        if ($_arr_chooseResult['rcode'] == 'y230103') {
            $this->mdl_spec->updatedTime($_arr_inputChoose['spec_id']);
        }

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

        if (!isset($this->groupAllow['spec']['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x180305');
        }

        $_arr_inputRemove = $this->mdl_specBelong->inputRemove();

        if ($_arr_inputRemove['rcode'] != 'y230201') {
            return $this->fetchJson($_arr_inputRemove['msg'], $_arr_inputRemove['rcode']);
        }

        //print_r($_arr_inputRemove);

        $_arr_specRow = $this->mdl_spec->check($_arr_inputRemove['spec_id']);

        //print_r($_arr_specRow);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $this->fetchJson($_arr_specRow['msg'], $_arr_specRow['rcode']);
        }

        $_arr_removeResult   = $this->mdl_specBelong->remove();

        if ($_arr_removeResult['rcode'] == 'y230104') {
            $this->mdl_spec->updatedTime($_arr_inputRemove['spec_id']);
        }

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

        if (!isset($this->groupAllow['spec']['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x180305');
        }

        $_arr_inputClear = $this->mdl_specBelong->inputClear();

        if ($_arr_inputClear['rcode'] != 'y230201') {
            return $this->fetchJson($_arr_inputClear['msg'], $_arr_inputClear['rcode']);
        }

        $_num_maxId = $_arr_inputClear['max_id'];

        $_arr_search = array(
            'max_id' => $_arr_inputClear['max_id'],
        );

        $_arr_getData  = $this->mdl_specBelong->clear(array(10, 'post'), $_arr_search);

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
