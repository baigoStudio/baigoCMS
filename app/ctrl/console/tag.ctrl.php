<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Json;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Tag extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_tag        = Loader::model('Tag');

        $this->generalData['status']    = $this->mdl_tag->arr_status;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x130301');
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'status'    => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_num_tagCount = $this->mdl_tag->count($_arr_search); //统计记录数
        $_arr_pageRow  = $this->obj_request->pagination($_num_tagCount); //取得分页数据
        $_arr_tagRows  = $this->mdl_tag->lists($this->config['var_default']['perpage'], $_arr_pageRow['except'], $_arr_search); //列出

        $_arr_tplData = array(
            'pageRow'   => $_arr_pageRow,
            'search'    => $_arr_search,
            'tagRows'   => $_arr_tagRows,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_tagRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function typeahead() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x130301');
        }

        $_arr_searchParam = array(
            'key' => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_search['status'] = 'show';

        $_arr_tagRows  = $this->mdl_tag->lists(1000, 0, $_arr_search); //列出

        $_arr_tags = array();

        foreach ($_arr_tagRows as $_key=>$_value) {
            $_arr_tags[] = $_value['tag_name'];
        }

        return $this->json($_arr_tags);
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_tagId = 0;

        if (isset($this->param['id'])) {
            $_num_tagId = $this->obj_request->input($this->param['id'], 'int', 0);
        }


        if ($_num_tagId > 0) {
            if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x130303');
            }

            $_arr_tagRow = $this->mdl_tag->read($_num_tagId);

            if ($_arr_tagRow['rcode'] != 'y130102') {
                return $this->error($_arr_tagRow['msg'], $_arr_tagRow['rcode']);
            }
        } else {
            if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x130302');
            }

            $_arr_tagRow = array(
                'tag_id'        => 0,
                'tag_name'      => '',
                'tag_status'    => $this->mdl_tag->arr_status[0],
            );
        }

        $_arr_tplData = array(
            'tagRow'  => $_arr_tagRow,
            'token'    => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_tagRows);

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

        $_arr_inputSubmit = $this->mdl_tag->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y130201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['tag_id'] > 0) {
            if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x130303');
            }
        } else {
            if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x130302');
            }
        }

        $_arr_submitResult = $this->mdl_tag->submit();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function status() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x130303');
        }

        $_arr_inputStatus = $this->mdl_tag->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y130201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_statusResult = $this->mdl_tag->status();

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

        if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x130304');
        }

        $_arr_inputDelete = $this->mdl_tag->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y130201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_deleteResult = $this->mdl_tag->delete();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
    }
}
