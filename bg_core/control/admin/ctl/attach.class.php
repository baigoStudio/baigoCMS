<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php");
include_once(BG_PATH_MODEL . "article.class.php");
include_once(BG_PATH_MODEL . "attach.class.php");
include_once(BG_PATH_MODEL . "thumb.class.php");
include_once(BG_PATH_MODEL . "mime.class.php");
include_once(BG_PATH_MODEL . "cate.class.php");
include_once(BG_PATH_MODEL . "mark.class.php");

/*-------------用户类-------------*/
class CONTROL_ATTACH {

    private $obj_base;
    private $config;
    private $adminLogged;
    private $obj_tpl;
    private $mdl_attach;
    private $mimeRows;
    private $mdl_admin;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"];
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
        $this->mdl_attach     = new MODEL_ATTACH(); //设置上传信息对象
        $this->mdl_thumb      = new MODEL_THUMB();
        $this->mdl_mime       = new MODEL_MIME();
        $this->mdl_admin      = new MODEL_ADMIN();
        $this->mdl_article    = new MODEL_ARTICLE(); //设置文章对象
        $this->mdl_cate       = new MODEL_CATE(); //设置栏目对象
        $this->mdl_mark       = new MODEL_MARK(); //设置标记对象
        $this->setUpload();
        $this->tplData = array(
            "adminLogged"    => $this->adminLogged,
            "uploadSize"     => BG_UPLOAD_SIZE * $this->sizeUnit,
            "mimeRows"       => $this->mimeRows
        );
    }


    function ctl_article() {
        $_num_articleId = fn_getSafe(fn_get("article_id"), "int", 0);
        if ($_num_articleId < 1) {
            return array(
                "alert" => "x120212"
            );
        }

        $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
        if ($_arr_articleRow["alert"] != "y120102") {
            return $_arr_articleRow;
        }

        if ((!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["edit"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_articleRow["article_cate_id"]]["edit"]) && $_arr_articleRow["article_admin_id"] != $this->adminLogged["admin_id"]) || !isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["browse"])) { //判断权限
            return array(
                "alert" => "x120303"
            );
        }

        $_arr_cateRow     = $this->mdl_cate->mdl_read($_arr_articleRow["article_cate_id"]);
        $_arr_markRow     = $this->mdl_mark->mdl_read($_arr_articleRow["article_mark_id"]);
        $_arr_attachIds   = fn_getAttach($_arr_articleRow["article_content"]);
        $_arr_attachRows  = array();
        $_arr_page        = fn_page(0);

        $_arr_search = array(
            "attach_ids"    => $_arr_attachIds,
            "box"           => "normal",
        );

        if ($_arr_attachIds) {
            $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
            $_arr_page        = fn_page($_num_attachCount);
            $_arr_attachRows  = $this->mdl_attach->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

            foreach ($_arr_attachRows as $_key=>$_value) {
                if ($_value["attach_type"] == "image") {
                    $_arr_attachRows[$_key]["attach_thumb"] = $this->mdl_attach->thumb_process($_value["attach_id"], $_value["attach_time"], $_value["attach_ext"]);
                }
                $_arr_attachRows[$_key]["adminRow"] = $this->mdl_admin->mdl_read($_value["attach_admin_id"]);
            }
        }

        $_arr_tpl = array(
            "ids"           => implode("|", $_arr_attachIds),
            "pageRow"       => $_arr_page,
            "markRow"       => $_arr_markRow,
            "cateRow"       => $_arr_cateRow,
            "attachRows"    => $_arr_attachRows,
            "articleRow"    => $_arr_articleRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("attach_article.tpl", $_arr_tplData);

        return array(
            "alert" => "y120102"
        );
    }


    /**
     * ctl_form function.
     *
     * @access public
     * @return void
     */
    function ctl_form() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["upload"])) {
            return array(
                "alert" => "x070302",
            );
        }

        if (!is_array($this->mimeRows)) {
            return array(
                "alert" => "x070405",
            );
        }

        $_num_articleId   = fn_getSafe(fn_get("article_id"), "int", 0);
        if ($_num_articleId > 0) {
            $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
            if ($_arr_articleRow["alert"] != "y120102") {
                return $_arr_articleRow;
            }
        } else {
            $_arr_articleRow = array(
                "article_id" => 0,
            );
        }

        $_arr_yearRows    = $this->mdl_attach->mdl_year(100);
        $_arr_extRows     = $this->mdl_attach->mdl_ext();

        $_arr_tpl = array(
            "articleRow" => $_arr_articleRow,
            "yearRows"   => $_arr_yearRows,
            "extRows"    => $_arr_extRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("attach_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y070302",
        );
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["browse"])) {
            return array(
                "alert" => "x070301",
            );
        }

        if (!is_array($this->mimeRows)) {
            return array(
                "alert" => "x070405",
            );
        }

        $_str_attachIds   = fn_getSafe(fn_get("ids"), "txt", "");

        if ($_str_attachIds) {
            $_arr_attachIds = explode("|", $_str_attachIds);
        } else {
            $_arr_attachIds = false;
        }

        $_arr_search = array(
            "box"           => fn_getSafe(fn_get("box"), "txt", "normal"),
            "key"           => fn_getSafe(fn_get("key"), "txt", ""),
            "year"          => fn_getSafe(fn_get("year"), "txt", ""),
            "month"         => fn_getSafe(fn_get("month"), "txt", ""),
            "ext"           => fn_getSafe(fn_get("ext"), "txt", ""),
            "admin_id"      => fn_getSafe(fn_get("admin_id"), "int", 0),
            "ids"           => $_str_attachIds,
            "attach_ids"    => $_arr_attachIds,
        ); //搜索设置

        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_attachCount);
        $_str_query       = http_build_query($_arr_search);
        $_arr_yearRows    = $this->mdl_attach->mdl_year(100);
        $_arr_extRows     = $this->mdl_attach->mdl_ext();
        $_arr_attachRows  = $this->mdl_attach->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        foreach ($_arr_attachRows as $_key=>$_value) {
            if ($_value["attach_type"] == "image") {
                //print_r($_arr_url);
                $_arr_attachRows[$_key]["attach_thumb"] = $this->mdl_attach->thumb_process($_value["attach_id"], $_value["attach_time"], $_value["attach_ext"]);
            }
            $_arr_attachRows[$_key]["adminRow"] = $this->mdl_admin->mdl_read($_value["attach_admin_id"]);
        }

        //print_r($_arr_attachRows);
        $_arr_searchAll = array(
            "box" => "normal",
        );

        $_arr_searchRecycle = array(
            "box" => "recycle",
        );

        $_arr_attachCount["all"]     = $this->mdl_attach->mdl_count($_arr_searchAll);
        $_arr_attachCount["recycle"] = $this->mdl_attach->mdl_count($_arr_searchRecycle);

        $_arr_tpl = array(
            "query"          => $_str_query,
            "pageRow"        => $_arr_page,
            "search"         => $_arr_search,
            "attachCount"    => $_arr_attachCount,
            "attachRows"     => $_arr_attachRows, //上传信息
            "yearRows"       => $_arr_yearRows, //目录列表
            "extRows"        => $_arr_extRows, //扩展名列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("attach_list.tpl", $_arr_tplData);

        return array(
            "alert" => "y070301",
        );
    }


    /**
     * setUpload function.
     *
     * @access private
     * @return void
     */
    private function setUpload() {
        $this->mdl_attach->thumbRows  = $this->mdl_thumb->mdl_list(100);

        $_arr_mimeRows = $this->mdl_mime->mdl_list(100);
        foreach ($_arr_mimeRows as $_key=>$_value) {
            $this->mimeRows[] = $_value["mime_name"];
        }

        switch (BG_UPLOAD_UNIT) { //初始化单位
            case "B":
                $this->sizeUnit = 1;
            break;

            case "KB":
                $this->sizeUnit = 1024;
            break;

            case "MB":
                $this->sizeUnit = 1024 * 1024;
            break;

            case "GB":
                $this->sizeUnit = 1024 * 1024 * 1024;
            break;
        }
    }
}
