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
class CONTROL_CONSOLE_REQUEST_SOURCE {

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

        $this->mdl_source     = new MODEL_SOURCE();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        if (!isset($this->group_allow['article']['source']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x140302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_sourceInput = $this->mdl_source->input_submit();

        if ($_arr_sourceInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_sourceInput);
        }

        $_arr_sourceRow = $this->mdl_source->mdl_submit();

        $this->obj_tpl->tplDisplay('result', $_arr_sourceRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['article']['source']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x140304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_sourceIds = $this->mdl_source->input_ids();
        if ($_arr_sourceIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_sourceIds);
        }

        $_arr_sourceRow = $this->mdl_source->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_sourceRow);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_sourceName    = fn_getSafe(fn_get('source_name'), 'txt', '');

        if (!fn_isEmpty($_str_sourceName)) {
            $_num_sourceId      = fn_getSafe(fn_get('source_id'), 'int', 0);
            $_arr_sourceRow     = $this->mdl_source->mdl_read($_str_sourceName, 'source_name', $_num_sourceId);

            if ($_arr_sourceRow['rcode'] == 'y140102') {
                $_arr_tplData = array(
                    'rcode' => 'x140203',
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
