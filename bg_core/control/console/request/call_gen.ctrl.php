<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------用户类-------------*/
class CONTROL_CONSOLE_REQUEST_CALL_GEN {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_file          = new CLASS_FILE();
        $this->obj_file->perms = 0755;

        if (BG_MODULE_FTP > 0) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->mdl_call         = new MODEL_CALL();
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_cate         = new MODEL_CATE();
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->mdl_article_pub  = new MODEL_ARTICLE_PUB();
        $this->call_init();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_attach       = new MODEL_ATTACH();
        $this->mdl_thumb        = new MODEL_THUMB();
        $this->mdl_link         = new MODEL_LINK();
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function ctrl_single() {
        $_num_callId = fn_getSafe(fn_post('call_id'), 'int', 0); //ID

        if ($_num_callId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x170213',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_callRow = $this->mdl_call->mdl_read($_num_callId);
        if ($_arr_callRow['rcode'] != 'y170102') {
            $_arr_tplData = array(
                'rcode' => $_arr_callRow['rcode'],
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_callRow = $this->call_process($_arr_callRow);

        if ($_arr_callRow['rcode'] != 'y170102' || $_arr_callRow['call_status'] != 'enable') {
            $_arr_tplData = array(
                'rcode' => 'x170404',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $this->output_process($_arr_callRow);

        $_arr_tplData = array(
            'callRow'   => $_arr_callRow,
            'rcode'     => 'y170403',
        );

        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    private function call_process($arr_callRow) {
        if (fn_isEmpty($arr_callRow['call_tpl'])) {
            switch ($arr_callRow['call_type']) {
                case 'spec':
                    $arr_callRow['call_tpl'] = 'call_spec';
                break;

                //栏目列表
                case 'cate':
                    $arr_callRow['call_tpl'] = 'call_cate';
                break;

                //TAG 列表
                case 'tag_list':
                case 'tag_rank':
                    $arr_callRow['call_tpl'] = 'call_tag';
                break;

                case 'link':
                    $arr_callRow['call_tpl'] = 'call_link';
                break;

                //文章列表
                default:
                    $arr_callRow['call_tpl'] = 'call_article';
                break;
            }
        }

        if (fn_isEmpty($arr_callRow['call_file'])) {
            $arr_callRow['call_file'] = 'html';
        }
        return $arr_callRow;
    }


    private function output_process($arr_callRow) {
        switch ($arr_callRow['call_type']) {
            case 'spec':
                $_str_outPut = $this->output_spec($arr_callRow);
            break;

            //栏目列表
            case 'cate':
                $_str_outPut = $this->output_cate($arr_callRow);
            break;

            //TAG 列表
            case 'tag_list':
            case 'tag_rank':
                $_str_outPut = $this->output_tag($arr_callRow);
            break;

            case 'link':
                $_str_outPut = $this->output_link($arr_callRow);
            break;

            //文章列表
            default:
                $_str_outPut = $this->output_article($arr_callRow);
            break;
        }

        //print_r($arr_callRow);
        //exit;

        $_num_size = $this->obj_file->file_put($arr_callRow['urlRow']['call_path'] . $arr_callRow['call_id'] . '.' . $arr_callRow['call_file'], $_str_outPut);

        $_arr_searchCate = array(
            'status' => 'show',
        );
        $_arr_cateRows = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);
        foreach ($_arr_cateRows as $_key=>$_value) {
            if (BG_MODULE_FTP > 0 && isset($_value['cate_ftp_host']) && !fn_isEmpty($_value['cate_ftp_host'])) {
                if ($_value['cate_ftp_pasv'] == 'on') {
                    $_bool_pasv = true;
                } else {
                    $_bool_pasv = false;
                }
                $this->obj_ftp->ftp_conn($_value['cate_ftp_host'], $_value['cate_ftp_port']);
                $this->obj_ftp->ftp_login($_value['cate_ftp_user'], $_value['cate_ftp_pass'], $_bool_pasv);
                $_ftp_status = $this->obj_ftp->file_upload($arr_callRow['urlRow']['call_path'] . $arr_callRow['call_id'] . '.' . $arr_callRow['call_file'], $_value['cate_ftp_path'] . $arr_callRow['urlRow']['call_pathShort']);
                $this->obj_ftp->close();
            }
        }
    }


    /**
     * output_cate function.
     *
     * @access public
     */
    private function output_cate($arr_callRow) {
        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . 'call' . DS); //初始化视图对象

        $_arr_searchCate = array(
            'status'        => 'show',
            'excepts'       => $arr_callRow['call_cate_excepts'],
            'parent_id'     => $arr_callRow['call_cate_id'],
        );

        $_arr_cateRows = $this->mdl_cate->mdl_listPub($arr_callRow['call_amount']['top'], $arr_callRow['call_amount']['except'], $_arr_searchCate);

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_gen_call_cate', $_arr_cateRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_gen_call_cate'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_gen_call_cate'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_cateRows = $_arr_pluginReturnDo['return'];
            }
        }

        $_arr_tplData = array(
            'callRow'   => $arr_callRow,
            'cateRows'  => $_arr_cateRows,
        );

        $_str_outPut = $_obj_tpl->tplDisplay($arr_callRow['call_tpl'], $_arr_tplData, false);

        return $_str_outPut;
    }


    /**
     * output_spec function.
     *
     * @access public
     */
    private function output_spec($arr_callRow) {
        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . 'call' . DS); //初始化视图对象

        $_arr_searchSpec = array(
            'status'        => 'show',
        );

        $_arr_specRows = $this->mdl_spec->mdl_list($arr_callRow['call_amount']['top'], $arr_callRow['call_amount']['except'], $_arr_searchSpec);

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_gen_call_spec', $_arr_specRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_gen_call_spec'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_gen_call_spec'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_specRows = $_arr_pluginReturnDo['return'];
            }
        }

