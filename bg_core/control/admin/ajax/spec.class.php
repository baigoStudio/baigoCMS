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
include_once(BG_PATH_MODEL . "spec.class.php");
include_once(BG_PATH_MODEL . "article.class.php");

/*-------------用户类-------------*/
class AJAX_SPEC {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_spec;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax       = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_spec       = new MODEL_SPEC();
        $this->mdl_article    = new MODEL_ARTICLE();

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
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
            $this->obj_ajax->halt_alert("x180302");
        }

        $_arr_specSubmit = $this->mdl_spec->input_submit();

        if ($_arr_specSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_specSubmit["alert"]);
        }

        $_arr_specRow = $this->mdl_spec->mdl_submit();

        $this->obj_ajax->halt_alert($_arr_specRow["alert"], "spec_id", $_arr_specRow["spec_id"]);
    }


    function ajax_status() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
            $this->obj_ajax->halt_alert("x180302");
        }

        $_arr_specIds = $this->mdl_spec->input_ids();
        if ($_arr_specIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_specIds["alert"]);
        }

        $_str_specStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
        if (!$_str_specStatus) {
            $this->obj_ajax->halt_alert("x020213");
        }

        $_arr_specRow = $this->mdl_spec->mdl_status($_str_specStatus);

        $this->obj_ajax->halt_alert($_arr_specRow["alert"]);
    }


    function ajax_toSpec() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
            $this->obj_ajax->halt_alert("x180302");
        }

        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_articleIds["alert"]);
        }

        $_str_act     = fn_getSafe($GLOBALS["act_post"], "txt", "");
        $_nun_specId  = fn_getSafe(fn_post("spec_id"), "int", 0);

        $_arr_articleRow = $this->mdl_article->mdl_toSpec($_str_act, $_nun_specId);

        $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["spec"])) {
            $this->obj_ajax->halt_alert("x180304");
        }

        $_arr_specIds = $this->mdl_spec->input_ids();
        if ($_arr_specIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_specIds["alert"]);
        }

        $_arr_specRow = $this->mdl_spec->mdl_del();

        $this->obj_ajax->halt_alert($_arr_specRow["alert"]);
    }


    /**
     * ajax_list function.
     *
     * @access public
     * @return void
     */
    function ajax_list() {
        $_arr_search = array(
            "key" => fn_getSafe(fn_get("key"), "txt", ""),
        );
        $_num_perPage     = 10;
        $_num_specCount   = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_specCount, $_num_perPage); //取得分页数据
        $_arr_specRows    = $this->mdl_spec->mdl_list($_num_perPage, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "pageRow"    => $_arr_page,
            "specRows"   => $_arr_specRows, //上传信息
        );

        exit(json_encode($_arr_tpl));
    }
}
