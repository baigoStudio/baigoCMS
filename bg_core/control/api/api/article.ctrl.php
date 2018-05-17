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
class CONTROL_API_API_ARTICLE {

    function __construct() { //构造函数
        $this->general_api          = new GENERAL_API();
        //$this->general_api->chk_install();

        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_custom       = new MODEL_CUSTOM();
        $_arr_customRows        = $this->mdl_custom->mdl_cache();

        $this->mdl_article_pub   = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->mdl_article_pub->custom_columns   = $_arr_customRows['article_customs'];

        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象

        $this->mdl_attach       = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();
    }


    function ctrl_hits() {
        $_num_articleId   = fn_getSafe(fn_get('article_id'), 'int', 0);

        if ($_num_articleId < 1) {
            $_arr_return = array(
                'rcode' => 'x120212',
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_articleRow = $this->mdl_article_pub->mdl_read($_num_articleId);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            $this->general_api->show_result($_arr_articleRow);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_cache($_arr_articleRow['article_cate_id']);
        if ($_arr_cateRow['rcode'] != 'y250102') {
            $this->general_api->show_result($_arr_cateRow);
        }

        if ($_arr_cateRow['cate_status'] != 'show') {
            $_arr_return = array(
                'rcode' => 'x250102',
            );
            $this->general_api->show_result($_arr_return);
        }

        if (isset($_arr_cateRow['cate_type']) && $_arr_cateRow['cate_type'] == 'link' && isset($_arr_cateRow['cate_link']) && !fn_isEmpty($_arr_cateRow['cate_link'])) {
            $_arr_return = array(
                'rcode' => 'x250218',
            );
            $this->general_api->show_result($_arr_return);
        }

        if (fn_isEmpty($_arr_articleRow['article_title']) || $_arr_articleRow['article_status'] != 'pub' || $_arr_articleRow['article_box'] != 'normal' || ($_arr_articleRow['article_is_time_pub'] > 0 && $_arr_articleRow['article_time_pub'] > time()) || ($_arr_articleRow['article_is_time_hide'] > 0 && $_arr_articleRow['article_time_hide'] < time())) {
            $_arr_return = array(
                'rcode' => 'x120102',
            );
            $this->general_api->show_result($_arr_return);
        }

        if (!fn_isEmpty($_arr_articleRow['article_link'])) {
            $_arr_return = array(
                'rcode'         => 'x120213',
            );
            $this->general_api->show_result($_arr_return);
        }

        $this->mdl_article_pub->mdl_hits($_arr_articleRow['article_id']);

        $_arr_return = array(
            'rcode' => 'y120405',
        );
        $this->general_api->show_result($_arr_return, $_arr_appChk['isBase64']);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_read() {
        $_arr_appChk = $this->general_api->app_chk_api();
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $_num_articleId   = fn_getSafe(fn_get('article_id'), 'int', 0);

        if ($_num_articleId < 1) {
            $_arr_return = array(
                'rcode' => 'x120212',
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_articleRow = $this->mdl_article_pub->mdl_read($_num_articleId);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            $this->general_api->show_result($_arr_articleRow);
        }

        unset($_arr_articleRow['urlRow']);

        $_arr_cateRow = $this->mdl_cate->mdl_cache($_arr_articleRow['article_cate_id']);
        if ($_arr_cateRow['rcode'] != 'y250102') {
            $this->general_api->show_result($_arr_cateRow);
        }

        if ($_arr_cateRow['cate_status'] != 'show') {
            $_arr_return = array(
                'rcode' => 'x250102',
            );
            $this->general_api->show_result($_arr_return);
        }

        unset($_arr_cateRow['urlRow']);

        if ($_arr_cateRow['cate_type'] == 'link' && !fn_isEmpty($_arr_cateRow['cate_link'])) {
            $_arr_return = array(
                'rcode' => 'x250218',
                'cate_link' => $_arr_cateRow['cate_link'],
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_articleRow['cateRow'] = $_arr_cateRow;

        if (fn_isEmpty($_arr_articleRow['article_title']) || $_arr_articleRow['article_status'] != 'pub' || $_arr_articleRow['article_box'] != 'normal' || ($_arr_articleRow['article_is_time_pub'] > 0 && $_arr_articleRow['article_time_pub'] > time()) || ($_arr_articleRow['article_is_time_hide'] > 0 && $_arr_articleRow['article_time_hide'] < time())) {
            $_arr_return = array(
                'rcode' => 'x120102',
            );
            $this->general_api->show_result($_arr_return);
        }

        if (!fn_isEmpty($_arr_articleRow['article_link'])) {
            $_arr_return = array(
                'rcode'         => 'x120213',
                'article_link'  => $_arr_articleRow['article_link'],
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_searchTag = array(
            'status'        => 'show',
            'article_id'    => $_arr_articleRow['article_id'],
        );
        $_arr_articleRow['tagRows'] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

        if ($_arr_articleRow['article_attach_id'] > 0) {
            $_arr_attachRow = $this->mdl_attach->mdl_url($_arr_articleRow['article_attach_id']);

            if ($_arr_attachRow['rcode'] == 'y070102') {
                if ($_arr_attachRow['attach_box'] != 'normal') {
                    $_arr_attachRow = array(
                        'rcode' => 'x070102',
                    );
                }
            }

            $_arr_articleRow['attachRow']    = $_arr_attachRow;
        }

        $this->mdl_article_pub->mdl_hits($_arr_articleRow['article_id']);

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_article_read', $_arr_articleRow); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_article_read'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_article_read'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_articleRow = $_arr_pluginReturnDo['return'];
            }
        }

        $this->general_api->show_result($_arr_articleRow, $_arr_appChk['isBase64']);
    }



    function ctrl_list() {
        $_arr_appChk = $this->general_api->app_chk_api();
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $_str_markIds   = fn_getSafe(fn_get('mark_ids'), 'txt', '');
        $_str_tagIds    = fn_getSafe(fn_get('tag_ids'), 'txt', '');
        $_str_specIds   = fn_getSafe(fn_get('spec_ids'), 'txt', '');
        $_str_customs   = fn_getSafe(fn_get('customs'), 'txt', '');
        $_num_cateId    = fn_getSafe(fn_get('cate_id'), 'int', 0);
        $_num_perPage   = fn_getSafe(fn_get('per_page'), 'int', BG_SITE_PERPAGE);

        $_arr_markIds   = array();
        $_arr_tagIds    = array();
        $_arr_specIds   = array();
        $_arr_customs   = array();

        if (!fn_isEmpty($_str_markIds)) {
            if (stristr($_str_markIds, '|')) {
                $_arr_markIds = explode('|', $_str_markIds);
            } else {
                $_arr_markIds = array($_str_markIds);
            }
        }
        if (!fn_isEmpty($_str_tagIds)) {
            if (stristr($_str_tagIds, '|')) {
                $_arr_tagIds  = explode('|', $_str_tagIds);
            }
        }
        if (!fn_isEmpty($_str_specIds)) {
            if (stristr($_str_specIds, '|')) {
                $_arr_specIds  = explode('|', $_str_specIds);
            }
        }
        $_str_customs = urldecode($_str_customs);
        $_str_customs = fn_htmlcode($_str_customs, 'decode', 'base64');
        $_str_customs = base64_decode($_str_customs);
        $_str_customs = urldecode($_str_customs);
        if (stristr($_str_customs, '&')) {
            $_arr_customs = explode('&', $_str_customs);
        } else {
            $_arr_customs = array($_str_customs);
        }

        $_arr_customSearch = array();
        if (!fn_isEmpty($_arr_customs)) {
            foreach ($_arr_customs as $_key=>$_value) {
                if (stristr($_value, '=')) {
                    $_arr_customRow = explode('=', $_value);
                    if (isset($_arr_customRow[0]) && isset($_arr_customRow[1])) {
                        $_arr_customSearch[$_arr_customRow[0]] = $_arr_customRow[1];
                    }
                }
            }
        }

        $_arr_cateIds = array();
        $_arr_cateRow = $this->mdl_cate->mdl_cache($_num_cateId);

        if ($_num_cateId > 0) {
            if ($_arr_cateRow['rcode'] == 'y250102' && $_arr_cateRow['cate_status'] == 'show') {
                $_arr_cateIds = $_arr_cateRow['cate_ids'];
            }
        }

        $_arr_search = array(
            'key'           => fn_getSafe(fn_get('key'), 'txt', ''),
            'year'          => fn_getSafe(fn_get('year'), 'txt', ''),
            'month'         => fn_getSafe(fn_get('month'), 'txt', ''),
            'spec_ids'      => $_arr_specIds,
            'cate_ids'      => $_arr_cateIds,
            'mark_ids'      => $_arr_markIds,
            'tag_ids'       => $_arr_tagIds,
            'custom_rows'   => $_arr_customSearch,
        );

        $_num_articleCount    = $this->mdl_article_pub->mdl_count($_arr_search);
        $_arr_page            = fn_page($_num_articleCount, $_num_perPage); //取得分页数据
        $_arr_articleRows     = $this->mdl_article_pub->mdl_list($_num_perPage, $_arr_page['except'], $_arr_search);

        foreach ($_arr_articleRows as $_key=>$_value) {
            unset($_arr_articleRows[$_key]['urlRow']['article_url']);

            $_arr_cateRow = $this->mdl_cate->mdl_cache($_value['article_cate_id']);

            if ($_arr_cateRow['rcode'] == 'y250102') {
                unset($_arr_cateRow['urlRow']);
            }
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
            $_arr_articleRows[$_key]['cateRow'] = $_arr_cateRow;
        }

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_article_list', $_arr_articleRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_article_list'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_article_list'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_articleRows = $_arr_pluginReturnDo['return'];
            }
        }

        $_arr_return = array(
            'pageRow'        => $_arr_page,
            'articleRows'    => $_arr_articleRows,
        );

        //print_r($_arr_appChk);

        $this->general_api->show_result($_arr_return, $_arr_appChk['isBase64']);
    }
}
