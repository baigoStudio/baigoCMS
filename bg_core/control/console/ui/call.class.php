<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------用户类-------------*/
class CONTROL_CONSOLE_UI_CALL {

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

        $this->obj_dir      = new CLASS_DIR();
        $this->mdl_call     = new MODEL_CALL();
        $this->mdl_cate     = new MODEL_CATE();
        $this->mdl_mark     = new MODEL_MARK();
        $this->mdl_spec     = new MODEL_SPEC();

        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    function ctrl_show() {
        if (!isset($this->group_allow["call"]["browse"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x170303";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_num_callId    = fn_getSafe(fn_get("call_id"), "int", 0);
        $_arr_specRows  = array();

        if ($_num_callId < 1) {
            $this->tplData["rcode"] = "x170213";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_callRow = $this->mdl_call->mdl_read($_num_callId);
        if ($_arr_callRow["rcode"] != "y170102") {
            $this->tplData["rcode"] = $_arr_callRow["rcode"];
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_searchCate = array(
            "status" => "show",
        );
        $_arr_cateRows  = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);
        $_arr_markRows  = $this->mdl_mark->mdl_list(100);
        if (!fn_isEmpty($_arr_callRow["call_spec_ids"])) {
            $_arr_searchSpec = array(
                "spec_ids"    => $_arr_callRow["call_spec_ids"],
            );
            $_arr_specRows = $this->mdl_spec->mdl_list(1000, 0, $_arr_searchSpec);
        }

        $_arr_tpl = array(
            "callRow"    => $_arr_callRow,
            "cateRows"   => $_arr_cateRows,
            "markRows"   => $_arr_markRows,
            "specRows"   => $_arr_specRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("call_show", $_arr_tplData);
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_form() {
        $_num_callId    = fn_getSafe(fn_get("call_id"), "int", 0);
        $_arr_specRows  = array();

        if ($_num_callId > 0) {
            if (!isset($this->group_allow["call"]["edit"]) && !$this->is_super) {
                $this->tplData["rcode"] = "x170303";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
            $_arr_callRow = $this->mdl_call->mdl_read($_num_callId);
            if ($_arr_callRow["rcode"] != "y170102") {
                $this->tplData["rcode"] = $_arr_callRow["rcode"];
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }

            if (!fn_isEmpty($_arr_callRow["call_spec_ids"])) {
                $_arr_searchSpec = array(
                    "spec_ids"    => $_arr_callRow["call_spec_ids"],
                );
                $_arr_specRows = $this->mdl_spec->mdl_list(1000, 0, $_arr_searchSpec);
            }
            //print_r($_arr_callRow);
        } else {
            if (!isset($this->group_allow["call"]["add"]) && !$this->is_super) {
                $this->tplData["rcode"] = "x170302";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }

            $_arr_statusKeys   = array_keys($this->obj_tpl->status["call"]);

            $_arr_callRow = array(
                "call_id"           => 0,
                "call_name"         => "",
                "call_file"         => "",
                "call_tpl"          => "",
                "call_amount"       => array(
                    "top"       => 10,
                    "except"    => 0,
                ),
                "call_attach"       => "",
                "call_cate_id"      => "",
                "call_cate_ids"     => array(),
                "call_cate_excepts" => array(),
                "call_mark_ids"     => array(),
                //"call_spec_ids"     => array(),
                "call_type"         => "",
                "call_status"       => $_arr_statusKeys[0],
            );
        }

        $_arr_searchCate = array(
            "status" => "show",
        );

        $_arr_cateRows    = $this->mdl_cate->mdl_list(1000, 0, $_arr_searchCate);
        $_arr_markRows    = $this->mdl_mark->mdl_list(100);

        $_arr_tplRows     = $this->obj_dir->list_dir(BG_PATH_TPL . "call/", BG_DEFAULT_TPL);

        foreach ($_arr_tplRows as $_key=>$_value) {
            $_arr_nameS = explode(".", $_value["name"]);
            $_arr_tplRows[$_key]["name_s"] = $_arr_nameS[0];
        }

        $_arr_tpl = array(
            "specRows"   => $_arr_specRows,
            "callRow"    => $_arr_callRow,
            "cateRows"   => $_arr_cateRows,
            "markRows"   => $_arr_markRows,
            "tplRows"    => $_arr_tplRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("call_form", $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow["call"]["browse"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x170301";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_search = array(
            "key"        => fn_getSafe(fn_get("key"), "txt", ""),
            "type"       => fn_getSafe(fn_get("type"), "txt", ""),
            "status"     => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_callCount   = $this->mdl_call->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_callCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_callRows    = $this->mdl_call->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "callRows"   => $_arr_callRows, //管理员列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("call_list", $_arr_tplData);
    }
}
