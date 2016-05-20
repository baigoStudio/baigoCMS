<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "spec.class.php");
include_once(BG_PATH_MODEL . "cate.class.php");
include_once(BG_PATH_MODEL . "article.class.php"); //载入文章模型类

/*-------------允许类-------------*/
class CONTROL_SPEC {

    public $obj_tpl;
    public $mdl_spec;
    public $adminLogged;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"];
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $this->mdl_spec       = new MODEL_SPEC();
        $this->mdl_cate       = new MODEL_CATE(); //设置栏目对象
        $this->mdl_article    = new MODEL_ARTICLE(); //设置文章对象
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    /**
     * ctl_select function.
     *
     * @access public
     * @return void
     */
    function ctl_select() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
            return array(
                "alert" => "x180303",
            );
        }

        $_num_specId = fn_getSafe(fn_get("spec_id"), "int", 0);

        if ($_num_specId < 1) {
            return array(
                "alert" => "x180204",
            );
        }

        $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
        if ($_arr_specRow["alert"] != "y180102") {
            return $_arr_specRow;
        }

        $_num_cateId        = fn_getSafe(fn_get("cate_id"), "int", 0);

        if ($_num_cateId != 0) {
            $_arr_cateIds = $this->mdl_cate->mdl_ids($_num_cateId);
        } else {
            $_arr_cateIds = false;
        }

        $_arr_search = array(
            "key"           => fn_getSafe(fn_get("key"), "txt", ""),
            "status"        => fn_getSafe(fn_get("status"), "txt", ""),
            "cate_id"       => $_num_cateId,
            "cate_ids"      => $_arr_cateIds,
            "not_spec_id"   => $_num_specId,
        );

        $_arr_searchBelong = array(
            "key"       => fn_getSafe(fn_get("key_belong"), "txt", ""),
            "spec_id"   => $_num_specId,
        );

        $_num_articleCount  = $this->mdl_article->mdl_count($_arr_search);
        $_arr_page          = fn_page($_num_articleCount); //取得分页数据
        $_str_query         = http_build_query($_arr_search);
        $_arr_articleRows   = $this->mdl_article->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_belongRows    = $this->mdl_article->mdl_list(1000, 0, $_arr_searchBelong);

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleRows[$_key]["specRow"] = $this->mdl_spec->mdl_read($_value["article_spec_id"]);
        }

        $_arr_searchCate = array(
            "status" => "show",
        );

        $_arr_cateRows        = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);

        $_arr_tpl = array(
            "query"         => $_str_query,
            "pageRow"       => $_arr_page,
            "search"        => $_arr_search,
            "searchBelong"  => $_arr_searchBelong,
            "specRow"       => $_arr_specRow, //管理员信息
            "cateRows"      => $_arr_cateRows,
            "articleRows"   => $_arr_articleRows,
            "belongRows"    => $_arr_belongRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("spec_select.tpl", $_arr_tplData);

        return array(
            "alert" => "y180102",
        );
    }


    /**
     * ctl_form function.
     *
     * @access public
     * @return void
     */
    function ctl_form() {
        $_num_specId = fn_getSafe(fn_get("spec_id"), "int", 0);

        if ($_num_specId > 0) {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
                return array(
                    "alert" => "x180303",
                );
            }
            $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
            if ($_arr_specRow["alert"] != "y180102") {
                return $_arr_specRow;
            }
        } else {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
                return array(
                    "alert" => "x180302",
                );
            }
            $_arr_specRow = array(
                "spec_id"       => 0,
                "spec_name"     => "",
                "spec_content"  => "",
                "spec_status"   => "show",
            );
        }

        $_arr_tpl = array(
            "specRow" => $_arr_specRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("spec_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y180102",
        );
    }


    function ctl_insert() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
            return array(
                "alert" => "x180301",
            );
        }

        $_num_articleId   = fn_getSafe(fn_get("article_id"), "int", 0);
        if ($_num_articleId > 0) {
            $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
            if ($_arr_articleRow["alert"] != "y120102") {
                return $_arr_articleRow;
            }

            $_arr_articleRow["specRow"] = $this->mdl_spec->mdl_read($_arr_articleRow["article_spec_id"]);
        } else {
            $_arr_articleRow = array(
                "article_id" => 0,
            );
        }

        $_arr_tpl = array(
            "articleRow" => $_arr_articleRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("spec_insert.tpl", $_arr_tplData);

        return array(
            "alert" => "y180301",
        );
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
            return array(
                "alert" => "x180301",
            );
        }

        $_arr_search = array(
            "key"        => fn_getSafe(fn_get("key"), "txt", ""),
            "status"     => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_specCount   = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_specCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_specRows    = $this->mdl_spec->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "specRows"   => $_arr_specRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("spec_list.tpl", $_arr_tplData);

        return array(
            "alert" => "y180301",
        );
    }
}
