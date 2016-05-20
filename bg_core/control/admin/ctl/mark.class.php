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
include_once(BG_PATH_MODEL . "mark.class.php");

/*-------------允许类-------------*/
class CONTROL_MARK {

    public $obj_tpl;
    public $mdl_mark;
    public $adminLogged;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $this->mdl_mark       = new MODEL_MARK();
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    function ctl_form() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["mark"])) {
            return array(
                "alert" => "x140301",
            );
        }

        $_num_markId  = fn_getSafe(fn_get("mark_id"), "int", 0);

        if ($_num_markId > 0) {
            $_arr_markRow = $this->mdl_mark->mdl_read($_num_markId);
            if ($_arr_markRow["alert"] != "y140102") {
                return $_arr_markRow;
            }
        } else {
            $_arr_markRow = array(
                "mark_id"   => 0,
                "mark_name" => "",
            );
        }

        $_arr_tpl = array(
            "markRow"    => $_arr_markRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("mark_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y140102",
        );
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["mark"])) {
            return array(
                "alert" => "x140301",
            );
        }

        $_arr_search = array(
            "key"        => fn_getSafe(fn_get("key"), "txt", ""),
        );

        $_num_markCount   = $this->mdl_mark->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_markCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_markRows    = $this->mdl_mark->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "markRows"   => $_arr_markRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("mark_list.tpl", $_arr_tplData);

        return array(
            "alert" => "y140301",
        );
    }
}
