<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\index;

use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');


/*-------------控制中心通用控制器-------------*/
class Call {

    function __construct() { //构造函数
        $this->obj_index    = Loader::classes('Index', '', false);

        $this->mdl_attach   = Loader::model('Attach');
    }

    function cate($num_cateId) {
        $_arr_cateRow   = $this->obj_index->cateRead($num_cateId);

        return $_arr_cateRow;
    }

    function attach($num_attachId) {
        $_arr_attachRow = array();
        $_arr_attachRow = $this->mdl_attach->read($num_attachId);

        return $_arr_attachRow;
    }

    function get($num_callId) {
        $_arr_return    = array();

        $_mdl_call = Loader::model('Call');

        $_arr_callRow   = $_mdl_call->read($num_callId);

        if ($_arr_callRow['rcode'] == 'y170102') {
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
        }

        $_arr_return['callRow'] = $_arr_callRow;

        return $_arr_return;
    }


    /**
     * cate function.
     *
     * @access public
     * @return void
     */
    private function callCate() {
        $_arr_callRow = $this->callRow;

        $_arr_searchCate = array(
            'status'    => 'show',
            'top'       => $_arr_callRow['call_amount']['top'],
            'except'    => $_arr_callRow['call_amount']['except'],
            'excepts'   => $_arr_callRow['call_cate_excepts'],
            'parent_id' => $_arr_callRow['call_cate_id'],
        );

        $_arr_cateRow = $this->obj_index->cateRead($_arr_callRow['call_cate_id']);

        $_arr_cateRows = $this->obj_index->cateLists($_arr_searchCate);

        $_arr_return = array(
            'cateRow'   => $_arr_cateRow,
            'cateRows'  => $_arr_cateRows,
        );

        $_mix_result = Plugin::listen('filter_pub_call_cate', $_arr_return); //编辑文章时触发
        $_arr_return = Plugin::resultProcess($_arr_return, $_mix_result);

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
            'status'    => 'show',
            'period'    => $_arr_callRow['call_period_time'],
        );

        $_mdl_spec = Loader::model('Spec');

        $_arr_specRows = $_mdl_spec->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchSpec);

        $_arr_return = array(
            'specRows'  => $_arr_specRows,
        );

        $_mix_result = Plugin::listen('filter_pub_call_spec', $_arr_return); //编辑文章时触发
        $_arr_return = Plugin::resultProcess($_arr_return, $_mix_result);

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

        $_mdl_tag = Loader::model('Tag');

        $_arr_tagRows = $_mdl_tag->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchTag);

        foreach ($_arr_tagRows as $_key=>&$_value) {
            $_value['tag_url'] = $_mdl_tag->urlProcess($_value);
        }

        $_arr_return = array(
            'tagRows'  => $_arr_tagRows,
        );

        $_mix_result = Plugin::listen('filter_pub_call_tag', $_arr_return); //编辑文章时触发
        $_arr_return = Plugin::resultProcess($_arr_return, $_mix_result);

        return $_arr_return;
    }


    private function callLink() {
        $_arr_callRow = $this->callRow;

        $_arr_searchLink = array(
            'status'    => 'enable',
            'type'      => 'friend',
        );

        $_mdl_link = Loader::model('Link');

        $_arr_linkRows = $_mdl_link->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_searchLink);

        $_arr_return = array(
            'linkRows'  => $_arr_linkRows,
        );

        $_mix_result = Plugin::listen('filter_pub_call_link', $_arr_return); //编辑文章时触发
        $_arr_return = Plugin::resultProcess($_arr_return, $_mix_result);

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
            $_arr_group = array('article_' . $_arr_callRow['call_type'], 'article_time_pub', 'article_id');
        }

        $_mdl_articleSpecView   = Loader::model('Article_Spec_View');

        $_arr_articleRows = $_mdl_articleSpecView->lists(array($_arr_callRow['call_amount']['top'], $_arr_callRow['call_amount']['except'], 'limit'), $_arr_search, $_arr_order, $_arr_group);

        $_arr_return = array(
            'articleRows' => $this->obj_index->articleListsProcess($_arr_articleRows),
        );

        $_mix_result = Plugin::listen('filter_pub_call_article', $_arr_return); //编辑文章时触发
        $_arr_return = Plugin::resultProcess($_arr_return, $_mix_result);

        return $_arr_return;
    }
}
