<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "thumb.class.php");

/*-------------用户类-------------*/
class AJAX_THUMB {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_thumb;
    private $is_super = false;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax       = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_thumb      = new MODEL_THUMB();

        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ajax_submit() {
        if (!isset($this->group_allow["attach"]["thumb"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x090302");
        }

        $_arr_thumbSubmit = $this->mdl_thumb->input_submit();

        if ($_arr_thumbSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_thumbSubmit["alert"]);
        }

        $_arr_thumbRow = $this->mdl_thumb->mdl_submit();

        $this->mdl_thumb->mdl_cache(true);

        $this->obj_ajax->halt_alert($_arr_thumbRow["alert"]);
    }


    function ajax_cache() {
        $this->mdl_thumb->mdl_cache(true);

        $this->obj_ajax->halt_alert("y090110");
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->group_allow["attach"]["thumb"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x090304");
        }

        $_arr_thumbIds = $this->mdl_thumb->input_ids();
        if ($_arr_thumbIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_thumbIds["alert"]);
        }

        $_arr_thumbRow = $this->mdl_thumb->mdl_del();

        $this->mdl_thumb->mdl_cache(true);

        $this->obj_ajax->halt_alert($_arr_thumbRow["alert"]);
    }
}
