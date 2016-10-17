<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "api.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "cate.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "custom.class.php");
include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "tag.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "attach.class.php"); //载入后台用户类
//include_once(BG_PATH_MODEL . "articleCustom.class.php"); //载入后台用户类

/*-------------文章类-------------*/
class API_ARTICLE {

    private $obj_api;
    private $mdl_app;
    private $mdl_cate;
    private $mdl_articlePub;
    private $mdl_tag;
    private $mdl_attach;
    private $mdl_thumb;

    function __construct() { //构造函数
        $this->obj_api          = new CLASS_API();
        $this->obj_api->chk_install();
        $this->mdl_app          = new MODEL_APP(); //设置管理组模型
        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->mdl_articlePub   = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->article_init();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象
        $this->mdl_attach       = new MODEL_ATTACH(); //设置文章对象
    }


    function api_hits() {
        $_num_articleId   = fn_getSafe(fn_get("article_id"), "int", 0);

        if ($_num_articleId < 1) {
            $_arr_return = array(
                "alert" => "x120212",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $_arr_articleRow = $this->mdl_articlePub->mdl_read($_num_articleId);

        if ($_arr_articleRow["alert"] != "y120102") {
            $this->obj_api->halt_re($_arr_articleRow);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_arr_articleRow["article_cate_id"]);
        if ($_arr_cateRow["alert"] != "y110102") {
            $this->obj_api->halt_re($_arr_cateRow);
        }

        if ($_arr_cateRow["cate_status"] != "show") {
            $_arr_return = array(
                "alert" => "x110102",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        if (isset($_arr_cateRow["cate_type"]) && $_arr_cateRow["cate_type"] == "link" && isset($_arr_cateRow["cate_link"]) && !fn_isEmpty($_arr_cateRow["cate_link"])) {
            $_arr_return = array(
                "alert" => "x110218",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        if (fn_isEmpty($_arr_articleRow["article_title"]) || $_arr_articleRow["article_status"] != "pub" || $_arr_articleRow["article_box"] != "normal" || $_arr_articleRow["article_time_pub"] > time() || ($_arr_articleRow["article_time_hide"] > 0 && $_arr_articleRow["article_time_hide"] < time())) {
            $_arr_return = array(
                "alert" => "x120102",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        if (!fn_isEmpty($_arr_articleRow["article_link"])) {
            $_arr_return = array(
                "alert"         => "x120213",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $this->mdl_articlePub->mdl_hits($_arr_articleRow["article_id"]);

        $_arr_return = array(
            "alert" => "y120405",
        );
        $this->obj_api->halt_re($_arr_return, true);
    }


    /**
     * api_list function.
     *
     * @access public
     * @return void
     */
    function api_read() {
        $this->app_check("get");

        $_num_articleId   = fn_getSafe(fn_get("article_id"), "int", 0);

        if ($_num_articleId < 1) {
            $_arr_return = array(
                "alert" => "x120212",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $_arr_articleRow = $this->mdl_articlePub->mdl_read($_num_articleId);

        if ($_arr_articleRow["alert"] != "y120102") {
            $this->obj_api->halt_re($_arr_articleRow);
        }

        unset($_arr_articleRow["urlRow"]);

        $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_arr_articleRow["article_cate_id"]);
        if ($_arr_cateRow["alert"] != "y110102") {
            $this->obj_api->halt_re($_arr_cateRow);
        }

        if ($_arr_cateRow["cate_status"] != "show") {
            $_arr_return = array(
                "alert" => "x110102",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        unset($_arr_cateRow["urlRow"]);

        if ($_arr_cateRow["cate_type"] == "link" && !fn_isEmpty($_arr_cateRow["cate_link"])) {
            $_arr_return = array(
                "alert" => "x110218",
                "cate_link" => $_arr_cateRow["cate_link"],
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $_arr_articleRow["cateRow"] = $_arr_cateRow;

        if (fn_isEmpty($_arr_articleRow["article_title"]) || $_arr_articleRow["article_status"] != "pub" || $_arr_articleRow["article_box"] != "normal" || $_arr_articleRow["article_time_pub"] > time() || ($_arr_articleRow["article_time_hide"] > 0 && $_arr_articleRow["article_time_hide"] < time())) {
            $_arr_return = array(
                "alert" => "x120102",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        if (!fn_isEmpty($_arr_articleRow["article_link"])) {
            $_arr_return = array(
                "alert"         => "x120213",
                "article_link"  => $_arr_articleRow["article_link"],
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $_arr_searchTag = array(
            "status"        => "show",
            "article_id"    => $_arr_articleRow["article_id"],
        );
        $_arr_articleRow["tagRows"] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

        if ($_arr_articleRow["article_attach_id"] > 0) {
            $_arr_attachRow = $this->mdl_attach->mdl_url($_arr_articleRow["article_attach_id"]);

            if ($_arr_attachRow["alert"] == "y070102") {
                if ($_arr_attachRow["attach_box"] != "normal") {
                    $_arr_attachRow = array(
                        "alert" => "x070102",
                    );
                }
            }

            $_arr_articleRow["attachRow"]    = $_arr_attachRow;
        }

        $this->mdl_articlePub->mdl_hits($_arr_articleRow["article_id"]);

        $this->obj_api->halt_re($_arr_articleRow, true);
    }



    function api_list() {
        $this->app_check("get");

        $_str_markIds   = fn_getSafe(fn_get("mark_ids"), "txt", "");
        $_str_tagIds    = fn_getSafe(fn_get("tag_ids"), "txt", "");
        $_str_specIds   = fn_getSafe(fn_get("spec_ids"), "txt", "");
        $_str_customs   = fn_getSafe(fn_get("customs"), "txt", "");
        $_num_cateId    = fn_getSafe(fn_get("cate_id"), "int", 0);
        $_num_perPage   = fn_getSafe(fn_get("per_page"), "int", BG_SITE_PERPAGE);

        $_arr_markIds   = array();
        $_arr_tagIds    = array();
        $_arr_specIds   = array();
        $_arr_customs   = array();

        if (!fn_isEmpty($_str_markIds)) {
            if (stristr($_str_markIds, "|")) {
                $_arr_markIds = explode("|", $_str_markIds);
            } else {
                $_arr_markIds = array($_str_markIds);
            }
        }
        if (!fn_isEmpty($_str_tagIds)) {
            if (stristr($_str_tagIds, "|")) {
                $_arr_tagIds  = explode("|", $_str_tagIds);
            }
        }
        if (!fn_isEmpty($_str_specIds)) {
            if (stristr($_str_specIds, "|")) {
                $_arr_specIds  = explode("|", $_str_specIds);
            }
        }
        $_str_customs = urldecode($_str_customs);
        $_str_customs = fn_htmlcode($_str_customs, "decode", "base64");
        $_str_customs = base64_decode($_str_customs);
        $_str_customs = urldecode($_str_customs);
        if (stristr($_str_customs, "&")) {
            $_arr_customs = explode("&", $_str_customs);
        } else {
            $_arr_customs = array($_str_customs);
        }

        $_arr_customSearch = array();
        if ($_arr_customs) {
            foreach ($_arr_customs as $_key=>$_value) {
                if (stristr($_value, "=")) {
                    $_arr_customRow = explode("=", $_value);
                    if (isset($_arr_customRow[0]) && isset($_arr_customRow[1])) {
                        $_arr_customSearch[$_arr_customRow[0]] = $_arr_customRow[1];
                    }
                }
            }
        }

        $_arr_cateIds = array();
        $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_num_cateId);

        if ($_num_cateId > 0) {
            if ($_arr_cateRow["alert"] == "y110102" && $_arr_cateRow["cate_status"] == "show") {
                $_arr_cateIds = $_arr_cateRow["cate_ids"];
            }
        }

        $_arr_search = array(
            "key"           => fn_getSafe(fn_get("key"), "txt", ""),
            "year"          => fn_getSafe(fn_get("year"), "txt", ""),
            "month"         => fn_getSafe(fn_get("month"), "txt", ""),
            "spec_ids"      => $_arr_specIds,
            "cate_ids"      => $_arr_cateIds,
            "mark_ids"      => $_arr_markIds,
            "tag_ids"       => $_arr_tagIds,
            "custom_rows"   => $_arr_customSearch,
        );

        $_num_articleCount    = $this->mdl_articlePub->mdl_count($_arr_search);
        $_arr_page            = fn_page($_num_articleCount, $_num_perPage); //取得分页数据
        $_arr_articleRows     = $this->mdl_articlePub->mdl_list($_num_perPage, $_arr_page["except"], $_arr_search);

        foreach ($_arr_articleRows as $_key=>$_value) {
            unset($_arr_articleRows[$_key]["urlRow"]["article_url"]);

            $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_value["article_cate_id"]);

            if ($_arr_cateRow["alert"] == "y110102") {
                unset($_arr_cateRow["urlRow"]);
            }
            $_arr_searchTag = array(
                "status"        => "show",
                "article_id"    => $_value["article_id"],
            );
            $_arr_articleRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

            if ($_value["article_attach_id"] > 0) {
                $_arr_attachRow = $this->mdl_attach->mdl_url($_value["article_attach_id"]);
                if ($_arr_attachRow["alert"] == "y070102") {
                    if ($_arr_attachRow["attach_box"] != "normal") {
                        $_arr_attachRow = array(
                            "alert" => "x070102",
                        );
                    }
                }
                $_arr_articleRows[$_key]["attachRow"]    = $_arr_attachRow;
            }
            $_arr_articleRows[$_key]["cateRow"] = $_arr_cateRow;
        }

        $_arr_return = array(
            "pageRow"        => $_arr_page,
            "articleRows"    => $_arr_articleRows,
        );

        //print_r($_arr_return);

        $this->obj_api->halt_re($_arr_return, true);
    }


    /**
     * app_check function.
     *
     * @access private
     * @param mixed $num_appId
     * @param string $str_method (default: "get")
     * @return void
     */
    private function app_check($str_method = "get") {
        $this->appGet = $this->obj_api->app_get($str_method);

        if ($this->appGet["alert"] != "ok") {
            $this->obj_api->halt_re($this->appGet);
        }

        $_arr_appRow = $this->mdl_app->mdl_read($this->appGet["app_id"]);
        if ($_arr_appRow["alert"] != "y190102") {
            $this->obj_api->halt_re($_arr_appRow);
        }
        $this->appAllow = $_arr_appRow["app_allow"];

        $_arr_appChk = $this->obj_api->app_chk($this->appGet, $_arr_appRow);
        if ($_arr_appChk["alert"] != "ok") {
            $this->obj_api->halt_re($_arr_appChk);
        }

        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();;
    }


    private function article_init() {
        $_arr_customRows    = $this->mdl_custom->mdl_cache();
        $this->mdl_articlePub->custom_columns   = $_arr_customRows["article_customs"];
    }
}
