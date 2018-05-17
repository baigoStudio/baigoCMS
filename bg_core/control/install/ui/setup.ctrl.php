<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


class CONTROL_INSTALL_UI_SETUP {

    function __construct() { //构造函数
        $this->config           = $GLOBALS['obj_base']->config;

        $this->general_install  = new GENERAL_INSTALL();

        $this->obj_tpl          = $this->general_install->obj_tpl;

        $this->obj_file         = new CLASS_FILE(); //初始化文件对象
        $this->obj_file->dir_mk(BG_PATH_CACHE . 'ssin');

        $this->setup_init();
    }


    function ctrl_phplib() {
        $this->obj_tpl->tplDisplay('setup_phplib', $this->tplData);
    }


    function ctrl_dbconfig() {
        $this->obj_tpl->tplDisplay('setup_dbconfig', $this->tplData);
    }


    /**
     * setup_2 function.
     *
     * @access public
     */
    function ctrl_dbtable() {
        $this->check_db();

        $this->table_admin();
        $this->table_article();
        $this->table_article_content();
        $this->table_call();
        $this->table_cate();
        $this->table_cate_belong();
        $this->table_group();
        $this->table_mark();
        $this->table_link();
        $this->table_mime();
        $this->table_tag();
        $this->table_tag_belong();
        $this->table_thumb();
        $this->table_attach();
        $this->table_spec();
        $this->table_spec_belong();
        $this->table_app();
        $this->table_custom();
        $this->table_source();
        $this->table_gsite();
        $this->table_gather();
        $this->table_session();
        $this->table_plugin();
        $this->view_article();
        $this->view_tag();
        $this->view_spec();

        $GLOBALS['obj_plugin']->trigger('action_setup_dbtable_complete');

        $this->obj_tpl->tplDisplay('setup_dbtable', $this->tplData);
    }


    function ctrl_form() {
        $this->check_db();

        if ($this->act == 'base') {
            $this->tplData['tplRows']     = $this->obj_file->dir_list(BG_PATH_TPL . 'pub' . DS);

            $_arr_timezoneRows  = fn_include(BG_PATH_INC . 'timezone.inc.php');

            $this->obj_tpl->lang['timezone']        = fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'timezone.php');
            $this->obj_tpl->lang['timezoneJson']    = json_encode($this->obj_tpl->lang['timezone']);

            $_arr_timezone[] = '';

            if (stristr(BG_SITE_TIMEZONE, '/')) {
                $_arr_timezone = explode('/', BG_SITE_TIMEZONE);
            }

            $this->tplData['timezoneRows']      = $_arr_timezoneRows;
            $this->tplData['timezoneRowsJson']  = json_encode($_arr_timezoneRows);
            $this->tplData['timezoneType']      = $_arr_timezone[0];
        }

