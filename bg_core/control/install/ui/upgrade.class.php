<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}


class CONTROL_INSTALL_UI_UPGRADE {

    function __construct() { //构造函数
        $this->obj_base         = $GLOBALS["obj_base"];
        $this->config           = $this->obj_base->config;

        $_arr_cfg["install"]    = true;
        $this->obj_tpl          = new CLASS_TPL(BG_PATH_TPLSYS . "install/" . BG_DEFAULT_UI, $_arr_cfg); //初始化视图对象
        $this->obj_dir          = new CLASS_DIR(); //初始化目录对象
        $this->obj_dir->mk_dir(BG_PATH_CACHE . "ssin");

        $this->fields           = require(BG_PATH_LANG . $this->config["lang"] . "/fields.php");

        $this->upgrade_init();
    }


    function ctrl_ext() {
        $this->obj_tpl->tplDisplay("upgrade_ext", $this->tplData);
    }


    function ctrl_dbconfig() {
        $this->obj_tpl->tplDisplay("upgrade_dbconfig", $this->tplData);
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

        $this->obj_tpl->tplDisplay("upgrade_form", $this->tplData);
    }


    /**
     * upgrade_2 function.
     *
     * @access public
     * @return void
     */
    function ctrl_dbtable() {
        $this->check_db();

        $this->table_admin();
        $this->table_article();
        $this->table_call();
        $this->table_cate();
        $this->table_cate_belong();
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

        $this->obj_tpl->tplDisplay("upgrade_dbtable", $this->tplData);
    }


    function ctrl_admin() {
        $this->check_db();

        $this->obj_tpl->tplDisplay("upgrade_admin", $this->tplData);
    }


    function ctrl_auth() {
        $this->check_db();

        $this->obj_tpl->tplDisplay("upgrade_auth", $this->tplData);
    }

    function ctrl_over() {
        $this->check_db();

        $this->obj_tpl->tplDisplay("upgrade_over", $this->tplData);
    }


    private function check_db() {
        if (fn_isEmpty(BG_DB_HOST) || fn_isEmpty(BG_DB_NAME) || fn_isEmpty(BG_DB_USER) || fn_isEmpty(BG_DB_PASS) || fn_isEmpty(BG_DB_CHARSET)) {
            $_arr_tplData = array(
                "rcode" => "x030404",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }
    }


    private function upgrade_init() {
        $_str_rcode = "";
        $_str_jump  = "";

        if (file_exists(BG_PATH_CONFIG . "installed.php")) { //如果新文件存在
            require(BG_PATH_CONFIG . "installed.php");  //载入
        } else if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //如果旧文件存在
            $this->obj_dir->copy_file(BG_PATH_CONFIG . "is_install.php", BG_PATH_CONFIG . "installed.php"); //拷贝
            require(BG_PATH_CONFIG . "installed.php");  //载入
        } else {
            $_str_rcode = "x030415";
            $_str_jump  = BG_URL_INSTALL . "index.php";
        }

        if (defined("BG_INSTALL_PUB") && PRD_CMS_PUB <= BG_INSTALL_PUB) {
            $_str_rcode = "x030403";
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
                "rcode" => "x030418",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }

        $this->act = fn_getSafe($GLOBALS["act"], "txt", "ext");

        $this->tplData = array(
            "errCount"      => $this->errCount,
            "extRow"        => $_arr_extRow,
            "act"           => $this->act,
            "upgrade_step"  => $this->upgrade_step($this->act),
        );
    }


