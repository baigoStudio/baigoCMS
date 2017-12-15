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
class CONTROL_CONSOLE_UI_CALL_GEN {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->mdl_call     = new MODEL_CALL();

        $this->tplData = array(
            'adminLogged'    => $this->adminLogged,
        );
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function ctrl_single() {
        $_num_callId = fn_getSafe(fn_get('call_id'), 'int', 0); //ID

        if ($_num_callId < 1) {
            $this->tplData['rcode'] = 'x170213';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_callRow = $this->mdl_call->mdl_read($_num_callId);
        if ($_arr_callRow['rcode'] != 'y170102') {
            $this->tplData['rcode'] = $_arr_callRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if ($_arr_callRow['rcode'] != 'y170102' || $_arr_callRow['call_status'] != 'enable') {
            $this->tplData['rcode'] = 'x170404';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_tpl = array(
            'callRow'   => $_arr_callRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('call_gen_single', $_arr_tplData);
    }


    function ctrl_list() {
        $_str_overall   = fn_getSafe(fn_get('overall'), 'txt', ''); //ID
        $_num_page      = fn_getSafe(fn_get('page'), 'int', 1);

        $_str_jump = BG_URL_CONSOLE . 'index.php?';

        $_arr_callRows = array();

        $_arr_search = array(
            'status'     => 'enable',
        );

        $_num_callCount  = $this->mdl_call->mdl_count($_arr_search);
        $_arr_page          = fn_page($_num_callCount, BG_COUNT_GEN); //取得分页数据

        if ($_num_page > $_arr_page['total']) {
            if ($_str_overall == 'true') {
                $_str_jump .= 'mod=spec_gen&act=1by1';
            } else {
                $this->tplData['rcode'] = 'y120406';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_str_jump .= 'mod=call_gen&act=list&page=' . ($_num_page + 1);

            $_arr_callRows   = $this->mdl_call->mdl_list(BG_COUNT_GEN, $_arr_page['except'], $_arr_search);
        }

        if ($_str_overall == 'true') {
            $_str_jump .= '&overall=true';
        }

        $_str_jump .= '&view=iframe';

        $_arr_tpl = array(
            'jump'      => $_str_jump,
            'pageRow'   => $_arr_page,
            'callRows'  => $_arr_callRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('call_gen_list', $_arr_tplData);
    }
}
