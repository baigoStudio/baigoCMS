<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}


class CONTROL_INSTALL_UI_SETUP {

    function __construct() { //构造函数
        $this->obj_base         = $GLOBALS["obj_base"];
        $this->config           = $this->obj_base->config;

        $_arr_cfg["install"]    = true;
        $this->obj_tpl          = new CLASS_TPL(BG_PATH_TPLSYS . "install/" . BG_DEFAULT_UI, $_arr_cfg); //初始化视图对象
        $this->obj_dir          = new CLASS_DIR(); //初始化目录对象
        $this->obj_dir->mk_dir(BG_PATH_CACHE . "ssin");

        $this->fields           = require(BG_PATH_LANG . $this->config["lang"] . "/fields.php");

        $this->setup_init();
    }


    function ctrl_ext() {
        $this->obj_tpl->tplDisplay("setup_ext", $this->tplData);
    }


    function ctrl_dbconfig() {
        $this->obj_tpl->tplDisplay("setup_dbconfig", $this->tplData);
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
        $this->table_session();
        $this->view_article();
        $this->view_tag();
        $this->view_spec();

        $this->obj_tpl->tplDisplay("setup_dbtable", $this->tplData);
    }


    function ctrl_form() {
        $this->check_db();

        if ($this->act == "base") {
            $this->tplData["tplRows"]     = $this->obj_dir->list_dir(BG_PATH_TPL . "pub/");

            $_arr_timezoneRows  = require(BG_PATH_LANG . $this->config["lang"] . "/timezone.php");

            $_arr_timezone[] = "";

            if (stristr(BG_SITE_TIMEZONE, "/")) {
                $_arr_timezone = explode("/", BG_SITE_TIMEZONE);
            }

            $this->tplData["timezoneRows"]  = $_arr_timezoneRows;
            $this->tplData["timezoneJson"]  = json_encode($_arr_timezoneRows);
            $this->tplData["timezoneType"]  = $_arr_timezone[0];
        }

        $this->obj_tpl->tplDisplay("setup_form", $this->tplData);
    }


