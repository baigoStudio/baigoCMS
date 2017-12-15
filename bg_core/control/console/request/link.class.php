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
class CONTROL_CONSOLE_REQUEST_LINK {

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

        $this->mdl_link     = new MODEL_LINK();
    }


    function ctrl_order() {
        if (!isset($this->group_allow['link']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x240303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }
        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_linkId = fn_getSafe(fn_post('link_id'), 'int', 0); //ID

        if ($_num_linkId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x240209',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_linkRow = $this->mdl_link->mdl_read($_num_linkId);
        if ($_arr_linkRow['rcode'] != 'y240102') {
            $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
        }

        $_str_orderType   = fn_getSafe(fn_post('order_type'), 'txt', 'order_first');
        $_num_targetId    = fn_getSafe(fn_post('order_target'), 'int', 0);
        $_arr_linkRow   = $this->mdl_link->mdl_order($_str_orderType, $_num_linkId, $_num_targetId);

        $this->misc_process();

        $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
    }


    function ctrl_cache() {
        $this->misc_process();

        $_arr_tplData = array(
            'rcode' => 'y240112',
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    function ctrl_status() {
        if (!isset($this->group_allow['link']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x240303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_linkIds = $this->mdl_link->input_ids();
        if ($_arr_linkIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_linkIds);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_linkRow = $this->mdl_link->mdl_status($_str_status);

        $this->misc_process();

        $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_linkInput = $this->mdl_link->input_submit();

        if ($_arr_linkInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_linkInput);
        }

        if ($_arr_linkInput['link_id'] > 0) {
            if (!isset($this->group_allow['link']['edit']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x240303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        } else {
            if (!isset($this->group_allow['link']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x240302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_linkRow = $this->mdl_link->mdl_submit();

        $this->misc_process();

        $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['link']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x240304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_linkIds = $this->mdl_link->input_ids();
        if ($_arr_linkIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_linkIds);
        }

        $_arr_linkRow = $this->mdl_link->mdl_del();

        $this->misc_process();

        $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
    }


    function misc_process() {
        $this->mdl_link->mdl_cache($this->mdl_link->arr_type[0], true);
    }
}
