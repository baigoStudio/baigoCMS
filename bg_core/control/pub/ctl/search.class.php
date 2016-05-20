<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------文章类-------------*/
class CONTROL_SEARCH {

    private $obj_tpl;
    private $search;
    private $mdl_tag;
    private $mdl_article;
    private $mdl_attach;
    private $cateCache;

    function __construct() { //构造函数
        $this->mdl_cate       = new MODEL_CATE(); //设置文章对象
        $this->mdl_custom     = new MODEL_CUSTOM();
        $this->mdl_attach     = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_thumb      = new MODEL_THUMB(); //设置上传信息对象
        $this->search_init();
        $_arr_cfg["pub"]      = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "pub/" . $this->config["tpl"], $_arr_cfg); //初始化视图对象
        $this->mdl_tag        = new MODEL_TAG();
        $this->mdl_articlePub = new MODEL_ARTICLE_PUB(); //设置文章对象
    }


    function ctl_show() {
        $_str_query       = "";
        $_arr_page        = array();
        $_arr_articleRows = array();

        if ($this->search["key"] || $this->search["customs"]) {
            $_num_articleCount    = $this->mdl_articlePub->mdl_count($this->search);
            $_arr_page            = fn_page($_num_articleCount, BG_SITE_PERPAGE); //取得分页数据
            $_str_query           = http_build_query($this->search);
            $_arr_articleRows     = $this->mdl_articlePub->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], $this->search);

            foreach ($_arr_articleRows as $_key=>$_value) {
                $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_value["article_cate_id"]);

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

                $_arr_articleRows[$_key]["cateRow"]  = $_arr_cateRow;
                if ($_arr_cateRow["cate_trees"][0]["cate_domain"]) {
                    $_arr_articleRows[$_key]["article_url"]  = $_arr_cateRow["cate_trees"][0]["cate_domain"] . "/" . $_value["article_url"];
                }
            }
        }

        $_arr_tpl = array(
            "query"          => $_str_query,
            "search"         => $this->search,
            "pageRow"        => $_arr_page,
            "customs"        => $this->search["custom_rows"],
            "articleRows"    => $_arr_articleRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("search_show.tpl", $_arr_tplData);

        return array(
            "alert" => "y130102",
        );
    }


    private function url_process() {
        switch (BG_VISIT_TYPE) {
            case "pstatic":
            case "static":
                $_str_searchUrl     = BG_URL_ROOT . "search/";
                $_str_pageAttach    = "page-";
            break;

            default:
                $_str_searchUrl     = BG_URL_ROOT . "index.php?mod=search&act_get=" . $GLOBALS["act_get"];
                $_str_pageAttach    = "&page=";
            break;
        }

        return array(
            "search_url"     => $_str_searchUrl,
            "page_attach"    => $_str_pageAttach,
        );
    }


    private function search_init() {
        if(defined("BG_SITE_TPL")) {
            $this->config["tpl"] = BG_SITE_TPL;
        } else {
            $this->config["tpl"] = "default";
        }

        $_num_cateId  = fn_getSafe(fn_get("cate_id"), "int", 0);
        $_str_customs = fn_getSafe(fn_get("customs"), "txt", "");

        $_str_customs = urldecode($_str_customs);
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
                $_arr_customRow = explode("=", $_value);
                if ($_arr_customRow && isset($_arr_customRow[1])) {
                    $_arr_customSearch[$_arr_customRow[0]] = $_arr_customRow[1];
                }
            }
        }

        $this->search = array(
            "cate_id"       => $_num_cateId,
            "key"           => urldecode(fn_getSafe(fn_get("key"), "txt", "")),
            "customs"       => $_str_customs,
            "custom_rows"   => $_arr_customSearch,
            "urlRow"        => $this->url_process(),
        );

        if ($_num_cateId > 0) {
            $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_num_cateId);

            if ($_arr_cateRow["alert"] == "y110102" && $_arr_cateRow["cate_status"] == "show") {
                $this->search["cate_ids"] = $_arr_cateRow["cate_ids"];
            }
        }

        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_cache();
        $_arr_cateRows                  = $this->mdl_cate->mdl_cache();
        $_arr_customRows                = $this->mdl_custom->mdl_cache();

        $this->tplData = array(
            "customRows" => $_arr_customRows["custom_list"],
            "cateRows"   => $_arr_cateRows,
        );
    }

}
