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
class CONTROL_CONSOLE_UI_ATTACH {

    private $group_allow    = array();
    private $is_super       = false;
    public $allowExtRows    = array();
    public $allowMimeRows   = array();

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

        $this->mdl_attach   = new MODEL_ATTACH(); //设置上传信息对象
        $this->mdl_thumb    = new MODEL_THUMB();
        $this->mdl_mime     = new MODEL_MIME();
        $this->mdl_admin    = new MODEL_ADMIN();
        $this->mdl_article  = new MODEL_ARTICLE(); //设置文章对象
        $this->mdl_cate     = new MODEL_CATE(); //设置栏目对象
        $this->mdl_mark     = new MODEL_MARK(); //设置标记对象

        $this->setUpload();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'uploadSize'    => BG_UPLOAD_SIZE * $this->sizeUnit,
            'type'          => $this->mdl_thumb->arr_type,
            'allowExtRows'  => $this->allowExtRows,
            'allowMimeRows' => $this->allowMimeRows,
        );
    }


    function ctrl_article() {
        $_num_articleId = fn_getSafe(fn_get('article_id'), 'int', 0);
        if ($_num_articleId < 1) {
            $this->tplData['rcode'] = 'x120212';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
        if ($_arr_articleRow['rcode'] != 'y120102') {
            $this->tplData['rcode'] = $_arr_articleRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if ((!isset($this->group_allow['article']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['edit']) && $_arr_articleRow['article_admin_id'] != $this->adminLogged['admin_id']) && !isset($this->group_allow['attach']['browse']) && !$this->is_super) { //判断权限
            $this->tplData['rcode'] = 'x120303';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_cateRow     = $this->mdl_cate->mdl_read($_arr_articleRow['article_cate_id']);
        $_arr_markRow     = $this->mdl_mark->mdl_read($_arr_articleRow['article_mark_id']);

        $_arr_attachIds = fn_qlistAttach($_arr_articleRow['article_content']);

        $_arr_attachRows  = array();
        $_arr_page        = fn_page(0);

        $_arr_search = array(
            'attach_ids'    => $_arr_attachIds,
            'box'           => 'normal',
        );

        if (!fn_isEmpty($_arr_attachIds)) {
            $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
            $_arr_page        = fn_page($_num_attachCount);
            $_arr_attachRows  = $this->mdl_attach->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

            foreach ($_arr_attachRows as $_key=>$_value) {
                if ($_value['attach_type'] == 'image') {
                    $_arr_attachRows[$_key]['attach_thumb'] = $this->mdl_attach->thumb_process($_value['attach_id'], $_value['attach_time'], $_value['attach_ext']);
                }
                $_arr_attachRows[$_key]['adminRow'] = $this->mdl_admin->mdl_read($_value['attach_admin_id']);
            }
        }

        $_arr_tpl = array(
            'ids'           => implode('|', $_arr_attachIds),
            'pageRow'       => $_arr_page,
            'markRow'       => $_arr_markRow,
            'cateRow'       => $_arr_cateRow,
            'attachRows'    => $_arr_attachRows,
            'articleRow'    => $_arr_articleRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('attach_article', $_arr_tplData);
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_form() {
        if (!isset($this->group_allow['attach']['upload']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x070302';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (fn_isEmpty($this->allowExtRows)) {
            $this->tplData['rcode'] = 'x070405';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_articleId   = fn_getSafe(fn_get('article_id'), 'int', 0);
        if ($_num_articleId > 0) {
            $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
            if ($_arr_articleRow['rcode'] != 'y120102') {
                $this->tplData['rcode'] = $_arr_articleRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            $_arr_articleRow = array(
                'article_id' => 0,
            );
        }

        $_arr_yearRows    = $this->mdl_attach->mdl_year(100);
        $_arr_extRows     = $this->mdl_attach->mdl_ext();

        $_arr_tpl = array(
            'articleRow' => $_arr_articleRow,
            'yearRows'   => $_arr_yearRows,
            'extRows'    => $_arr_extRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('attach_form', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow['attach']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x070301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (fn_isEmpty($this->allowExtRows)) {
            $this->tplData['rcode'] = 'x070405';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_str_attachIds   = fn_getSafe(fn_get('ids'), 'txt', '');

        if (fn_isEmpty($_str_attachIds)) {
            $_arr_attachIds = false;
        } else {
            $_arr_attachIds = explode('|', $_str_attachIds);
        }

        $_arr_search = array(
            'box'           => fn_getSafe(fn_get('box'), 'txt', 'normal'),
            'key'           => fn_getSafe(fn_get('key'), 'txt', ''),
            'year'          => fn_getSafe(fn_get('year'), 'txt', ''),
            'month'         => fn_getSafe(fn_get('month'), 'txt', ''),
            'ext'           => fn_getSafe(fn_get('ext'), 'txt', ''),
            'admin_id'      => fn_getSafe(fn_get('admin_id'), 'int', 0),
            'ids'           => $_str_attachIds,
            'attach_ids'    => $_arr_attachIds,
        ); //搜索设置

        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_attachCount);
        $_str_query       = http_build_query($_arr_search);
        $_arr_yearRows    = $this->mdl_attach->mdl_year(100);
        $_arr_extRows     = $this->mdl_attach->mdl_ext();
        $_arr_attachRows  = $this->mdl_attach->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        foreach ($_arr_attachRows as $_key=>$_value) {
            if ($_value['attach_type'] == 'image') {
                //print_r($_arr_url);
                $_arr_attachRows[$_key]['attach_thumb'] = $this->mdl_attach->thumb_process($_value['attach_id'], $_value['attach_time'], $_value['attach_ext']);
            }
            $_arr_attachRows[$_key]['adminRow'] = $this->mdl_admin->mdl_read($_value['attach_admin_id']);
        }

        //print_r($_arr_attachRows);
        $_arr_searchAll = array(
            'box' => 'normal',
        );

        $_arr_searchRecycle = array(
            'box' => 'recycle',
        );

        $_arr_attachCount['all']     = $this->mdl_attach->mdl_count($_arr_searchAll);
        $_arr_attachCount['recycle'] = $this->mdl_attach->mdl_count($_arr_searchRecycle);

        $_arr_tpl = array(
            'query'          => $_str_query,
            'pageRow'        => $_arr_page,
            'search'         => $_arr_search,
            'attachCount'    => $_arr_attachCount,
            'attachRows'     => $_arr_attachRows, //上传信息
            'yearRows'       => $_arr_yearRows, //目录列表
            'extRows'        => $_arr_extRows, //扩展名列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('attach_list', $_arr_tplData);
    }


    /**
     * setUpload function.
     *
     * @access private
     */
    private function setUpload() {
        $_arr_allowMimeRows = array();
        $_arr_allowExtRows  = array();
        $_arr_mimeRows      = $this->mdl_mime->mdl_list(100);

        foreach ($_arr_mimeRows as $_key=>$_value) {
            $_arr_allowExtRows[]    = strtolower($_value['mime_ext']);
            $_arr_allowMimeRows     = array_merge($_arr_allowMimeRows, $_value['mime_content']);
        }

        $this->allowExtRows     = array_filter(array_unique($_arr_allowExtRows));
        $this->allowMimeRows    = array_filter(array_unique($_arr_allowMimeRows));

        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_list(100);

        //print_r($this->allowMimeRows);

        switch (BG_UPLOAD_UNIT) { //初始化单位
            case 'B':
                $this->sizeUnit = 1;
            break;

            case 'KB':
                $this->sizeUnit = 1024;
            break;

            case 'MB':
                $this->sizeUnit = 1024 * 1024;
            break;

            case 'GB':
                $this->sizeUnit = 1024 * 1024 * 1024;
            break;
        }
    }
}
