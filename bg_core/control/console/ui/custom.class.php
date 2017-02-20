<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}


/*-------------允许类-------------*/
class CONTROL_CONSOLE_UI_CUSTOM {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->obj_base     = $GLOBALS["obj_base"]; //获取界面类型
        $this->config       = $this->obj_base->config;

        $this->obj_console  = new CLASS_CONSOLE();
        $this->obj_console->chk_install();

        $this->adminLogged  = $this->obj_console->ssin_begin();
        $this->obj_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->obj_console->obj_tpl;

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        if (isset($this->adminLogged["groupRow"]["group_allow"])) {
            $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
        }

        $this->fields       = require(BG_PATH_LANG . $this->config["lang"] . "/fields.php");

        $this->mdl_custom   = new MODEL_CUSTOM();
        $this->mdl_cate     = new MODEL_CATE(); //设置栏目对象

        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    function ctrl_order() {
        if (!isset($this->group_allow["opt"]["article"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x200303";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_num_customId = fn_getSafe(fn_get("custom_id"), "int", 0);

        if ($_num_customId < 1) {
            $this->tplData["rcode"] = "x200209";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_customRow = $this->mdl_custom->mdl_read($_num_customId);
        if ($_arr_customRow["rcode"] != "y200102") {
            $this->tplData["rcode"] = $_arr_customRow["rcode"];
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_tpl = array(
            "customRow"    => $_arr_customRow, //栏目信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("custom_order", $_arr_tplData);
    }


    function ctrl_form() {
        if (!isset($this->group_allow["opt"]["article"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x200301";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_num_customId    = fn_getSafe(fn_get("custom_id"), "int", 0);

        if ($_num_customId > 0) {
            $_arr_customRow = $this->mdl_custom->mdl_read($_num_customId);
            if ($_arr_customRow["rcode"] != "y200102") {
                $this->tplData["rcode"] = $_arr_customRow["rcode"];
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
        } else {
            $_arr_statusKeys   = array_keys($this->obj_tpl->status["custom"]);

            $_arr_customRow = array(
                "custom_id"         => 0,
                "custom_name"       => "",
                "custom_type"       => "",
                "custom_opt"        => "",
                "custom_status"     => $_arr_statusKeys[0],
                "custom_parent_id"  => -1,
                "custom_cate_id"    => -1,
                "custom_format"     => "",
            );
        }

        if (!fn_isEmpty($_arr_customRow["custom_opt"])) {
            $this->fields[$_arr_customRow["custom_type"]]["option"] = $_arr_customRow["custom_opt"];
        }

        $_arr_searchCate = array(
            "status" => "show",
        );

        $_arr_searchCustom = array(
            "status" => "enable",
        );

        $_arr_customRows  = $this->mdl_custom->mdl_list(1000, 0, $_arr_searchCustom);
        $_arr_cateRows    = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);

        //print_r($_arr_customRow);

        $_arr_tpl = array(
            "customRow"  => $_arr_customRow,
            "customRows" => $_arr_customRows,
            "cateRows"   => $_arr_cateRows,
            "fields"     => $this->fields,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("custom_form", $_arr_tplData);
    }

    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow["opt"]["article"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x200301";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_search = array(
            "key"        => fn_getSafe(fn_get("key"), "txt", ""),
            "status"     => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_customCount = $this->mdl_custom->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_customCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_customRows  = $this->mdl_custom->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        //print_r($_arr_customRows);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "customRows" => $_arr_customRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("custom_list", $_arr_tplData);
    }
}
