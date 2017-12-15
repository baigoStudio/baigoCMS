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
class CONTROL_CONSOLE_UI_GROUP {

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

        $this->mdl_group    = new MODEL_GROUP();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_group->arr_status,
            'type'          => $this->mdl_group->arr_type,
        );
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_show() {
        if (!isset($this->group_allow['group']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x040301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_groupId = fn_getSafe(fn_get('group_id'), 'int', 0);

        if ($_num_groupId < 1) {
            $this->tplData['rcode'] = 'x040206';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_groupRow = $this->mdl_group->mdl_read($_num_groupId);
        if ($_arr_groupRow['rcode'] != 'y040102') {
            $this->tplData['rcode'] = $_arr_groupRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_tpl = array(
            'groupRow' => $_arr_groupRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('group_show', $_arr_tplData);
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_form() {
        $_num_groupId = fn_getSafe(fn_get('group_id'), 'int', 0);

        if ($_num_groupId > 0) {
            if (!isset($this->group_allow['group']['edit']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x040303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_groupRow = $this->mdl_group->mdl_read($_num_groupId);
            if ($_arr_groupRow['rcode'] != 'y040102') {
                $this->tplData['rcode'] = $_arr_groupRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            if (!isset($this->group_allow['group']['add']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x040302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_groupRow = array(
                'group_id'      => 0,
                'group_name'    => '',
                'group_note'    => '',
                'group_type'    => $this->mdl_group->arr_type[0],
                'group_status'  => $this->mdl_group->arr_status[0],
                'group_allow'   => array(),
            );
        }


        $_arr_tpl = array(
            'groupRow' => $_arr_groupRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('group_form', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow['group']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x040301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'type'      => fn_getSafe(fn_get('type'), 'txt', ''),
            'status'    => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_groupCount  = $this->mdl_group->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_groupCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_groupRows   = $this->mdl_group->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'groupRows'  => $_arr_groupRows, //管理员列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('group_list', $_arr_tplData);
    }
}
