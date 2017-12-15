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
class CONTROL_PUB_UI_TAG {

    function __construct() { //构造函数
        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->mdl_article_pub  = new MODEL_ARTICLE_PUB();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_attach       = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象

        $this->tag_init();

        $this->general_pub  = new GENERAL_PUB($this->config['tpl']);

        $this->obj_tpl  = $this->general_pub->obj_tpl;
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_show() {
        $_str_tagName = '';

        switch (BG_VISIT_TYPE) {
            case 'static':
            case 'pstatic':
                if (isset($GLOBALS['route']['bg_query']) && !fn_isEmpty($GLOBALS['route']['bg_query'])) {
                    foreach ($GLOBALS['route']['bg_query'] as $_key=>$_value) {
                        if (stristr($_value, 'tag-')) {
                            $_arr_tagName    = explode('-', $_value);
                            $_str_tagName    = fn_getSafe($_arr_tagName[1], 'txt', '');
                        }

                        if (stristr($_value, 'page-')) {
                            $_arr_page   = explode('-', $_value);
                            $_num_page   = fn_getSafe($_arr_page[1], 'int', 1);
                        }
                    }
                }
            break;

            default:
                $_str_tagName   = fn_getSafe(fn_get('tag_name'), 'txt', '');
                $_num_page      = fn_getSafe(fn_get('page'), 'int', 1);
            break;
        }

        if (fn_isEmpty($_str_tagName)) {
            $this->tplData['rcode'] = 'x130201';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_tagRow = $this->mdl_tag->mdl_read($_str_tagName, 'tag_name');

        if ($_arr_tagRow['rcode'] != 'y130102') {
            $this->obj_tpl->tplDisplay('error', $_arr_tagRow);
        }

        if ($_arr_tagRow['tag_status'] != 'show') {
            $this->tplData['rcode'] = 'x130102';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'tag_ids' => array($_arr_tagRow['tag_id']),
        );

        $_arr_articleRows     = array();

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

        //统计 tag 文章数
        $this->mdl_tag->mdl_countDo($_arr_tagRow['tag_id'], $_num_articleCount); //更新

        $_arr_tplData = array(
            'pageRow'        => $_arr_page,
            'tagRow'         => $_arr_tagRow,
            'articleRows'    => $_arr_articleRows,
            'cateRows'       => $this->cateRows,
            'customRows'     => $this->customRows['custom_list'],
        );

        $this->obj_tpl->tplDisplay('tag_show', $_arr_tplData);
    }


    private function tag_init() {
        $this->config['tpl'] = BG_SITE_TPL;

        $this->cateRows     = $this->mdl_cate->mdl_cache();
        $this->customRows   = $this->mdl_custom->mdl_cache();
        $this->mdl_article_pub->custom_columns   = $this->customRows['article_customs'];
    }
}