    /**
     * setup_7 function.
     *
     * @access public
     */
    function ctrl_ssoAuto() {
        $this->check_db();

        if (!file_exists(BG_PATH_SSO . "api/api.php")) {
            $_arr_tplData = array(
                "rcode" => "x030420",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }

        if (file_exists(BG_PATH_SSO . "config/installed.php")) {
            $_arr_tplData = array(
                "rcode" => "x030408",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }

        $this->obj_tpl->tplDisplay("setup_ssoAuto", $this->tplData);
    }


    function ctrl_ssoAdmin() {
        $this->check_db();

        if (!file_exists(BG_PATH_SSO . "api/api.php")) {
            $_arr_tplData = array(
                "rcode" => "x030421",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }

        if (file_exists(BG_PATH_SSO . "config/installed.php")) {
            $_arr_tplData = array(
                "rcode" => "x030408",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }

        $this->obj_tpl->tplDisplay("setup_ssoAdmin", $this->tplData);
    }


    /**
     * setup_8 function.
     *
     * @access public
     */
    function ctrl_admin() {
        $this->check_db();

        $this->obj_tpl->tplDisplay("setup_admin", $this->tplData);
    }


    function ctrl_auth() {
        $this->check_db();

        $this->obj_tpl->tplDisplay("setup_auth", $this->tplData);
    }


    function ctrl_over() {
        $this->check_db();

        $this->obj_tpl->tplDisplay("setup_over", $this->tplData);
    }


    private function check_db() {
        if (fn_isEmpty(BG_DB_HOST) || fn_isEmpty(BG_DB_NAME) || fn_isEmpty(BG_DB_USER) || fn_isEmpty(BG_DB_PASS) || fn_isEmpty(BG_DB_CHARSET)) {
            $_arr_tplData = array(
                "rcode" => "x030404",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }
    }


    private function setup_init() {
        $_str_rcode = "";
        $_str_jump  = "";

        if (file_exists(BG_PATH_CONFIG . "installed.php")) { //如果新文件存在
            require(BG_PATH_CONFIG . "installed.php");  //载入
            $_str_rcode = "x030403";
        } else if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //如果旧文件存在
            $this->obj_dir->copy_file(BG_PATH_CONFIG . "is_install.php", BG_PATH_CONFIG . "installed.php"); //拷贝
            require(BG_PATH_CONFIG . "installed.php");  //载入
            $_str_rcode = "x030403";
        }

        if (defined("BG_INSTALL_PUB") && PRD_CMS_PUB > BG_INSTALL_PUB) {
            $_str_rcode = "x030416";
            $_str_jump  = BG_URL_INSTALL . "index.php?mod=upgrade";
        }

        if (!fn_isEmpty($_str_rcode)) {
            if (!fn_isEmpty($_str_jump)) {
                header("Location: " . $_str_jump);
            }

            $_arr_tplData = array(
                "rcode" => $_str_rcode,
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }

        $_arr_extRow      = get_loaded_extensions();
        $this->errCount   = 0;

        foreach ($this->obj_tpl->type["ext"] as $_key=>$_value) {
            if (!in_array($_key, $_arr_extRow)) {
                $this->errCount++;
            }
        }

        if ($this->errCount > 0) {
            $_arr_tplData = array(
                "rcode" => "x030413",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }

        $this->act = fn_getSafe($GLOBALS["act"], "txt", "ext");

        $this->tplData = array(
            "errCount"      => $this->errCount,
            "extRow"        => $_arr_extRow,
            "act"           => $this->act,
            "setup_step"    => $this->setup_step($this->act),
        );
    }


    private function setup_step($act) {
        $_arr_optKeys = array_keys($this->obj_tpl->opt);
        $_index       = array_search($act, $_arr_optKeys);

        $_arr_prev     = array_slice($this->obj_tpl->opt, $_index - 1, -1);
        if (fn_isEmpty($_arr_prev)) {
            $_key_prev = "dbtable";
        } else {
            $_key_prev = key($_arr_prev);
        }

        $_arr_next     = array_slice($this->obj_tpl->opt, $_index + 1, 1);
        if (fn_isEmpty($_arr_next)) {
            $_key_next = "admin";
        } else {
            $_key_next = key($_arr_next);
        }

        return array(
            "prev" => $_key_prev,
            "next" => $_key_next,
        );
    }


    /**
     * table_admin function.
     *
     * @access private
     */
    private function table_admin() {
        $_mdl_admin                 = new MODEL_ADMIN();
        $_mdl_admin->adminStatus    = $this->obj_tpl->status["admin"];
        $_mdl_admin->adminTypes     = $this->obj_tpl->type["admin"];
        $_arr_adminTable            = $_mdl_admin->mdl_create_table();

        $this->tplData["db_rcode"]["admin_table"] = array(
            "rcode"   => $_arr_adminTable["rcode"],
            "status"  => substr($_arr_adminTable["rcode"], 0, 1),
        );
    }


    /**
     * table_article function.
     *
     * @access private
     */
    private function table_article() {
        $_mdl_article                   = new MODEL_ARTICLE();
        $_mdl_article->articleStatus    = $this->obj_tpl->status["article"];
        $_mdl_article->articleGens      = $this->obj_tpl->status["gen"];
        $_arr_articleCreateTable        = $_mdl_article->mdl_create_table();
        $_arr_articleCreateIndex        = $_mdl_article->mdl_create_index();

        $this->tplData["db_rcode"]["article_create_table"] = array(
            "rcode"   => $_arr_articleCreateTable["rcode"],
            "status"  => substr($_arr_articleCreateTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["article_create_index"] = array(
            "rcode"   => $_arr_articleCreateIndex["rcode"],
            "status"  => substr($_arr_articleCreateIndex["rcode"], 0, 1),
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
        $_mdl_call->callStatus  = $this->obj_tpl->status["call"];
        $_mdl_call->callTypes   = $this->obj_tpl->type["call"];
        $_mdl_call->callAttachs = $this->obj_tpl->type["callAttach"];
        $_mdl_call->callFiles   = $this->obj_tpl->type["callFile"];
        $_arr_callCreateTable   = $_mdl_call->mdl_create_table();

        $this->tplData["db_rcode"]["call_create_table"] = array(
            "rcode"   => $_arr_callCreateTable["rcode"],
            "status"  => substr($_arr_callCreateTable["rcode"], 0, 1),
        );
    }


    /**
     * table_cate function.
     *
     * @access private
     */
    private function table_cate() {
        $_mdl_cate              = new MODEL_CATE();
        $_mdl_cate->cateStatus  = $this->obj_tpl->status["cate"];
        $_mdl_cate->cateTypes   = $this->obj_tpl->type["cate"];
        $_mdl_cate->catePasvs   = $this->obj_tpl->status["pasv"];
        $_arr_cateCreateTable   = $_mdl_cate->mdl_create_table();
        $_arr_cateCreateIndex   = $_mdl_cate->mdl_create_index();

        $this->tplData["db_rcode"]["cate_create_table"] = array(
            "rcode"   => $_arr_cateCreateTable["rcode"],
            "status"  => substr($_arr_cateCreateTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["cate_create_index"] = array(
            "rcode"   => $_arr_cateCreateIndex["rcode"],
            "status"  => substr($_arr_cateCreateIndex["rcode"], 0, 1),
        );
    }


    /**
     * table_cate_belong function.
     *
     * @access private
     */
    private function table_cate_belong() {
        $_mdl_cateBelong            = new MODEL_CATE_BELONG();
        $_arr_cateBelongCreateTable = $_mdl_cateBelong->mdl_create_table();

        $this->tplData["db_rcode"]["cate_belong_create_table"] = array(
            "rcode"   => $_arr_cateBelongCreateTable["rcode"],
            "status"  => substr($_arr_cateBelongCreateTable["rcode"], 0, 1),
        );
    }


    private function view_article() {
        $_mdl_articlePub        = new MODEL_ARTICLE_PUB();
        $_arr_cateCreateView    = $_mdl_articlePub->mdl_create_cate_view();
        $_arr_tagCreateView     = $_mdl_articlePub->mdl_create_tag_view();
        $_arr_specCreateView    = $_mdl_articlePub->mdl_create_spec_view();

        $this->tplData["db_rcode"]["cate_create_view"] = array(
            "rcode"   => $_arr_cateCreateView["rcode"],
            "status"  => substr($_arr_cateCreateView["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["tag_create_view"] = array(
            "rcode"   => $_arr_tagCreateView["rcode"],
            "status"  => substr($_arr_tagCreateView["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["spec_create_view"] = array(
            "rcode"   => $_arr_specCreateView["rcode"],
            "status"  => substr($_arr_specCreateView["rcode"], 0, 1),
        );
    }


    /**
     * table_group function.
     *
     * @access private
     */
    private function table_group() {
        $_mdl_group                 = new MODEL_GROUP();
        $_mdl_group->groupStatus    = $this->obj_tpl->status["group"];
        $_mdl_group->groupTypes     = $this->obj_tpl->type["group"];
        $_arr_groupCreateTable      = $_mdl_group->mdl_create_table();

        $this->tplData["db_rcode"]["group_create_table"] = array(
            "rcode"   => $_arr_groupCreateTable["rcode"],
            "status"  => substr($_arr_groupCreateTable["rcode"], 0, 1),
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

        $this->tplData["db_rcode"]["mark_create_table"] = array(
            "rcode"   => $_arr_markCreateTable["rcode"],
            "status"  => substr($_arr_markCreateTable["rcode"], 0, 1),
        );
    }


    private function table_link() {
        $_mdl_link              = new MODEL_LINK();
        $_mdl_link->linkStatus  = $this->obj_tpl->status["link"];
        $_mdl_link->linkTypes   = $this->obj_tpl->type["link"];
        $_arr_linkCreateTable   = $_mdl_link->mdl_create_table();

        $this->tplData["db_rcode"]["link_create_table"] = array(
            "rcode"   => $_arr_linkCreateTable["rcode"],
            "status"  => substr($_arr_linkCreateTable["rcode"], 0, 1),
        );
    }


    private function table_spec() {
        $_mdl_spec              = new MODEL_SPEC();
        $_mdl_spec->specStatus  = $this->obj_tpl->status["spec"];
        $_arr_specCreateTable   = $_mdl_spec->mdl_create_table();

        $this->tplData["db_rcode"]["spec_create_table"] = array(
            "rcode"   => $_arr_specCreateTable["rcode"],
            "status"  => substr($_arr_specCreateTable["rcode"], 0, 1),
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

        $this->tplData["db_rcode"]["mime_create_table"] = array(
            "rcode"   => $_arr_mimeCreateTable["rcode"],
            "status"  => substr($_arr_mimeCreateTable["rcode"], 0, 1),
        );
    }


    /**
     * table_tag function.
     *
     * @access private
     */
    private function table_tag() {
        $_mdl_tag               = new MODEL_TAG();
        $_mdl_tag->tagStatus    = $this->obj_tpl->status["tag"];
        $_arr_tagCreateTable    = $_mdl_tag->mdl_create_table();
        $_arr_tagCreateIndex    = $_mdl_tag->mdl_create_index();

        $this->tplData["db_rcode"]["tag_create_table"] = array(
            "rcode"   => $_arr_tagCreateTable["rcode"],
            "status"  => substr($_arr_tagCreateTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["tag_create_index"] = array(
            "rcode"   => $_arr_tagCreateIndex["rcode"],
            "status"  => substr($_arr_tagCreateIndex["rcode"], 0, 1),
        );
    }


    /**
     * table_tag_belong function.
     *
     * @access private
     */
    private function table_tag_belong() {
        $_mdl_tagBelong             = new MODEL_TAG_BELONG();
        $_arr_tagBelongCreateTable  = $_mdl_tagBelong->mdl_create_table();
        $_arr_tagBelongCreateIndex  = $_mdl_tagBelong->mdl_create_index();

        $this->tplData["db_rcode"]["tag_belong_create_table"] = array(
            "rcode"   => $_arr_tagBelongCreateTable["rcode"],
            "status"  => substr($_arr_tagBelongCreateTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["tag_belong_create_index"] = array(
            "rcode"   => $_arr_tagBelongCreateIndex["rcode"],
            "status"  => substr($_arr_tagBelongCreateIndex["rcode"], 0, 1),
        );
    }


    private function view_tag() {
        $_mdl_tagBelong             = new MODEL_TAG_BELONG();
        $_arr_tagBelongCreateView   = $_mdl_tagBelong->mdl_create_view();

        $this->tplData["db_rcode"]["tag_belong_create_view"] = array(
            "rcode"   => $_arr_tagBelongCreateView["rcode"],
            "status"  => substr($_arr_tagBelongCreateView["rcode"], 0, 1),
        );
    }


    /**
     * table_tag_belong function.
     *
     * @access private
     */
    private function table_spec_belong() {
        $_mdl_specBelong            = new MODEL_SPEC_BELONG();
        $_arr_specBelongCreateTable = $_mdl_specBelong->mdl_create_table();
        $_arr_specBelongCreateIndex = $_mdl_specBelong->mdl_create_index();

        $this->tplData["db_rcode"]["spec_belong_create_table"] = array(
            "rcode"   => $_arr_specBelongCreateTable["rcode"],
            "status"  => substr($_arr_specBelongCreateTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["spec_belong_create_index"] = array(
            "rcode"   => $_arr_specBelongCreateIndex["rcode"],
            "status"  => substr($_arr_specBelongCreateIndex["rcode"], 0, 1),
        );
    }


    private function view_spec() {
        $_mdl_specBelong            = new MODEL_SPEC_BELONG();
        $_arr_specBelongCreateView  = $_mdl_specBelong->mdl_create_view();

        $this->tplData["db_rcode"]["spec_belong_create_view"] = array(
            "rcode"   => $_arr_specBelongCreateView["rcode"],
            "status"  => substr($_arr_specBelongCreateView["rcode"], 0, 1),
        );
    }


    /**
     * table_thumb function.
     *
     * @access private
     */
    private function table_thumb() {
        $_mdl_thumb             = new MODEL_THUMB();
        $_mdl_thumb->thumbTypes = $this->obj_tpl->type["thumb"];
        $_arr_thumbCreateTable  = $_mdl_thumb->mdl_create_table();

        $this->tplData["db_rcode"]["thumb_create_table"] = array(
            "rcode"   => $_arr_thumbCreateTable["rcode"],
            "status"  => substr($_arr_thumbCreateTable["rcode"], 0, 1),
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

        $this->tplData["db_rcode"]["attach_create_table"] = array(
            "rcode"   => $_arr_attachCreateTable["rcode"],
            "status"  => substr($_arr_attachCreateTable["rcode"], 0, 1),
        );
    }


    /**
     * table_app function.
     *
     * @access private
     */
    private function table_app() {
        $_mdl_app               = new MODEL_APP();
        $_mdl_app->appStatus    = $this->obj_tpl->status["app"];
        $_arr_appCreateTable    = $_mdl_app->mdl_create_table();

        $this->tplData["db_rcode"]["app_create_table"] = array(
            "rcode"   => $_arr_appCreateTable["rcode"],
            "status"  => substr($_arr_appCreateTable["rcode"], 0, 1),
        );
    }


    /**
     * table_custom function.
     *
     * @access private
     */
    private function table_custom() {
        $_mdl_custom        = new MODEL_CUSTOM();
        $_mdl_articleCustom = new MODEL_ARTICLE_CUSTOM();
        $_mdl_articlePub    = new MODEL_ARTICLE_PUB();

        $_mdl_custom->customStatus  = $this->obj_tpl->status["custom"];
        $_mdl_custom->customTypes   = $this->fields;
        $_mdl_custom->customFormats = $this->obj_tpl->type["custom"];
        $_arr_customCreateTable     = $_mdl_custom->mdl_create_table();

        $_arr_searchCustom = array(
            "status" => "enable",
        );
        $_arr_customRows = $_mdl_custom->mdl_list(1000, 0, $_arr_searchCustom, 0, false);

        $_mdl_articleCustom->mdl_create_table($_arr_customRows);
        $_mdl_articlePub->mdl_create_custom_view($_arr_customRows);
        $_mdl_custom->mdl_cache(true);


        $this->tplData["db_rcode"]["custom_table"] = array(
            "rcode"   => $_arr_customCreateTable["rcode"],
            "status"  => substr($_arr_customCreateTable["rcode"], 0, 1),
        );
    }


    private function table_session() {
        $_mdl_session               = new MODEL_SESSION();
        $_arr_sessionCreateTable    = $_mdl_session->mdl_create_table();

        $this->tplData["db_rcode"]["session_create_table"] = array(
            "rcode"   => $_arr_sessionCreateTable["rcode"],
            "status"  => substr($_arr_sessionCreateTable["rcode"], 0, 1),
        );
    }
}
