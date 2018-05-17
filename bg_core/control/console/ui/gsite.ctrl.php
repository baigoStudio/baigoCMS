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
class CONTROL_CONSOLE_UI_GSITE {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->config       = $GLOBALS['obj_base']->config;

        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_tpl->lang['selector']      = fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'selector.php');

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->mdl_gsite    = new MODEL_GSITE();
        $this->mdl_cate     = new MODEL_CATE();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_gsite->arr_status,
            'keepTag'       => $this->mdl_gsite->keepTag, //系统保留标签
            'keepAttr'      => $this->mdl_gsite->keepAttr, //系统保留属性
        );
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_show() {
        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x270301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_gsiteId = fn_getSafe(fn_get('gsite_id'), 'int', 0);

        if ($_num_gsiteId < 1) {
            $this->tplData['rcode'] = 'x270213';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite->mdl_read($_num_gsiteId);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            $this->tplData['rcode'] = $_arr_gsiteRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_read($_arr_gsiteRow['gsite_cate_id']);

        $_arr_tpl = array(
            'gsiteRow'  => $_arr_gsiteRow,
            'cateRow'   => $_arr_cateRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_show', $_arr_tplData);
    }


    function ctrl_step() {
        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x270302';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_gsiteId = fn_getSafe(fn_get('gsite_id'), 'int', 0);

        if ($_num_gsiteId < 1) {
            $this->tplData['rcode'] = 'x270213';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite->mdl_read($_num_gsiteId);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            $this->tplData['rcode'] = $_arr_gsiteRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_cateRow   = $this->mdl_cate->mdl_read($_arr_gsiteRow['gsite_cate_id']);

        $_arr_tpl = array(
            'gsiteRow'  => $_arr_gsiteRow,
            'cateRow'   => $_arr_cateRow,
            'attrQList' => fn_include(BG_PATH_INC . 'attrQList.inc.php'),
            'attrOften' => fn_include(BG_PATH_INC . 'attrOften.inc.php'),
            'filter'    => fn_include(BG_PATH_INC . 'filter.inc.php'),
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        switch ($GLOBALS['route']['bg_act']) {
            case 'stepPageContent':
                $_str_tpl = 'page_content';
            break;

            case 'stepPageList':
                $_str_tpl = 'page_list';
            break;

            case 'stepContent':
                $_str_tpl = 'content';
            break;

            default:
                $_str_tpl = 'list';
            break;
        }

        $this->obj_tpl->tplDisplay('gsite_step_' . $_str_tpl, $_arr_tplData);
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_form() {
        $_num_gsiteId = fn_getSafe(fn_get('gsite_id'), 'int', 0);

        if ($_num_gsiteId > 0) {
            if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x270303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_gsiteRow = $this->mdl_gsite->mdl_read($_num_gsiteId);
            if ($_arr_gsiteRow['rcode'] != 'y270102') {
                $this->tplData['rcode'] = $_arr_gsiteRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_gsiteRow = $this->mdl_gsite->selector_process($_arr_gsiteRow);
        } else {
            if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x270302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_gsiteRow = array(
                'gsite_id'      => 0,
                'gsite_name'    => '',
                'gsite_note'    => '',
                'gsite_status'  => $this->mdl_gsite->arr_status[0],
                'gsite_url'     => '',
                'gsite_charset' => '',
                'gsite_cate_id' => 0,
            );
        }


        $_arr_searchCate = array(
            'status' => 'show',
        );
        $_arr_cateRows      = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);

        $_arr_tpl = array(
            'gsiteRow'      => $_arr_gsiteRow,
            'cateRows'      => $_arr_cateRows,
            'charsetRows'   => fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'charset.php'),
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_form', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x270301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'type'      => fn_getSafe(fn_get('type'), 'txt', ''),
            'status'    => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_gsiteCount  = $this->mdl_gsite->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_gsiteCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_gsiteRows   = $this->mdl_gsite->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'gsiteRows'  => $_arr_gsiteRows, //管理员列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_list', $_arr_tplData);
    }
}
