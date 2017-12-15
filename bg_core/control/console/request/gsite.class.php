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
class CONTROL_CONSOLE_REQUEST_GSITE {

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

        $this->mdl_gsite_step = new MODEL_GSITE_STEP();
    }


    function ctrl_step_page_content() {
        $_arr_gsiteInput = $this->mdl_gsite_step->input_step_page_content();
        if ($_arr_gsiteInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteInput);
        }

        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x270303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite_step->mdl_step_page_content();

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }


    function ctrl_step_page_list() {
        $_arr_gsiteInput = $this->mdl_gsite_step->input_step_page_list();
        if ($_arr_gsiteInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteInput);
        }

        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x270303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite_step->mdl_step_page_list();

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }


    function ctrl_step_content() {
        $_arr_gsiteInput = $this->mdl_gsite_step->input_step_content();
        if ($_arr_gsiteInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteInput);
        }

        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x270303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite_step->mdl_step_content();

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }


    function ctrl_step_list() {
        $_arr_gsiteInput = $this->mdl_gsite_step->input_step_list();
        if ($_arr_gsiteInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteInput);
        }

        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x270303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite_step->mdl_step_list();

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }



    function ctrl_duplicate() {
        $_arr_gsiteInput = $this->mdl_gsite_step->input_duplicate();
        if ($_arr_gsiteInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteInput);
        }

        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x270302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite_step->mdl_duplicate();

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_gsiteInput = $this->mdl_gsite_step->input_submit();
        if ($_arr_gsiteInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteInput);
        }

        if ($_arr_gsiteInput['gsite_id'] > 0) {
            if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x270303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        } else {
            if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x270302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_gsiteRow = $this->mdl_gsite_step->mdl_submit();

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x270303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gsiteIds = $this->mdl_gsite_step->input_ids();
        if ($_arr_gsiteIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteIds);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_gsiteRow = $this->mdl_gsite_step->mdl_status($_str_status);

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x270304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gsiteIds = $this->mdl_gsite_step->input_ids();
        if ($_arr_gsiteIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteIds);
        }

        $_arr_gsiteRow = $this->mdl_gsite_step->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }


    /**
     * ajax_chkGroup function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_gsiteName   = fn_getSafe(fn_get('gsite_name'), 'txt', '');
        if (!fn_isEmpty($_str_gsiteName)) {
            $_num_gsiteId     = fn_getSafe(fn_get('gsite_id'), 'int', 0);
            $_arr_gsiteRow = $this->mdl_gsite_step->mdl_read($_str_gsiteName, 'gsite_name', $_num_gsiteId);

            if ($_arr_gsiteRow['rcode'] == 'y270102') {
                $_arr_tplData = array(
                    'rcode' => 'x270203',
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
