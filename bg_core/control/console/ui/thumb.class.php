<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------缩略图类-------------*/
class CONTROL_CONSOLE_UI_THUMB {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
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

        $this->mdl_thumb    = new MODEL_THUMB(); //设置上传信息对象

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'type'          => $this->mdl_thumb->arr_type,
        );
    }


    function ctrl_show() {
        if (!isset($this->group_allow['attach']['thumb']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x090301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_thumbId = fn_getSafe(fn_get('thumb_id'), 'int', 0);

        if ($_num_thumbId < 1) {
            $this->tplData['rcode'] = 'x090207';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_thumbRow = $this->mdl_thumb->mdl_read($_num_thumbId);
        if ($_arr_thumbRow['rcode'] != 'y090102') {
            $this->tplData['rcode'] = $_arr_thumbRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_tpl = array(
            'thumbRow'   => $_arr_thumbRow, //上传信息信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('thumb_show', $_arr_tplData);
    }


    function ctrl_form() {
        if (!isset($this->group_allow['attach']['thumb']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x090301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_thumbId = fn_getSafe(fn_get('thumb_id'), 'int', 0);

        if ($_num_thumbId > 0) {
            $_arr_thumbRow = $this->mdl_thumb->mdl_read($_num_thumbId);
            if ($_arr_thumbRow['rcode'] != 'y090102') {
                $this->tplData['rcode'] = $_arr_thumbRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_arr_thumbRow = array(
                'thumb_id'      => 0,
                'thumb_type'    => $this->mdl_thumb->arr_type[0],
                'thumb_width'   => '',
                'thumb_height'  => '',
            );
        }

        $_arr_tpl = array(
            'thumbRow'   => $_arr_thumbRow, //上传信息信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('thumb_form', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow['attach']['thumb']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x090301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_thumbCount  = $this->mdl_thumb->mdl_count();
        $_arr_page        = fn_page($_num_thumbCount); //取得分页数据
        $_arr_thumbRows   = $this->mdl_thumb->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except']);

        $_arr_tpl = array(
            'pageRow'    => $_arr_page,
            'thumbRows'  => $_arr_thumbRows, //上传信息信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('thumb_list', $_arr_tplData);
    }
}
