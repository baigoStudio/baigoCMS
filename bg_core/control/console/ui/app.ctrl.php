<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------管理员控制器-------------*/
class CONTROL_CONSOLE_UI_APP {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->config   = $GLOBALS['obj_base']->config;

        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_tpl->lang['appMod']      = fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'appMod.php');

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->mdl_app      = new MODEL_APP(); //设置管理员模型

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_app->arr_status,
            'appMod'        => fn_include(BG_PATH_INC . 'appMod.inc.php'), //菜单
        );
    }

    /*============编辑管理员界面============
    返回提示
    */
    function ctrl_show() {
        if (!isset($this->group_allow['opt']['app']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x050301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_appId = fn_getSafe(fn_get('app_id'), 'int', 0);

        if ($_num_appId < 1) {
            $this->tplData['rcode'] = 'x050203';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_appRow = $this->mdl_app->mdl_read($_num_appId);
        if ($_arr_appRow['rcode'] != 'y050102') {
            $this->tplData['rcode'] = $_arr_appRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_appRow['app_key'] = fn_baigoCrypt($_arr_appRow['app_key'], $_arr_appRow['app_name']);

        $this->tplData['appRow'] = $_arr_appRow;

        $this->obj_tpl->tplDisplay('app_show', $this->tplData);
    }


    /*============编辑管理员界面============
    返回提示
    */
    function ctrl_form() {
        $_num_appId = fn_getSafe(fn_get('app_id'), 'int', 0);

        if ($_num_appId > 0) {
            if (!isset($this->group_allow['opt']['app']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x050303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_appRow = $this->mdl_app->mdl_read($_num_appId);
            if ($_arr_appRow['rcode'] != 'y050102') {
                $this->tplData['rcode'] = $_arr_appRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            if (!isset($this->group_allow['opt']['app']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x050302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_appRow = array(
                'app_id'        => 0,
                'app_name'      => '',
                'app_notify'    => '',
                'app_ip_allow'  => '',
                'app_ip_bad'    => '',
                'app_note'      => '',
                'app_status'    => $this->mdl_app->arr_status[0],
            );
        }

        //print_r($_arr_appRow);

        $this->tplData['appRow'] = $_arr_appRow;

        $this->obj_tpl->tplDisplay('app_form', $this->tplData);
    }


    /*============列出管理员界面============
    无返回
    */
    function ctrl_list() {
        if (!isset($this->group_allow['opt']['app']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x050301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'    => fn_getSafe(fn_get('key'), 'txt', ''),
            'status' => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_appCount    = $this->mdl_app->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_appCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_appRows     = $this->mdl_app->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'appRows'    => $_arr_appRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('app_list', $_arr_tplData);
    }
}
