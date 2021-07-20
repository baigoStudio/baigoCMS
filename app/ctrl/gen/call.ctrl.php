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
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------用户类-------------*/
class Call extends Ctrl {

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->configConsole    = $this->config['console'];

        $this->mdl_link     = Loader::model('Link');
        $this->mdl_tag      = Loader::model('Tag');
        $this->mdl_cate     = Loader::model('Cate');
        $this->mdl_spec     = Loader::model('Spec');

        $this->mdl_call     = Loader::model('Call');
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'overall'   => array('str', ''),
            'page'      => array('int', 1),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_callRows = array();

        $_arr_search['status'] ='enable';

        $_arr_pageRow    = $this->mdl_call->pagination($_arr_search, $this->configConsole['count_gen']);

        $_str_jump       = $this->url['route_gen'];

        if ($_arr_search['page'] > $_arr_pageRow['total']) {
            if ($_arr_search['overall'] == 'overall') {
                $_str_jump .= 'spec/index/';
            } else {
                return $this->error('Complete generation', 'y170406');
            }
        } else {
            $_str_jump .= 'call/index/page/' . ($_arr_search['page'] + 1) . '/';

            $_arr_callRows   = $this->mdl_call->lists(array($this->configConsole['count_gen'], $_arr_pageRow['offset'], 'limit'), $_arr_search);
        }

        if ($_arr_search['overall'] == 'overall') {
            $_str_jump .= 'overall/overall/';
        }

        $_str_jump .= 'view/iframe/';

        $_arr_tplData = array(
            'jump'      => $_str_jump,
            'callRows'  => $_arr_callRows,
            'token'     => $this->obj_request->token(),
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

        $_num_callId = 0;

        if (isset($this->param['id'])) {
            $_num_callId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_callId < 1) {
            return $this->error('Missing ID', 'x170202', 400);
        }

        $_arr_callRow = $this->mdl_call->read($_num_callId);

        if ($_arr_callRow['rcode'] != 'y170102') {
            return $this->error($_arr_callRow['msg'], $_arr_callRow['rcode'], 404);
        }

        if ($_arr_callRow['call_status'] != 'enable') {
            return $this->error('Call is valid', $_arr_callRow['rcode'], 404);
        }

        $_arr_tplData = array(
            'callRow'       => $_arr_callRow,
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

        $_arr_inputSubmit = $this->mdl_call->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y170201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        $_arr_callRow = $this->callRead($_arr_inputSubmit['call_id']);

        if ($_arr_callRow['rcode'] != 'y170102') {
            return $this->fetchJson($_arr_callRow['msg'], $_arr_callRow['rcode']);
        }

        $_arr_outResult = $this->output();

        if ($_arr_outResult['rcode'] != 'y170405') {
            return $this->fetchJson($_arr_outResult['msg'], $_arr_outResult['rcode']);
        }

        if ($this->ftpOpen) {
            $_mix_ftpResult = $this->ftpProcess($_arr_callRow);
            if ($_mix_ftpResult !== true) {
                return $this->fetchJson($_mix_ftpResult['msg'], $_mix_ftpResult['rcode']);
            }
        }

        return $this->fetchJson($_arr_outResult['msg'], $_arr_outResult['rcode']);
    }


    private function callRead($num_callId) {
        $_arr_callRow = $this->mdl_call->read($num_callId);

        if ($_arr_callRow['rcode'] != 'y170102') {
            return $_arr_callRow;
        }

        if ($_arr_callRow['call_status'] != 'enable') {
            return array(
                'rcode' => 'x170102',
                'msg'   => $_arr_callRow['msg'],
            );
        }

        $_arr_callRow = $this->mdl_call->pathProcess($_arr_callRow);

        $this->callRow = $_arr_callRow;

        return $_arr_callRow;
    }


    /**
     * cate function.
     *
     * @access public
     * @return void
     */
    private function callCate() {
        $_arr_callRow = $this->callRow;

        $_arr_cateRow = $this->obj_index->cateRead($_arr_callRow['call_cate_id']);

        $_arr_searchCate = array(
            'status'    => 'show',
            'top'       => $_arr_callRow['call_amount']['top'],
            'except'    => $_arr_callRow['call_amount']['except'],
            'not_ids'   => $_arr_callRow['call_cate_excepts'],
            'parent_id' => $_arr_callRow['call_cate_id'],
        );

        $_arr_cateRows = $this->obj_index->cateLists($_arr_searchCate);

        $_arr_return = array(
            'cateRow'   => $_arr_cateRow,
            'cateRows'  => $_arr_cateRows,
        );

        $_arr_return = Plugin::listen('filter_gen_call_cate', $_arr_return); //编辑文章时触发

        return $_arr_return;
    }


    /**
     * spec function.
     *
     * @access public
     * @return void
     */
    private function callSpec() {
        $_arr_callRow = $this->callRow;

        $_arr_searchSpec = array(
            'status' => 'show',
            'period' => $_arr_callRow['call_period_time'],
        );

        $_arr_specRows = $this->mdl_spec->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchSpec);

        $_arr_return = array(
            'specRows'  => $_arr_specRows,
        );

        $_arr_return = Plugin::listen('filter_gen_call_spec', $_arr_return); //编辑文章时触发

        return $_arr_return;
    }


