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
class CONTROL_CONSOLE_REQUEST_CUSTOM {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console          = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged          = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl              = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->mdl_custom           = new MODEL_CUSTOM();
        $this->mdl_article_pub      = new MODEL_ARTICLE_PUB();
        $this->mdl_article_custom   = new MODEL_ARTICLE_CUSTOM();
    }


    function ctrl_order() {
        if (!isset($this->group_allow['article']['custom']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x200303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }
        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_customId = fn_getSafe(fn_post('custom_id'), 'int', 0); //ID

        if ($_num_customId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x200209',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_customRow = $this->mdl_custom->mdl_read($_num_customId);
        if ($_arr_customRow['rcode'] != 'y200102') {
            $this->obj_tpl->tplDisplay('result', $_arr_customRow);
        }

        $_num_parentId    = fn_getSafe(fn_post('custom_parent_id'), 'int', 0);
        $_str_orderType   = fn_getSafe(fn_post('order_type'), 'txt', 'order_first');
        $_num_targetId    = fn_getSafe(fn_post('order_target'), 'int', 0);
        $_arr_customRow   = $this->mdl_custom->mdl_order($_str_orderType, $_num_customId, $_num_targetId, $_num_parentId);

        $this->misc_process();

        $this->obj_tpl->tplDisplay('result', $_arr_customRow);
    }


    function ctrl_cache() {
        $this->misc_process();

        //print_r($_str_outPut);

        $_arr_tplData = array(
            'rcode' => 'y200110',
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_customInput = $this->mdl_custom->input_submit();

        if ($_arr_customInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_customInput);
        }

        if ($_arr_customInput['custom_id'] > 0) {
            if (!isset($this->group_allow['article']['custom']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x200303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        } else {
            if (!isset($this->group_allow['article']['custom']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x200302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_customRow = $this->mdl_custom->mdl_submit();

        $this->misc_process();

        $this->obj_tpl->tplDisplay('result', $_arr_customRow);
    }


    function ctrl_status() {
        if (!isset($this->group_allow['article']['custom']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x170303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_customIds = $this->mdl_custom->input_ids();
        if ($_arr_customIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_customIds);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_customRow = $this->mdl_custom->mdl_status($_str_status);

        $this->misc_process();

        $this->obj_tpl->tplDisplay('result', $_arr_customRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['article']['custom']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x200304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_customIds = $this->mdl_custom->input_ids();
        if ($_arr_customIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_customIds);
        }

        $_arr_customRow = $this->mdl_custom->mdl_del();

        $this->misc_process();

        $this->obj_tpl->tplDisplay('result', $_arr_customRow);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_customName      = fn_getSafe(fn_get('custom_name'), 'txt', '');
        if (!fn_isEmpty($_str_customName)) {
            $_num_customId    = fn_getSafe(fn_get('custom_id'), 'int', 0);

            if (!fn_isEmpty($_str_customName)) {
                $_arr_customRow       = $this->mdl_custom->mdl_read($_str_customName, 'custom_name', $_num_customId);

                if ($_arr_customRow['rcode'] == 'y200102') {
                    $_arr_tplData = array(
                        'rcode' => 'x200203',
                    );
                    $this->obj_tpl->tplDisplay('result', $_arr_tplData);
                }
            }
        }

        $_arr_tplData = array(
            'msg' => 'ok'
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    function misc_process() {
        $_arr_searchCustom = array(
            'status' => 'enable',
        );
        $_arr_customRows = $this->mdl_custom->mdl_list(1000, 0, $_arr_searchCustom, 0, false);
        $this->mdl_article_custom->mdl_create_table($_arr_customRows);
        $this->mdl_article_pub->mdl_create_custom_view($_arr_customRows);
        $this->mdl_custom->mdl_cache(true);
    }
}
