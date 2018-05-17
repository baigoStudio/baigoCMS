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
class CONTROL_CONSOLE_UI_SOURCE {

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

        $this->mdl_source     = new MODEL_SOURCE();

        $this->tplData = array(
            'adminLogged' => $this->adminLogged
        );
    }


    function ctrl_form() {
        if (!isset($this->group_allow['article']['source']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x260301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_sourceId  = fn_getSafe(fn_get('source_id'), 'int', 0);

        if ($_num_sourceId > 0) {
            $_arr_sourceRow = $this->mdl_source->mdl_read($_num_sourceId);
            if ($_arr_sourceRow['rcode'] != 'y260102') {
                $this->tplData['rcode'] = $_arr_sourceRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_arr_sourceRow = array(
                'source_id'     => 0,
                'source_name'   => '',
                'source_author' => '',
                'source_url'    => '',
                'source_note'   => '',
            );
        }

        $_arr_tpl = array(
            'sourceRow'    => $_arr_sourceRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('source_form', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow['article']['source']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x260301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key' => fn_getSafe(fn_get('key'), 'txt', ''),
        );

        $_num_sourceCount   = $this->mdl_source->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_sourceCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_sourceRows    = $this->mdl_source->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'sourceRows'   => $_arr_sourceRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('source_list', $_arr_tplData);
    }
}
