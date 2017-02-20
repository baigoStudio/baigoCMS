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
class CONTROL_PUB_UI_CATE {

    var $config = array();

    function __construct() { //构造函数
        $this->mdl_cate       = new MODEL_CATE(); //设置文章对象
        $this->mdl_custom     = new MODEL_CUSTOM();
        $this->mdl_articlePub = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->mdl_tag        = new MODEL_TAG();
        $this->mdl_attach     = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_thumb      = new MODEL_THUMB(); //设置上传信息对象

        $this->cate_init();

        $_arr_cfg["pub"]      = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "pub/" . $this->config["tpl"], $_arr_cfg); //初始化视图对象
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_show() {
        if ($this->search["cate_id"] < 1) {
            $_arr_tplData = array(
                "rcode" => "x250217",
            );
            $this->obj_tpl->tplDisplay("error", $_arr_tplData);
        }

        if ($this->cateRow["rcode"] != "y250102") {
            $this->obj_tpl->tplDisplay("error", $this->cateRow);
        }

        if (isset($this->cateRow["cate_type"]) && $this->cateRow["cate_type"] == "link" && isset($this->cateRow["cate_link"]) && !fn_isEmpty($this->cateRow["cate_link"])) {
            header("Location: " . $this->cateRow["cate_link"]);
            exit;
        }

        if ($this->cateRow["cate_perpage"] > 0 && $this->cateRow["cate_perpage"] != BG_SITE_PERPAGE) {
            $_num_perpage = $this->cateRow["cate_perpage"];
        } else {
            $_num_perpage = BG_SITE_PERPAGE;
        }

        $_num_articleCount    = $this->mdl_articlePub->mdl_count($this->search);
        $_arr_page            = fn_page($_num_articleCount, $_num_perpage); //取得分页数据
        $_str_query           = http_build_query($this->search);
        $_arr_articleRows     = $this->mdl_articlePub->mdl_list($_num_perpage, $_arr_page["except"], $this->search);

        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleCateRow = $this->mdl_cate->mdl_cache(false, $_value["article_cate_id"]);

            $_arr_searchTag = array(
                "status"        => "show",
                "article_id"    => $_value["article_id"],
            );
            $_arr_articleRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

            if ($_value["article_attach_id"] > 0) {
                $_arr_attachRow = $this->mdl_attach->mdl_url($_value["article_attach_id"]);
                if ($_arr_attachRow["rcode"] == "y070102") {
                    if ($_arr_attachRow["attach_box"] != "normal") {
                        $_arr_attachRow = array(
                            "rcode" => "x070102",
                        );
                    }
                }
                $_arr_articleRows[$_key]["attachRow"]    = $_arr_attachRow;
            }

            $_arr_articleRows[$_key]["cateRow"]  = $_arr_articleCateRow;
            /*if ($_arr_articleCateRow["cate_trees"][0]["cate_domain"]) {
                $_arr_articleRows[$_key]["urlRow"]["article_url"]  = $_arr_articleCateRow["cate_trees"][0]["cate_domain"] . "/" . $_value["urlRow"]["article_url"];
            }*/
            $_arr_articleRows[$_key]["urlRow"]  = $this->mdl_cate->article_url_process($_value, $_arr_articleCateRow);
        }

        //print_r($_arr_articleRows);

        $_arr_tplData = array(
            "query"          => $_str_query,
            "search"         => $this->search,
            "pageRow"        => $_arr_page,
            "customs"        => $this->search["custom_rows"],
            "articleRows"    => $_arr_articleRows,
        );

        $_arr_tpl = array_merge($this->tplData, $_arr_tplData);

        switch ($this->cateRow["cate_type"]) {
            case "single":
                $_str_tplFile = "single";
            break;

            default:
                $_str_tplFile = "show";
            break;
        }

        $this->obj_tpl->tplDisplay("cate_" . $_str_tplFile . "", $_arr_tpl);
    }


    /**
     * cate_init function.
     *
     * @access private
     */
    private function cate_init() {
        if (defined("BG_SITE_TPL")) {
            $this->config["tpl"] = BG_SITE_TPL;
        } else {
            $this->config["tpl"] = "default";
        }

        $_num_cateId  = fn_getSafe(fn_get("cate_id"), "int", 0);
        $_str_customs = fn_getSafe(fn_get("customs"), "txt", "");

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

        if (!fn_isEmpty($_arr_customs)) {
            foreach ($_arr_customs as $_key=>$_value) {
                $_arr_customRow = explode("=", $_value);
                if (!fn_isEmpty($_arr_customRow) && isset($_arr_customRow[1])) {
                    $_arr_customSearch[$_arr_customRow[0]] = $_arr_customRow[1];
                }
            }
        }

        $this->search = array(
            "cate_ids"      => array(),
            "cate_id"       => $_num_cateId,
            "key"           => urldecode(fn_getSafe(fn_get("key"), "txt", "")),
            "customs"       => $_str_customs,
            "custom_rows"   => $_arr_customSearch,
        );

        $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_num_cateId);

        if (isset($_arr_cateRow["rcode"]) && $_arr_cateRow["rcode"] == "y250102" && isset($_arr_cateRow["cate_status"]) && $_arr_cateRow["cate_status"] == "show") {
            $this->cateRow          = $_arr_cateRow;
            $this->config["tpl"]    = $this->cateRow["cate_tplDo"];
        } else {
            $this->cateRow = array(
                "rcode" => "x250102",
            );
        }

        if (isset($_arr_cateRow["cate_ids"])) {
            $this->search["cate_ids"] = $_arr_cateRow["cate_ids"];
        }

        $_arr_cateRows      = $this->mdl_cate->mdl_cache();
        $_arr_customRows    = $this->mdl_custom->mdl_cache();
        $this->mdl_articlePub->custom_columns   = $_arr_customRows["article_customs"];

        $this->tplData = array(
            "customRows" => $_arr_customRows["custom_list"],
            "cateRows"   => $_arr_cateRows,
            "cateRow"    => $this->cateRow,
        );
    }
}
