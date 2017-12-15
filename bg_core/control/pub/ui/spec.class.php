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
class CONTROL_PUB_UI_SPEC {

    function __construct() { //构造函数
        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_article_pub  = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_attach       = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象

        $this->spec_init();

        $this->general_pub  = new GENERAL_PUB($this->config['tpl']);

        $this->obj_tpl  = $this->general_pub->obj_tpl;
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_show() {
        $_num_specId = 0;

        switch (BG_VISIT_TYPE) {
            case 'static':
            case 'pstatic':
                if (isset($GLOBALS['route']['bg_query']) && !fn_isEmpty($GLOBALS['route']['bg_query'])) {
                    foreach ($GLOBALS['route']['bg_query'] as $_key=>$_value) {
                        if (stristr($_value, 'id-')) {
                            $_arr_specId   = explode('-', $_value);
                            $_num_specId   = fn_getSafe($_arr_specId[1], 'int', 1);
                        }

                        if (stristr($_value, 'page-')) {
                            $_arr_page   = explode('-', $_value);
                            $_num_page   = fn_getSafe($_arr_page[1], 'int', 1);
                        }
                    }
                }
            break;

            default:
                $_num_specId    = fn_getSafe(fn_get('spec_id'), 'int', 0);
                $_num_page      = fn_getSafe(fn_get('page'), 'int', 1);
            break;
        }

        if ($_num_specId < 1) {
            $this->tplData['rcode'] = 'x180204';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
        if ($_arr_specRow['rcode'] != 'y180102') {
            $this->obj_tpl->tplDisplay('error', $_arr_specRow);
        }

        if ($_arr_specRow['spec_status'] != 'show') {
            $this->tplData['rcode'] = 'x180102';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search['spec_ids'] = array($_num_specId);

        $_num_articleCount    = $this->mdl_article_pub->mdl_count($_arr_search);
        $_arr_page            = fn_page($_num_articleCount, BG_SITE_PERPAGE, $_num_page); //取得分页数据
        $_arr_articleRows     = $this->mdl_article_pub->mdl_list(BG_SITE_PERPAGE, $_arr_page['except'], $_arr_search);

        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleCateRow = $this->mdl_cate->mdl_cache($_value['article_cate_id']);

            $_arr_searchTag = array(
                'status'        => 'show',
                'article_id'    => $_value['article_id'],
            );
            $_arr_articleRows[$_key]['tagRows'] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

            if ($_value['article_attach_id'] > 0) {
                $_arr_attachRow = $this->mdl_attach->mdl_url($_value['article_attach_id']);
                if ($_arr_attachRow['rcode'] == 'y070102') {
                    if ($_arr_attachRow['attach_box'] != 'normal') {
                        $_arr_attachRow = array(
                            'rcode' => 'x070102',
                        );
                    }
                }
                $_arr_articleRows[$_key]['attachRow']    = $_arr_attachRow;
            }

            $_arr_articleRows[$_key]['cateRow']  = $_arr_articleCateRow;
            /*if ($_arr_articleCateRow['cate_trees'][0]['cate_domain']) {
                $_arr_articleRows[$_key]['urlRow']['article_url']  = $_arr_articleCateRow['cate_trees'][0]['cate_domain'] . '/' . $_value['urlRow']['article_url'];
            }*/
            $_arr_articleRows[$_key]['urlRow']  = $this->mdl_cate->article_url_process($_value, $_arr_articleCateRow);
        }

        $_arr_tpl = array(
            'pageRow'       => $_arr_page,
            'specRow'       => $_arr_specRow,
            'articleRows'   => $_arr_articleRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('spec_show', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        $_str_key   = '';
        $_num_page  = 1;

        switch (BG_VISIT_TYPE) {
            case 'static':
            case 'pstatic':
                if (isset($GLOBALS['route']['bg_query']) && !fn_isEmpty($GLOBALS['route']['bg_query'])) {
                    foreach ($GLOBALS['route']['bg_query'] as $_key=>$_value) {
                        if (stristr($_value, 'key-')) {
                            $_arr_key   = explode('-', $_value);
                            $_str_key   = fn_getSafe($_arr_key[1], 'txt', '');
                        }

                        if (stristr($_value, 'page-')) {
                            $_arr_page   = explode('-', $_value);
                            $_num_page   = fn_getSafe($_arr_page[1], 'int', 1);
                        }
                    }
                }
            break;

            default:
                $_str_key   = fn_getSafe(fn_get('key'), 'txt', '');
                $_num_page  = fn_getSafe(fn_get('page'), 'int', 1);
            break;
        }

        $_arr_search = array(
            'status'    => 'show',
            'key'       => urldecode($_str_key),
        );

        $_num_specCount = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page      = fn_page($_num_specCount, BG_SITE_PERPAGE, $_num_page); //取得分页数据
        $_str_query     = http_build_query($_arr_search);
        $_arr_specRows  = $this->mdl_spec->mdl_list(BG_SITE_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'search'        => $_arr_search,
            'query'         => $_str_query,
            'pageRow'       => $_arr_page,
            'specRows'      => $_arr_specRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('spec_list', $_arr_tplData);
    }


    private function spec_init() {
        $this->config['tpl'] = BG_SITE_TPL;

        $_arr_cateRows      = $this->mdl_cate->mdl_cache();
        $_arr_customRows    = $this->mdl_custom->mdl_cache();
        $this->mdl_article_pub->custom_columns   = $_arr_customRows['article_customs'];
        $this->urlRow       = $this->mdl_spec->url_process_global();

        $this->tplData = array(
            'urlRow'        => $this->urlRow,
            'cateRows'      => $_arr_cateRows,
            'customRows'    => $_arr_customRows['custom_list'],
        );
    }
}
