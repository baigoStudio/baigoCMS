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
class CONTROL_CONSOLE_UI_ARTICLE_GEN {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->mdl_cate     = new MODEL_CATE(); //设置文章对象
        $this->mdl_article  = new MODEL_ARTICLE(); //设置文章对象

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
        $_num_articleId = fn_getSafe(fn_get('article_id'), 'int', 0); //ID

        if ($_num_articleId < 1) {
            $this->tplData['rcode'] = 'x120212';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId);
        if ($_arr_articleRow['rcode'] != 'y120102') {
            $this->tplData['rcode'] = $_arr_articleRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (fn_isEmpty($_arr_articleRow['article_title']) || $_arr_articleRow['article_status'] != 'pub' || $_arr_articleRow['article_box'] != 'normal' || ($_arr_articleRow['article_is_time_pub'] > 0 && $_arr_articleRow['article_time_pub'] > time()) || ($_arr_articleRow['article_is_time_hide'] > 0 && $_arr_articleRow['article_time_hide'] < time())) {
            $this->tplData['rcode'] = 'x120404';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (!fn_isEmpty($_arr_articleRow['article_link'])) {
            $this->mdl_article->mdl_isGen($_arr_articleRow['article_id']);
            $this->tplData['rcode'] = 'x120404';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_readPub($_arr_articleRow['article_cate_id']);

        if ($_arr_cateRow['rcode'] != 'y250102' || $_arr_cateRow['cate_status'] != 'show' || ($_arr_cateRow['cate_type'] == 'link' && !fn_isEmpty($_arr_cateRow['cate_link']))) {
            $this->tplData['rcode'] = 'x120404';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_articleRow['cateRow'] = $_arr_cateRow;

        $_arr_tpl = array(
            'articleRow'    => $_arr_articleRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('article_gen_single', $_arr_tplData);
    }


    function ctrl_list() {
        $_str_overall   = fn_getSafe(fn_get('overall'), 'txt', ''); //ID
        $_str_enforce   = fn_getSafe(fn_get('enforce'), 'txt', ''); //ID
        //$_num_page      = fn_getSafe(fn_get('page'), 'int', 1);
        $_num_maxId     = fn_getSafe(fn_get('max_id'), 'int', 0);

        $_arr_search = array(
            'gen'       => 'true',
            'max_id'    => $_num_maxId,
        );

        if ($_str_enforce != 'true') {
            $_arr_search['not_enforce'] = 'true';
        }

        $_arr_articleRows   = array();
        $_str_jump          = BG_URL_CONSOLE . 'index.php?';

        $_arr_order = array(
            array('article_id', 'DESC'),
        );
        $_arr_articleRows   = $this->mdl_article->mdl_list(BG_COUNT_GEN, 0, $_arr_search, $_arr_order);

        if (fn_isEmpty($_arr_articleRows)) {
            if ($_str_overall == 'true') {
                $_str_jump .= 'm=cate_gen&a=1by1';
            } else {
                $this->tplData['rcode'] = 'y120406';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_arr_articleRow = end($_arr_articleRows);
            $_str_jump .= 'm=article_gen&a=list&max_id=' . $_arr_articleRow['article_id'];
        }

        if ($_str_overall == 'true') {
            $_str_jump .= '&overall=true';
        }
        if ($_str_enforce == 'true') {
            $_str_jump .= '&enforce=true';
        }
        $_str_jump .= '&view=iframe';

        $_arr_tpl = array(
            'jump'          => $_str_jump,
            'enforce'       => $_str_enforce,
            'articleRows'   => $_arr_articleRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('article_gen_list', $_arr_tplData);
    }
}
