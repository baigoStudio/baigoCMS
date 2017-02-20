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
class CONTROL_CONSOLE_UI_MARK {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
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

        $this->mdl_mark     = new MODEL_MARK();

        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    function ctrl_form() {
        if (!isset($this->group_allow["article"]["mark"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x140301";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_num_markId  = fn_getSafe(fn_get("mark_id"), "int", 0);

        if ($_num_markId > 0) {
            $_arr_markRow = $this->mdl_mark->mdl_read($_num_markId);
            if ($_arr_markRow["rcode"] != "y140102") {
                $this->tplData["rcode"] = $_arr_markRow["rcode"];
                $this->obj_tpl->tplDisplay("error", $this->tplData);
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

        $this->obj_tpl->tplDisplay("mark_form", $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow["article"]["mark"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x140301";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_search = array(
            "key" => fn_getSafe(fn_get("key"), "txt", ""),
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

        $this->obj_tpl->tplDisplay("mark_list", $_arr_tplData);
    }
}
