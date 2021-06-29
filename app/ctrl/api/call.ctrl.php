<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\api;

use app\classes\api\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

class Call extends Ctrl {

    function read() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_return   = array();

        $_num_callId   = $this->obj_request->get('call_id', 'int', 0);

        if ($_num_callId < 1) {
            return $this->fetchJson('Missing ID', 'x170202', 400);
        }

        $_arr_callRow  = $this->obj_index->callRead($_num_callId);

        if ($_arr_callRow['rcode'] != 'y170102') {
            return $this->fetchJson($_arr_callRow['msg'], $_arr_callRow['rcode'], 404);
        }

        $this->callRow  = $_arr_callRow;

        switch ($_arr_callRow['call_type']) {
            //专题
            case 'spec':
                $_arr_return = $this->callSpec();
            break;

            //栏目列表
            case 'cate':
                $_arr_return = $this->callCate();
            break;

            //TAG 列表
            case 'tag_list':
            case 'tag_rank':
                $_arr_return = $this->callTag();
            break;

            case 'link':
                $_arr_return = $this->callLink();
            break;

            //文章列表
            default:
                $_arr_return = $this->callArticle();
            break;
        }

        $_arr_return['callRow'] = $_arr_callRow;

        return $this->json($_arr_return);
    }


    /**
     * cate function.
     *
     * @access public
     * @return void
     */
    private function callCate() {
        $_arr_callRow = $this->callRow;

        $_arr_cateRow  = $this->obj_index->cateRead($_arr_callRow['call_cate_id']);

        $_arr_searchCate = array(
            'status'    => 'show',
            'top'       => $_arr_callRow['call_amount']['top'],
            'except'    => $_arr_callRow['call_amount']['except'],
            'excepts'   => $_arr_callRow['call_cate_excepts'],
            'parent_id' => $_arr_callRow['call_cate_id'],
        );

        $_arr_cateRows = $this->obj_index->cateLists($_arr_searchCate);

        $_arr_return = array(
            'cateRow'   => $_arr_cateRow,
            'cateRows'  => $_arr_cateRows,
        );

        $_arr_return = Plugin::listen('filter_api_call_cate', $_arr_return); //编辑文章时触发

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

        $_mdl_spec     = Loader::model('Spec');

        $_arr_specRows = $_mdl_spec->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchSpec);

        $_arr_return = array(
            'specRows'  => $_arr_specRows,
        );

        $_arr_return = Plugin::listen('filter_api_call_spec', $_arr_return); //编辑文章时触发

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
            'status'    => $_arr_callRow['call_type'],
        );

        $_mdl_tag = Loader::model('Tag');

        $_arr_tagRows = $_mdl_tag->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchTag);

        $_arr_return = array(
            'tagRows'  => $_arr_tagRows,
        );

        $_arr_return = Plugin::listen('filter_api_call_tag', $_arr_return); //编辑文章时触发

        return $_arr_return;
    }


    private function callLink() {
        $_arr_callRow = $this->callRow;

        $_arr_searchLink = array(
            'status'    => 'enable',
            'type'      => 'friend',
            'cate_ids'  => $_arr_callRow['call_cate_ids'],
        );

        $_mdl_link     = Loader::model('Link');

        $_arr_linkRows = $_mdl_link->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchLink);

        $_arr_return = array(
            'linkRows'  => $_arr_linkRows,
        );

        $_arr_return = Plugin::listen('filter_api_call_link', $_arr_return); //编辑文章时触发

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
            'articleRows'   => $this->obj_index->articleListsProcess($_arr_articleRows, false),
        );

        $_arr_return = Plugin::listen('filter_api_call_article', $_arr_return); //编辑文章时触发

        return $_arr_return;
    }
}
