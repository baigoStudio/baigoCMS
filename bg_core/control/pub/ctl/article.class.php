<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------文章类-------------*/
class CONTROL_ARTICLE {

    private $cateRow;
    private $articleRow;
    private $tplData;
    private $obj_tpl;
    private $mdl_cate;
    private $mdl_articlePub;
    private $mdl_tag;
    private $mdl_attach;
    private $config;
    private $cateCache;

    function __construct() { //构造函数
        $this->mdl_cate       = new MODEL_CATE(); //设置文章对象
        $this->mdl_articlePub = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->mdl_tag        = new MODEL_TAG();
        $this->mdl_custom     = new MODEL_CUSTOM();
        $this->article_init();
        $_arr_cfg["pub"]      = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "pub/" . $this->config["tpl"], $_arr_cfg); //初始化视图对象
        $this->mdl_attach     = new MODEL_ATTACH();
        $this->mdl_thumb      = new MODEL_THUMB();
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_show() {
        if ($this->articleId < 1) {
            return array(
                "alert" => "x120212",
            );
        }

        if ($this->articleRow["alert"] != "y120102") {
            return $this->articleRow;
        }

        if (fn_isEmpty($this->articleRow["article_title"]) || $this->articleRow["article_status"] != "pub" || $this->articleRow["article_box"] != "normal" || $this->articleRow["article_time_pub"] > time() || ($this->articleRow["article_time_hide"] > 0 && $this->articleRow["article_time_hide"] < time())) {
            return array(
                "alert" => "x120102",
            );
        }

        if (isset($this->articleRow["article_link"]) && !fn_isEmpty($this->articleRow["article_link"])) {
            return array(
                "alert"         => "x120213",
                "article_link"  => $this->articleRow["article_link"],
            );
        }

        if ($this->cateRow["alert"] != "y110102") {
            return $this->cateRow;
        }

        if ($this->cateRow["cate_status"] != "show") {
            return array(
                "alert" => "x110102",
            );
        }

        if (isset($this->cateRow["cate_type"]) && $this->cateRow["cate_type"] == "link" && isset($this->cateRow["cate_link"]) && !fn_isEmpty($this->cateRow["cate_link"])) {
            return array(
                "alert"     => "x110218",
                "cate_link" => $this->cateRow["cate_link"],
            );
        }

        $this->articleRow["cateRow"]    = $this->cateRow;

        $_arr_searchTag = array(
            "status"        => "show",
            "article_id"    => $this->articleRow["article_id"],
        );
        $this->articleRow["tagRows"]    = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);
        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_cache();
        $_arr_cateRows                  = $this->mdl_cate->mdl_cache();
        $_arr_customRows                = $this->mdl_custom->mdl_cache();

        if ($this->articleRow["article_attach_id"] > 0) {
            $_arr_attachRow = $this->mdl_attach->mdl_url($this->articleRow["article_attach_id"]);
            if ($_arr_attachRow["alert"] == "y070102") {
                if ($_arr_attachRow["attach_box"] != "normal") {
                    $_arr_attachRow = array(
                        "alert" => "x070102",
                    );
                }
            }
            $this->articleRow["attachRow"]   = $_arr_attachRow;
        }

        //print_r(date("W", strtotime("2014-12-01")));

        $this->mdl_articlePub->mdl_hits($this->articleRow["article_id"]);

        $_arr_tagIds    = array();
        $_arr_assRows   = array();

        foreach ($this->articleRow["tagRows"] as $_key=>$_value) {
            $_arr_tagIds[] = $_value["tag_id"];
        }

        if ($_arr_tagIds) {
            $_arr_search = array(
                "tag_ids" => $_arr_tagIds,
            );
            $_arr_assRows = $this->mdl_articlePub->mdl_list(BG_SITE_ASSOCIATE, 0, $_arr_search);

            foreach ($_arr_assRows as $_key=>$_value) {
                $_arr_articleCateRow = $this->mdl_cate->mdl_cache(false, $_value["article_cate_id"]);
                $_arr_searchTag = array(
                    "status"        => "show",
                    "tarticle_id"   => $_value["article_id"],
                );
                $_arr_assRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

                if ($_value["article_attach_id"] > 0) {
                    $_arr_attachRow = $this->mdl_attach->mdl_url($_value["article_attach_id"]);
                    if ($_arr_attachRow["alert"] == "y070102") {
                        if ($_arr_attachRow["attach_box"] != "normal") {
                            $_arr_attachRow = array(
                                "alert" => "x070102",
                            );
                        }
                    }
                    $_arr_assRows[$_key]["attachRow"]    = $_arr_attachRow;
                }

                $_arr_assRows[$_key]["cateRow"]  = $_arr_articleCateRow;
                /*if ($_arr_articleCateRow["cate_trees"][0]["cate_domain"]) {
                    $_arr_assRows[$_key]["urlRow"]["article_url"]  = $_arr_articleCateRow["cate_trees"][0]["cate_domain"] . "/" . $_value["urlRow"]["article_url"];
                }*/
                $_arr_assRows[$_key]["urlRow"]  = $this->mdl_cate->article_url_process($_value, $_arr_articleCateRow);
            }
        }


        $_arr_tpl = array(
            "cateRows"       => $_arr_cateRows,
            "customRows"     => $_arr_customRows["custom_list"],
            "articleRow"     => $this->articleRow,
            "associateRows"  => $_arr_assRows,
        );

        $this->obj_tpl->tplDisplay("article_show.tpl", $_arr_tpl);

        return array(
            "alert" => "y120102",
        );
    }


    /**
     * article_init function.
     *
     * @access private
     * @return void
     */
    private function article_init() {
        $this->articleId   = fn_getSafe(fn_get("article_id"), "int", 0);

        if ($this->articleId > 0) {

            $_arr_customRows    = $this->mdl_custom->mdl_cache();
            $this->mdl_articlePub->custom_columns   = $_arr_customRows["article_customs"];

            $this->articleRow = $this->mdl_articlePub->mdl_read($this->articleId);
            if ($this->articleRow["alert"] == "y120102") {
                $this->cateRow = $this->mdl_cate->mdl_cache(false, $this->articleRow["article_cate_id"]);
                if ($this->cateRow["alert"] == "y110102" && isset($this->cateRow["cate_tplDo"])) {
                    $this->config["tpl"]    = $this->cateRow["cate_tplDo"];
                } else {
                    $this->config["tpl"]    = "default";
                }
                $this->articleRow["urlRow"] = $this->mdl_cate->article_url_process($this->articleRow, $this->cateRow);
            }
        }
    }
}
