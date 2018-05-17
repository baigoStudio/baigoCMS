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
class CONTROL_CONSOLE_REQUEST_TAG {

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

        $this->mdl_tag      = new MODEL_TAG();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        if (!isset($this->group_allow['article']['tag']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x130303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }
        $_arr_tagInput = $this->mdl_tag->input_submit();
        if ($_arr_tagInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_tagInput);
        }

        $_arr_tagRow = $this->mdl_tag->mdl_submit();

        $this->obj_tpl->tplDisplay('result', $_arr_tagRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->group_allow['article']['tag']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x130303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_tagIds = $this->mdl_tag->input_ids();

        if ($_arr_tagIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_tagIds);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_tagRow = $this->mdl_tag->mdl_status($_str_status);

        $this->obj_tpl->tplDisplay('result', $_arr_tagRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['article']['tag']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x130304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_tagIds = $this->mdl_tag->input_ids();
        if ($_arr_tagIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_tagIds);
        }

        $_arr_tagRow = $this->mdl_tag->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_tagRow);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_tagName = fn_getSafe(fn_get('tag_name'), 'txt', '');

        if (!fn_isEmpty($_str_tagName)) {
            $_num_tagId   = fn_getSafe(fn_get('tag_id'), 'int', 0);
            $_arr_tagRow  = $this->mdl_tag->mdl_read($_str_tagName, 'tag_name', $_num_tagId);

            if ($_arr_tagRow['rcode'] == 'y130102') {
                $_arr_tplData = array(
                    'rcode' => 'x130203',
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
     * ajax_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_list() {
        $_arr_search = array(
            'key' => fn_getSafe(fn_get('key'), 'txt', ''),
        );
        $_arr_tagRows = $this->mdl_tag->mdl_list(1000, 0, $_arr_search);
        $_arr_tagRow  = array();
        if (!fn_isEmpty($_arr_tagRows)) {
            foreach ($_arr_tagRows as $_key=>$_value) {
                $_arr_tagRow[] = $_value['tag_name'];
            }
        }

        $this->obj_tpl->tplDisplay('result', $_arr_tagRow);
    }
}
