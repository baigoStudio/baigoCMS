<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------文章类-------------*/
class CONTROL_PUB_UI_ARTICLE {

    public $articleRow = array();
    public $cateRow    = array();
    public $config     = array();

    function __construct() { //构造函数
        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_article_pub  = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->mdl_link         = new MODEL_LINK();
        $this->mdl_attach       = new MODEL_ATTACH();
        $this->mdl_thumb        = new MODEL_THUMB();

        $this->article_init();

        $this->general_pub  = new GENERAL_PUB($this->config['tpl']);

        $this->obj_tpl  = $this->general_pub->obj_tpl;
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_show() {
        if ($this->articleId < 1) {
            $this->tplData['rcode'] = 'x120212';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if ($this->articleRow['rcode'] != 'y120102') {
            $this->obj_tpl->tplDisplay('error', $this->articleRow);
        }

        if (!isset($this->articleRow['article_title']) || fn_isEmpty($this->articleRow['article_title']) || $this->articleRow['article_status'] != 'pub' || $this->articleRow['article_box'] != 'normal' || ($this->articleRow['article_is_time_pub'] > 0 && $this->articleRow['article_time_pub'] > time()) || ($this->articleRow['article_is_time_hide'] > 0 && $this->articleRow['article_time_hide'] < time())) {
            $this->tplData['rcode'] = 'x120102';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (isset($this->articleRow['article_link']) && !fn_isEmpty($this->articleRow['article_link'])) {
            header('Location: ' . $this->articleRow['article_link']);
            exit;
        }

        if ($this->articleRow['article_cate_id'] < 1) {
            $this->tplData['rcode'] = 'x250217';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }


        if ($this->cateRow['rcode'] != 'y250102') {
            $this->obj_tpl->tplDisplay('error', $this->cateRow);
        }

        if ($this->cateRow['cate_status'] != 'show') {
            $this->tplData['rcode'] = 'x250102';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (isset($this->cateRow['cate_type']) && $this->cateRow['cate_type'] == 'link' && isset($this->cateRow['cate_link']) && !fn_isEmpty($this->cateRow['cate_link'])) {
            header('Location: ' . $this->cateRow['cate_link']);
            exit;
        }

        $_arr_searchTag = array(
            'status'        => 'show',
            'article_id'    => $this->articleRow['article_id'],
        );
        $this->articleRow['tagRows']    = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);
        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_cache();
        $_arr_cateRows                  = $this->mdl_cate->mdl_cache();
        $_arr_customRows                = $this->mdl_custom->mdl_cache();

        if ($this->articleRow['article_attach_id'] > 0) {
            $_arr_attachRow = $this->mdl_attach->mdl_url($this->articleRow['article_attach_id']);
            if ($_arr_attachRow['rcode'] == 'y070102') {
                if ($_arr_attachRow['attach_box'] != 'normal') {
                    $_arr_attachRow = array(
                        'rcode' => 'x070102',
                    );
                }
            }
            $this->articleRow['attachRow']   = $_arr_attachRow;
        }

        //print_r(date('W', strtotime('2014-12-01')));

        $this->mdl_article_pub->mdl_hits($this->articleRow['article_id']);

        $_arr_tagIds    = array();
        $_arr_assRows   = array();

        foreach ($this->articleRow['tagRows'] as $_key=>$_value) {
            $_arr_tagIds[] = $_value['tag_id'];
        }

        if (!fn_isEmpty($_arr_tagIds)) {
            $_arr_search = array(
                'tag_ids' => $_arr_tagIds,
            );
            $_arr_assRows = $this->mdl_article_pub->mdl_list(BG_SITE_ASSOCIATE, 0, $_arr_search);

            foreach ($_arr_assRows as $_key=>$_value) {
                $_arr_articleCateRow = $this->mdl_cate->mdl_cache($_value['article_cate_id']);
                $_arr_searchTag = array(
                    'status'        => 'show',
                    'tarticle_id'   => $_value['article_id'],
                );
                $_arr_assRows[$_key]['tagRows'] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

                if ($_value['article_attach_id'] > 0) {
                    $_arr_attachRow = $this->mdl_attach->mdl_url($_value['article_attach_id']);
                    if ($_arr_attachRow['rcode'] == 'y070102') {
                        if ($_arr_attachRow['attach_box'] != 'normal') {
                            $_arr_attachRow = array(
                                'rcode' => 'x070102',
                            );
                        }
                    }
                    $_arr_assRows[$_key]['attachRow']    = $_arr_attachRow;
                }

                $_arr_assRows[$_key]['cateRow']  = $_arr_articleCateRow;
                /*if ($_arr_articleCateRow['cate_trees'][0]['cate_domain']) {
                    $_arr_assRows[$_key]['urlRow']['article_url']  = $_arr_articleCateRow['cate_trees'][0]['cate_domain'] . '/' . $_value['urlRow']['article_url'];
                }*/
                $_arr_assRows[$_key]['urlRow']  = $this->mdl_cate->article_url_process($_value, $_arr_articleCateRow);
            }
        }

        $_arr_linkRows = $this->mdl_link->mdl_cache('auto');

        if (!fn_isEmpty($_arr_linkRows)) {
            foreach ($_arr_linkRows as $_key=>$_value) {
                $_str_link  = ' <a href=\'' . $_value['link_url'] . '\'';
                if (!fn_isEmpty($_value['link_blank'])) {
                    $_str_link .= ' target=\'_blank\'';
                }
                $_str_link .= '>' . $_value['link_name'] . '</a> ';
                $this->articleRow['article_content'] = str_ireplace($_value['link_name'], $_str_link, $this->articleRow['article_content']);
            }
        }

        $_arr_tpl = array(
            'cateRows'       => $_arr_cateRows,
            'customRows'     => $_arr_customRows['custom_list'],
            'articleRow'     => $this->articleRow,
            'associateRows'  => $_arr_assRows,
        );

        $this->obj_tpl->tplDisplay('article_show', $_arr_tpl);
    }


    /**
     * article_init function.
     *
     * @access private
     */
    private function article_init() {
        $this->config['tpl'] = BG_SITE_TPL;

        $_num_articleId = 0;

        switch (BG_VISIT_TYPE) {
            case 'static':
            case 'pstatic':
                if (isset($GLOBALS['route']['bg_query']) && !fn_isEmpty($GLOBALS['route']['bg_query'])) {
                    foreach ($GLOBALS['route']['bg_query'] as $_key=>$_value) {
                        if (stristr($_value, 'id-')) {
                            $_arr_articleId    = explode('-', $_value);
                            $_num_articleId    = fn_getSafe($_arr_articleId[1], 'int', 0);
                        }
                    }
                }
            break;

            default:
                $_num_articleId = fn_getSafe(fn_get('article_id'), 'int', 0);
            break;
        }

        $this->articleId = $_num_articleId;

        if ($this->articleId > 0) {
            $this->articleRow = $this->mdl_article_pub->mdl_read($this->articleId);
            if ($this->articleRow['rcode'] == 'y120102') {
                if ($this->articleRow['article_cate_id'] > 0) {
                    $this->cateRow = $this->mdl_cate->mdl_cache($this->articleRow['article_cate_id']);
                    if ($this->cateRow['rcode'] == 'y250102') {
                        if (isset($this->cateRow['cate_tplDo']) && !fn_isEmpty($this->cateRow['cate_tplDo'])) {
                            $this->config['tpl'] = $this->cateRow['cate_tplDo'];
                        }

                        $this->articleRow['urlRow']     = $this->mdl_cate->article_url_process($this->articleRow, $this->cateRow);
                        $this->articleRow['cateRow']    = $this->cateRow;
                    }
                }
            }
        }

        $_arr_customRows    = $this->mdl_custom->mdl_cache();
        $this->mdl_article_pub->custom_columns   = $_arr_customRows['article_customs'];
    }
}
