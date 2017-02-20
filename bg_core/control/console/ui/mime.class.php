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
class CONTROL_CONSOLE_UI_MIME {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->obj_base     = $GLOBALS["obj_base"];
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

        $this->mime         = require(BG_PATH_LANG . $this->config["lang"] . "/mime.php");

        $this->mdl_mime     = new MODEL_MIME();

        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    function ctrl_form() {
        if (!isset($this->group_allow["attach"]["mime"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x080301";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_num_mimeId  = fn_getSafe(fn_get("mime_id"), "int", 0);

        $_arr_mimeRows    = $this->mdl_mime->mdl_list(1000);

        foreach ($_arr_mimeRows as $_key=>$_value) {
            unset($this->mime[$_value["mime_name"]]);
        }

        if ($_num_mimeId > 0) {
            $_arr_mimeRow = $this->mdl_mime->mdl_read($_num_mimeId);
            if ($_arr_mimeRow["rcode"] != "y080102") {
                $this->tplData["rcode"] = $_arr_mimeRow["rcode"];
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
        } else {
            $_arr_mimeRow = array(
                "mime_id"   => 0,
                "mime_name" => "",
                "mime_ext"  => "",
                "mime_note" => "",
            );
        }

        $_arr_tpl = array(
            "mimeJson"   => json_encode($this->mime),
            "mimeOften"  => $this->mime,
            "mimeRow"    => $_arr_mimeRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("mime_form", $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->group_allow["attach"]["mime"]) && !$this->is_super) {
            $this->tplData["rcode"] = "x080301";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_num_mimeCount   = $this->mdl_mime->mdl_count();
        $_arr_page        = fn_page($_num_mimeCount); //取得分页数据
        $_arr_mimeRows    = $this->mdl_mime->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"]);

        $_arr_tpl = array(
            "pageRow"    => $_arr_page,
            "mimeRows"   => $_arr_mimeRows, //上传信息信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("mime_list", $_arr_tplData);
    }

}
