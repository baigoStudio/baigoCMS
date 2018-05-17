<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------文章控制器-------------*/
class CONTROL_CONSOLE_UI_ARTICLE {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged     = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl  = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->mdl_article      = new MODEL_ARTICLE(); //设置文章对象
        $this->mdl_gather       = new MODEL_GATHER(); //设置文章对象
        $this->mdl_cate         = new MODEL_CATE(); //设置栏目对象
        $this->mdl_cate_belong  = new MODEL_CATE_BELONG(); //设置栏目从属对象
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_mark         = new MODEL_MARK(); //设置标记对象
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_admin        = new MODEL_ADMIN(); //设置管理员对象
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->mdl_source       = new MODEL_SOURCE();

        $this->article_init();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_article->arr_status,
            'boxs'          => $this->mdl_article->arr_box,
        );
    }


    /** 文章表单
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_form() {
        $_num_articleId = fn_getSafe(fn_get('article_id'), 'int', 0);
        $_num_gatherId  = fn_getSafe(fn_get('gather_id'), 'int', 0);
        $_arr_specRows  = array();

        if ($_num_articleId > 0) {
            $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
            if ($_arr_articleRow['rcode'] != 'y120102') {
                $this->tplData['rcode'] = $_arr_articleRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            if (!isset($this->group_allow['article']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['edit']) && $_arr_articleRow['article_admin_id'] != $this->adminLogged['admin_id'] && !$this->is_super) { //判断权限
                $this->tplData['rcode'] = 'x120303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_cateBelongRows = $this->mdl_cate_belong->mdl_list($_arr_articleRow['article_id']); //读取从属数据
            foreach ($_arr_cateBelongRows as $_key=>$_value) {
                $_arr_articleRow['cate_ids'][] = $_value['belong_cate_id'];
            }

            $_arr_articleRow['cate_ids'][]   = $_arr_articleRow['article_cate_id'];
            $_arr_searchTag = array(
                'status'        => 'show',
                'article_id'    => $_arr_articleRow['article_id'],
            );
            $_arr_tagRows = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

            $_arr_articleRow['article_tags'] = array();
            foreach ($_arr_tagRows as $_key=>$_value) {
                $_arr_articleRow['article_tags'][]  = $_value['tag_name'];
            }
            $_arr_articleRow['article_excerpt_type'] = 'manual';

            $_arr_searchSpec = array(
                'article_id'    => $_arr_articleRow['article_id'],
            );
            $_arr_specRows = $this->mdl_spec->mdl_list(1000, 0, $_arr_searchSpec);
        } else {
            if (isset($this->group_allow['article']['approve']) || $this->is_super) {
                $_str_status = 'pub';
            } else {
                $_str_status = 'wait';
            }

            if (isset($this->adminLogged['admin_prefer']['excerpt']['type']) && !fn_isEmpty($this->adminLogged['admin_prefer']['excerpt']['type'])) {
                $_str_excerptType = $this->adminLogged['admin_prefer']['excerpt']['type'];
            } else {
                if (defined('BG_SITE_EXCERPT_TYPE') && !fn_isEmpty('BG_SITE_EXCERPT_TYPE')) {
                    $_str_excerptType = BG_SITE_EXCERPT_TYPE;
                } else {
                    $_str_excerptType = 'auto';
                }
            }

            $_str_articleTitle      = '';
            $_str_articleContent    = '';
            $_str_articleExcerpt    = '';
            $_num_articleCateId     = 0;
            $_tm_articleTimeShow    = time();
            $_str_articleSource     = '';
            $_str_articleSourceUrl  = '';
            $_str_articleAuthor     = '';

            if ($_num_gatherId > 0) {
                $_arr_gatherRow = $this->mdl_gather->mdl_read($_num_gatherId); //读取文章
                if ($_arr_gatherRow['rcode'] != 'y280102') {
                    $this->tplData['rcode'] = $_arr_gatherRow['rcode'];
                    $this->obj_tpl->tplDisplay('error', $this->tplData);
                }

                $_str_articleTitle      = $_arr_gatherRow['gather_title'];
                $_str_articleContent    = $_arr_gatherRow['gather_content'];
                $_str_articleExcerpt    = '';
                $_num_articleCateId     = $_arr_gatherRow['gather_cate_id'];
                $_tm_articleTimeShow    = $_arr_gatherRow['gather_time_show'];
                $_str_articleSource     = $_arr_gatherRow['gather_source'];
                $_str_articleSourceUrl  = $_arr_gatherRow['gather_source_url'];
                $_str_articleAuthor     = $_arr_gatherRow['gather_author'];
            }

            $_arr_articleRow = array(
                'article_id'            => 0,
                'article_title'         => $_str_articleTitle,
                'article_content'       => $_str_articleContent,
                'article_link'          => '',
                'article_excerpt'       => $_str_articleExcerpt,
                'article_excerpt_type'  => $_str_excerptType,
                'article_cate_id'       => $_num_articleCateId,
                'article_status'        => $_str_status,
                'article_box'           => 'normal',
                'article_time_show'     => $_tm_articleTimeShow,
                'article_is_time_pub'   => 0,
                'article_time_pub'      => time(),
                'article_is_time_hide'  => 0,
                'article_time_hide'     => time(),
                'cate_ids'              => array(),
                'article_tags'          => array(),
                'article_customs'       => array(),
                'article_mark_id'       => 0,
                'article_source'        => $_str_articleSource,
                'article_source_url'    => $_str_articleSourceUrl,
                'article_author'        => $_str_articleAuthor,
            );
            $_arr_specRow = array();
        }

        $_arr_searchCate = array(
            'status' => 'show',
        );
        $_arr_cateRows      = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);
        $_arr_markRows      = $this->mdl_mark->mdl_list(100);
        $_arr_sourceRows    = $this->mdl_source->mdl_list(100);

        $_arr_sourceJson = array();

        foreach ($_arr_sourceRows as $_key=>$_value) {
            $_arr_sourceJson[$_value['source_id']] = $_value;
        }

        if (fn_isEmpty($_arr_cateRows)) {
            $this->tplData['rcode'] = 'x250401';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_articleRow['cate_ids']        = array_filter(array_unique($_arr_articleRow['cate_ids']));
        $_arr_articleRow['article_tags']    = json_encode($_arr_articleRow['article_tags']);

        $_arr_tpl = array(
            'gather_id'     => $_num_gatherId,
            'specRows'      => $_arr_specRows,
            'cateRows'      => $_arr_cateRows, //栏目列表
            'markRows'      => $_arr_markRows, //标记列表
            'sourceRows'    => $_arr_sourceRows, //标记列表
            'sourceJson'    => json_encode($_arr_sourceJson), //标记列表
            'customRows'    => $this->customRows, //标记列表
            'articleRow'    => $_arr_articleRow, //栏目信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('article_form', $_arr_tplData);
    }


    function ctrl_show_content() {
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

        if (!isset($this->group_allow['article']['browse']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['browse']) && $_arr_articleRow['article_admin_id'] != $this->adminLogged['admin_id'] && !$this->is_super) { //判断权限
            $this->tplData['rcode'] = 'x120301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_tpl = array(
            'articleRow'    => $_arr_articleRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('article_show_content', $_arr_tplData);
    }


    /** 显示文章
     * ctrl_show function.
     *
     * @access public
     * @param mixed $num_articleId
     * @param int $num_ucId (default: 0)
     */
    function ctrl_show() {
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

        if (!isset($this->group_allow['article']['browse']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['browse']) && $_arr_articleRow['article_admin_id'] != $this->adminLogged['admin_id'] && !$this->is_super) { //判断权限
            $this->tplData['rcode'] = 'x120301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_belongRow = $this->mdl_cate_belong->mdl_list($_arr_articleRow['article_id']);
        foreach ($_arr_belongRow as $_key=>$_value) {
            $_arr_articleRow['cate_ids'][] = $_value['belong_cate_id'];
        }
        $_arr_articleRow['cate_ids'][] = $_arr_articleRow['article_cate_id'];

        $_arr_searchCate = array(
            'status' => 'show',
        );

        $_arr_searchTag = array(
            'status'        => 'show',
            'article_id'    => $_arr_articleRow['article_id'],
        );

        $_arr_searchSpec = array(
            'article_id'    => $_arr_articleRow['article_id'],
        );

        $_arr_cateRow                   = $this->mdl_cate->mdl_read($_arr_articleRow['article_cate_id']);
        $_arr_cateRows                  = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);
        $_arr_markRow                   = $this->mdl_mark->mdl_read($_arr_articleRow['article_mark_id']);
        $_arr_tagRows                   = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag); //读取从属数据
        $_arr_specRows                  = $this->mdl_spec->mdl_list(1000, 0, $_arr_searchSpec);
        $_arr_articleRow['cate_ids']    = array_filter(array_unique($_arr_articleRow['cate_ids']));
        $_arr_urlRow                    = $this->mdl_cate->article_url_process($_arr_articleRow, $_arr_cateRow);

        if (!file_exists($_arr_urlRow['article_pathFull'])) {
            $_arr_articleRow['article_is_gen'] = 'not';
        }

        $_arr_articleRow['urlRow']      = $_arr_urlRow;

        $_arr_tpl = array(
            'cateRow'       => $_arr_cateRow, //栏目
            'cateRows'      => $_arr_cateRows, //栏目列表
            'markRow'       => $_arr_markRow, //标记列表
            'customRows'    => $this->customRows, //标记列表
            'articleRow'    => $_arr_articleRow,
            'tagRows'       => $_arr_tagRows,
            'specRows'      => $_arr_specRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('article_show', $_arr_tplData);
    }


    /** 列出文章
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        $_str_box     = fn_getSafe(fn_get('box'), 'txt', '');
        $_num_cateId  = fn_getSafe(fn_get('cate_id'), 'int', 0);

        if ($_num_cateId != 0) {
            $_arr_cateIds = $this->mdl_cate->mdl_ids($_num_cateId);
        } else {
            $_arr_cateIds = false;
        }


        if ($this->is_super || isset($this->group_allow['article']['browse'])) {
            $_num_adminId = fn_getSafe(fn_get('admin_id'), 'int', 0);
        } else {
            $_num_adminId = $this->adminLogged['admin_id'];
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'year'      => fn_getSafe(fn_get('year'), 'txt', ''),
            'month'     => fn_getSafe(fn_get('month'), 'txt', ''),
            'status'    => fn_getSafe(fn_get('status'), 'txt', ''),
            'mark_id'   => fn_getSafe(fn_get('mark_id'), 'int', 0),
            'cate_id'   => $_num_cateId,
            'box'       => $_str_box,
            'cate_ids'  => $_arr_cateIds,
            'admin_id'  => $_num_adminId,
        );

        $_num_articleCount  = $this->mdl_article->mdl_count($_arr_search);
        $_arr_page          = fn_page($_num_articleCount); //取得分页数据
        $_str_query         = http_build_query($_arr_search);
        $_arr_articleRows   = $this->mdl_article->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_articleCount['all']       = $this->mdl_article->mdl_count();

        $_arr_searchDraft = array(
            'box'       => 'draft',
            'admin_id'  => $_num_adminId,
        );
        $_arr_searchRecycle = array(
            'box'       => 'recycle',
            'admin_id'  => $_num_adminId,
        );
        $_arr_articleCount['draft']     = $this->mdl_article->mdl_count($_arr_searchDraft);
        $_arr_articleCount['recycle']   = $this->mdl_article->mdl_count($_arr_searchRecycle);

        $_arr_searchCate = array(
            'status' => 'show',
        );

        $_arr_articleYear   = $this->mdl_article->mdl_year();
        $_arr_cateRows      = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);
        $_arr_markRows      = $this->mdl_mark->mdl_list(100);

        $_arr_unknownCate   = array();
        $_arr_notGen        = array();

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_cateRow = $this->mdl_cate->mdl_read($_value['article_cate_id']);
            if ($_arr_cateRow['rcode'] != 'y250102' && $_value['article_cate_id'] > 0) {
                $_arr_unknownCate[] = $_value['article_id'];
            }
            $_arr_articleRows[$_key]['cateRow']     = $_arr_cateRow;
            $_arr_articleRows[$_key]['markRow']     = $this->mdl_mark->mdl_read($_value['article_mark_id']);
            $_arr_articleRows[$_key]['adminRow']    = $this->mdl_admin->mdl_read($_value['article_admin_id']);

            $_arr_urlRow      = $this->mdl_cate->article_url_process($_value);
            if (!file_exists($_arr_urlRow['article_pathFull'])) {
                $_arr_articleRows[$_key]['article_is_gen'] = 'not';
                $_arr_notGen[] = $_value['article_id'];
            }
            //$_arr_articleRows[$_key]['urlRow']      = $_arr_urlRow;
        }

        if (!fn_isEmpty($_arr_unknownCate)) { //更新不属于栏目
            $this->mdl_article->mdl_unknownCate($_arr_unknownCate);
        }

        if (!fn_isEmpty($_arr_notGen)) { //更新未生成
            $this->mdl_article->mdl_isGen($_arr_notGen, 'not');
        }

        $_arr_tpl = array(
            'query'          => $_str_query,
            'pageRow'        => $_arr_page,
            'search'         => $_arr_search,
            'cateRows'       => $_arr_cateRows,
            'markRows'       => $_arr_markRows, //标记列表
            'articleRows'    => $_arr_articleRows,
            'articleCount'   => $_arr_articleCount,
            'articleYear'    => $_arr_articleYear,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('article_list', $_arr_tplData);
    }


    private function article_init() {
        $_arr_searchCustom = array(
            'status'    => 'enable',
            'parent_id' => 0,
        );

        $this->customRows = $this->mdl_custom->mdl_list(100, 0, $_arr_searchCustom);
        $this->mdl_custom->mdl_cache(true);
        $this->mdl_article->custom_columns = $this->mdl_custom->mdl_column_custom();
    }
}
