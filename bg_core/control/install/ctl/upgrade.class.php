<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类

class CONTROL_UPGRADE {

    private $obj_tpl;

    function __construct() { //构造函数
        $this->obj_base     = $GLOBALS["obj_base"];
        $this->config       = $this->obj_base->config;
        $_arr_cfg["admin"]  = true;
        $this->obj_tpl      = new CLASS_TPL(BG_PATH_TPLSYS . "install/" . BG_DEFAULT_UI, $_arr_cfg); //初始化视图对象
        $this->fields       = include_once(BG_PATH_LANG . $this->config["lang"] . "/fields.php");
        $this->obj_dir      = new CLASS_DIR(); //初始化目录对象
        $this->obj_dir->mk_dir(BG_PATH_CACHE . "ssin");
        $this->upgrade_init();
    }


    function ctl_ext() {
        $this->obj_tpl->tplDisplay("upgrade_ext.tpl", $this->tplData);

        return array(
            "alert" => "y030403",
        );
    }


    function ctl_dbconfig() {
        if ($this->errCount > 0) {
            return array(
                "alert" => "x030417",
            );
        }

        $this->obj_tpl->tplDisplay("upgrade_dbconfig.tpl", $this->tplData);

        return array(
            "alert" => "y030404",
        );
    }


    function ctl_form() {
        if ($this->errCount > 0) {
            return array(
                "alert" => "x030418",
            );
        }

        if (!$this->check_db()) {
            return array(
                "alert" => "x030419",
            );
        }

        if ($this->act_get == "base") {
            $this->tplData["tplRows"]     = $this->obj_dir->list_dir(BG_PATH_TPL . "pub/");
            $this->tplData["excerptType"] = $this->obj_tpl->type["excerpt"];
        }

        $this->obj_tpl->tplDisplay("upgrade_form.tpl", $this->tplData);

        return array(
            "alert" => "y030405",
        );
    }


    /**
     * upgrade_2 function.
     *
     * @access public
     * @return void
     */
    function ctl_dbtable() {
        if ($this->errCount > 0) {
            return array(
                "alert" => "x030418",
            );
        }

        if (!$this->check_db()) {
            return array(
                "alert" => "x030419",
            );
        }

        $this->table_admin();
        $this->table_article();
        $this->table_call();
        $this->table_cate();
        $this->table_cate_belong();
        $this->table_mark();
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

        $this->obj_tpl->tplDisplay("upgrade_dbtable.tpl", $this->tplData);

        return array(
            "alert" => "y030404",
        );
    }


    function ctl_over() {
        if ($this->errCount > 0) {
            return array(
                "alert" => "x030418",
            );
        }

        if (!$this->check_db()) {
            return array(
                "alert" => "x030419",
            );
        }

        $this->obj_tpl->tplDisplay("upgrade_over.tpl", $this->tplData);

        return array(
            "alert" => "y030405",
        );
    }


    private function check_db() {
        if (fn_isEmpty(BG_DB_HOST) || fn_isEmpty(BG_DB_NAME) || fn_isEmpty(BG_DB_USER) || fn_isEmpty(BG_DB_PASS) || fn_isEmpty(BG_DB_CHARSET)) {
            return false;
        } else {
            if (!defined("BG_DB_PORT")) {
                define("BG_DB_PORT", "3306");
            }

            $_cfg_host = array(
                "host"      => BG_DB_HOST,
                "name"      => BG_DB_NAME,
                "user"      => BG_DB_USER,
                "pass"      => BG_DB_PASS,
                "charset"   => BG_DB_CHARSET,
                "debug"     => BG_DEBUG_DB,
                "port"      => BG_DB_PORT,
            );

            $GLOBALS["obj_db"]   = new CLASS_MYSQLI($_cfg_host); //设置数据库对象
            $this->obj_db        = $GLOBALS["obj_db"];
            if (!$this->obj_db->connect()) {
                return false;
            }

            if (!$this->obj_db->select_db()) {
                return false;
            }
            return true;
        }
    }


