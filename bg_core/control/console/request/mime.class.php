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
class CONTROL_CONSOLE_REQUEST_MIME {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->obj_console  = new CLASS_CONSOLE();
        $this->obj_console->dspType = "result";
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

        $this->mdl_mime     = new MODEL_MIME();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        if (!isset($this->group_allow["attach"]["mime"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x080302",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_mimeInput = $this->mdl_mime->input_submit();

        if ($_arr_mimeInput["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_mimeInput);
        }

        $_arr_mimeRow = $this->mdl_mime->mdl_submit();

        $this->obj_tpl->tplDisplay("result", $_arr_mimeRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow["attach"]["mime"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x080304",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_mimeIds = $this->mdl_mime->input_ids();
        if ($_arr_mimeIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_mimeIds);
        }

        $_arr_mimeRow = $this->mdl_mime->mdl_del();

        $this->obj_tpl->tplDisplay("result", $_arr_mimeRow);
    }



    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_mimeName    = fn_getSafe(fn_get("mime_name"), "txt", "");

        if (!fn_isEmpty($_str_mimeName)) {
            $_num_mimeId      = fn_getSafe(fn_get("mime_id"), "int", 0);
            $_arr_mimeRow     = $this->mdl_mime->mdl_read($_str_mimeName, "mime_name", $_num_mimeId);

            if ($_arr_mimeRow["rcode"] == "y080102") {
                $_arr_tplData = array(
                    "rcode" => "x080206",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
        }

        $_arr_tplData = array(
            "msg" => "ok"
        );
        $this->obj_tpl->tplDisplay("result", $_arr_tplData);
    }
}
