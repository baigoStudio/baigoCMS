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
class CONTROL_CONSOLE_REQUEST_ARTICLE_GEN {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_dir      = new CLASS_DIR();
        $this->obj_dir->perms = 0755;

        if (BG_MODULE_FTP > 0) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_article_pub  = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->article_init();
        $this->mdl_attach       = new MODEL_ATTACH();
        $this->mdl_thumb        = new MODEL_THUMB();

        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_list(100);
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function ctrl_single($num_articleId = 0, $is_gen = true) {
        if ($num_articleId > 0) {
            $_num_articleId = $num_articleId;
        } else {
            $_num_articleId = fn_getSafe(fn_post('article_id'), 'int', 0); //ID
        }

        if ($_num_articleId < 1) {
            if ($is_gen) {
                $_arr_tplData = array(
                    'rcode' => 'x120212',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                return;
            }
        }

        $_str_enforce = fn_getSafe(fn_post('enforce'), 'txt', ''); //ID

        $_arr_articleRow = $this->mdl_article_pub->mdl_read($_num_articleId);
        if ($_arr_articleRow['rcode'] != 'y120102') {
            if ($is_gen) {
                $_arr_tplData = array(
                    'rcode' => $_arr_articleRow['rcode'],
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                return;
            }
        }

        if ($_arr_articleRow['article_is_gen'] == 'yes' && $_str_enforce != 'true') {
            if ($is_gen) {
                $_arr_tplData = array(
                    'rcode' => 'x120402',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                return;
            }
        }

        if (fn_isEmpty($_arr_articleRow['article_title']) || $_arr_articleRow['article_status'] != 'pub' || $_arr_articleRow['article_box'] != 'normal' || ($_arr_articleRow['article_is_time_pub'] > 0 && $_arr_articleRow['article_time_pub'] > time()) || ($_arr_articleRow['article_is_time_hide'] > 0 && $_arr_articleRow['article_time_hide'] < time())) {
            if ($is_gen) {
                $_arr_tplData = array(
                    'rcode' => 'x120404',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                return;
            }
        }

        if (!fn_isEmpty($_arr_articleRow['article_link'])) {
            $this->mdl_article_pub->mdl_isGen($_arr_articleRow['article_id']);
            if ($is_gen) {
                $_arr_tplData = array(
                    'rcode' => 'x120404',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                return;
            }
        }

        $this->cate_process($_arr_articleRow['article_cate_id']);

        $_arr_articleRow['cateRow'] = $this->cateRow;
        $_arr_articleRow['urlRow']  = $this->mdl_cate->article_url_process($_arr_articleRow, $this->cateRow);

        $this->output_process($_arr_articleRow);

        $_arr_tplData = array(
            'articleRow'    => $_arr_articleRow,
            'rcode'         => 'y120403',
        );

        if ($is_gen) {
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        } else {
            return;
        }
    }


    /**
     * cate_init function.
     *
     * @access private
     */
    private function article_init() {
        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

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


    private function cate_process($num_cateId) {
        $this->cateRow               = $this->mdl_cate->mdl_readPub($num_cateId);
        if ($this->cateRow['rcode'] != 'y250102' || $this->cateRow['cate_status'] != 'show' || ($this->cateRow['cate_type'] == 'link' && !fn_isEmpty($this->cateRow['cate_link']))) {
            if ($is_gen) {
                $_arr_tplData = array(
                    'rcode' => 'x120404',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                return;
            }
        }

        $this->cateRow['cate_tplDo'] = $this->mdl_cate->tpl_process($this->cateRow['cate_id']);

        if (!fn_isEmpty($this->cateRow['cate_trees'])) {
            foreach ($this->cateRow['cate_trees'] as $_key_tree=>$_value_tree) {
                $_arr_cate = $this->mdl_cate->mdl_readPub($_value_tree['cate_id']);
                $this->cateRow['cate_trees'][$_key_tree]['urlRow'] = $_arr_cate['urlRow'];
            }
        }

        if (BG_MODULE_FTP > 0) {
            $this->ftpRow = $this->mdl_cate->mdl_read($this->cateRow['cate_trees'][0]['cate_id']);
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
    }


    private function output_process($arr_articleRow) {
        $_obj_tpl           = new CLASS_TPL(BG_PATH_TPL . 'pub/' . $arr_articleRow['cateRow']['cate_tplDo']); //初始化视图对象

        $_arr_searchTag = array(
            'status'        => 'show',
            'article_id'    => $arr_articleRow['article_id'],
        );
        $arr_articleRow['tagRows']    = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

        if ($arr_articleRow['article_attach_id'] > 0) {
            $_arr_attachRow = $this->mdl_attach->mdl_url($arr_articleRow['article_attach_id']);
            if ($_arr_attachRow['rcode'] == 'y070102') {
                if ($_arr_attachRow['attach_box'] != 'normal') {
                    $_arr_attachRow = array(
                        'rcode' => 'x070102',
                    );
                }
            }
            $arr_articleRow['attachRow']   = $_arr_attachRow;
        }

        $_arr_tagIds    = array();
        $_arr_assRows   = array();

        foreach ($arr_articleRow['tagRows'] as $_key=>$_value) {
            $_arr_tagIds[] = $_value['tag_id'];
        }

        if (!fn_isEmpty($_arr_tagIds)) {
            $_arr_search = array(
                'tag_ids' => $_arr_tagIds,
            );
            $_arr_assRows = $this->mdl_article_pub->mdl_list(BG_SITE_ASSOCIATE, 0, $_arr_search);

            foreach ($_arr_assRows as $_key=>$_value) {
                $_arr_assCateRow = $this->cate_process($_value['article_cate_id']);
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

                $_arr_assRows[$_key]['cateRow']  = $_arr_assCateRow;
                /*if ($_arr_assCateRow['cate_trees'][0]['cate_domain']) {
                    $_arr_assRows[$_key]['urlRow']['article_url']  = $_arr_assCateRow['cate_trees'][0]['cate_domain'] . '/' . $_value['urlRow']['article_url'];
                }*/
                $_arr_assRows[$_key]['urlRow']   = $this->mdl_cate->article_url_process($_value, $_arr_assCateRow);
            }
        }


        $_arr_tplData = array(
            'customRows'    => $this->customRows,
            'cateRows'      => $this->cateRows,
            'articleRow'    => $arr_articleRow,
            'associateRows' => $_arr_assRows,
        );

        $_str_outPut    = $_obj_tpl->tplDisplay('article_show', $_arr_tplData, false);

        $_num_size      = $this->obj_dir->put_file($arr_articleRow['urlRow']['article_path'] . $arr_articleRow['article_id'] . $arr_articleRow['urlRow']['page_ext'], $_str_outPut);

        if ($_num_size < 1) {
            $_arr_tplData = array(
                'rcode' => 'x120403',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $this->mdl_article_pub->mdl_isGen($arr_articleRow['article_id']);

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
            $_ftp_status = $this->obj_ftp->up_file($arr_articleRow['urlRow']['article_pathFull'], $this->ftpRow['cate_ftp_path'] . $arr_articleRow['urlRow']['article_pathShort']);
        }
    }
}
