<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类

/*-------------用户类-------------*/
class AJAX_GROUP {

    private $adminLogged;
    private $mdl_group;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax       = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_group      = new MODEL_GROUP();

        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ajax_submit() {
        $_arr_groupSubmit = $this->mdl_group->input_submit();
        if ($_arr_groupSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_groupSubmit["alert"]);
        }

        if ($_arr_groupSubmit["group_id"] > 0) {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["group"]["edit"])) {
                $this->obj_ajax->halt_alert("x040303");
            }
        } else {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["group"]["add"])) {
                $this->obj_ajax->halt_alert("x040302");
            }
        }

        $_arr_groupRow = $this->mdl_group->mdl_submit();

        $this->obj_ajax->halt_alert($_arr_groupRow["alert"]);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ajax_status() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["group"]["edit"])) {
            $this->obj_ajax->halt_alert("x040303");
        }

        $_arr_groupIds = $this->mdl_group->input_ids();
        if ($_arr_groupIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_groupIds["alert"]);
        }

        $_str_groupStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
        if (!$_str_groupStatus) {
            $this->obj_ajax->halt_alert("x040207");
        }

        $_arr_groupRow = $this->mdl_group->mdl_status($_str_groupStatus);

        $this->obj_ajax->halt_alert($_arr_groupRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["group"]["del"])) {
            $this->obj_ajax->halt_alert("x040304");
        }

        $_arr_groupIds = $this->mdl_group->input_ids();
        if ($_arr_groupIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_groupIds["alert"]);
        }

        $_arr_groupRow = $this->mdl_group->mdl_del();

        $this->obj_ajax->halt_alert($_arr_groupRow["alert"]);
    }


    /**
     * ajax_chkGroup function.
     *
     * @access public
     * @return void
     */
    function ajax_chkname() {
        $_str_groupName   = fn_getSafe(fn_get("group_name"), "txt", "");
        $_num_groupId     = fn_getSafe(fn_get("group_id"), "int", 0);

        $_arr_groupRow = $this->mdl_group->mdl_read($_str_groupName, "group_name", $_num_groupId);

        if ($_arr_groupRow["alert"] == "y040102") {
            $this->obj_ajax->halt_re("x040203");
        }

        $arr_re = array(
            "re" => "ok"
        );

        exit(json_encode($arr_re));
    }
}
