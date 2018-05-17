<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

class CONTROL_API_API_CALL {

    function __construct() { //构造函数
        $this->general_api          = new GENERAL_API();
        //$this->general_api->chk_install();

        $this->mdl_call         = new MODEL_CALL();
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_cate         = new MODEL_CATE();
        $this->mdl_article_pub  = new MODEL_ARTICLE_PUB();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象
        $this->mdl_attach       = new MODEL_ATTACH();
        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();
    }


    function ctrl_read() {
        $_arr_appChk = $this->general_api->app_chk_api();
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $_num_callId = fn_getSafe(fn_get('call_id'), 'int', 0);

        if ($_num_callId < 1) {
            $_arr_return = array(
                'rcode' => 'x170213',
            );
            $this->general_api->show_result($_arr_return);
        }

        $this->callRow = $this->mdl_call->mdl_read($_num_callId);

        if ($this->callRow['rcode'] != 'y170102') {
            $this->general_api->show_result($this->callRow);
        }


        if ($this->callRow['call_status'] != 'enable') {
            $_arr_return = array(
                'rcode' => 'x170102',
            );
            $this->general_api->show_result($_arr_return);
        }

        switch ($this->callRow['call_type']) {
            case 'spec':
                $_arr_return = $this->call_spec();
            break;

        //栏目列表
            case 'cate':
                $_arr_return = $this->call_cate();
            break;

            //TAG 列表
            case 'tag_list':
            case 'tag_rank':
                $_arr_return = $this->call_tag();
            break;

            case 'link':
                $_arr_return = $this->call_link();
            break;

            //文章列表
            default:
                $_arr_return = $this->call_article();
            break;
        }

        //print_r($_arr_return);

        $this->general_api->show_result($_arr_return, $_arr_appChk['isBase64']);
    }

    /**
     * call_cate function.
     *
     * @access public
     * @return void
     */
    private function call_cate() {
        $_arr_searchCate = array(
            'status'    => 'show',
            'excepts'   => $this->callRow['call_cate_excepts'],
            'parent_id' => $this->callRow['call_cate_id'],
        );

        $_arr_cateRows = $this->mdl_cate->mdl_listPub($this->callRow['call_amount']['top'], $this->callRow['call_amount']['except'], $_arr_searchCate);

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_call_cate', $_arr_cateRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_call_cate'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_call_cate'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_cateRows = $_arr_pluginReturnDo['return'];
            }
        }

        return $_arr_cateRows;
    }


    /**
     * call_spec function.
     *
     * @access public
     * @return void
     */
    private function call_spec() {
        $_arr_search = array(
            'status' => 'show',
        );
        $_arr_specRows = $this->mdl_spec->mdl_list($this->callRow['call_amount']['top'], $this->callRow['call_amount']['except'], $_arr_search);

        foreach ($_arr_specRows as $_key=>$_value) {
            unset($_arr_specRows[$_key]['urlRow']);
        }

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_call_spec', $_arr_specRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_call_spec'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_call_spec'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_specRows = $_arr_pluginReturnDo['return'];
            }
        }

        return $_arr_specRows;
    }


    private function call_link() {
        $_arr_searchLink = array(
            'status'        => 'enable',
            'type'          => 'friend',
        );
        $_arr_linkRows = $this->mdl_link->mdl_list($this->callRow['call_amount']['top'], $this->callRow['call_amount']['except'], $_arr_searchLink);

        foreach ($_arr_linkRows as $_key=>$_value) {
            unset($_arr_linkRows[$_key]['urlRow']);
        }

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_call_link', $_arr_linkRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_call_link'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_call_link'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_linkRows = $_arr_pluginReturnDo['return'];
            }
        }

        return $_arr_linkRows;
    }


    /**
     * call_tag function.
     *
     * @access public
     * @return void
     */
    private function call_tag() {
        $_arr_searchTag = array(
            'status'        => 'show',
            'type'          => $this->callRow['call_type'],
        );
        $_arr_tagRows = $this->mdl_tag->mdl_list($this->callRow['call_amount']['top'], $this->callRow['call_amount']['except'], $_arr_searchTag);

        foreach ($_arr_tagRows as $_key=>$_value) {
            unset($_arr_tagRows[$_key]['urlRow']);
        }

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_call_tag', $_arr_tagRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_call_tag'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_call_tag'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_tagRows = $_arr_pluginReturnDo['return'];
            }
        }

        return $_arr_tagRows;
    }


    /**
     * call_article function.
     *
     * @access public
     * @return void
     */
    private function call_article() {
        $_arr_search = array(
            'cate_ids'      => $this->callRow['call_cate_ids'],
            'mark_ids'      => $this->callRow['call_mark_ids'],
            'spec_ids'      => $this->callRow['call_spec_ids'],
            'attach_type'   => $this->callRow['call_attach'],
        );

        $_arr_articleRows = $this->mdl_article_pub->mdl_list($this->callRow['call_amount']['top'], $this->callRow['call_amount']['except'], $_arr_search, $this->callRow['call_type']);

        if (!fn_isEmpty($_arr_articleRows)) {
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
        }

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_call_article', $_arr_articleRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_call_article'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_call_article'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_articleRows = $_arr_pluginReturnDo['return'];
            }
        }

        return $_arr_articleRows;
    }
}
