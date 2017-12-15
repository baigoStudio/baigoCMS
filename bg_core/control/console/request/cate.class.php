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
class CONTROL_CONSOLE_REQUEST_CATE {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        if (defined('BG_MODULE_GEN') && BG_MODULE_GEN > 0 && defined('BG_VISIT_TYPE') && BG_VISIT_TYPE == 'static') {
            $this->obj_dir = new CLASS_DIR();
        }

        if (BG_MODULE_FTP > 0) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->mdl_cate     = new MODEL_CATE();
        $this->mdl_cate->mdl_cache(0, true);
    }


    function ctrl_duplicate() {
        $_arr_cateInput = $this->mdl_cate->input_duplicate();
        if ($_arr_cateInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_cateInput);
        }

        if (!isset($this->group_allow['cate']['add']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x250302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_duplicate();

        $this->obj_tpl->tplDisplay('result', $_arr_cateRow);
    }

    /**
     * ajax_order function.
     *
     * @access public
     * @return void
     */
    function ctrl_order() {
        if (!isset($this->group_allow['cate']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x250303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }
        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_cateId = fn_getSafe(fn_post('cate_id'), 'int', 0); //ID

        if ($_num_cateId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x250217',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);
        if ($_arr_cateRow['rcode'] != 'y250102') {
            $this->obj_tpl->tplDisplay('result', $_arr_cateRow);
        }

        $_num_parentId    = fn_getSafe(fn_post('cate_parent_id'), 'int', 0);
        $_str_orderType   = fn_getSafe(fn_post('order_type'), 'txt', 'order_first');
        $_num_targetId    = fn_getSafe(fn_post('order_target'), 'int', 0);
        $_arr_cateRow     = $this->mdl_cate->mdl_order($_str_orderType, $_num_cateId, $_num_targetId, $_num_parentId);

        $this->obj_tpl->tplDisplay('result', $_arr_cateRow);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_cateInput = $this->mdl_cate->input_submit();

        if ($_arr_cateInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_cateInput);
        }

        if ($_arr_cateInput['cate_id'] > 0) {
            if (!isset($this->group_allow['cate']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_cateInput['cate_id']]['cate']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x250303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        } else {
            if (!isset($this->group_allow['cate']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x250302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_cateRow     = $this->mdl_cate->mdl_submit(); //提交

        $_arr_cateIds[]   = $_arr_cateRow['cate_id'];

        $_arr_cateRowRead = $this->mdl_cate->mdl_readPub($_arr_cateRow['cate_id']); //根据提交结果读取栏目信息

        if (!fn_isEmpty($_arr_cateRowRead['cate_trees'])) { //根据栏目树形结构，取出所有栏目 id
            foreach ($_arr_cateRowRead['cate_trees'] as $_key=>$_value) {
                $_arr_cateIds[] = $_value['cate_id'];
            }
        }

        $_arr_cateIds = array_filter(array_unique($_arr_cateIds)); //去除重复

        $this->obj_tpl->tplDisplay('result', $_arr_cateRow);
    }


    /**
     * ajax_cache function.
     *
     * @access public
     * @return void
     */
    function ctrl_cache() {
        $_arr_cateIds = $this->mdl_cate->input_ids();
        if ($_arr_cateIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_cateIds);
        }

        //print_r($_str_outPut);

        $_arr_tplData = array(
            'rcode' => 'y250110',
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->group_allow['cate']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x250303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_cateIds = $this->mdl_cate->input_ids();
        if ($_arr_cateIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_cateIds);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_cateRow = $this->mdl_cate->mdl_status($_str_status);

        if (defined('BG_MODULE_GEN') && BG_MODULE_GEN > 0 && defined('BG_VISIT_TYPE') && BG_VISIT_TYPE == 'static') {
            if ($_str_status != 'show') {
                $arr_search = array(
                    'cate_ids' => $_arr_cateIds['cate_ids'],
                );
                $_arr_cateRows = $this->mdl_cate->mdl_list(1000, 0, $arr_search, 1, false);
                foreach ($_arr_cateRows as $_key=>$_value) {
                    $this->obj_dir->del_dir($_value['urlRow']['cate_path']);
                    if (defined('BG_MODULE_FTP') && BG_MODULE_FTP > 0) {
                        if ($_value['cate_parent_id'] == 0 && isset($_value['cate_ftp_host']) && !fn_isEmpty($_value['cate_ftp_host'])) {
                            if ($_value['cate_ftp_pasv'] == 'on') {
                                $_bool_pasv = true;
                            } else {
                                $_bool_pasv = false;
                            }
                            $this->ftp_status_conn  = $this->obj_ftp->ftp_conn($_value['cate_ftp_host'], $_value['cate_ftp_port']);
                            $this->ftp_status_login = $this->obj_ftp->ftp_login($_value['cate_ftp_user'], $_value['cate_ftp_pass'], $_bool_pasv);

                            $this->obj_ftp->del_dir($_value['cate_ftp_path'] . $_value['urlRow']['cate_pathShort']);
                        }
                    }
                }
            }
        }

        $this->obj_tpl->tplDisplay('result', $_arr_cateRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['cate']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x250304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_cateIds = $this->mdl_cate->input_ids();
        if ($_arr_cateIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_cateIds);
        }

        if (defined('BG_MODULE_GEN') && BG_MODULE_GEN > 0 && defined('BG_VISIT_TYPE') && BG_VISIT_TYPE == 'static') {
            $arr_search = array(
                'cate_ids' => $_arr_cateIds['cate_ids'],
            );
            $_arr_cateRows = $this->mdl_cate->mdl_list(1000, 0, $arr_search, 1, false);
            foreach ($_arr_cateRows as $_key=>$_value) {
                $this->obj_dir->del_dir($_value['urlRow']['cate_path']);
                if (defined('BG_MODULE_FTP') && BG_MODULE_FTP > 0) {
                    if ($_value['cate_parent_id'] == 0 && isset($_value['cate_ftp_host']) && !fn_isEmpty($_value['cate_ftp_host'])) {
                        if ($_value['cate_ftp_pasv'] == 'on') {
                            $_bool_pasv = true;
                        } else {
                            $_bool_pasv = false;
                        }
                        $this->ftp_status_conn  = $this->obj_ftp->ftp_conn($_value['cate_ftp_host'], $_value['cate_ftp_port']);
                        $this->ftp_status_login = $this->obj_ftp->ftp_login($_value['cate_ftp_user'], $_value['cate_ftp_pass'], $_bool_pasv);

                        $this->obj_ftp->del_dir($_value['cate_ftp_path'] . $_value['urlRow']['cate_pathShort']);
                    }
                }
            }
        }

        $_arr_cateRow = $this->mdl_cate->mdl_del();

        $this->mdl_cate->mdl_cache_del($_arr_cateIds['cate_ids']);

        $this->obj_tpl->tplDisplay('result', $_arr_cateRow);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_cateName        = fn_getSafe(fn_get('cate_name'), 'txt', '');
        if (!fn_isEmpty($_str_cateName)) {
            $_num_cateId          = fn_getSafe(fn_get('cate_id'), 'int', 0);
            $_num_cateParentId    = fn_getSafe(fn_get('cate_parent_id'), 'int', 0);

            $_arr_cateRow = $this->mdl_cate->mdl_read($_str_cateName, 'cate_name', $_num_cateId, $_num_cateParentId);

            if ($_arr_cateRow['rcode'] == 'y250102') {
                $_arr_tplData = array(
                    'rcode' => 'x250203',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_tplData = array(
            'msg' => 'ok'
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_chkalias function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkalias() {
        $_str_cateAlias       = fn_getSafe(fn_get('cate_alias'), 'txt', '');
        if (!fn_isEmpty($_str_cateAlias)) {
            $_num_cateId          = fn_getSafe(fn_get('cate_id'), 'int', 0);
            $_num_cateParentId    = fn_getSafe(fn_get('cate_parent_id'), 'int', 0);

            $_arr_cateRow = $this->mdl_cate->mdl_read($_str_cateAlias, 'cate_alias', $_num_cateId, $_num_cateParentId);

            if ($_arr_cateRow['rcode'] == 'y250102') {
                $_arr_tplData = array(
                    'rcode' => 'x250206',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_tplData = array(
            'msg' => 'ok'
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }
}
