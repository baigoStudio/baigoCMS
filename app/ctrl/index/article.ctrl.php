<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\index;

use app\classes\index\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Html;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Article extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_attach   = Loader::model('Attach');
        $this->mdl_article  = Loader::model('Article');
    }


    function index() {
        $_mix_init = $this->indexInit();

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

        $_arr_articleRow = $this->obj_index->articleRead($_num_articleId);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            return $this->error($_arr_articleRow['msg'], $_arr_articleRow['rcode']);
        }

        if (isset($_arr_articleRow['article_link']) && !Func::isEmpty($_arr_articleRow['article_link'])) {
            return $this->redirect($_arr_articleRow['article_link']);
        }

        $_arr_cateRow    = $this->obj_index->cateRead($_arr_articleRow['article_cate_id']);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        if (isset($_arr_cateRow['cate_link']) && !Func::isEmpty($_arr_cateRow['cate_link'])) {
            return $this->redirect($_arr_cateRow['cate_link']);
        }

        $_arr_tagRows    = $this->obj_index->tagLists($_num_articleId);

        $_arr_tagIds    = array();
        $_arr_assRows   = array();

        foreach ($_arr_tagRows as $_key=>$_value) {
            $_arr_tagIds[] = $_value['tag_id'];
        }

        if (!Func::isEmpty($_arr_tagIds)) {
            $_arr_assRows = $this->obj_index->assLists($_arr_tagIds);
        }

        $_arr_articleRow['article_content'] = $this->obj_index->linkProcess($_arr_articleRow['article_content'], $_arr_cateRow['cate_ids']);
        $_arr_articleRow['article_content'] = $this->obj_index->albumProcess($_arr_articleRow['article_content']);

        $this->mdl_article->hits($_arr_articleRow['article_id']);

        $_arr_tplData = array(
            'cateRow'       => $_arr_cateRow,
            'articleRow'    => $_arr_articleRow,
            'tagRows'       => $_arr_tagRows,
            'associateRows' => $_arr_assRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $_mix_result = Plugin::listen('filter_pub_article_show', $_arr_tpl);
        $_arr_tpl    = Plugin::resultProcess($_arr_tpl, $_mix_result);

        $this->assign($_arr_tpl);

        $_str_tpl = '';

        if (Func::isEmpty($_arr_articleRow['article_tpl']) || $_arr_articleRow['article_tpl'] === '-1') {
            $_str_tplDo = '';
            if (Func::isEmpty($_arr_cateRow['cate_tpl_do'])) {
                $_str_tplDo = $this->configBase['site_tpl'];
            } else {
                $_str_tplDo = $_arr_cateRow['cate_tpl_do'];
            }

            $_str_tpl = BG_TPL_INDEX . $_str_tplDo . DS . 'article' . DS . 'index';
        } else {
            $_str_tpl = BG_TPL_ARTICLE . $_arr_articleRow['article_tpl'];
        }

        $_str_tpl .= GK_EXT_TPL;

        return $this->fetch($_str_tpl);
    }
}
