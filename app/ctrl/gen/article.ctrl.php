<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\gen;

use app\classes\gen\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Ftp;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------用户类-------------*/
class Article extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->configConsole    = $this->config['console'];

        $this->mdl_attach   = Loader::model('Attach');
        $this->mdl_article  = Loader::model('Article');
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'overall'   => array('str', ''),
            'enforce'   => array('str', ''),
            'range_min' => array('int', 0),
            'range_max' => array('int', 0),
            'max'       => array('int', 0),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        if ($_arr_search['max'] > 0) {
            $_arr_search['max_id'] = $_arr_search['max'];
        }

        $_arr_search['range_id'][0] = $_arr_search['range_min'];
        $_arr_search['range_id'][1] = $_arr_search['range_max'];

        if ($_arr_search['enforce'] != 'enforce') {
            $_arr_search['is_gen'] = 'not';
        }

        $_arr_order = array('article_id', 'DESC');

        $_arr_getData       = $this->mdl_article->lists($this->configConsole['count_gen'], $_arr_search, $_arr_order);
        $_str_jump          = $this->url['route_gen'];

        if (Func::isEmpty($_arr_getData['dataRows'])) {
            if ($_arr_search['overall'] == 'overall') {
                $_str_jump .= 'cate/one-by-one/';
            } else {
                return $this->error('Complete generation', 'y120406');
            }
        } else {
            $_arr_articleRow = end($_arr_getData['dataRows']);
            $_str_jump .= 'article/index/max/' . $_arr_articleRow['article_id'] . '/';
        }

        if ($_arr_search['overall'] == 'overall') {
            $_str_jump .= 'overall/overall/';
        }
        if ($_arr_search['enforce'] == 'enforce') {
            $_str_jump .= 'enforce/enforce/';
        }
        if ($_arr_search['range_min'] > 0) {
            $_str_jump .= 'range_min/' . $_arr_search['range_min'] . '/';
        }
        if ($_arr_search['range_max'] > 0) {
            $_str_jump .= 'range_max/' . $_arr_search['range_max'] . '/';
        }
        $_str_jump .= 'view/iframe/';

        $_arr_tplData = array(
            'jump'          => $_str_jump,
            'search'        => $_arr_search,
            'articleRows'   => $_arr_getData['dataRows'],
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function enforce() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_tplData = array(
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

        $_num_articleId = 0;

        if (isset($this->param['id'])) {
            $_num_articleId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_articleId < 1) {
            return $this->error('Missing ID', 'x120202', 400);
        }

        $_arr_articleRow = $this->mdl_article->read($_num_articleId);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            return $this->error($_arr_articleRow['msg'], $_arr_articleRow['rcode'], 404);
        }

        if (Func::isEmpty($_arr_articleRow['article_title']) || $_arr_articleRow['article_status'] != 'pub' || $_arr_articleRow['article_box'] != 'normal' || ($_arr_articleRow['article_is_time_pub'] > 0 && $_arr_articleRow['article_time_pub'] > GK_NOW) || ($_arr_articleRow['article_is_time_hide'] > 0 && $_arr_articleRow['article_time_hide'] < GK_NOW)) {
            return $this->error('Unable to generate', 'x120404');
        }

        if (!Func::isEmpty($_arr_articleRow['article_link'])) {
            $this->mdl_article->isGen(array($_arr_articleRow['article_id']));
            return $this->error('Unable to generate', 'x120403');
        }

        $_arr_cateRow = $this->mdl_cate->read($_arr_articleRow['article_cate_id']);

        if ($_arr_cateRow['rcode'] != 'y250102' || $_arr_cateRow['cate_status'] != 'show' || !Func::isEmpty($_arr_cateRow['cate_link'])) {
            return $this->error('Unable to generate', 'x120402');
        }

        $_arr_tplData = array(
            'cateRow'       => $_arr_cateRow,
            'articleRow'    => $_arr_articleRow,
            'token'         => $this->obj_request->token(),
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

        $_arr_inputSubmit = $this->mdl_article->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        $_arr_articleRow = $this->obj_index->articleRead($_arr_inputSubmit['article_id']);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            return $this->fetchJson($_arr_articleRow['msg'], $_arr_articleRow['rcode']);
        }

        if (isset($_arr_articleRow['article_link']) && !Func::isEmpty($_arr_articleRow['article_link'])) {
            $this->mdl_article->isGen(array($_arr_articleRow['article_id']));
            return $this->fetchJson('Unable to generate', 'x120403');
        }

        if ($_arr_articleRow['article_is_gen'] == 'yes' && $_arr_inputSubmit['enforce'] != 'enforce') {
            return $this->fetchJson('Unable to generate', 'x120401');
        }

        $_arr_articleRow = $this->mdl_article->pathProcess($_arr_articleRow);

        $_arr_cateRow    = $this->cateProcess($_arr_articleRow['article_cate_id']);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $this->fetchJson($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        $_arr_tagRows    = $this->obj_index->tagLists($_arr_inputSubmit['article_id']);

        $_arr_attachRow  = array();

        $_arr_tagIds     = array();
        $_arr_assRows    = array();

        foreach ($_arr_tagRows as $_key=>$_value) {
            $_arr_tagIds[] = $_value['tag_id'];
        }

        if (!Func::isEmpty($_arr_tagIds)) {
            $_arr_assRows = $this->obj_index->assLists($_arr_tagIds);
        }

        $_arr_articleRow['article_content'] = $this->obj_index->linkProcess($_arr_articleRow['article_content'], $_arr_cateRow['cate_ids']);
        $_arr_articleRow['article_content'] = $this->obj_index->albumProcess($_arr_articleRow['article_content']);

        $_arr_tplData = array(
            'cateRow'       => $_arr_cateRow,
            'articleRow'    => $_arr_articleRow,
            'tagRows'       => $_arr_tagRows,
            'associateRows' => $_arr_assRows,
        );

        $_arr_outResult = $this->output($_arr_tplData);

        if ($_arr_outResult['rcode'] != 'y120405') {
            return $this->fetchJson($_arr_outResult['msg'], $_arr_outResult['rcode']);
        }

        $this->mdl_article->isGen(array($_arr_articleRow['article_id']));

        if ($this->ftpInit) {
            $_mix_ftpResult = $this->ftpProcess($_arr_articleRow);

            if ($_mix_ftpResult !== true) {
                return $this->fetchJson($_mix_ftpResult['msg'], $_mix_ftpResult['rcode']);
            }
        }

        return $this->fetchJson($_arr_outResult['msg'], $_arr_outResult['rcode']);
    }


    private function output($arr_tplData) {
        $_arr_cateRow = $this->cateRow;

        $_str_tplDo = '';

        if (Func::isEmpty($_arr_cateRow['cate_tpl_do'])) {
            $_str_tplDo = $this->configBase['site_tpl'];
        } else {
            $_str_tplDo = $_arr_cateRow['cate_tpl_do'];
        }

        $_str_tplPath   = BG_TPL_INDEX . $_str_tplDo . DS;

        if (Func::isEmpty($arr_tplData['articleRow']['article_tpl']) || $arr_tplData['articleRow']['article_tpl'] === '-1') {
            $_str_tpl = $_str_tplPath . 'article' . DS . 'index';
        } else {
            $_str_tpl = BG_TPL_ARTICLE . $arr_tplData['articleRow']['article_tpl'];
        }

        $_str_tpl .= GK_EXT_TPL;

        //print_r($_str_tpl);

        $_mix_result    = Plugin::listen('filter_gen_article', $arr_tplData); //编辑文章时触发
        $arr_tplData    = Plugin::resultProcess($arr_tplData, $_mix_result);

        $_mix_outputResult = $this->outputProcess($arr_tplData, $arr_tplData['articleRow']['article_path'], $_str_tplPath, $_str_tpl);

        if (is_array($_mix_outputResult) && isset($_mix_outputResult['rcode'])) {
            return $_mix_outputResult;
        }

        if ($_mix_outputResult > 0) {
            $_arr_return = array(
                'rcode' => 'y120405',
                'msg'   => 'Generate article successfully',
            );
        } else {
            $_arr_return = array(
                'rcode' => 'x120405',
                'msg'   => 'Generate article failed',
            );
        }

        return $_arr_return;
    }


    private function ftpProcess($arr_articleRow) {
        if (!$this->obj_ftp->init()) {
            return array(
                'msg'   => $this->obj_ftp->getError(),
                'rcode' => 'x070410',
            );
        }

        //print_r($this->ftpRow['cate_ftp_path'] . '/' . $arr_articleRow['article_path_name']);

        $_ftp_status = $this->obj_ftp->fileUpload($arr_articleRow['article_path'], '/' . $this->configRoute['article'] . '/' . $arr_articleRow['article_path_name']);

        if ($_ftp_status !== true) {
            return array(
                'msg'   => $this->obj_ftp->getError(),
                'rcode' => 'x070410',
            );
        }

        return true;
    }
}
