<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

if (!function_exists('fn_qlistAttach')) {
    fn_include(BG_PATH_FUNC . 'gather.func.php');
}

/*-------------用户类-------------*/
class CONTROL_CONSOLE_UI_GSITE_SOURCE {

    private $gsiteRow       = array();
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

        $this->tplData = array(
            'adminLogged' => $this->adminLogged,
        );

        $this->gsite_init();
    }


    function ctrl_page_content() {
        $_arr_sourceRow  = array(
            'url'       => '',
            'content'   => '',
        );

        if (!fn_isEmpty($this->gsiteRow['gsite_list_selector']) && !fn_isEmpty($this->gsiteRow['gsite_page_list_selector'])) {
            $_arr_rule = array(
                'url' => array($this->gsiteRow['gsite_list_selector'], 'href'),
            );

            $_obj_dom = fn_qlistDom($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

            if (isset($_obj_dom[0]['url']) && !fn_isEmpty($_obj_dom[0]['url'])) {
                $_str_pageUrl    = fn_formatUrl($_obj_dom[0]['url'], $this->gsiteRow['gsite_url']);

                $_arr_pageRule = array(
                    'url' => array($this->gsiteRow['gsite_page_list_selector'], 'href'),
                );

                $_obj_domPage    = fn_qlistDom($_str_pageUrl, $_arr_pageRule, $this->gsiteRow['gsite_charset']);

                if (isset($_obj_domPage[0]['url']) && !fn_isEmpty($_obj_domPage[0]['url'])) {
                    $_str_contentUrl    = fn_formatUrl($_obj_domPage[0]['url'], $this->gsiteRow['gsite_url']);

                    $_arr_contentRule = array(
                        'content' => array('', 'html'),
                    );

                    $_obj_domContent    = fn_qlistDom($_str_contentUrl, $_arr_contentRule, $this->gsiteRow['gsite_charset']);

                    $_arr_sourceRow['url'] = $_str_contentUrl;

                    if (isset($_obj_domContent[0]['content'])) {
                        $_arr_sourceRow['content'] = fn_htmlcode($_obj_domContent[0]['content']);
                    }
                }
            }
        }

        $_arr_tpl = array(
            'sourceRow'    => $_arr_sourceRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_source', $_arr_tplData);
    }



    function ctrl_content() {
        $_arr_sourceRow  = array(
            'url'       => '',
            'content'   => '',
        );

        if (!fn_isEmpty($this->gsiteRow['gsite_list_selector'])) {
            $_arr_rule = array(
                'url' => array($this->gsiteRow['gsite_list_selector'], 'href'),
            );

            $_obj_dom = fn_qlistDom($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

            if (isset($_obj_dom[0]['url']) && !fn_isEmpty($_obj_dom[0]['url'])) {
                $_str_contentUrl    = fn_formatUrl($_obj_dom[0]['url'], $this->gsiteRow['gsite_url']);

                $_arr_contentRule = array(
                    'content' => array('', 'html'),
                );

                $_obj_domContent    = fn_qlistDom($_str_contentUrl, $_arr_contentRule, $this->gsiteRow['gsite_charset']);

                $_arr_sourceRow['url'] = $_str_contentUrl;

                if (isset($_obj_domContent[0]['content'])) {
                    $_arr_sourceRow['content'] = fn_htmlcode($_obj_domContent[0]['content']);
                }
            }
        }

        $_arr_tpl = array(
            'sourceRow' => $_arr_sourceRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_source', $_arr_tplData);
    }


    function ctrl_form() {
        $_arr_sourceRow = array(
            'url'       => $this->gsiteRow['gsite_url'],
            'content'   => '',
        );

        switch ($GLOBALS['route']['bg_act']) {
            case 'list':
                $_str_selector = 'body';
            break;

            case 'form':
                $_str_selector = 'head';
            break;
        }

        $_arr_rule = array(
            'content' => array('', 'html'),
        );

        $_obj_dom = fn_qlistDom($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

        if (isset($_obj_dom[0]['content'])) {
            $_arr_sourceRow['content'] = fn_htmlcode($_obj_dom[0]['content']);
        }

        $_arr_tpl = array(
            'sourceRow' => $_arr_sourceRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_source', $_arr_tplData);
    }


    private function gsite_init() {
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

        $this->gsiteRow = $this->mdl_gsite->selector_process($_arr_gsiteRow);
    }
}
