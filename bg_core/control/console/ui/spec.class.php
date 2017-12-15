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
class CONTROL_CONSOLE_UI_SPEC {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console      = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged      = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl          = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_cate         = new MODEL_CATE(); //设置栏目对象
        $this->mdl_article      = new MODEL_ARTICLE(); //设置文章对象
        $this->mdl_call         = new MODEL_CALL();
        $this->mdl_spec_belong  = new MODEL_SPEC_BELONG(); //设置文章对象

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_spec->arr_status,
            'statusArticle' => $this->mdl_article->arr_status,
        );
    }


    /**
     * ctrl_select function.
     *
     * @access public
     */
    function ctrl_select() {
        if (!isset($this->group_allow['spec']['edit']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x180303';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_specId = fn_getSafe(fn_get('spec_id'), 'int', 0);

        if ($_num_specId < 1) {
            $this->tplData['rcode'] = 'x180204';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
        if ($_arr_specRow['rcode'] != 'y180102') {
            $this->tplData['rcode'] = $_arr_specRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_cateId = fn_getSafe(fn_get('cate_id'), 'int', 0);

        if ($_num_cateId != 0) {
            $_arr_cateIds = $this->mdl_cate->mdl_ids($_num_cateId);
        } else {
            $_arr_cateIds = false;
        }

        $_arr_searchBelong = array(
            'key'       => fn_getSafe(fn_get('key_belong'), 'txt', ''),
            'spec_ids'  => array($_num_specId),
        );

        $_arr_belongIds     = array();

        $_arr_belongRows    = $this->mdl_article->mdl_list(1000, 0, $_arr_searchBelong);

        foreach ($_arr_belongRows as $_key=>$_value) {
            $_arr_belongIds[] = $_value['article_id'];
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'status'    => fn_getSafe(fn_get('status'), 'txt', ''),
            'cate_id'   => $_num_cateId,
            'cate_ids'  => $_arr_cateIds,
            'not_ids'   => $_arr_belongIds,
        );

        $_num_articleCount  = $this->mdl_article->mdl_count($_arr_search);
        $_arr_page          = fn_page($_num_articleCount); //取得分页数据
        $_str_query         = http_build_query($_arr_search);
        $_arr_articleRows   = $this->mdl_article->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_searchCate = array(
            'status' => 'show',
        );
        $_arr_cateRows        = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);

        $_arr_tpl = array(
            'query'         => $_str_query,
            'pageRow'       => $_arr_page,
            'search'        => $_arr_search,
            'searchBelong'  => $_arr_searchBelong,
            'specRow'       => $_arr_specRow,
            'cateRows'      => $_arr_cateRows,
            'articleRows'   => $_arr_articleRows,
            'belongRows'    => $_arr_belongRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('spec_select', $_arr_tplData);
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_form() {
        $_num_specId = fn_getSafe(fn_get('spec_id'), 'int', 0);

        if ($_num_specId > 0) {
            if (!isset($this->group_allow['spec']['edit']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x180303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
            if ($_arr_specRow['rcode'] != 'y180102') {
                $this->tplData['rcode'] = $_arr_specRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            if (!isset($this->group_allow['spec']['add']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x180302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_specRow = array(
                'spec_id'       => 0,
                'spec_name'     => '',
                'spec_content'  => '',
                'spec_status'   => $this->mdl_spec->arr_status[0],
            );
        }

        $_arr_tpl = array(
            'specRow' => $_arr_specRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('spec_form', $_arr_tplData);
    }


    function ctrl_insert() {
        $_arr_specIds   = array();
        $_str_target    = fn_getSafe(fn_get('target'), 'txt', 'article');

        switch ($_str_target) {
            case 'call':
                $_arr_articleRow = array();
                $_num_callId = fn_getSafe(fn_get('call_id'), 'int', 0);
                if ($_num_callId > 0) {
                    $_arr_callRow = $this->mdl_call->mdl_read($_num_callId); //读取文章
                    if ($_arr_callRow['rcode'] != 'y170102') {
                        $this->tplData['rcode'] = $_arr_callRow['rcode'];
                        $this->obj_tpl->tplDisplay('error', $this->tplData);
                    }

                    $_arr_specIds = $_arr_callRow['call_spec_ids'];
                } else {
                    $_arr_callRow = array(
                        'call_id' => 0,
                    );
                }
            break;

            default:
                $_arr_callRow   = array();
                $_num_articleId = fn_getSafe(fn_get('article_id'), 'int', 0);
                if ($_num_articleId > 0) {
                    $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
                    if ($_arr_articleRow['rcode'] != 'y120102') {
                        $this->tplData['rcode'] = $_arr_articleRow['rcode'];
                        $this->obj_tpl->tplDisplay('error', $this->tplData);
                    }

                    $_arr_specIds = $this->mdl_spec_belong->mdl_ids($_num_articleId);
                } else {
                    $_arr_articleRow = array(
                        'article_id' => 0,
                    );
                }
            break;
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'target'    => $_str_target,
        );

        $_str_specIds = json_encode($_arr_specIds);

        $_arr_tpl = array(
            'specIds'       => $_str_specIds,
            'search'        => $_arr_search,
            'callRow'       => $_arr_callRow,
            'articleRow'    => $_arr_articleRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('spec_insert', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow['spec']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x180301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'        => fn_getSafe(fn_get('key'), 'txt', ''),
            'status'     => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_specCount   = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_specCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_specRows    = $this->mdl_spec->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'     => $_str_query,
            'pageRow'   => $_arr_page,
            'search'    => $_arr_search,
            'specRows'  => $_arr_specRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('spec_list', $_arr_tplData);
    }
}
