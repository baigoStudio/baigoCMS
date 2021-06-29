<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\gen;

use app\classes\gen\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\File;
use ginkgo\Html;
use ginkgo\Ftp;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------用户类-------------*/
class Cate extends Ctrl {

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->configConsole    = $this->config['console'];

        $this->mdl_cate     = Loader::model('Cate');
    }


    function oneByOne() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'overall'   => array('str', ''),
            'min'       => array('int', 0),
        );

        $_arr_search    = $this->obj_request->param($_arr_searchParam);
        $_arr_pageRow   = $this->obj_request->pagination(0);
        $_arr_cateRow   = $this->mdl_cate->next($_arr_search['min']);
        $_str_jump      = $this->url['route_gen'];

        if ($_arr_cateRow['rcode'] != 'y250102') {
            if ($_arr_search['overall'] == 'overall') {
                $_str_jump .= 'call/index/';
            } else {
                return $this->error('Complete generation', 'y250406');
            }
        } else {
            $_str_jump .= 'cate/one-by-one/min/' . $_arr_cateRow['cate_id'] . '/';

            if ($_arr_cateRow['cate_status'] == 'show' && Func::isEmpty($_arr_cateRow['cate_link'])) {
                $_arr_cateRow['cate_ids']   = $this->mdl_cate->ids($_arr_cateRow['cate_id']);
                $_arr_pageRow               = $this->pageProcess($_arr_cateRow);
            }
        }

        if ($_arr_search['overall'] == 'overall') {
            $_str_jump .= 'overall/overall/';
        }
        $_str_jump .= 'view/iframe/';

        $_arr_tplData = array(
            'jump'          => $_str_jump,
            'pageRow'       => $_arr_pageRow,
            'cateRow'       => $_arr_cateRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function single() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_cateId = 0;

        if (isset($this->param['id'])) {
            $_num_cateId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_cateId < 1) {
            return $this->error('Missing ID', 'x250202', 400);
        }

        $_arr_cateRow = $this->mdl_cate->read($_num_cateId);

        if ($_arr_cateRow['rcode'] != 'y250102' || $_arr_cateRow['cate_status'] != 'show' || !Func::isEmpty($_arr_cateRow['cate_link'])) {
            return $this->error('Unable to generate', 'x250402');
        }

        $_arr_cateRow['cate_ids']   = $this->mdl_cate->ids($_arr_cateRow['cate_id']);

        $_arr_pageRow               = $this->pageProcess($_arr_cateRow);

        $_arr_tplData = array(
            'pageRow'   => $_arr_pageRow,
            'cateRow'   => $_arr_cateRow,
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

        $_arr_inputSubmit = $this->mdl_cate->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y250201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        $_arr_cateRow = $this->cateProcess($_arr_inputSubmit['cate_id'], $_arr_inputSubmit['page']);

        //print_r($_arr_cateRow);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $this->fetchJson($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        $_arr_pageRow = $this->pageProcess($_arr_cateRow, $_arr_inputSubmit['page']);

        $_arr_search = array(
            'cate_ids' => $_arr_cateRow['cate_ids'],
        );

        $_mdl_articleCateView           = Loader::model('Article_Cate_View');

        $_arr_articleRows               = $_mdl_articleCateView->lists(array($_arr_pageRow['perpage'], $_arr_pageRow['offset'], 'limit'), $_arr_search);

        $_arr_cateRow['cate_content']   = $this->obj_index->linkProcess($_arr_cateRow['cate_content'], $_arr_cateRow['cate_ids']);
        $_arr_cateRow['cate_content']   = $this->obj_index->albumProcess($_arr_cateRow['cate_content']);

        $_arr_tplData = array(
            'urlRow'        => $_arr_cateRow['cate_url'],
            'pageRow'       => $_arr_pageRow,
            'cateRow'       => $_arr_cateRow,
            'articleRows'   => $this->obj_index->articleListsProcess($_arr_articleRows),
        );

        $_arr_outResult = $this->output($_arr_tplData);

        if ($_arr_outResult['rcode'] != 'y250405') {
            return $this->fetchJson($_arr_outResult['msg'], $_arr_outResult['rcode']);
        }

        if ($this->ftpInit) {
            $_ftp_status = $this->obj_ftp->fileUpload($_arr_cateRow['cate_path'], '/' . $_arr_cateRow['cate_path_name']);
        }

        $_arr_outResult['msg'] = $this->obj_lang->get($_arr_outResult['msg']);

        //$this->outputType('json');

        return $this->json($_arr_outResult);
    }


    private function pageProcess($arr_cateRow, $page = 0) {
        $_arr_search = array(
            'cate_ids' => $arr_cateRow['cate_ids'],
        );

        $_mdl_articleCateView       = Loader::model('Article_Cate_View');
        $_arr_pageRow               = $_mdl_articleCateView->pagination($_arr_search, $arr_cateRow['cate_perpage'], $page); //取得分页数据
        $_arr_pageRow['total_abs']  = $_arr_pageRow['total'];
        $_arr_pageRow['perpage']    = $arr_cateRow['cate_perpage'];

        if ($_arr_pageRow['total'] >= $this->configVisit['visit_pagecount']) {
            $_arr_pageRow['total'] = $this->configVisit['visit_pagecount'];
        }

        if ($_arr_pageRow['group_end'] >= $this->configVisit['visit_pagecount']) {
            $_arr_pageRow['group_end'] = $this->configVisit['visit_pagecount'];
        }

        return $_arr_pageRow;
    }


    private function output($arr_tplData) {
        $_arr_cateRow = $this->cateRow;

        if (Func::isEmpty($_arr_cateRow['cate_tpl_do'])) {
            $_arr_cateRow['cate_tpl_do'] = $this->configBase['site_tpl'];
        }

        $_str_pathTpl = BG_TPL_INDEX . $_arr_cateRow['cate_tpl_do'] . DS;

        if ($arr_tplData['pageRow']['total_abs'] > $this->configVisit['visit_pagecount']) {
            $arr_tplData['pageRow']['final']    = false;
            $arr_tplData['page_more']           = true;
        }

        //$arr_tplData['path_tpl']   = $_str_pathTpl;

        $arr_tplData = Plugin::listen('filter_gen_cate', $arr_tplData); //编辑文章时触发

        if (isset($_arr_cateRow['cate_path_index'])) {
            $this->outputProcess($arr_tplData, $_arr_cateRow['cate_path_index'], $_str_pathTpl, 'cate' . DS . 'index');
        }

        $_mix_outputResult = $this->outputProcess($arr_tplData, $_arr_cateRow['cate_path'], $_str_pathTpl, 'cate' . DS . 'index');

        if (is_array($_mix_outputResult) && isset($_mix_outputResult['rcode'])) {
            return $_mix_outputResult;
        }

        if ($_mix_outputResult > 0) {
            $_arr_return = array(
                'rcode' => 'y250405',
                'msg'   => 'Generate category successfully',
            );
        } else {
            $_arr_return = array(
                'rcode' => 'x250405',
                'msg'   => 'Generate category failed',
            );
        }

        return $_arr_return;
    }
}