    /**
     * tag function.
     *
     * @access public
     * @return void
     */
    private function callTag() {
        $_arr_callRow = $this->callRow;

        $_arr_searchTag = array(
            'status'    => 'show',
            'type'      => $_arr_callRow['call_type'],
        );

        $_arr_tagRows = $this->mdl_tag->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchTag);

        $_arr_return = array(
            'tagRows'  => $_arr_tagRows,
        );

        $_arr_return = Plugin::listen('filter_gen_call_tag', $_arr_return); //编辑文章时触发

        return $_arr_return;
    }


    private function callLink() {
        $_arr_callRow = $this->callRow;

        $_arr_searchLink = array(
            'status'    => 'enable',
            'type'      => 'friend',
            'cate_ids'  => $_arr_callRow['call_cate_ids'],
        );

        $_arr_linkRows = $this->mdl_link->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchLink);

        $_arr_return = array(
            'linkRows'  => $_arr_linkRows,
        );

        $_arr_return = Plugin::listen('filter_gen_call_link', $_arr_return); //编辑文章时触发

        return $_arr_return;
    }


    /**
     * article function.
     *
     * @access public
     * @return void
     */
    private function callArticle() {
        $_arr_callRow = $this->callRow;

        $_arr_search = array(
            'cate_ids'      => $_arr_callRow['call_cate_ids'],
            'mark_ids'      => $_arr_callRow['call_mark_ids'],
            'spec_ids'      => $_arr_callRow['call_spec_ids'],
            'attach_type'   => $_arr_callRow['call_attach'],
            'period'        => $_arr_callRow['call_period_time'],
        );

        if (Func::isEmpty($_arr_callRow['call_type']) || $_arr_callRow['call_type'] == 'article') {
            $_arr_order = array(
                array('article_top', 'DESC'),
                array('article_time_pub', 'DESC'),
                array('article_id', 'DESC'),
            );
            $_arr_group = array('article_top', 'article_time_pub', 'article_id');
        } else {
            $_arr_order = array(
                array('article_' . $_arr_callRow['call_type'], 'DESC'),
                array('article_time_pub', 'DESC'),
                array('article_id', 'DESC'),
            );
            $_arr_group = array('article_top', 'article_' . $_arr_callRow['call_type'], 'article_id');
        }

        $_mdl_articleSpecView   = Loader::model('Article_Spec_View');

        $_arr_articleRows = $_mdl_articleSpecView->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_search, $_arr_order, $_arr_group);

        $_arr_return = array(
            'articleRows'   => $this->obj_index->articleListsProcess($_arr_articleRows),
        );

        $_arr_return = Plugin::listen('filter_gen_call_article', $_arr_return); //编辑文章时触发

        return $_arr_return;
    }


    private function output() {
        $_arr_callRow = $this->callRow;

        switch ($_arr_callRow['call_type']) {
            //专题
            case 'spec':
                $_arr_tplData = $this->callSpec();
            break;

            //栏目列表
            case 'cate':
                $_arr_tplData = $this->callCate();
            break;

            //TAG 列表
            case 'tag_list':
            case 'tag_rank':
                $_arr_tplData = $this->callTag();
            break;

            case 'link':
                $_arr_tplData = $this->callLink();
            break;

            //文章列表
            default:
                $_arr_tplData = $this->callArticle();
            break;
        }

        $_arr_tplData['callRow'] = $_arr_callRow;

        $_str_tpl = BG_TPL_CALL . $_arr_callRow['call_tpl'] . GK_EXT_TPL;

        $_mix_outputResult = $this->outputProcess($_arr_tplData, $_arr_callRow['call_path'], BG_TPL_CALL, $_str_tpl);

        if (is_array($_mix_outputResult) && isset($_mix_outputResult['rcode'])) {
            return $_mix_outputResult;
        }

        if ($_mix_outputResult > 0) {
            $_arr_return = array(
                'rcode' => 'y170405',
                'msg'   => 'Generate call successfully',
            );
        } else {
            $_arr_return = array(
                'rcode' => 'x170405',
                'msg'   => 'Generate call failed',
            );
        }

        return $_arr_return;
    }


    private function ftpProcess($arr_callRow) {
        $_mdl_cate    = Loader::model('Cate', '', 'console');

        $_arr_ftpRows = $_mdl_cate->lists(array(1000, 'limit'));

        foreach ($_arr_ftpRows as $_key=>$_value) {
            $_config_ftp = array(
                'host' => $_value['cate_ftp_host'],
                'port' => $_value['cate_ftp_port'],
                'user' => $_value['cate_ftp_user'],
                'pass' => $_value['cate_ftp_pass'],
                'path' => $_value['cate_ftp_path'],
                'pasv' => $_value['cate_ftp_pasv'],
            );

            if (!Func::isEmpty($_config_ftp['host']) && !Func::isEmpty($_config_ftp['user']) && !Func::isEmpty($_config_ftp['pass'])) {
                $this->obj_ftp = Ftp::instance($_config_ftp);

                $_ftp_status = $this->obj_ftp->fileUpload($arr_callRow['call_path'], '/' . $this->configRoute['call'] . '/' . $arr_callRow['call_path_name']);

                if ($_ftp_status !== true) {
                    return array(
                        'msg'   => $this->obj_ftp->getError(),
                        'rcode' => 'x070410',
                    );
                }
            }
        }

        return true;
    }
}
