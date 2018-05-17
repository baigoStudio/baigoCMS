<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

if (!function_exists('fn_qlistAttach')) {
    fn_include(BG_PATH_FUNC . 'gather.func.php');
}

/*-------------用户类-------------*/
class CONTROL_CONSOLE_REQUEST_SPEC {

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
            $this->obj_file = new CLASS_FILE();
        }

        if (BG_MODULE_FTP > 0) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_article      = new MODEL_ARTICLE();
        $this->mdl_spec_belong  = new MODEL_SPEC_BELONG();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_specInput = $this->mdl_spec->input_submit();
        if ($_arr_specInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_specInput);
        }

        if ($_arr_specInput['spec_id'] > 0) {
            if (!isset($this->group_allow['spec']['edit']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x180303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_console_spec_edit', $_arr_specInput); //编辑文章时触发
            if (isset($_arr_pluginReturn['filter_console_spec_edit'])) {
                $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_console_spec_edit'];
            }
        } else {
            if (!isset($this->group_allow['spec']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x180302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_console_spec_add', $_arr_specInput); //编辑文章时触发
            if (isset($_arr_pluginReturn['filter_console_spec_add'])) {
                $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_console_spec_add'];
            }
        }

        if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
            $_arr_pluginInput = $this->mdl_spec->input_submit($_arr_pluginReturnDo['return']);

            if ($_arr_pluginInput['rcode'] != 'ok') {
                $_arr_pluginInput['msg'] = $this->obj_tpl->lang['commom']['label']['errPlugin'];
                if (isset($_arr_pluginReturnDo['plugin'])) {
                    $_arr_pluginInput['msg'] .= ' - ' . $_arr_pluginReturnDo['plugin'];
                }
                $this->obj_tpl->tplDisplay('result', $_arr_pluginInput);
            }
        }

        $_arr_specRow = $this->mdl_spec->mdl_submit();

        $_arr_tplData = array(
            'rcode'     => $_arr_specRow['rcode'],
            'spec_id'   => $_arr_specRow['spec_id'],
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    function ctrl_status() {
        if (!isset($this->group_allow['spec']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x180302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_specIds = $this->mdl_spec->input_ids();
        if ($_arr_specIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_specIds);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_return = array(
            'spec_ids'      => $_arr_specIds['spec_ids'],
            'spec_status'   => $_str_status,
        );

        $GLOBALS['obj_plugin']->trigger('action_console_spec_status', $_arr_return); //删除链接时触发

        $_arr_specRow = $this->mdl_spec->mdl_status($_str_status);

        if (defined('BG_MODULE_GEN') && BG_MODULE_GEN > 0 && defined('BG_VISIT_TYPE') && BG_VISIT_TYPE == 'static') {
            if ($_str_status != 'show') {
                $arr_search = array(
                    'spec_ids' => $_arr_specIds['spec_ids'],
                );
                $_arr_specRows = $this->mdl_spec->mdl_list(1000, 0, $arr_search);
                foreach ($_arr_specRows as $_key=>$_value) {
                    $this->obj_file->dir_del($_value['urlRow']['spec_path']);
                    if (defined('BG_MODULE_FTP') && !fn_isEmpty(BG_MODULE_FTP)) {
                        if (defined('BG_SPEC_FTPHOST') && !fn_isEmpty(BG_SPEC_FTPHOST)) {
                            if (BG_SPEC_FTPPASV == 'on') {
                                $_bool_pasv = true;
                            } else {
                                $_bool_pasv = false;
                            }
                            $this->ftp_status_conn  = $this->obj_ftp->ftp_conn(BG_SPEC_FTPHOST, BG_SPEC_FTPPORT);
                            $this->ftp_status_login = $this->obj_ftp->ftp_login(BG_SPEC_FTPUSER, BG_SPEC_FTPPASS, $_bool_pasv);

                            $this->obj_ftp->dir_del(BG_SPEC_FTPPATH . $_value['urlRow']['spec_pathShort']);
                        }
                    }
                }
            }
        }

        $this->obj_tpl->tplDisplay('result', $_arr_specRow);
    }


    function ctrl_belongDel() {
        if (!isset($this->group_allow['spec']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x180302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_str_rcode = 'x180406';

        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_articleIds);
        }

        $_nun_specId  = fn_getSafe(fn_post('spec_id'), 'int', 0);

        $_arr_specBelongRow = $this->mdl_spec_belong->mdl_del(0, $_nun_specId, false, $_arr_articleIds['article_ids']);

        if ($_arr_specBelongRow['rcode'] == 'y230104') {
            $_str_rcode = 'y180406';
        }

        //$_arr_articleRow = $this->mdl_article->mdl_toSpec($_str_act, $_nun_specId);

        $_arr_tplData = array(
            'rcode' => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    function ctrl_belongAdd() {
        if (!isset($this->group_allow['spec']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x180302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_str_rcode = 'x180405';

        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_articleIds);
        }

        $_nun_specId  = fn_getSafe(fn_post('spec_id'), 'int', 0);

        foreach ($_arr_articleIds['article_ids'] as $_key=>$_value) {
            if (!fn_isEmpty($_value)) {
                $_arr_specBelongRow = $this->mdl_spec_belong->mdl_submit(intval($_value), $_nun_specId);
                if ($_arr_specBelongRow['rcode'] == 'y230101') {
                    $_str_rcode = 'y180405';
                }
            }
        }

        //$_arr_articleRow = $this->mdl_article->mdl_toSpec($_str_act, $_nun_specId);

        $_arr_tplData = array(
            'rcode' => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['spec']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x180304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_specIds = $this->mdl_spec->input_ids();
        if ($_arr_specIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_specIds);
        }

        if (defined('BG_MODULE_GEN') && BG_MODULE_GEN > 0 && defined('BG_VISIT_TYPE') && BG_VISIT_TYPE == 'static') {
            $arr_search = array(
                'spec_ids' => $_arr_specIds['spec_ids'],
            );
            $_arr_specRows = $this->mdl_spec->mdl_list(1000, 0, $arr_search);
            foreach ($_arr_specRows as $_key=>$_value) {
                $this->obj_file->dir_del($_value['urlRow']['spec_path']);
                if (defined('BG_MODULE_FTP') && !fn_isEmpty(BG_MODULE_FTP)) {
                    if (defined('BG_SPEC_FTPHOST') && !fn_isEmpty(BG_SPEC_FTPHOST)) {
                        if (BG_SPEC_FTPPASV == 'on') {
                            $_bool_pasv = true;
                        } else {
                            $_bool_pasv = false;
                        }
                        $this->ftp_status_conn  = $this->obj_ftp->ftp_conn(BG_SPEC_FTPHOST, BG_SPEC_FTPPORT);
                        $this->ftp_status_login = $this->obj_ftp->ftp_login(BG_SPEC_FTPUSER, BG_SPEC_FTPPASS, $_bool_pasv);

                        $this->obj_ftp->dir_del(BG_SPEC_FTPPATH . $_value['urlRow']['spec_pathShort']);
                    }
                }
            }
        }

        $GLOBALS['obj_plugin']->trigger('action_console_spec_del', $_arr_specIds['spec_ids']); //删除链接时触发

        $_arr_specRow = $this->mdl_spec->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_specRow);
    }


    /**
     * ajax_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_list() {
        $_arr_search = array(
            'key' => fn_getSafe(fn_get('key'), 'txt', ''),
        );
        $_num_perPage     = 10;
        $_num_specCount   = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_specCount, $_num_perPage); //取得分页数据
        $_arr_specRows    = $this->mdl_spec->mdl_list($_num_perPage, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'pageRow'    => $_arr_page,
            'specRows'   => $_arr_specRows, //上传信息
        );

        $this->obj_tpl->tplDisplay('result', $_arr_tpl);
    }
}
