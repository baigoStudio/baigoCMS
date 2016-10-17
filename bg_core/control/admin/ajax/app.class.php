<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入管理帐号模型

/*-------------用户控制器-------------*/
class AJAX_APP {

    private $adminLogged;
    private $obj_ajax;
    private $log;
    private $mdl_app;
    private $mdl_log;
    private $is_super = false;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //已登录用户信息
        $this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
        $this->obj_ajax->chk_install();
        $this->mdl_app        = new MODEL_APP(); //设置用户模型

        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
    }


    function ajax_reset() {
        if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x190303");
        }

        $_num_appId   = fn_getSafe(fn_post("app_id"), "int", 0);

        if ($_num_appId < 1) {
            return array(
                "alert" => "x190203",
            );
        }

        $_arr_appRow = $this->mdl_app->mdl_read($_num_appId);
        if ($_arr_appRow["alert"] != "y190102") {
            return $_arr_appRow;
        }

        $_arr_appRow  = $this->mdl_app->mdl_reset($_num_appId);

        $this->obj_ajax->halt_alert($_arr_appRow["alert"]);
    }



    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ajax_submit() {
        $_arr_appSubmit = $this->mdl_app->input_submit();

        if ($_arr_appSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_appSubmit["alert"]);
        }

        if ($_arr_appSubmit["app_id"] > 0) {
            if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
                $this->obj_ajax->halt_alert("x190303");
            }
        } else {
            if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
                $this->obj_ajax->halt_alert("x190302");
            }
        }

        $_arr_appRow = $this->mdl_app->mdl_submit();

        $this->obj_ajax->halt_alert($_arr_appRow["alert"]);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ajax_status() {
        if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x190303");
        }

        $_str_status = fn_getSafe($GLOBALS["act_post"], "txt", "");

        $_arr_appIds = $this->mdl_app->input_ids();
        if ($_arr_appIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_appIds["alert"]);
        }

        $_arr_appRow = $this->mdl_app->mdl_status($_str_status);

        $this->obj_ajax->halt_alert($_arr_appRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->group_allow["opt"]["app"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x190304");
        }

        $_arr_appIds = $this->mdl_app->input_ids();
        if ($_arr_appIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_appIds["alert"]);
        }

        $_arr_appRow = $this->mdl_app->mdl_del();

        $this->obj_ajax->halt_alert($_arr_appRow["alert"]);
    }
}
