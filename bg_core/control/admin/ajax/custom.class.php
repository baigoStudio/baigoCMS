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
include_once(BG_PATH_MODEL . "custom.class.php");
include_once(BG_PATH_MODEL . "articlePub.class.php");
include_once(BG_PATH_MODEL . "articleCustom.class.php");


/*-------------用户类-------------*/
class AJAX_CUSTOM {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_custom;

    function __construct() { //构造函数
        $this->adminLogged        = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax           = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_custom         = new MODEL_CUSTOM();
        $this->mdl_articlePub     = new MODEL_ARTICLE_PUB();
        $this->mdl_articleCustom  = new MODEL_ARTICLE_CUSTOM();

        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }
    }


    function ajax_order() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["custom"])) {
            $this->obj_ajax->halt_alert("x200303");
        }
        if (!fn_token("chk")) { //令牌
            $this->obj_ajax->halt_alert("x030206");
        }

        $_num_customId = fn_getSafe(fn_post("custom_id"), "int", 0); //ID

        if ($_num_customId < 1) {
            $this->obj_ajax->halt_alert("x200209");
        }

        $_arr_customRow = $this->mdl_custom->mdl_read($_num_customId);
        if ($_arr_customRow["alert"] != "y200102") {
            $this->obj_ajax->halt_alert($_arr_customRow["alert"]);
        }

        $_num_parentId    = fn_getSafe(fn_post("custom_parent_id"), "int", 0);
        $_str_orderType   = fn_getSafe(fn_post("order_type"), "txt", "order_first");
        $_num_targetId    = fn_getSafe(fn_post("order_target"), "int", 0);
        $_arr_customRow   = $this->mdl_custom->mdl_order($_str_orderType, $_num_customId, $_num_targetId, $_num_parentId);

        $this->misc_process();

        $this->obj_ajax->halt_alert($_arr_customRow["alert"]);
    }


    function ajax_cache() {
        $this->misc_process();

        //print_r($_str_outPut);

        $this->obj_ajax->halt_alert("y200110");
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ajax_submit() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["custom"])) {
            $this->obj_ajax->halt_alert("x200302");
        }

        $_arr_customSubmit = $this->mdl_custom->input_submit();

        if ($_arr_customSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_customSubmit["alert"]);
        }

        $_arr_customRow = $this->mdl_custom->mdl_submit();

        $this->misc_process();

        $this->obj_ajax->halt_alert($_arr_customRow["alert"]);
    }


    function ajax_status() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["custom"])) {
            $this->obj_ajax->halt_alert("x170303");
        }

        $_arr_customIds = $this->mdl_custom->input_ids();
        if ($_arr_customIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_customIds["alert"]);
        }

        $_str_customStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
        if (!$_str_customStatus) {
            $this->obj_ajax->halt_alert("x200206");
        }

        $_arr_customRow = $this->mdl_custom->mdl_status($_str_customStatus);

        $this->misc_process();

        $this->obj_ajax->halt_alert($_arr_customRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["custom"])) {
            $this->obj_ajax->halt_alert("x200304");
        }

        $_arr_customIds = $this->mdl_custom->input_ids();
        if ($_arr_customIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_customIds["alert"]);
        }

        $_arr_customRow = $this->mdl_custom->mdl_del();

        $this->misc_process();

        $this->obj_ajax->halt_alert($_arr_customRow["alert"]);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ajax_chkname() {
        $_str_customName      = fn_getSafe(fn_get("custom_name"), "txt", "");
        $_num_customId        = fn_getSafe(fn_get("custom_id"), "int", 0);
        $_arr_customRow       = $this->mdl_custom->mdl_read($_str_customName, "custom_name", $_num_customId);
        if ($_arr_customRow["alert"] == "y200102") {
            $this->obj_ajax->halt_re("x200203");
        }

        $arr_re = array(
            "re" => "ok"
        );

        exit(json_encode($arr_re));
    }


    function misc_process() {
        $_arr_searchCustom = array(
            "status" => "enable",
        );
        $_arr_customRows = $this->mdl_custom->mdl_list(1000, 0, $_arr_searchCustom, 0, false);
        $this->mdl_articleCustom->mdl_create_table($_arr_customRows);
        $this->mdl_articlePub->mdl_create_custom_view($_arr_customRows);
        $this->mdl_custom->mdl_cache(true);
    }
}