        $_arr_tplData = array(
            'callRow'   => $arr_callRow,
            'specRows'  => $_arr_specRows,
        );

        $_str_outPut = $_obj_tpl->tplDisplay($arr_callRow['call_tpl'], $_arr_tplData, false);

        return $_str_outPut;
    }


    private function output_link($arr_callRow) {
        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . 'call' . DS); //初始化视图对象

        $_arr_searchLink = array(
            'status'    => 'enable',
            'type'      => 'friend',
        );
        $_arr_linkRows = $this->mdl_link->mdl_list($arr_callRow['call_amount']['top'], $arr_callRow['call_amount']['except'], $_arr_searchLink);

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_gen_call_link', $_arr_linkRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_gen_call_link'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_gen_call_link'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_linkRows = $_arr_pluginReturnDo['return'];
            }
        }

        $_arr_tplData = array(
            'callRow'   => $arr_callRow,
            'linkRows'  => $_arr_linkRows,
        );

        $_str_outPut = $_obj_tpl->tplDisplay($arr_callRow['call_tpl'], $_arr_tplData, false);

        return $_str_outPut;
    }


    /**
     * output_tag function.
     *
     * @access public
     */
    private function output_tag($arr_callRow) {
        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . 'call' . DS); //初始化视图对象

        $_arr_searchTag = array(
            'status'        => 'show',
            'article_id'    => $arr_callRow['call_type'],
        );
        $_arr_tagRows = $this->mdl_tag->mdl_list($arr_callRow['call_amount']['top'], $arr_callRow['call_amount']['except'], $_arr_searchTag);

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_gen_call_tag', $_arr_tagRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_gen_call_tag'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_gen_call_tag'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_tagRows = $_arr_pluginReturnDo['return'];
            }
        }

        $_arr_tplData = array(
            'callRow'   => $arr_callRow,
            'tagRows'   => $_arr_tagRows,
        );

        $_str_outPut = $_obj_tpl->tplDisplay($arr_callRow['call_tpl'], $_arr_tplData, false);

        return $_str_outPut;
    }


    /**
     * output_article function.
     *
     * @access public
     */
    private function output_article($arr_callRow) {
        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . 'call' . DS); //初始化视图对象

        $_arr_search = array(
            'cate_ids'      => $arr_callRow['call_cate_ids'],
            'mark_ids'      => $arr_callRow['call_mark_ids'],
            'spec_ids'      => $arr_callRow['call_spec_ids'],
            'attach_type'   => $arr_callRow['call_attach'],
        );

        $_arr_articleRows = $this->mdl_article_pub->mdl_list($arr_callRow['call_amount']['top'], $arr_callRow['call_amount']['except'], $_arr_search, $arr_callRow['call_type']);

        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_list(100);

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleCateRow = $this->mdl_cate->mdl_readPub($_value['article_cate_id']);
            $_arr_articleCateRow = $this->cate_process($_arr_articleCateRow);
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

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_gen_call_article', $_arr_articleRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_gen_call_article'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_gen_call_article'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_articleRows = $_arr_pluginReturnDo['return'];
            }
        }

        $_arr_tplData = array(
            'callRow'       => $arr_callRow,
            'articleRows'   => $_arr_articleRows,
        );

        $_str_outPut = $_obj_tpl->tplDisplay($arr_callRow['call_tpl'], $_arr_tplData, false);

        return $_str_outPut;
    }


    private function cate_process($arr_cateRow) {
        $arr_cateRow['cate_tplDo'] = $this->mdl_cate->tpl_process($arr_cateRow['cate_id']);
        $arr_cateRow['cate_ids']   = $this->mdl_cate->mdl_ids($arr_cateRow['cate_id']);
        if (!fn_isEmpty($arr_cateRow['cate_trees'])) {
            foreach ($arr_cateRow['cate_trees'] as $_key_tree=>$_value_tree) {
                $_arr_cate = $this->mdl_cate->mdl_readPub($_value_tree['cate_id']);
                $arr_cateRow['cate_trees'][$_key_tree]['urlRow'] = $_arr_cate['urlRow'];
            }
        }

        return $arr_cateRow;
    }


    private function call_init() {
        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_column_custom = $this->mdl_custom->mdl_column_custom();
        $this->mdl_article_pub->custom_columns   = $_arr_column_custom;
    }
}
