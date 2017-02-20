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
class CONTROL_CONSOLE_UI_CATE {

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
        $this->mdl_cate     = new MODEL_CATE(); //设置栏目对象

        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    /**
     * ctrl_order function.
     *
     * @access public
     */
    function ctrl_order() {
        if (!isset($this->group_allow["cate"]["edit"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x250303";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_num_cateId = fn_getSafe(fn_get("cate_id"), "int", 0);

        if ($_num_cateId < 1) {
            $this->tplData["rcode"] = "x250217";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);
        if ($_arr_cateRow["rcode"] != "y250102") {
            $this->tplData["rcode"] = $_arr_cateRow["rcode"];
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_tpl = array(
            "cateRow"    => $_arr_cateRow, //栏目信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("cate_order", $_arr_tplData);
    }


    /**
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_form() {
        $_num_cateId = fn_getSafe(fn_get("cate_id"), "int", 0);

        if ($_num_cateId > 0) {
            if (!isset($this->group_allow["cate"]["edit"]) && !isset($this->adminLogged["admin_allow_cate"][$_num_cateId]["cate"]) && !$this->is_super) {
                $this->tplData["rcode"] = "x250303";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
            $_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);
            if ($_arr_cateRow["rcode"] != "y250102") {
                $this->tplData["rcode"] = $_arr_cateRow["rcode"];
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
        } else {
            if (!isset($this->group_allow["cate"]["add"]) && !$this->is_super) {
                $this->tplData["rcode"] = "x250302";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }

            $_arr_statusKeys   = array_keys($this->obj_tpl->status["cate"]);
            $_arr_typeKeys     = array_keys($this->obj_tpl->type["cate"]);

            $_arr_cateRow = array(
                "cate_id"           => 0,
                "cate_name"         => "",
                "cate_alias"        => "",
                "cate_content"      => "",
                "cate_link"         => "",
                "cate_type"         => $_arr_typeKeys[0],
                "cate_status"       => $_arr_statusKeys[0],
                "cate_parent_id"    => -1,
                "cate_domain"       => "",
                "cate_perpage"      => BG_SITE_PERPAGE,
                "cate_ftp_host"     => "",
                "cate_ftp_port"     => "",
                "cate_ftp_user"     => "",
                "cate_ftp_pass"     => "",
                "cate_ftp_path"     => "",
            );
        }

        $_arr_cateRows    = $this->mdl_cate->mdl_list(1000);

        $_arr_tplRows     = $this->obj_dir->list_dir(BG_PATH_TPL . "pub/");

        $_arr_tpl = array(
            "cateRow"    => $_arr_cateRow, //栏目信息
            "cateRows"   => $_arr_cateRows, //栏目列表
            "tplRows"    => $_arr_tplRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("cate_form", $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow["cate"]["browse"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x250301";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_search = array(
            "key"        => fn_getSafe(fn_get("key"), "txt", ""),
            "type"       => fn_getSafe(fn_get("type"), "txt", ""),
            "status"     => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_cateCount   = $this->mdl_cate->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_cateCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_cateRows    = $this->mdl_cate->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "cateRows"   => $_arr_cateRows, //栏目信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("cate_list", $_arr_tplData);
    }
}
