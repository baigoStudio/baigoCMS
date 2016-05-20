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
include_once(BG_PATH_MODEL . "tag.class.php");

/*-------------允许类-------------*/
class CONTROL_TAG {

    public $obj_tpl;
    public $mdl_tag;
    public $adminLogged;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"];
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $this->mdl_tag        = new MODEL_TAG(); //设置上传信息对象
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    function ctl_form() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["tag"])) {
            return array(
                "alert" => "x130301",
            );
        }

        $_num_tagId = fn_getSafe(fn_get("tag_id"), "int", 0);

        if ($_num_tagId > 0) {
            $_arr_tagRow = $this->mdl_tag->mdl_read($_num_tagId);
            if ($_arr_tagRow["alert"] != "y130102") {
                return $_arr_tagRow;
            }
        } else {
            $_arr_tagRow = array(
                "tag_id"        => 0,
                "tag_name"      => "",
                "tag_status"    => "show",
            );
        }

        $_arr_tpl = array(
            "tagRow"     => $_arr_tagRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("tag_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y130102",
        );
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["tag"])) {
            return array(
                "alert" => "x130301",
            );
        }

        $_arr_search = array(
            "key"        => fn_getSafe(fn_get("key"), "txt", ""),
            "status"     => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_tagCount    = $this->mdl_tag->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_tagCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_tagRows     = $this->mdl_tag->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "tagRows"    => $_arr_tagRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("tag_list.tpl", $_arr_tplData);

        return array(
            "alert" => "y130301",
        );
    }
}
