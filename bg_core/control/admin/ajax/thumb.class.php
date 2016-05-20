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
include_once(BG_PATH_MODEL . "thumb.class.php");

/*-------------用户类-------------*/
class AJAX_THUMB {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_thumb;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax       = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_thumb      = new MODEL_THUMB();

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
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["thumb"])) {
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
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["thumb"])) {
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


    /**
     * ajax_chk function.
     *
     * @access public
     * @return void
     */
    function ajax_chk() {
        $_num_thumbId     = fn_getSafe(fn_get("thumb_id"), "int", 0);
        $_num_thumbWidth  = fn_getSafe(fn_get("thumb_width"), "int", 0);
        $_num_thumbHeight = fn_getSafe(fn_get("thumb_height"), "int", 0);
        $_str_thumbType   = fn_getSafe(fn_get("thumb_type"), "txt", "");

        $_arr_thumbRow  = $this->mdl_thumb->mdl_check($_num_thumbWidth, $_num_thumbHeight, $_str_thumbType);
        if ($_arr_thumbRow["alert"] == "y130102") {
            $this->obj_ajax->halt_re("x130203");
        }

        $arr_re = array(
            "re" => "ok"
        );

        exit(json_encode($arr_re));
    }
}
