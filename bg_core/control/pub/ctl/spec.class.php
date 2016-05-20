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
class CONTROL_SPEC {

    private $obj_tpl;
    private $search;
    private $mdl_spec;
    private $mdl_tag;
    private $mdl_attach;
    private $cateCache;

    function __construct() { //构造函数
        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->spec_init();
        $_arr_cfg["pub"]        = true;
        $this->obj_tpl          = new CLASS_TPL(BG_PATH_TPL . "pub/" . $this->config["tpl"], $_arr_cfg); //初始化视图对象
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_articlePub   = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->mdl_attach       = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_show() {
        $_num_specId  = fn_getSafe(fn_get("spec_id"), "int", 0);

        if ($_num_specId < 1) {
            return array(
                "alert" => "x180204",
            );
        }

        $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
        if ($_arr_specRow["alert"] != "y180102") {
            return $_arr_specRow;
        }

        if ($_arr_specRow["spec_status"] != "show") {
            return array(
                "alert" => "x180102",
            );
        }

        $this->search["spec_id"] = $_num_specId;

        $_num_articleCount    = $this->mdl_articlePub->mdl_count($this->search);
        $_arr_page            = fn_page($_num_articleCount, BG_SITE_PERPAGE); //取得分页数据
        $_str_query           = http_build_query($this->search);
        $_arr_articleRows     = $this->mdl_articlePub->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], $this->search);

        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();

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

        $_arr_tplData = array(
            "query"          => $_str_query,
            "pageRow"        => $_arr_page,
            "search"         => $this->search,
            "specRow"        => $_arr_specRow,
            "articleRows"    => $_arr_articleRows,
            "cateRows"       => $this->cateRows,
            "customRows"     => $this->customRows["custom_list"],
        );

        $this->obj_tpl->tplDisplay("spec_show.tpl", $_arr_tplData);

        return array(
            "alert" => "y180102",
        );
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        $_arr_search = array(
            "status" => "show",
        );
        $_num_specCount   = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_specCount); //取得分页数据
        $_str_query       = http_build_query($this->search);
        $_arr_specRows    = $this->mdl_spec->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tplData = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $this->search,
            "specRows"   => $_arr_specRows,
            "cateRows"   => $this->cateRows,
            "customRows" => $this->customRows["custom_list"],
        );

        $this->obj_tpl->tplDisplay("spec_list.tpl", $_arr_tplData);
    }


    private function url_process() {
        switch (BG_VISIT_TYPE) {
            case "static":
            case "pstatic":
                $_str_specUrl        = BG_URL_ROOT . "spec/";
                $_str_pageAttach    = "page-";
            break;

            default:
                $_str_specUrl        = BG_URL_ROOT . "index.php?mod=spec&act_get=list";
                $_str_pageAttach    = "&page=";
            break;
        }

        return array(
            "spec_url"       => $_str_specUrl,
            "page_attach"    => $_str_pageAttach,
        );
    }


    private function spec_init() {
        if(defined("BG_SITE_TPL")) {
            $this->config["tpl"] = BG_SITE_TPL;
        } else {
            $this->config["tpl"] = "default";
        }

        $_arr_urlRow = $this->url_process();

        $this->search = array(
            "urlRow"     => $_arr_urlRow,
        );

        if (BG_VISIT_TYPE == "static") {
            $this->search["page_ext"] = "." . BG_VISIT_FILE;
        } else {
            $this->search["page_ext"] = "";
        }

        $this->cateRows     = $this->mdl_cate->mdl_cache();
        $this->customRows   = $this->mdl_custom->mdl_cache();
    }
}
