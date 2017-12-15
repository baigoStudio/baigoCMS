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
class CONTROL_CONSOLE_UI_TAG {

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

        $this->mdl_tag      = new MODEL_TAG(); //设置上传信息对象

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_tag->arr_status,
        );
    }


    function ctrl_form() {
        if (!isset($this->group_allow['article']['tag']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x130301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_tagId = fn_getSafe(fn_get('tag_id'), 'int', 0);

        if ($_num_tagId > 0) {
            $_arr_tagRow = $this->mdl_tag->mdl_read($_num_tagId);
            if ($_arr_tagRow['rcode'] != 'y130102') {
                $this->tplData['rcode'] = $_arr_tagRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_arr_tagRow = array(
                'tag_id'        => 0,
                'tag_name'      => '',
                'tag_status'    => $this->mdl_tag->arr_status[0],
            );
        }

        $_arr_tpl = array(
            'tagRow'     => $_arr_tagRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('tag_form', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow['article']['tag']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x130301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'        => fn_getSafe(fn_get('key'), 'txt', ''),
            'status'     => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_tagCount    = $this->mdl_tag->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_tagCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_tagRows     = $this->mdl_tag->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'tagRows'    => $_arr_tagRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('tag_list', $_arr_tplData);
    }
}
