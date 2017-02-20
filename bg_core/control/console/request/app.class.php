<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}


/*-------------用户控制器-------------*/
class CONTROL_CONSOLE_REQUEST_APP {

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

        $this->mdl_app      = new MODEL_APP(); //设置用户模型
    }


    function ctrl_reset() {
        if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x190303",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_num_appId   = fn_getSafe(fn_post("app_id"), "int", 0);

        if ($_num_appId < 1) {
            return array(
                "rcode" => "x190203",
            );
        }

        $_arr_appRow = $this->mdl_app->mdl_read($_num_appId);
        if ($_arr_appRow["rcode"] != "y190102") {
            return $_arr_appRow;
        }

        $_arr_appRow  = $this->mdl_app->mdl_reset($_num_appId);

        $this->obj_tpl->tplDisplay("result", $_arr_appRow);
    }



    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_appInput = $this->mdl_app->input_submit();

        if ($_arr_appInput["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_appInput);
        }

        if ($_arr_appInput["app_id"] > 0) {
            if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
                $_arr_tplData = array(
                    "rcode" => "x190303",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
        } else {
            if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
                $_arr_tplData = array(
                    "rcode" => "x190302",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
        }

        $_arr_appRow = $this->mdl_app->mdl_submit();

        $this->obj_tpl->tplDisplay("result", $_arr_appRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x190303",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_str_status = fn_getSafe($GLOBALS["act"], "txt", "");

        $_arr_appIds = $this->mdl_app->input_ids();
        if ($_arr_appIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_appIds);
        }

        $_arr_appRow = $this->mdl_app->mdl_status($_str_status);

        $this->obj_tpl->tplDisplay("result", $_arr_appRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x190304",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_appIds = $this->mdl_app->input_ids();
        if ($_arr_appIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_appIds);
        }

        $_arr_appRow = $this->mdl_app->mdl_del();

        $this->obj_tpl->tplDisplay("result", $_arr_appRow);
    }
}
