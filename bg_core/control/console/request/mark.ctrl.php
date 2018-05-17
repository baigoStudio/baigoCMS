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
class CONTROL_CONSOLE_REQUEST_MARK {

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

        $this->mdl_mark     = new MODEL_MARK();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        if (!isset($this->group_allow['article']['mark']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x140302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_markInput = $this->mdl_mark->input_submit();

        if ($_arr_markInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_markInput);
        }

        $_arr_markRow = $this->mdl_mark->mdl_submit();

        $this->obj_tpl->tplDisplay('result', $_arr_markRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['article']['mark']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x140304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_markIds = $this->mdl_mark->input_ids();
        if ($_arr_markIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_markIds);
        }

        $_arr_markRow = $this->mdl_mark->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_markRow);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_markName    = fn_getSafe(fn_get('mark_name'), 'txt', '');

        if (!fn_isEmpty($_str_markName)) {
            $_num_markId      = fn_getSafe(fn_get('mark_id'), 'int', 0);
            $_arr_markRow     = $this->mdl_mark->mdl_read($_str_markName, 'mark_name', $_num_markId);

            if ($_arr_markRow['rcode'] == 'y140102') {
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
