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
class CONTROL_CONSOLE_REQUEST_CATE_GEN {

    private $mdl_cate;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_file      = new CLASS_FILE();
        $this->obj_file->perms = 0755;

        if (BG_MODULE_FTP > 0) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->mdl_cate                 = new MODEL_CATE();
        $this->mdl_custom               = new MODEL_CUSTOM();
        $this->mdl_article_pub          = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->cate_init();
        $this->mdl_tag                  = new MODEL_TAG();
        $this->mdl_attach               = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_thumb                = new MODEL_THUMB(); //设置上传信息对象
        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_list(100);
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function ctrl_single() {
        $_num_cateId    = fn_getSafe(fn_post('cate_id'), 'int', 0); //ID
        $_num_page      = fn_getSafe(fn_post('page'), 'int', 0);

        if ($_num_cateId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x250217',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_readPub($_num_cateId);
        if ($_arr_cateRow['rcode'] != 'y250102') {
            $_arr_tplData = array(
                'rcode' => $_arr_cateRow['rcode'],
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if ($_arr_cateRow['cate_status'] != 'show' || ($_arr_cateRow['cate_type'] == 'link' && !fn_isEmpty($_arr_cateRow['cate_link']))) {
            $_arr_tplData = array(
                'rcode' => 'x250404',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_cateRow   = $this->cate_process($_arr_cateRow);
        $_arr_page      = $this->data_process($_arr_cateRow);

        if ($_num_page <= $_arr_page['total']) {
            $this->output_process($_arr_cateRow, $_arr_page);
            //print_r($_arr_cateIds);
        }

        $_arr_tplData = array(
            'cateRow'   => $_arr_cateRow,
            'rcode'     => 'y250403',
        );

        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * cate_init function.
     *
     * @access private
     */
    private function cate_init() {
        $_arr_searchCate = array(
            'status' => 'show',
        );
        $this->cateRows     = $this->mdl_cate->mdl_listPub(1000, 0, $_arr_searchCate);
        $_arr_column_custom = $this->mdl_custom->mdl_column_custom();
        $this->mdl_article_pub->custom_columns   = $_arr_column_custom;

        $_arr_searchCustom = array(
            'status' => 'enable',
        );
        $this->customRows = $this->mdl_custom->mdl_list(1000, 0, $_arr_searchCustom);
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
        $arr_cateRow['is_static'] = true;

        if (BG_MODULE_FTP > 0) {
            $this->ftpRow = $this->mdl_cate->mdl_read($arr_cateRow['cate_trees'][0]['cate_id']);
            if (isset($this->ftpRow['cate_ftp_host']) && !fn_isEmpty($this->ftpRow['cate_ftp_host'])) {
                if ($this->ftpRow['cate_ftp_pasv'] == 'on') {
                    $_bool_pasv = true;
                } else {
                    $_bool_pasv = false;
                }
                $this->ftp_status_conn  = $this->obj_ftp->ftp_conn($this->ftpRow['cate_ftp_host'], $this->ftpRow['cate_ftp_port']);
                $this->ftp_status_login = $this->obj_ftp->ftp_login($this->ftpRow['cate_ftp_user'], $this->ftpRow['cate_ftp_pass'], $_bool_pasv);
            }
        }

        return $arr_cateRow;
    }


    private function data_process($arr_cateRow) {
        //每页记录数
        if ($arr_cateRow['cate_perpage'] > 0 && $arr_cateRow['cate_perpage'] != BG_SITE_PERPAGE) {
            $_num_perpage = $arr_cateRow['cate_perpage'];
        } else {
            $_num_perpage = BG_SITE_PERPAGE;
        }

        $_arr_search = array(
            'cate_ids' => $arr_cateRow['cate_ids'],
        );
        $_num_articleCount  = $this->mdl_article_pub->mdl_count($_arr_search); //统计
        $_arr_page          = fn_page($_num_articleCount, $_num_perpage, 'post'); //取得分页数据

        if ($_arr_page['total'] >= BG_VISIT_PAGE) {
            $_arr_page['total'] = BG_VISIT_PAGE;
        }

        if ($_arr_page['end'] >= BG_VISIT_PAGE) {
            $_arr_page['end'] = BG_VISIT_PAGE;
        }

        $_arr_page['perpage'] = $_num_perpage;

        return $_arr_page;
    }

    private function output_process($arr_cateRow, $arr_page) {
        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . 'pub/' . $arr_cateRow['cate_tplDo']); //初始化视图对象

        $_arr_search = array(
            'cate_ids' => $arr_cateRow['cate_ids'],
        );
        $_arr_articleRows   = $this->mdl_article_pub->mdl_list($arr_page['perpage'], $arr_page['except'], $_arr_search); //列出

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

        $_arr_tplData = array(
            'customRows'    => $this->customRows,
            'cateRows'      => $this->cateRows,
            'cateRow'       => $arr_cateRow,
            'pageRow'       => $arr_page,
            'articleRows'   => $_arr_articleRows,
        );

        switch ($arr_cateRow['cate_type']) {
            case 'single':
                $_str_tplFile = 'single';
            break;

            default:
                $_str_tplFile = 'show';
            break;
        }

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_gen_cate_show', $_arr_tplData); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_gen_cate_show'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_gen_cate_show'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_tplData = $_arr_pluginReturnDo['return'];
            }
        }

        $_str_outPut    = $_obj_tpl->tplDisplay('cate_' . $_str_tplFile, $_arr_tplData, false);

        //print_r($arr_cateRow['urlRow']['cate_path'] . $arr_cateRow['urlRow']['page_attach'] . $arr_page['page'] . $arr_cateRow['urlRow']['page_ext']);

        $_num_size      = $this->obj_file->file_put($arr_cateRow['urlRow']['cate_path'] . $arr_cateRow['urlRow']['page_attach'] . $arr_page['page'] . $arr_cateRow['urlRow']['page_ext'], $_str_outPut);

        if ($_num_size < 1) {
            $_arr_tplData = array(
                'rcode' => 'x250403',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $this->obj_file->file_copy($arr_cateRow['urlRow']['cate_path'] . $arr_cateRow['urlRow']['page_attach'] . '1' . $arr_cateRow['urlRow']['page_ext'], $arr_cateRow['urlRow']['cate_path'] . 'index' . $arr_cateRow['urlRow']['page_ext']);

        if (BG_MODULE_FTP > 0 && isset($this->ftpRow['cate_ftp_host']) && !fn_isEmpty($this->ftpRow['cate_ftp_host'])) {
            if (!$this->ftp_status_conn) {
                $_arr_tplData = array(
                    'rcode' => 'x030301',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
            if (!$this->ftp_status_login) {
                $_arr_tplData = array(
                    'rcode' => 'x030302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
            $_ftp_status = $this->obj_ftp->file_upload($arr_cateRow['urlRow']['cate_path'] . $arr_cateRow['urlRow']['page_attach'] . $arr_page['page'] . $arr_cateRow['urlRow']['page_ext'], $this->ftpRow['cate_ftp_path'] . $arr_cateRow['urlRow']['cate_pathShort'] . $arr_cateRow['urlRow']['page_attach'] . $arr_page['page'] . $arr_cateRow['urlRow']['page_ext']);

            $_ftp_status = $this->obj_ftp->file_upload($arr_cateRow['urlRow']['cate_path'] . 'index' . $arr_cateRow['urlRow']['page_ext'], $this->ftpRow['cate_ftp_path'] . $arr_cateRow['urlRow']['cate_pathShort'] . 'index' . $arr_cateRow['urlRow']['page_ext']);
        }
    }
}
