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
class CONTROL_CONSOLE_REQUEST_THUMB {

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

        $this->mdl_thumb    = new MODEL_THUMB();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        if (!isset($this->group_allow['attach']['thumb']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x090302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_thumbInput = $this->mdl_thumb->input_submit();

        if ($_arr_thumbInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_thumbInput);
        }

        $_arr_thumbRow = $this->mdl_thumb->mdl_submit();

        $this->mdl_thumb->mdl_cache(true);

        $this->obj_tpl->tplDisplay('result', $_arr_thumbRow);
    }


    function ctrl_cache() {
        $this->mdl_thumb->mdl_cache(true);

        $_arr_tplData = array(
            'rcode' => 'y090110',
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
        if (!isset($this->group_allow['attach']['thumb']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x090304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_thumbIds = $this->mdl_thumb->input_ids();
        if ($_arr_thumbIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_thumbIds);
        }

        $_arr_thumbRow = $this->mdl_thumb->mdl_del();

        $this->mdl_thumb->mdl_cache(true);

        $this->obj_tpl->tplDisplay('result', $_arr_thumbRow);
    }
}