        $this->obj_tpl->tplDisplay('setup_form', $this->tplData);
    }


    /**
     * setup_7 function.
     *
     * @access public
     */
    function ctrl_ssoAuto() {
        $this->check_db();

        if (!file_exists(BG_PATH_SSO . 'api' . DS . 'api.php')) {
            $_arr_tplData = array(
                'rcode' => 'x030420',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        if (file_exists(BG_PATH_SSO . 'config' . DS . 'installed.php')) {
            $_arr_tplData = array(
                'rcode' => 'x030408',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $this->obj_tpl->tplDisplay('setup_ssoAuto', $this->tplData);
    }


    function ctrl_ssoAdmin() {
        $this->check_db();

        if (!file_exists(BG_PATH_SSO . 'api' . DS . 'api.php')) {
            $_arr_tplData = array(
                'rcode' => 'x030421',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        if (file_exists(BG_PATH_SSO . 'config' . DS . 'installed.php')) {
            $_arr_tplData = array(
                'rcode' => 'x030408',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $this->obj_tpl->tplDisplay('setup_ssoAdmin', $this->tplData);
    }


    /**
     * setup_8 function.
     *
     * @access public
     */
    function ctrl_admin() {
        $this->check_db();

        $this->obj_tpl->tplDisplay('setup_admin', $this->tplData);
    }


    function ctrl_auth() {
        $this->check_db();

        $this->obj_tpl->tplDisplay('setup_auth', $this->tplData);
    }


    function ctrl_over() {
        $this->check_db();

        $this->obj_tpl->tplDisplay('setup_over', $this->tplData);
    }


    private function check_db() {
        if (!defined('BG_DB_HOST') || fn_isEmpty(BG_DB_HOST) || !defined('BG_DB_NAME') || fn_isEmpty(BG_DB_NAME) || !defined('BG_DB_PASS') || fn_isEmpty(BG_DB_PASS) || !defined('BG_DB_CHARSET') || fn_isEmpty(BG_DB_CHARSET)) {
            $_arr_tplData = array(
                'rcode' => 'x030404',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }
    }


    private function setup_init() {
        $_str_rcode = '';
        $_str_jump  = '';

        if (file_exists(BG_PATH_CONFIG . 'installed.php')) { //如果新文件存在
            fn_include(BG_PATH_CONFIG . 'installed.php');  //载入
            $_str_rcode = 'x030403';
        } else if (file_exists(BG_PATH_CONFIG . 'is_install.php')) { //如果旧文件存在
            $this->obj_file->file_copy(BG_PATH_CONFIG . 'is_install.php', BG_PATH_CONFIG . 'installed.php'); //拷贝
            fn_include(BG_PATH_CONFIG . 'installed.php');  //载入
            $_str_rcode = 'x030403';
        }

        if (defined('BG_INSTALL_PUB') && PRD_CMS_PUB > BG_INSTALL_PUB) {
            $_str_rcode = 'x030416';
            $_str_jump  = BG_URL_INSTALL . 'index.php?m=upgrade';
        }

        if (!fn_isEmpty($_str_rcode)) {
            if (!fn_isEmpty($_str_jump)) {
                header('Location: ' . $_str_jump);
            }

            $_arr_tplData = array(
                'rcode' => $_str_rcode,
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $_arr_phplibRow      = get_loaded_extensions();
        $this->errCount   = 0;

        foreach ($this->obj_tpl->phplib as $_key=>$_value) {
            if (!in_array($_key, $_arr_phplibRow)) {
                $this->errCount++;
            }
        }

        $this->act = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', 'phplib');

        $this->tplData = array(
            'errCount'      => $this->errCount,
            'phplibRow'     => $_arr_phplibRow,
            'act'           => $this->act,
            'setup_step'    => $this->setup_step($this->act),
        );
    }


    private function setup_step($act) {
        $_arr_optKeys = array_keys($this->obj_tpl->opt);
        $_index       = array_search($act, $_arr_optKeys);

        $_arr_prev     = array_slice($this->obj_tpl->opt, $_index - 1, -1);
        if (fn_isEmpty($_arr_prev)) {
            $_key_prev = 'dbtable';
        } else {
            $_key_prev = key($_arr_prev);
        }

        $_arr_next     = array_slice($this->obj_tpl->opt, $_index + 1, 1);
        if (fn_isEmpty($_arr_next)) {
            $_key_next = 'admin';
        } else {
            $_key_next = key($_arr_next);
        }

        return array(
            'prev' => $_key_prev,
            'next' => $_key_next,
        );
    }


    /**
     * table_admin function.
     *
     * @access private
     */
    private function table_admin() {
        $_mdl_admin                 = new MODEL_ADMIN();
        $_arr_adminTable            = $_mdl_admin->mdl_create_table();

        $this->tplData['db_rcode']['admin_table'] = array(
            'rcode'   => $_arr_adminTable['rcode'],
            'status'  => substr($_arr_adminTable['rcode'], 0, 1),
        );
    }


    /**
     * table_article function.
     *
     * @access private
     */
    private function table_article() {
        $_mdl_article                   = new MODEL_ARTICLE();
        $_arr_articleCreateTable        = $_mdl_article->mdl_create_table();
        $_arr_articleCreateIndex        = $_mdl_article->mdl_create_index();

        $this->tplData['db_rcode']['article_create_table'] = array(
            'rcode'   => $_arr_articleCreateTable['rcode'],
            'status'  => substr($_arr_articleCreateTable['rcode'], 0, 1),
        );
        $this->tplData['db_rcode']['article_create_index'] = array(
            'rcode'   => $_arr_articleCreateIndex['rcode'],
            'status'  => substr($_arr_articleCreateIndex['rcode'], 0, 1),
        );
    }


    private function table_article_content() {
        $_mdl_article_content               = new MODEL_ARTICLE_CONTENT();
        $_arr_article_contentCreateTable    = $_mdl_article_content->mdl_create_table();

        $this->tplData['db_rcode']['article_content_create_table'] = array(
            'rcode'   => $_arr_article_contentCreateTable['rcode'],
            'status'  => substr($_arr_article_contentCreateTable['rcode'], 0, 1),
        );
    }


    /**
     * table_call function.
     *
     * @access private
     */
    private function table_call() {
        $_mdl_call              = new MODEL_CALL();
        $_mdl_call              = new MODEL_CALL();
        $_arr_callCreateTable   = $_mdl_call->mdl_create_table();

        $this->tplData['db_rcode']['call_create_table'] = array(
            'rcode'   => $_arr_callCreateTable['rcode'],
            'status'  => substr($_arr_callCreateTable['rcode'], 0, 1),
        );
    }


    /**
     * table_cate function.
     *
     * @access private
     */
    private function table_cate() {
        $_mdl_cate              = new MODEL_CATE();
        $_arr_cateCreateTable   = $_mdl_cate->mdl_create_table();
        $_arr_cateCreateIndex   = $_mdl_cate->mdl_create_index();

        $this->tplData['db_rcode']['cate_create_table'] = array(
            'rcode'   => $_arr_cateCreateTable['rcode'],
            'status'  => substr($_arr_cateCreateTable['rcode'], 0, 1),
        );
        $this->tplData['db_rcode']['cate_create_index'] = array(
            'rcode'   => $_arr_cateCreateIndex['rcode'],
            'status'  => substr($_arr_cateCreateIndex['rcode'], 0, 1),
        );
    }


    /**
     * table_cate_belong function.
     *
     * @access private
     */
    private function table_cate_belong() {
        $_mdl_cate_belong            = new MODEL_CATE_BELONG();
        $_arr_cateBelongCreateTable = $_mdl_cate_belong->mdl_create_table();

        $this->tplData['db_rcode']['cate_belong_create_table'] = array(
            'rcode'   => $_arr_cateBelongCreateTable['rcode'],
            'status'  => substr($_arr_cateBelongCreateTable['rcode'], 0, 1),
        );
    }


    private function view_article() {
        $_mdl_article_pub       = new MODEL_ARTICLE_PUB();
        $_arr_cateCreateView    = $_mdl_article_pub->mdl_create_cate_view();
        $_arr_tagCreateView     = $_mdl_article_pub->mdl_create_tag_view();
        $_arr_specCreateView    = $_mdl_article_pub->mdl_create_spec_view();

        $this->tplData['db_rcode']['cate_create_view'] = array(
            'rcode'   => $_arr_cateCreateView['rcode'],
            'status'  => substr($_arr_cateCreateView['rcode'], 0, 1),
        );
        $this->tplData['db_rcode']['tag_create_view'] = array(
            'rcode'   => $_arr_tagCreateView['rcode'],
            'status'  => substr($_arr_tagCreateView['rcode'], 0, 1),
        );
        $this->tplData['db_rcode']['spec_create_view'] = array(
            'rcode'   => $_arr_specCreateView['rcode'],
            'status'  => substr($_arr_specCreateView['rcode'], 0, 1),
        );
    }


    /**
     * table_group function.
     *
     * @access private
     */
    private function table_group() {
        $_mdl_group                 = new MODEL_GROUP();
        $_arr_groupCreateTable      = $_mdl_group->mdl_create_table();

        $this->tplData['db_rcode']['group_create_table'] = array(
            'rcode'   => $_arr_groupCreateTable['rcode'],
            'status'  => substr($_arr_groupCreateTable['rcode'], 0, 1),
        );
    }


    /**
     * table_mark function.
     *
     * @access private
     */
    private function table_mark() {
        $_mdl_mark              = new MODEL_MARK();
        $_arr_markCreateTable   = $_mdl_mark->mdl_create_table();

        $this->tplData['db_rcode']['mark_create_table'] = array(
            'rcode'   => $_arr_markCreateTable['rcode'],
            'status'  => substr($_arr_markCreateTable['rcode'], 0, 1),
        );
    }


    private function table_link() {
        $_mdl_link              = new MODEL_LINK();
        $_arr_linkCreateTable   = $_mdl_link->mdl_create_table();

        $this->tplData['db_rcode']['link_create_table'] = array(
            'rcode'   => $_arr_linkCreateTable['rcode'],
            'status'  => substr($_arr_linkCreateTable['rcode'], 0, 1),
        );
    }


    private function table_spec() {
        $_mdl_spec              = new MODEL_SPEC();
        $_arr_specCreateTable   = $_mdl_spec->mdl_create_table();

        $this->tplData['db_rcode']['spec_create_table'] = array(
            'rcode'   => $_arr_specCreateTable['rcode'],
            'status'  => substr($_arr_specCreateTable['rcode'], 0, 1),
        );
    }

    /**
     * table_mime function.
     *
     * @access private
     */
    private function table_mime() {
        $_mdl_mime              = new MODEL_MIME();
        $_arr_mimeCreateTable   = $_mdl_mime->mdl_create_table();

        $this->tplData['db_rcode']['mime_create_table'] = array(
            'rcode'   => $_arr_mimeCreateTable['rcode'],
            'status'  => substr($_arr_mimeCreateTable['rcode'], 0, 1),
        );
    }


    /**
     * table_tag function.
     *
     * @access private
     */
    private function table_tag() {
        $_mdl_tag               = new MODEL_TAG();
        $_arr_tagCreateTable    = $_mdl_tag->mdl_create_table();
        $_arr_tagCreateIndex    = $_mdl_tag->mdl_create_index();

        $this->tplData['db_rcode']['tag_create_table'] = array(
            'rcode'   => $_arr_tagCreateTable['rcode'],
            'status'  => substr($_arr_tagCreateTable['rcode'], 0, 1),
        );
        $this->tplData['db_rcode']['tag_create_index'] = array(
            'rcode'   => $_arr_tagCreateIndex['rcode'],
            'status'  => substr($_arr_tagCreateIndex['rcode'], 0, 1),
        );
    }


    /**
     * table_tag_belong function.
     *
     * @access private
     */
    private function table_tag_belong() {
        $_mdl_tag_belong             = new MODEL_TAG_BELONG();
        $_arr_tagBelongCreateTable  = $_mdl_tag_belong->mdl_create_table();
        $_arr_tagBelongCreateIndex  = $_mdl_tag_belong->mdl_create_index();

        $this->tplData['db_rcode']['tag_belong_create_table'] = array(
            'rcode'   => $_arr_tagBelongCreateTable['rcode'],
            'status'  => substr($_arr_tagBelongCreateTable['rcode'], 0, 1),
        );
        $this->tplData['db_rcode']['tag_belong_create_index'] = array(
            'rcode'   => $_arr_tagBelongCreateIndex['rcode'],
            'status'  => substr($_arr_tagBelongCreateIndex['rcode'], 0, 1),
        );
    }


    private function view_tag() {
        $_mdl_tag_belong             = new MODEL_TAG_BELONG();
        $_arr_tagBelongCreateView   = $_mdl_tag_belong->mdl_create_view();

        $this->tplData['db_rcode']['tag_belong_create_view'] = array(
            'rcode'   => $_arr_tagBelongCreateView['rcode'],
            'status'  => substr($_arr_tagBelongCreateView['rcode'], 0, 1),
        );
    }


    /**
     * table_tag_belong function.
     *
     * @access private
     */
    private function table_spec_belong() {
        $_mdl_spec_belong            = new MODEL_SPEC_BELONG();
        $_arr_specBelongCreateTable = $_mdl_spec_belong->mdl_create_table();
        $_arr_specBelongCreateIndex = $_mdl_spec_belong->mdl_create_index();

        $this->tplData['db_rcode']['spec_belong_create_table'] = array(
            'rcode'   => $_arr_specBelongCreateTable['rcode'],
            'status'  => substr($_arr_specBelongCreateTable['rcode'], 0, 1),
        );
        $this->tplData['db_rcode']['spec_belong_create_index'] = array(
            'rcode'   => $_arr_specBelongCreateIndex['rcode'],
            'status'  => substr($_arr_specBelongCreateIndex['rcode'], 0, 1),
        );
    }


    private function view_spec() {
        $_mdl_spec_belong            = new MODEL_SPEC_BELONG();
        $_arr_specBelongCreateView  = $_mdl_spec_belong->mdl_create_view();

        $this->tplData['db_rcode']['spec_belong_create_view'] = array(
            'rcode'   => $_arr_specBelongCreateView['rcode'],
            'status'  => substr($_arr_specBelongCreateView['rcode'], 0, 1),
        );
    }


    /**
     * table_thumb function.
     *
     * @access private
     */
    private function table_thumb() {
        $_mdl_thumb             = new MODEL_THUMB();
        $_arr_thumbCreateTable  = $_mdl_thumb->mdl_create_table();

        $this->tplData['db_rcode']['thumb_create_table'] = array(
            'rcode'   => $_arr_thumbCreateTable['rcode'],
            'status'  => substr($_arr_thumbCreateTable['rcode'], 0, 1),
        );
    }


    /**
     * table_attach function.
     *
     * @access private
     */
    private function table_attach() {
        $_mdl_attach            = new MODEL_ATTACH();
        $_arr_attachCreateTable = $_mdl_attach->mdl_create_table();

        $this->tplData['db_rcode']['attach_create_table'] = array(
            'rcode'   => $_arr_attachCreateTable['rcode'],
            'status'  => substr($_arr_attachCreateTable['rcode'], 0, 1),
        );
    }


    /**
     * table_app function.
     *
     * @access private
     */
    private function table_app() {
        $_mdl_app               = new MODEL_APP();
        $_arr_appCreateTable    = $_mdl_app->mdl_create_table();

        $this->tplData['db_rcode']['app_create_table'] = array(
            'rcode'   => $_arr_appCreateTable['rcode'],
            'status'  => substr($_arr_appCreateTable['rcode'], 0, 1),
        );
    }


    private function table_plugin() {
        $_mdl_plugin               = new MODEL_PLUGIN();
        $_arr_pluginCreateTable    = $_mdl_plugin->mdl_create_table();

        $this->tplData['db_rcode']['plugin_create_table'] = array(
            'rcode'   => $_arr_pluginCreateTable['rcode'],
            'status'  => substr($_arr_pluginCreateTable['rcode'], 0, 1),
        );
    }

    /**
     * table_custom function.
     *
     * @access private
     */
    private function table_custom() {
        $_mdl_custom            = new MODEL_CUSTOM();
        $_mdl_article_custom    = new MODEL_ARTICLE_CUSTOM();
        $_mdl_article_pub       = new MODEL_ARTICLE_PUB();
        $_arr_customCreateTable = $_mdl_custom->mdl_create_table();

        $_arr_searchCustom = array(
            'status' => 'enable',
        );
        $_arr_customRows = $_mdl_custom->mdl_list(1000, 0, $_arr_searchCustom, 0, false);

        $_mdl_article_custom->mdl_create_table($_arr_customRows);
        $_mdl_article_pub->mdl_create_custom_view($_arr_customRows);
        $_mdl_custom->mdl_cache(true);


        $this->tplData['db_rcode']['custom_create_table'] = array(
            'rcode'   => $_arr_customCreateTable['rcode'],
            'status'  => substr($_arr_customCreateTable['rcode'], 0, 1),
        );
    }


    private function table_source() {
        $_mdl_source            = new MODEL_SOURCE();
        $_arr_sourceCreateTable = $_mdl_source->mdl_create_table();

        $this->tplData['db_rcode']['source_create_table'] = array(
            'rcode'   => $_arr_sourceCreateTable['rcode'],
            'status'  => substr($_arr_sourceCreateTable['rcode'], 0, 1),
        );
    }


    private function table_gsite() {
        $_mdl_gsite               = new MODEL_GSITE();
        $_arr_gsiteCreateTable    = $_mdl_gsite->mdl_create_table();

        $this->tplData['db_rcode']['gsite_create_table'] = array(
            'rcode'   => $_arr_gsiteCreateTable['rcode'],
            'status'  => substr($_arr_gsiteCreateTable['rcode'], 0, 1),
        );
    }

    private function table_gather() {
        $_mdl_gather               = new MODEL_GATHER();
        $_arr_gatherCreateTable    = $_mdl_gather->mdl_create_table();

        $this->tplData['db_rcode']['gather_create_table'] = array(
            'rcode'   => $_arr_gatherCreateTable['rcode'],
            'status'  => substr($_arr_gatherCreateTable['rcode'], 0, 1),
        );
    }

    private function table_session() {
        $_mdl_session               = new MODEL_SESSION();
        $_arr_sessionCreateTable    = $_mdl_session->mdl_create_table();

        $this->tplData['db_rcode']['session_create_table'] = array(
            'rcode'   => $_arr_sessionCreateTable['rcode'],
            'status'  => substr($_arr_sessionCreateTable['rcode'], 0, 1),
        );
    }
}