    private function upgrade_step($act) {
        $_arr_optKeys  = array_keys($this->obj_tpl->opt);
        $_index        = array_search($act, $_arr_optKeys);

        $_arr_prev     = array_slice($this->obj_tpl->opt, $_index - 1, -1);
        if (fn_isEmpty($_arr_prev)) {
            $_key_prev = "dbtable";
        } else {
            $_key_prev = key($_arr_prev);
        }

        $_arr_next     = array_slice($this->obj_tpl->opt, $_index + 1, 1);
        if (fn_isEmpty($_arr_next)) {
            $_key_next = "over";
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
     * @return void
     */
    private function table_admin() {
        $_mdl_admin                 = new MODEL_ADMIN();
        $_mdl_admin->adminStatus    = $this->obj_tpl->status["admin"];
        $_mdl_admin->adminTypes     = $this->obj_tpl->type["admin"];
        $_arr_adminAlterTable       = $_mdl_admin->mdl_alter_table();

        $this->tplData["db_rcode"]["admin_alter_table"] = array(
            "rcode"   => $_arr_adminAlterTable["rcode"],
            "status"  => substr($_arr_adminAlterTable["rcode"], 0, 1),
        );
    }


    /**
     * table_article function.
     *
     * @access private
     * @return void
     */
    private function table_article() {
        $_mdl_article                   = new MODEL_ARTICLE();
        $_mdl_article->articleStatus    = $this->obj_tpl->status["article"];
        $_mdl_article->articleGens      = $this->obj_tpl->status["gen"];
        $_arr_articleAlterTable         = $_mdl_article->mdl_alter_table();
        $_arr_articleCreateIndex        = $_mdl_article->mdl_create_index();
        $_arr_articleCopyTable          = $_mdl_article->mdl_copy_table();
        $_arr_articleDropTable          = $_mdl_article->mdl_drop();

        $this->tplData["db_rcode"]["article_alter_table"] = array(
            "rcode"   => $_arr_articleAlterTable["rcode"],
            "status"  => substr($_arr_articleAlterTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["article_create_index"] = array(
            "rcode"   => $_arr_articleCreateIndex["rcode"],
            "status"  => substr($_arr_articleCreateIndex["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["article_copy_table"] = array(
            "rcode"   => $_arr_articleCopyTable["rcode"],
            "status"  => substr($_arr_articleCopyTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["article_drop_table"] = array(
            "rcode"   => $_arr_articleDropTable["rcode"],
            "status"  => substr($_arr_articleDropTable["rcode"], 0, 1),
        );
    }


    /**
     * table_call function.
     *
     * @access private
     * @return void
     */
    private function table_call() {
        $_mdl_call              = new MODEL_CALL();
        $_mdl_call->callStatus  = $this->obj_tpl->status["call"];
        $_mdl_call->callTypes   = $this->obj_tpl->type["call"];
        $_mdl_call->callAttachs = $this->obj_tpl->type["callAttach"];
        $_mdl_call->callFiles   = $this->obj_tpl->type["callFile"];
        $_arr_callAlterTable    = $_mdl_call->mdl_alter_table();

        $this->tplData["db_rcode"]["call_alter_table"] = array(
            "rcode"   => $_arr_callAlterTable["rcode"],
            "status"  => substr($_arr_callAlterTable["rcode"], 0, 1),
        );
    }


    /**
     * table_cate function.
     *
     * @access private
     * @return void
     */
    private function table_cate() {
        $_mdl_cate              = new MODEL_CATE();
        $_mdl_cate->cateStatus  = $this->obj_tpl->status["cate"];
        $_mdl_cate->cateTypes   = $this->obj_tpl->type["cate"];
        $_mdl_cate->catePasvs   = $this->obj_tpl->status["pasv"];
        $_arr_cateAlterTable    = $_mdl_cate->mdl_alter_table();
        $_arr_cateIndexTable    = $_mdl_cate->mdl_create_index();

        $this->tplData["db_rcode"]["cate_alter_table"] = array(
            "rcode"   => $_arr_cateAlterTable["rcode"],
            "status"  => substr($_arr_cateAlterTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["cate_create_index"] = array(
            "rcode"   => $_arr_cateIndexTable["rcode"],
            "status"  => substr($_arr_cateIndexTable["rcode"], 0, 1),
        );
    }


    /**
     * table_cate_belong function.
     *
     * @access private
     * @return void
     */
    private function table_cate_belong() {
        $_mdl_cateBelong            = new MODEL_CATE_BELONG();
        $_arr_cateBelongAlterTable  = $_mdl_cateBelong->mdl_alter_table();

        $this->tplData["db_rcode"]["cate_belong_alter_table"] = array(
            "rcode"   => $_arr_cateBelongAlterTable["rcode"],
            "status"  => substr($_arr_cateBelongAlterTable["rcode"], 0, 1),
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
     * @return void
     */
    private function table_group() {
        $_mdl_group                 = new MODEL_GROUP();
        $_mdl_group->groupStatus    = $this->obj_tpl->status["group"];
        $_mdl_group->groupTypes     = $this->obj_tpl->type["group"];
        $_arr_groupAlterTable       = $_mdl_group->mdl_alter_table();

        $this->tplData["db_rcode"]["group_alter_table"] = array(
            "rcode"   => $_arr_groupAlterTable["rcode"],
            "status"  => substr($_arr_groupAlterTable["rcode"], 0, 1),
        );
    }


    /**
     * table_mark function.
     *
     * @access private
     * @return void
     */
    private function table_mark() {
        $_mdl_mark              = new MODEL_MARK();
        $_arr_markAlterTable    = $_mdl_mark->mdl_alter_table();

        $this->tplData["db_rcode"]["mark_alter_table"] = array(
            "rcode"   => $_arr_markAlterTable["rcode"],
            "status"  => substr($_arr_markAlterTable["rcode"], 0, 1),
        );
    }


    private function table_link() {
        $_mdl_link              = new MODEL_LINK();
        $_mdl_link->linkStatus  = $this->obj_tpl->status["link"];
        $_mdl_link->linkTypes   = $this->obj_tpl->type["link"];
        $_arr_linkCreateTable   = $_mdl_link->mdl_create_table();
        $_arr_linkAlterTable    = $_mdl_link->mdl_alter_table();

        $this->tplData["db_rcode"]["link_create_table"] = array(
            "rcode"   => $_arr_linkCreateTable["rcode"],
            "status"  => substr($_arr_linkCreateTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["link_alter_table"] = array(
            "rcode"   => $_arr_linkAlterTable["rcode"],
            "status"  => substr($_arr_linkAlterTable["rcode"], 0, 1),
        );
    }


    private function table_spec() {
        $_mdl_spec              = new MODEL_SPEC();
        $_mdl_spec->specStatus  = $this->obj_tpl->status["spec"];
        $_arr_specCreateTable   = $_mdl_spec->mdl_create_table();
        $_arr_specAlterTable    = $_mdl_spec->mdl_alter_table();

        $this->tplData["db_rcode"]["spec_create_table"] = array(
            "rcode"   => $_arr_specCreateTable["rcode"],
            "status"  => substr($_arr_specCreateTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["spec_alter_table"] = array(
            "rcode"   => $_arr_specAlterTable["rcode"],
            "status"  => substr($_arr_specAlterTable["rcode"], 0, 1),
        );
    }


    /**
     * table_mime function.
     *
     * @access private
     * @return void
     */
    private function table_mime() {
        $_mdl_mime              = new MODEL_MIME();
        $_arr_mimeAlterTable    = $_mdl_mime->mdl_alter_table();

        $this->tplData["db_rcode"]["mime_alter_table"] = array(
            "rcode"   => $_arr_mimeAlterTable["rcode"],
            "status"  => substr($_arr_mimeAlterTable["rcode"], 0, 1),
        );
    }


    /**
     * table_tag function.
     *
     * @access private
     * @return void
     */
    private function table_tag() {
        $_mdl_tag               = new MODEL_TAG();
        $_mdl_tag->tagStatus    = $this->obj_tpl->status["tag"];
        $_arr_tagCreateIndex    = $_mdl_tag->mdl_create_index();
        $_arr_tagAlterTable     = $_mdl_tag->mdl_alter_table();

        $this->tplData["db_rcode"]["tag_create_index"] = array(
            "rcode"   => $_arr_tagCreateIndex["rcode"],
            "status"  => substr($_arr_tagCreateIndex["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["tag_alter_table"] = array(
            "rcode"   => $_arr_tagAlterTable["rcode"],
            "status"  => substr($_arr_tagAlterTable["rcode"], 0, 1),
        );
    }


    /**
     * table_tag_belong function.
     *
     * @access private
     * @return void
     */
    private function table_tag_belong() {
        $_mdl_tagBelong             = new MODEL_TAG_BELONG();
        $_arr_tagBelongCreateIndex  = $_mdl_tagBelong->mdl_create_index();

        $this->tplData["db_rcode"]["tag_belong_create_index"] = array(
            "rcode"   => $_arr_tagBelongCreateIndex["rcode"],
            "status"  => substr($_arr_tagBelongCreateIndex["rcode"], 0, 1),
        );
    }


    private function view_tag() {
        $_mdl_tagBelong       = new MODEL_TAG_BELONG();
        $_arr_tagBelongView   = $_mdl_tagBelong->mdl_create_view();

        $this->tplData["db_rcode"]["tag_belong_view"] = array(
            "rcode"   => $_arr_tagBelongView["rcode"],
            "status"  => substr($_arr_tagBelongView["rcode"], 0, 1),
        );
    }


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
     * @return void
     */
    private function table_thumb() {
        $_mdl_thumb             = new MODEL_THUMB();
        $_mdl_thumb->thumbTypes = $this->obj_tpl->type["thumb"];
        $_arr_thumbAlterTable   = $_mdl_thumb->mdl_alter_table();

        $this->tplData["db_rcode"]["thumb_alter_table"] = array(
            "rcode"   => $_arr_thumbAlterTable["rcode"],
            "status"  => substr($_arr_thumbAlterTable["rcode"], 0, 1),
        );
    }


    /**
     * table_attach function.
     *
     * @access private
     * @return void
     */
    private function table_attach() {
        $_mdl_attach            = new MODEL_ATTACH();
        $_arr_attachRenameTable = $_mdl_attach->mdl_rename_table();
        $_arr_attachAlterTable  = $_mdl_attach->mdl_alter_table();

        $this->tplData["db_rcode"]["attach_rename_table"] = array(
            "rcode"   => $_arr_attachRenameTable["rcode"],
            "status"  => substr($_arr_attachRenameTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["attach_alter_table"] = array(
            "rcode"   => $_arr_attachAlterTable["rcode"],
            "status"  => substr($_arr_attachAlterTable["rcode"], 0, 1),
        );
    }


    private function table_app() {
        $_mdl_app               = new MODEL_APP();
        $_mdl_app->appStatus    = $this->obj_tpl->status["app"];
        $_arr_appCreateTable    = $_mdl_app->mdl_create_table();
        $_arr_appAlterTable     = $_mdl_app->mdl_alter_table();

        $this->tplData["db_rcode"]["app_create_table"] = array(
            "rcode"   => $_arr_appCreateTable["rcode"],
            "status"  => substr($_arr_appCreateTable["rcode"], 0, 1),
        );
        $this->tplData["db_rcode"]["app_alter_table"] = array(
            "rcode"   => $_arr_appAlterTable["rcode"],
            "status"  => substr($_arr_appAlterTable["rcode"], 0, 1),
        );
    }


    private function table_custom() {
        $_mdl_custom        = new MODEL_CUSTOM();
        $_mdl_articleCustom = new MODEL_ARTICLE_CUSTOM();
        $_mdl_articlePub    = new MODEL_ARTICLE_PUB();

        $_mdl_custom->customStatus  = $this->obj_tpl->status["custom"];
        $_mdl_custom->customTypes   = $this->fields;
        $_mdl_custom->customFormats = $this->obj_tpl->type["custom"];
        $_arr_customCreateTable     = $_mdl_custom->mdl_create_table();
        $_arr_customAlterTable      = $_mdl_custom->mdl_alter_table();

        $_arr_searchCustom = array(
            "status" => "enable",
        );
        $_arr_customRows = $_mdl_custom->mdl_list(1000, 0, $_arr_searchCustom, 0, false);

        $_mdl_articleCustom->mdl_create_table($_arr_customRows);
        $_mdl_articlePub->mdl_create_custom_view($_arr_customRows);
        $_mdl_custom->mdl_cache(true);

        $this->tplData["db_rcode"]["custom_create_table"] = array(
            "rcode"   => $_arr_customCreateTable["rcode"],
            "status"  => substr($_arr_customCreateTable["rcode"], 0, 1),
        );

        $this->tplData["db_rcode"]["custom_alter_table"] = array(
            "rcode"   => $_arr_customAlterTable["rcode"],
            "status"  => substr($_arr_customAlterTable["rcode"], 0, 1),
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
