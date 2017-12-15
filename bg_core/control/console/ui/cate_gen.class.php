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
class CONTROL_CONSOLE_UI_CATE_GEN {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->mdl_cate         = new MODEL_CATE();
        $this->mdl_article_pub  = new MODEL_ARTICLE_PUB(); //设置文章对象

        $this->tplData = array(
            'adminLogged'    => $this->adminLogged,
        );
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function ctrl_single() {
        $_num_cateId = fn_getSafe(fn_get('cate_id'), 'int', 0); //ID

        if ($_num_cateId < 1) {
            $this->tplData['rcode'] = 'x250217';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_readPub($_num_cateId);
        if ($_arr_cateRow['rcode'] != 'y250102') {
            $this->tplData['rcode'] = $_arr_cateRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if ($_arr_cateRow['cate_status'] != 'show' || ($_arr_cateRow['cate_type'] == 'link' && !fn_isEmpty($_arr_cateRow['cate_link']))) {
            $this->tplData['rcode'] = 'x250404';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_cateRow['cate_ids'] = $this->mdl_cate->mdl_ids($_arr_cateRow['cate_id']);

        $_arr_page = $this->data_process($_arr_cateRow);

        //print_r($_arr_page);

        $_arr_tpl = array(
            'cateRow'   => $_arr_cateRow,
            'pageRow'   => $_arr_page,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('cate_gen_single', $_arr_tplData);
    }


    function ctrl_1by1() {
        $_num_minId     = fn_getSafe(fn_get('min_id'), 'int', 0); //ID
        $_str_overall   = fn_getSafe(fn_get('overall'), 'txt', ''); //ID

        $_str_jump = BG_URL_CONSOLE . 'index.php?';

        $_arr_page = array(
            'total' => 1,
        );

        $_arr_cateRow = $this->mdl_cate->mdl_readPub($_num_minId, 'cate_id', 0, 0, true);
        if ($_arr_cateRow['rcode'] != 'y250102') {
            if ($_str_overall == 'true') {
                $_str_jump .= 'mod=call_gen&act=list';
            } else {
                $this->tplData['rcode'] = 'y120406';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_str_jump .= 'mod=cate_gen&act=1by1&min_id=' . $_arr_cateRow['cate_id'];

            if ($_arr_cateRow['cate_status'] == 'show' && ($_arr_cateRow['cate_type'] != 'link' && fn_isEmpty($_arr_cateRow['cate_link']))) {
                $_arr_cateRow['cate_ids'] = $this->mdl_cate->mdl_ids($_arr_cateRow['cate_id']);
                $_arr_page      = $this->data_process($_arr_cateRow);
            }
        }

        if ($_str_overall == 'true') {
            $_str_jump .= '&overall=true';
        }

        $_str_jump .= '&view=iframe';

        $_arr_tpl = array(
            'cateRow'   => $_arr_cateRow,
            'pageRow'   => $_arr_page,
            'jump'      => $_str_jump,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('cate_gen_1by1', $_arr_tplData);
    }



    private function data_process($arr_cateRow) {
        //每页记录数
        if ($arr_cateRow['cate_perpage'] > 0 && $arr_cateRow['cate_perpage'] != BG_SITE_PERPAGE) {
            $_num_perpage = $arr_cateRow['cate_perpage'];
        } else {
            $_num_perpage = BG_SITE_PERPAGE;
        }

        $_arr_search = array(
            'cate_ids' => $arr_cateRow['cate_ids'],
        );
        $_num_articleCount  = $this->mdl_article_pub->mdl_count($_arr_search); //统计
        $_arr_page          = fn_page($_num_articleCount, $_num_perpage); //取得分页数据

        if ($_arr_page['total'] >= BG_VISIT_PAGE) {
            $_arr_page['total'] = BG_VISIT_PAGE;
        }

        if ($_arr_page['end'] >= BG_VISIT_PAGE) {
            $_arr_page['end'] = BG_VISIT_PAGE;
        }

        $_arr_page['perpage'] = $_num_perpage;

        return $_arr_page;
    }


}