    private function upgrade_init() {
        $_arr_extRow      = get_loaded_extensions();
        $this->errCount   = 0;

        foreach ($this->obj_tpl->type["ext"] as $_key=>$_value) {
            if (!in_array($_key, $_arr_extRow)) {
                $this->errCount++;
            }
        }

        $this->act_get = fn_getSafe(fn_get("act_get"), "txt", "ext");

        $this->tplData = array(
            "errCount"   => $this->errCount,
            "extRow"     => $_arr_extRow,
            "act_get"    => $this->act_get,
            "act_next"   => $this->upgrade_next($this->act_get),
        );
    }


    private function upgrade_next($act_get) {
        $_arr_optKeys = array_keys($this->obj_tpl->opt);
        $_index       = array_search($act_get, $_arr_optKeys);
        $_arr_opt     = array_slice($this->obj_tpl->opt, $_index + 1, 1);
        if ($_arr_opt) {
            $_key = key($_arr_opt);
        } else {
            $_key = "over";
        }

        return $_key;
    }


    /**
     * table_admin function.
     *
     * @access private
     * @return void
     */
    private function table_admin() {
        include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
        $_mdl_admin                 = new MODEL_ADMIN();
        $_mdl_admin->adminStatus    = $this->obj_tpl->status["admin"];
        $_mdl_admin->adminTypes     = $this->obj_tpl->type["admin"];
        $_arr_adminAlert            = $_mdl_admin->mdl_alert_table();

        $this->tplData["db_alert"]["admin_table"] = array(
            "alert"   => $_arr_adminAlert["alert"],
            "status"  => substr($_arr_adminAlert["alert"], 0, 1),
        );
    }


