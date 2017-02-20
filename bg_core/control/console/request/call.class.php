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
class CONTROL_CONSOLE_REQUEST_CALL {

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

        $this->mdl_call     = new MODEL_CALL();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_callInput = $this->mdl_call->input_submit();
        if ($_arr_callInput["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_callInput);
        }

        if ($_arr_callInput["call_id"] > 0) {
            if (!isset($this->group_allow["call"]["edit"]) && !$this->is_super) {
                $_arr_tplData = array(
                    "rcode" => "x170303",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
        } else {
            if (!isset($this->group_allow["call"]["add"]) && !$this->is_super) {
                $_arr_tplData = array(
                    "rcode" => "x170302",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
        }

        $_arr_callRow = $this->mdl_call->mdl_submit();

        $this->obj_tpl->tplDisplay("result", $_arr_callRow);
    }


    function ctrl_status() {
        if (!isset($this->group_allow["call"]["edit"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x170303",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_callIds = $this->mdl_call->input_ids();
        if ($_arr_callIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_callIds);
        }

        $_str_callStatus = fn_getSafe($GLOBALS["act"], "txt", "");

        $_arr_callRow = $this->mdl_call->mdl_status($_str_callStatus);

        $this->obj_tpl->tplDisplay("result", $_arr_callRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow["call"]["del"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x170304",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_callIds = $this->mdl_call->input_ids();
        if ($_arr_callIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_callIds);
        }

        $_arr_callRow = $this->mdl_call->mdl_del();

        $this->obj_tpl->tplDisplay("result", $_arr_callRow);
    }
}
