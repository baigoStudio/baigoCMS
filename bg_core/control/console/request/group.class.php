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
class CONTROL_CONSOLE_REQUEST_GROUP {

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

        $this->mdl_group    = new MODEL_GROUP();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_groupInput = $this->mdl_group->input_submit();
        if ($_arr_groupInput["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_groupInput);
        }

        if ($_arr_groupInput["group_id"] > 0) {
            if (!isset($this->group_allow["group"]["edit"]) && !$this->is_super) {
                $_arr_tplData = array(
                    "rcode" => "x040303",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
        } else {
            if (!isset($this->group_allow["group"]["add"]) && !$this->is_super) {
                $_arr_tplData = array(
                    "rcode" => "x040302",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
        }

        $_arr_groupRow = $this->mdl_group->mdl_submit();

        $this->obj_tpl->tplDisplay("result", $_arr_groupRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->group_allow["group"]["edit"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x040303",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_groupIds = $this->mdl_group->input_ids();
        if ($_arr_groupIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_groupIds);
        }

        $_str_groupStatus = fn_getSafe($GLOBALS["act"], "txt", "");

        $_arr_groupRow = $this->mdl_group->mdl_status($_str_groupStatus);

        $this->obj_tpl->tplDisplay("result", $_arr_groupRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow["group"]["del"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x040304",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_groupIds = $this->mdl_group->input_ids();
        if ($_arr_groupIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_groupIds);
        }

        $_arr_groupRow = $this->mdl_group->mdl_del();

        $this->obj_tpl->tplDisplay("result", $_arr_groupRow);
    }


    /**
     * ajax_chkGroup function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_groupName   = fn_getSafe(fn_get("group_name"), "txt", "");
        if (!fn_isEmpty($_str_groupName)) {
            $_num_groupId     = fn_getSafe(fn_get("group_id"), "int", 0);
            $_arr_groupRow = $this->mdl_group->mdl_read($_str_groupName, "group_name", $_num_groupId);

            if ($_arr_groupRow["rcode"] == "y040102") {
                $_arr_tplData = array(
                    "rcode" => "x040203",
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