    /**
     * table_article function.
     *
     * @access private
     * @return void
     */
    private function table_article() {
        include_once(BG_PATH_MODEL . "article.class.php"); //载入管理帐号模型
        $_mdl_article                   = new MODEL_ARTICLE();
        $_mdl_article->articleStatus    = $this->obj_tpl->status["article"];
        $_mdl_article->articleGens      = $this->obj_tpl->status["gen"];
        $_arr_articleAlert              = $_mdl_article->mdl_alert_table();
        $_arr_articleIndex              = $_mdl_article->mdl_create_index();
        $_arr_articleCopy               = $_mdl_article->mdl_copy_table();
        $_arr_articleDrop               = $_mdl_article->mdl_drop();

        $this->tplData["db_alert"]["article_table_alert"] = array(
            "alert"   => $_arr_articleAlert["alert"],
            "status"  => substr($_arr_articleAlert["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["article_index"] = array(
            "alert"   => $_arr_articleIndex["alert"],
            "status"  => substr($_arr_articleIndex["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["article_table_copy"] = array(
            "alert"   => $_arr_articleCopy["alert"],
            "status"  => substr($_arr_articleCopy["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["article_table_drop"] = array(
            "alert"   => $_arr_articleDrop["alert"],
            "status"  => substr($_arr_articleDrop["alert"], 0, 1),
        );
    }


    /**
     * table_call function.
     *
     * @access private
     * @return void
     */
    private function table_call() {
        include_once(BG_PATH_MODEL . "call.class.php"); //载入管理帐号模型
        $_mdl_call              = new MODEL_CALL();
        $_mdl_call->callStatus  = $this->obj_tpl->status["call"];
        $_mdl_call->callTypes   = $this->obj_tpl->type["call"];
        $_mdl_call->callAttachs = $this->obj_tpl->type["callAttach"];
        $_mdl_call->callFiles   = $this->obj_tpl->type["callFile"];
        $_arr_callAlert         = $_mdl_call->mdl_alert_table();

        $this->tplData["db_alert"]["call_table"] = array(
            "alert"   => $_arr_callAlert["alert"],
            "status"  => substr($_arr_callAlert["alert"], 0, 1),
        );
    }


    /**
     * table_cate function.
     *
     * @access private
     * @return void
     */
    private function table_cate() {
        include_once(BG_PATH_MODEL . "cate.class.php"); //载入管理帐号模型
        $_mdl_cate              = new MODEL_CATE();
        $_mdl_cate->cateStatus  = $this->obj_tpl->status["cate"];
        $_mdl_cate->cateTypes   = $this->obj_tpl->type["cate"];
        $_mdl_cate->catePasvs   = $this->obj_tpl->status["pasv"];
        $_arr_cateAlert         = $_mdl_cate->mdl_alert_table();
        $_arr_cateIndex         = $_mdl_cate->mdl_create_index();

        $this->tplData["db_alert"]["cate_table"] = array(
            "alert"   => $_arr_cateAlert["alert"],
            "status"  => substr($_arr_cateAlert["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["cate_table"] = array(
            "alert"   => $_arr_cateIndex["alert"],
            "status"  => substr($_arr_cateIndex["alert"], 0, 1),
        );
    }


    /**
     * table_cate_belong function.
     *
     * @access private
     * @return void
     */
    private function table_cate_belong() {
        include_once(BG_PATH_MODEL . "cateBelong.class.php"); //载入管理帐号模型
        $_mdl_cateBelong      = new MODEL_CATE_BELONG();
        $_arr_cateBelongAlert = $_mdl_cateBelong->mdl_alert_table();

        $this->tplData["db_alert"]["cate_belong_table"] = array(
            "alert"   => $_arr_cateBelongAlert["alert"],
            "status"  => substr($_arr_cateBelongAlert["alert"], 0, 1),
        );
    }


    private function view_article() {
        include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入管理帐号模型
        $_mdl_articlePub    = new MODEL_ARTICLE_PUB();
        $_arr_cateView      = $_mdl_articlePub->mdl_create_cate_view();
        $_arr_tagView       = $_mdl_articlePub->mdl_create_tag_view();
        $_arr_specView      = $_mdl_articlePub->mdl_create_spec_view();

        $this->tplData["db_alert"]["cate_view"] = array(
            "alert"   => $_arr_cateView["alert"],
            "status"  => substr($_arr_cateView["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["tag_view"] = array(
            "alert"   => $_arr_tagView["alert"],
            "status"  => substr($_arr_tagView["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["spec_view"] = array(
            "alert"   => $_arr_specView["alert"],
            "status"  => substr($_arr_specView["alert"], 0, 1),
        );
    }


    /**
     * table_group function.
     *
     * @access private
     * @return void
     */
    private function table_group() {
        include_once(BG_PATH_MODEL . "group.class.php"); //载入管理帐号模型
        $_mdl_group                 = new MODEL_GROUP();
        $_mdl_group->groupStatus    = $this->obj_tpl->status["group"];
        $_mdl_group->groupTypes     = $this->obj_tpl->type["group"];
        $_arr_groupAlert            = $_mdl_group->mdl_alert_table();

        $this->tplData["db_alert"]["group_table"] = array(
            "alert"   => $_arr_groupAlert["alert"],
            "status"  => substr($_arr_groupAlert["alert"], 0, 1),
        );
    }


    /**
     * table_mark function.
     *
     * @access private
     * @return void
     */
    private function table_mark() {
        include_once(BG_PATH_MODEL . "mark.class.php"); //载入管理帐号模型
        $_mdl_mark        = new MODEL_MARK();
        $_arr_markAlert   = $_mdl_mark->mdl_alert_table();

        $this->tplData["db_alert"]["mark_table"] = array(
            "alert"   => $_arr_markAlert["alert"],
            "status"  => substr($_arr_markAlert["alert"], 0, 1),
        );
    }


    private function table_spec() {
        include_once(BG_PATH_MODEL . "spec.class.php");
        $_mdl_spec              = new MODEL_SPEC();
        $_mdl_spec->specStatus  = $this->obj_tpl->status["spec"];
        $_arr_specTable         = $_mdl_spec->mdl_create_table();
        $_arr_specAlert         = $_mdl_spec->mdl_alert_table();

        $this->tplData["db_alert"]["spec_table_create"] = array(
            "alert"   => $_arr_specTable["alert"],
            "status"  => substr($_arr_specTable["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["spec_table_alert"] = array(
            "alert"   => $_arr_specAlert["alert"],
            "status"  => substr($_arr_specAlert["alert"], 0, 1),
        );
    }


    /**
     * table_mime function.
     *
     * @access private
     * @return void
     */
    private function table_mime() {
        include_once(BG_PATH_MODEL . "mime.class.php"); //载入管理帐号模型
        $_mdl_mime        = new MODEL_MIME();
        $_arr_mimeAlert   = $_mdl_mime->mdl_alert_table();

        $this->tplData["db_alert"]["mime_table"] = array(
            "alert"   => $_arr_mimeAlert["alert"],
            "status"  => substr($_arr_mimeAlert["alert"], 0, 1),
        );
    }


    /**
     * table_tag function.
     *
     * @access private
     * @return void
     */
    private function table_tag() {
        include_once(BG_PATH_MODEL . "tag.class.php"); //载入管理帐号模型
        $_mdl_tag               = new MODEL_TAG();
        $_mdl_tag->tagStatus    = $this->obj_tpl->status["tag"];
        $_arr_tagIndex          = $_mdl_tag->mdl_create_index();
        $_arr_tagTable          = $_mdl_tag->mdl_alert_table();

        $this->tplData["db_alert"]["tag_index"] = array(
            "alert"   => $_arr_tagIndex["alert"],
            "status"  => substr($_arr_tagIndex["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["tag_table"] = array(
            "alert"   => $_arr_tagTable["alert"],
            "status"  => substr($_arr_tagTable["alert"], 0, 1),
        );
    }


    /**
     * table_tag_belong function.
     *
     * @access private
     * @return void
     */
    private function table_tag_belong() {
        include_once(BG_PATH_MODEL . "tagBelong.class.php"); //载入管理帐号模型
        $_mdl_tagBelong       = new MODEL_TAG_BELONG();
        $_arr_tagBelongIndex  = $_mdl_tagBelong->mdl_create_index();

        $this->tplData["db_alert"]["tag_belong_index"] = array(
            "alert"   => $_arr_tagBelongIndex["alert"],
            "status"  => substr($_arr_tagBelongIndex["alert"], 0, 1),
        );
    }


    private function view_tag() {
        include_once(BG_PATH_MODEL . "tagBelong.class.php"); //载入管理帐号模型
        $_mdl_tagBelong       = new MODEL_TAG_BELONG();
        $_arr_tagBelongView   = $_mdl_tagBelong->mdl_create_view();

        $this->tplData["db_alert"]["tag_belong_view"] = array(
            "alert"   => $_arr_tagBelongView["alert"],
            "status"  => substr($_arr_tagBelongView["alert"], 0, 1),
        );
    }


    private function table_spec_belong() {
        include_once(BG_PATH_MODEL . "specBelong.class.php"); //载入管理帐号模型
        $_mdl_specBelong       = new MODEL_SPEC_BELONG();
        $_arr_specBelongTable  = $_mdl_specBelong->mdl_create_table();
        $_arr_specBelongIndex  = $_mdl_specBelong->mdl_create_index();

        $this->tplData["db_alert"]["spec_belong_table"] = array(
            "alert"   => $_arr_specBelongTable["alert"],
            "status"  => substr($_arr_specBelongTable["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["spec_belong_index"] = array(
            "alert"   => $_arr_specBelongIndex["alert"],
            "status"  => substr($_arr_specBelongIndex["alert"], 0, 1),
        );
    }


    private function view_spec() {
        include_once(BG_PATH_MODEL . "specBelong.class.php"); //载入管理帐号模型
        $_mdl_specBelong       = new MODEL_SPEC_BELONG();
        $_arr_specBelongView   = $_mdl_specBelong->mdl_create_view();

        $this->tplData["db_alert"]["spec_belong_view"] = array(
            "alert"   => $_arr_specBelongView["alert"],
            "status"  => substr($_arr_specBelongView["alert"], 0, 1),
        );
    }


    /**
     * table_thumb function.
     *
     * @access private
     * @return void
     */
    private function table_thumb() {
        include_once(BG_PATH_MODEL . "thumb.class.php"); //载入管理帐号模型
        $_mdl_thumb             = new MODEL_THUMB();
        $_mdl_thumb->thumbTypes = $this->obj_tpl->type["thumb"];
        $_arr_thumbAlert        = $_mdl_thumb->mdl_alert_table();

        $this->tplData["db_alert"]["thumb_table"] = array(
            "alert"   => $_arr_thumbAlert["alert"],
            "status"  => substr($_arr_thumbAlert["alert"], 0, 1),
        );
    }


    /**
     * table_attach function.
     *
     * @access private
     * @return void
     */
    private function table_attach() {
        include_once(BG_PATH_MODEL . "attach.class.php"); //载入管理帐号模型

        $_arr_tableRows = $this->obj_db->show_tables();

        foreach ($_arr_tableRows as $_key=>$_value) {
            $_arr_tables[] = $_value["Tables_in_" . BG_DB_NAME];
        }

        $_str_alert = "y070113";

        if (in_array(BG_DB_TABLE . "upfile", $_arr_tables) && !in_array(BG_DB_TABLE . "attach", $_arr_tables)) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "upfile", false, BG_DB_TABLE . "attach");

            if ($_reselt) {
                $_str_alert = "y070112";
            }
        }

        $this->tplData["db_alert"]["attach_table_rename"] = array(
            "alert"   => $_str_alert,
            "status"  => substr($_str_alert, 0, 1),
        );

        $_mdl_attach      = new MODEL_ATTACH();
        $_arr_attachAlert = $_mdl_attach->mdl_alert_table();

        $this->tplData["db_alert"]["attach_table"] = array(
            "alert"   => $_arr_attachAlert["alert"],
            "status"  => substr($_arr_attachAlert["alert"], 0, 1),
        );
    }


    private function table_app() {
        include_once(BG_PATH_MODEL . "app.class.php"); //载入管理帐号模型
        $_mdl_app               = new MODEL_APP();
        $_mdl_app->appStatus    = $this->obj_tpl->status["app"];
        $_arr_appTable          = $_mdl_app->mdl_create_table();
        $_arr_appAlert          = $_mdl_app->mdl_alert_table();

        $this->tplData["db_alert"]["app_table_create"] = array(
            "alert"   => $_arr_appTable["alert"],
            "status"  => substr($_arr_appTable["alert"], 0, 1),
        );
        $this->tplData["db_alert"]["app_table_alert"] = array(
            "alert"   => $_arr_appAlert["alert"],
            "status"  => substr($_arr_appAlert["alert"], 0, 1),
        );
    }


    private function table_custom() {
        include_once(BG_PATH_MODEL . "custom.class.php"); //载入管理帐号模型
        include_once(BG_PATH_MODEL . "articleCustom.class.php");
        include_once(BG_PATH_MODEL . "articlePub.class.php");

        $_mdl_custom        = new MODEL_CUSTOM();
        $_mdl_articleCustom = new MODEL_ARTICLE_CUSTOM();
        $_mdl_articlePub    = new MODEL_ARTICLE_PUB();

        $_mdl_custom->customStatus  = $this->obj_tpl->status["custom"];
        $_mdl_custom->customTypes   = $this->fields;
        $_mdl_custom->customFormats = $this->obj_tpl->type["custom"];
        $_arr_customTable           = $_mdl_custom->mdl_create_table();
        $_arr_customAlert           = $_mdl_custom->mdl_alert_table();

        $_arr_searchCustom = array(
            "status" => "enable",
        );
        $_arr_customRows = $_mdl_custom->mdl_list(1000, 0, $_arr_searchCustom, 0, false);

        $_mdl_articleCustom->mdl_create_table($_arr_customRows);
        $_mdl_articlePub->mdl_create_custom_view($_arr_customRows);
        $_mdl_custom->mdl_cache(true);

        $this->tplData["db_alert"]["custom_table_create"] = array(
            "alert"   => $_arr_customTable["alert"],
            "status"  => substr($_arr_customTable["alert"], 0, 1),
        );

        $this->tplData["db_alert"]["custom_table_alert"] = array(
            "alert"   => $_arr_customAlert["alert"],
            "status"  => substr($_arr_customAlert["alert"], 0, 1),
        );
    }


    private function table_session() {
        include_once(BG_PATH_MODEL . "session.class.php"); //载入管理帐号模型
        $_mdl_session       = new MODEL_SESSION();
        $_arr_sessionTable  = $_mdl_session->mdl_create_table();

        $this->tplData["db_alert"]["session_table"] = array(
            "alert"   => $_arr_sessionTable["alert"],
            "status"  => substr($_arr_sessionTable["alert"], 0, 1),
        );
    }
}
