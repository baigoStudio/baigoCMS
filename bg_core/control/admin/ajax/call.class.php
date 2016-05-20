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
include_once(BG_PATH_MODEL . "call.class.php");

/*-------------用户类-------------*/
class AJAX_CALL {

    private $adminLogged;
    private $mdl_call;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax       = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_call       = new MODEL_CALL();

        if ($this->adminLogged["alert"] != "y020102") {
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
        $_arr_callSubmit = $this->mdl_call->input_submit();
        if ($_arr_callSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_callSubmit["alert"]);
        }

        if ($_arr_callSubmit["call_id"] > 0) {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["call"]["edit"])) {
                $this->obj_ajax->halt_alert("x170303");
            }
        } else {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["call"]["add"])) {
                $this->obj_ajax->halt_alert("x170302");
            }
        }

        $_arr_callRow = $this->mdl_call->mdl_submit();

        $this->obj_ajax->halt_alert($_arr_callRow["alert"]);
    }


    function ajax_status() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["call"]["edit"])) {
            $this->obj_ajax->halt_alert("x170303");
        }

        $_arr_callIds = $this->mdl_call->input_ids();
        if ($_arr_callIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_callIds["alert"]);
        }

        $_str_callStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
        if (!$_str_callStatus) {
            $this->obj_ajax->halt_alert("x170206");
        }

        $_arr_callRow = $this->mdl_call->mdl_status($_str_callStatus);

        $this->obj_ajax->halt_alert($_arr_callRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["call"]["del"])) {
            $this->obj_ajax->halt_alert("x170304");
        }

        $_arr_callIds = $this->mdl_call->input_ids();
        if ($_arr_callIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_callIds["alert"]);
        }

        $_arr_callRow = $this->mdl_call->mdl_del();

        $this->obj_ajax->halt_alert($_arr_callRow["alert"]);
    }


    /**
     * ajax_chkGroup function.
     *
     * @access public
     * @return void
     */
    function ajax_chkname() {
        $_str_callName   = fn_getSafe(fn_get("call_name"), "txt", "");
        $_num_callId     = fn_getSafe(fn_get("call_id"), "int", 0);

        $_arr_callRow = $this->mdl_call->mdl_read($_str_callName, "call_name", $_num_callId);

        if ($_arr_callRow["alert"] == "y170102") {
            $this->obj_ajax->halt_re("x170203");
        }

        $arr_re = array(
            "re" => "ok"
        );

        exit(json_encode($arr_re));
    }
}
