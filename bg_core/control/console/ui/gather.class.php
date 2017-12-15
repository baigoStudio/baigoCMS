<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


fn_include(BG_PATH_FUNC . 'gather.func.php');

/*-------------用户类-------------*/
class CONTROL_CONSOLE_UI_GATHER {

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

        $this->mdl_gsite    = new MODEL_GSITE();
        $this->mdl_cate     = new MODEL_CATE();
        $this->mdl_gather   = new MODEL_GATHER();
        $this->mdl_article  = new MODEL_ARTICLE();
        $this->mdl_admin    = new MODEL_ADMIN();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'statusGsite'   => $this->mdl_gsite->arr_status,
        );
    }


    function ctrl_1by1() {
        if (!isset($this->group_allow['gather']['gather']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x270303';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_gatherRows    = array();
        $_str_jump          = '';
        $_count             = 1;

        $_num_minId = fn_getSafe(fn_get('min_id'), 'int', 0);

        $_arr_gsiteRow = $this->mdl_gsite->mdl_read($_num_minId, 'gsite_id', true);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            $this->tplData['rcode'] = 'y280401';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite->selector_process($_arr_gsiteRow);

        $_str_jump = BG_URL_CONSOLE . 'index.php?mod=gather&act=1by1&min_id=' . $_arr_gsiteRow['gsite_id'] . '&view=iframe';

        if (!fn_isEmpty($_arr_gsiteRow['gsite_list_selector']) && !fn_isEmpty($_arr_gsiteRow['gsite_title_selector'])) {
            $_arr_rule = array(
                'url'       => array($_arr_gsiteRow['gsite_list_selector'], 'href'),
                'content'   => array($_arr_gsiteRow['gsite_list_selector'], 'html', $_arr_gsiteRow['gsite_page_content_filter']),
            );

            $_obj_dom = fn_qlistDom($_arr_gsiteRow['gsite_url'], $_arr_rule, $_arr_gsiteRow['gsite_charset']);

            if (!fn_isEmpty($_obj_dom)) {
                foreach ($_obj_dom as $_key=>$_value) {
                    if ($_count < BG_COUNT_GATHER) {
                        $_str_md5 = md5(fn_formatUrl($_value['url'], $_arr_gsiteRow['gsite_url']));
                        $_arr_gatherRows[$_str_md5] = array(
                            'url'       => fn_formatUrl($_value['url'], $_arr_gsiteRow['gsite_url']),
                            'content'   => $_value['content'],
                        );
                    }

                    $_count++;
                }
            }
        }

        $_arr_tpl = array(
            'jump'          => $_str_jump,
            'gsiteRow'      => $_arr_gsiteRow,
            'gatherRows'    => $_arr_gatherRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gather_1by1', $_arr_tplData);
    }


    function ctrl_store() {
        if (!isset($this->group_allow['gather']['gather']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x270303';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_page      = fn_getSafe(fn_get('page'), 'int', 1);
        $_bool_enforce  = fn_getSafe(fn_get('enforce'), 'txt', '');

        $_arr_search = array();

        if ($_bool_enforce != 'true') {
            $_arr_search['wait'] = 'true';
        }

        $_str_ids = '';

        if ($GLOBALS['route']['bg_act'] == 'store') {
            $_arr_gatherIds = fn_get('gather_ids');
            if (fn_isEmpty($_arr_gatherIds)) {
                $this->tplData['rcode'] = 'x030202';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            foreach ($_arr_gatherIds as $_key=>$_value) {
                $_num_id    = fn_getSafe($_value, 'int', 0);
                $_arr_ids[] = $_num_id;
                $_str_ids  .= '&gather_ids[]=' . $_num_id;
            }

            $_arr_search['gather_ids'] = $_arr_ids;
        }

        //print_r($_str_ids);

        $_num_gatherCount   = $this->mdl_gather->mdl_count($_arr_search);
        $_arr_page          = fn_page($_num_gatherCount, BG_COUNT_GATHER); //取得分页数据

        if ($_num_page > $_arr_page['total']) {
            $this->tplData['rcode'] = 'y280404';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_str_query         = http_build_query($_arr_search);
        $_arr_gatherRows    = $this->mdl_gather->mdl_list(BG_COUNT_GATHER, $_arr_page['except'], $_arr_search, 'ASC');

        $_str_jump = BG_URL_CONSOLE . 'index.php?mod=gather&act=' . $GLOBALS['route']['bg_act'] . '&page=' . ($_arr_page['page'] + 1) . '&view=iframe' . $_str_ids . '&enforce=' . $_bool_enforce;

        $_arr_tpl = array(
            'jump'          => $_str_jump,
            'gatherRows'    => $_arr_gatherRows,
            'enforce'       => $_bool_enforce,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gather_store', $_arr_tplData);
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_single() {
        if (!isset($this->group_allow['gather']['gather']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x270303';
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

        $_arr_gsiteRow = $this->mdl_gsite->selector_process($_arr_gsiteRow);

        if (fn_isEmpty($_arr_gsiteRow['gsite_list_selector'])) {
            $this->tplData['rcode'] = 'x280203';
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        if (fn_isEmpty($_arr_gsiteRow['gsite_title_selector'])) {
            $this->tplData['rcode'] = 'x280202';
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $_arr_gatherRows = array();

        $_count = 1;

        $_arr_rule = array(
            'url'       => array($_arr_gsiteRow['gsite_list_selector'], 'href'),
            'content'   => array($_arr_gsiteRow['gsite_list_selector'], 'html'),
        );

        $_obj_dom = fn_qlistDom($_arr_gsiteRow['gsite_url'], $_arr_rule, $_arr_gsiteRow['gsite_charset']);

        if (!fn_isEmpty($_obj_dom)) {
            foreach ($_obj_dom as $_key=>$_value) {
                if ($_count < BG_COUNT_GATHER) {
                    $_str_md5 = md5(fn_formatUrl($_value['url'], $_arr_gsiteRow['gsite_url']));

                    $_arr_gatherRows[$_str_md5] = array(
                        'url'       => fn_formatUrl($_value['url'], $_arr_gsiteRow['gsite_url']),
                        'content'   => $_value['content'],
                    );
                }

                $_count++;
            }
        }

        $_arr_tpl = array(
            'gsiteRow'      => $_arr_gsiteRow,
            'gatherRows'    => $_arr_gatherRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gather_single', $_arr_tplData);
    }


    function ctrl_show() {
        if (!isset($this->group_allow['gather']['approve']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x280301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_gatherId = fn_getSafe(fn_get('gather_id'), 'int', 0);
        if ($_num_gatherId < 1) {
            $this->tplData['rcode'] = 'x280204';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_gatherRow = $this->mdl_gather->mdl_read($_num_gatherId);
        if ($_arr_gatherRow['rcode'] != 'y280102') {
            $this->tplData['rcode'] = $_arr_gatherRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_gsiteRow      = $this->mdl_gsite->mdl_read($_arr_gatherRow['gather_gsite_id']);
        $_arr_cateRow       = $this->mdl_cate->mdl_read($_arr_gatherRow['gather_cate_id']);
        $_arr_articleRow    = $this->mdl_article->mdl_read($_arr_gatherRow['gather_article_id']);
        $_arr_adminRow      = $this->mdl_admin->mdl_read($_arr_gatherRow['gather_admin_id']);

        $_arr_tpl = array(
            'gatherRow'     => $_arr_gatherRow,
            'gsiteRow'      => $_arr_gsiteRow,
            'cateRow'       => $_arr_cateRow,
            'articleRow'    => $_arr_articleRow,
            'adminRow'      => $_arr_adminRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gather_' . $GLOBALS['route']['bg_act'], $_arr_tplData);
    }


    function ctrl_list() {
        if (!isset($this->group_allow['gather']['approve']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x280301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'gsite_id'  => fn_getSafe(fn_get('gsite_id'), 'int', 0),
            'cate_id'   => fn_getSafe(fn_get('cate_id'), 'int', 0),
        );

        $_num_gatherCount   = $this->mdl_gather->mdl_count($_arr_search);
        $_arr_page          = fn_page($_num_gatherCount); //取得分页数据
        $_str_query         = http_build_query($_arr_search);
        $_arr_gatherRows    = $this->mdl_gather->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        foreach ($_arr_gatherRows as $_key=>$_value) {
            $_arr_gatherRows[$_key]['cateRow']  = $this->mdl_cate->mdl_read($_value['gather_cate_id']);
            $_arr_gatherRows[$_key]['gsiteRow'] = $this->mdl_gsite->mdl_read($_value['gather_gsite_id']);
        }

        $_arr_searchCate = array(
            'status' => 'show',
        );
        $_arr_cateRows      = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);

        $_arr_searchGsite = array(
            'status' => 'enable',
        );
        $_arr_gsiteRows      = $this->mdl_gsite->mdl_list(1000, 0, $_arr_searchGsite);

        $_arr_tpl = array(
            'query'         => $_str_query,
            'pageRow'       => $_arr_page,
            'search'        => $_arr_search,
            'gatherRows'    => $_arr_gatherRows,
            'gsiteRows'     => $_arr_gsiteRows,
            'cateRows'      => $_arr_cateRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gather_list', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_gather() {
        if (!isset($this->group_allow['gather']['gather']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x280301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
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

        $this->obj_tpl->tplDisplay('gather_gather', $_arr_tplData);
    }
}
