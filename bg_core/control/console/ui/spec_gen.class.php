<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

class CONTROL_CONSOLE_UI_SPEC_GEN {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_article_pub  = new MODEL_ARTICLE_PUB(); //设置文章对象

        $this->tplData = array(
            'adminLogged'    => $this->adminLogged,
        );
    }


    function ctrl_list() {
        $_str_overall   = fn_getSafe(fn_get('overall'), 'txt', ''); //ID
        $_num_page      = fn_getSafe(fn_get('page'), 'int', 0);

        $_arr_search = array(
            'status'    => 'show',
        );
        $_num_specCount = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page      = fn_page($_num_specCount, BG_SITE_PERPAGE); //取得分页数据
        $_arr_page      = $this->page_process($_arr_page);

        if ($_num_page > $_arr_page['total']) {
            $this->tplData['rcode'] = 'y120406';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_tplData = array(
            'pageRow'   => $_arr_page,
            'search'    => $_arr_search,
        );

        $this->obj_tpl->tplDisplay('spec_gen_list', $_arr_tplData);
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function ctrl_single() {
        $_num_specId = fn_getSafe(fn_get('spec_id'), 'int', 0); //ID

        if ($_num_specId < 1) {
            $this->tplData['rcode'] = 'x180204';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
        if ($_arr_specRow['rcode'] != 'y180102') {
            $this->tplData['rcode'] = $_arr_specRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if ($_arr_specRow['spec_status'] != 'show') {
            $this->tplData['rcode'] = 'x180404';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_page = $this->data_process($_arr_specRow);

        $_arr_tplData = array(
            'specRow'   => $_arr_specRow,
            'pageRow'   => $_arr_page,
        );

        $this->obj_tpl->tplDisplay('spec_gen_single', $_arr_tplData);
    }


    function ctrl_1by1() {
        $_num_maxId     = fn_getSafe(fn_get('max_id'), 'int', 0); //ID
        $_str_overall   = fn_getSafe(fn_get('overall'), 'txt', ''); //ID

        $_str_jump = BG_URL_CONSOLE . 'index.php?mod=spec_gen';

        $_arr_page = array(
            'total' => 1,
        );

        $_arr_specRow = $this->mdl_spec->mdl_read($_num_maxId, true);
        if ($_arr_specRow['rcode'] != 'y180102') {
            if ($_str_overall == 'true') {
                $_str_jump .= '&act=list';
            } else {
                $this->tplData['rcode'] = 'y120406';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_str_jump .= '&act=1by1&max_id=' . $_arr_specRow['spec_id'];

            if ($_arr_specRow['spec_status'] == 'show') {
                $_arr_page = $this->data_process($_arr_specRow);
            }
        }

        if ($_str_overall == 'true') {
            $_str_jump .= '&overall=true';
        }

        $_str_jump .= '&view=iframe';

        $_arr_tplData = array(
            'specRow'   => $_arr_specRow,
            'pageRow'   => $_arr_page,
            'jump'      => $_str_jump,
            'overall'   => $_str_overall,
        );

        $this->obj_tpl->tplDisplay('spec_gen_1by1', $_arr_tplData);
    }


    private function data_process($arr_specRow) {
        $_arr_search = array(
            'spec_ids' => array($arr_specRow['spec_id']),
        );
        $_num_articleCount  = $this->mdl_article_pub->mdl_count($_arr_search); //统计
        $_arr_page          = fn_page($_num_articleCount, BG_SITE_PERPAGE); //取得分页数据

        $_arr_page = $this->page_process($_arr_page);

        return $_arr_page;
    }


    private function page_process($arr_page) {
        if ($arr_page['total'] >= BG_VISIT_PAGE) {
            $arr_page['total'] = BG_VISIT_PAGE;
        }

        if ($arr_page['end'] >= BG_VISIT_PAGE) {
            $arr_page['end'] = BG_VISIT_PAGE;
        }

        return $arr_page;
    }
}
