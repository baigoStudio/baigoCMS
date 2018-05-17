<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------允许类-------------*/
class CONTROL_CONSOLE_UI_CUSTOM {

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

        $this->mdl_custom   = new MODEL_CUSTOM();
        $this->mdl_cate     = new MODEL_CATE(); //设置栏目对象

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'    => $this->mdl_custom->arr_status,
            'type'      => $this->mdl_custom->arr_type,
            'format'    => $this->mdl_custom->arr_format,
        );
    }


    function ctrl_order() {
        if (!isset($this->group_allow['opt']['article']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x200303';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_customId = fn_getSafe(fn_get('custom_id'), 'int', 0);

        if ($_num_customId < 1) {
            $this->tplData['rcode'] = 'x200209';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_customRow = $this->mdl_custom->mdl_read($_num_customId);
        if ($_arr_customRow['rcode'] != 'y200102') {
            $this->tplData['rcode'] = $_arr_customRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_tpl = array(
            'customRow'    => $_arr_customRow, //栏目信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('custom_order', $_arr_tplData);
    }


    function ctrl_form() {
        if (!isset($this->group_allow['opt']['article']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x200301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_customId    = fn_getSafe(fn_get('custom_id'), 'int', 0);

        if ($_num_customId > 0) {
            $_arr_customRow = $this->mdl_custom->mdl_read($_num_customId);
            if ($_arr_customRow['rcode'] != 'y200102') {
                $this->tplData['rcode'] = $_arr_customRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_arr_customRow = array(
                'custom_id'         => 0,
                'custom_name'       => '',
                'custom_type'       => '',
                'custom_opt'        => '',
                'custom_status'     => $this->mdl_custom->arr_status[0],
                'custom_parent_id'  => -1,
                'custom_cate_id'    => -1,
                'custom_format'     => '',
                'custom_require'    => 0,
                'custom_size'       => 30,
            );
        }

        $_arr_searchCate = array(
            'status' => 'show',
        );

        $_arr_searchCustom = array(
            'status' => 'enable',
        );

        $_arr_customRows  = $this->mdl_custom->mdl_list(1000, 0, $_arr_searchCustom);
        $_arr_cateRows    = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);

        //print_r($_arr_customRow);

        $_arr_tpl = array(
            'customRow'  => $_arr_customRow,
            'customRows' => $_arr_customRows,
            'cateRows'   => $_arr_cateRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('custom_form', $_arr_tplData);
    }

    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow['opt']['article']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x200301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'        => fn_getSafe(fn_get('key'), 'txt', ''),
            'status'     => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_customCount = $this->mdl_custom->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_customCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_customRows  = $this->mdl_custom->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        //print_r($_arr_customRows);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'customRows' => $_arr_customRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('custom_list', $_arr_tplData);
    }
}
