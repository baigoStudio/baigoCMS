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
include_once(BG_PATH_MODEL . "cate.class.php"); //载入栏目类

/*-------------用户类-------------*/
class AJAX_CATE {

    private $mdl_cate;

    function __construct() { //构造函数
        $this->adminLogged  = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax     = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_cate     = new MODEL_CATE();

        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        $this->mdl_cate->mdl_cache(true);
    }


    /**
     * ajax_order function.
     *
     * @access public
     * @return void
     */
    function ajax_order() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["cate"]["edit"])) {
            $this->obj_ajax->halt_alert("x110303");
        }
        if (!fn_token("chk")) { //令牌
            $this->obj_ajax->halt_alert("x030206");
        }

        $_num_cateId = fn_getSafe(fn_post("cate_id"), "int", 0); //ID

        if ($_num_cateId < 1) {
            $this->obj_ajax->halt_alert("x110217");
        }

        $_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);
        if ($_arr_cateRow["alert"] != "y110102") {
            $this->obj_ajax->halt_alert($_arr_cateRow["alert"]);
        }

        $_num_parentId    = fn_getSafe(fn_post("cate_parent_id"), "int", 0);
        $_str_orderType   = fn_getSafe(fn_post("order_type"), "txt", "order_first");
        $_num_targetId    = fn_getSafe(fn_post("order_target"), "int", 0);
        $_arr_cateRow     = $this->mdl_cate->mdl_order($_str_orderType, $_num_cateId, $_num_targetId, $_num_parentId);

        $this->obj_ajax->halt_alert($_arr_cateRow["alert"]);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ajax_submit() {
        $_arr_cateSubmit = $this->mdl_cate->input_submit();

        if ($_arr_cateSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_cateSubmit["alert"]);
        }

        if ($_arr_cateSubmit["cate_id"] > 0) {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["cate"]["edit"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_cateSubmit["cate_id"]]["cate"])) {
                $this->obj_ajax->halt_alert("x110303");
            }
        } else {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["cate"]["add"])) {
                $this->obj_ajax->halt_alert("x110302");
            }
        }

        $_arr_cateRow     = $this->mdl_cate->mdl_submit(); //提交

        $_arr_cateIds[]   = $_arr_cateRow["cate_id"];

        $_arr_cateRowRead = $this->mdl_cate->mdl_readPub($_arr_cateRow["cate_id"]); //根据提交结果读取栏目信息

        if ($_arr_cateRowRead["cate_trees"]) { //根据栏目树形结构，取出所有栏目 id
            foreach ($_arr_cateRowRead["cate_trees"] as $_key=>$_value) {
                $_arr_cateIds[] = $_value["cate_id"];
            }
        }

        $_arr_cateIds = array_unique($_arr_cateIds); //去除重复

        $this->obj_ajax->halt_alert($_arr_cateRow["alert"]);
    }


    /**
     * ajax_cache function.
     *
     * @access public
     * @return void
     */
    function ajax_cache() {
        $_arr_cateIds = $this->mdl_cate->input_ids();
        if ($_arr_cateIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_cateIds["alert"]);
        }

        //print_r($_str_outPut);

        $this->obj_ajax->halt_alert("y110110");
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ajax_status() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["cate"]["edit"])) {
            $this->obj_ajax->halt_alert("x110303");
        }

        $_arr_cateIds = $this->mdl_cate->input_ids();
        if ($_arr_cateIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_cateIds["alert"]);
        }

        $_str_cateStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
        if (!$_str_cateStatus) {
            $this->obj_ajax->halt_alert("x110216");
        }

        $_arr_cateRow = $this->mdl_cate->mdl_status($_str_cateStatus);

        $this->obj_ajax->halt_alert($_arr_cateRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["cate"]["del"])) {
            $this->obj_ajax->halt_alert("x110304");
        }

        $_arr_cateIds = $this->mdl_cate->input_ids();
        if ($_arr_cateIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_cateIds["alert"]);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_del();

        $this->mdl_cate->mdl_cache_del($_arr_cateIds["cate_ids"]);

        $this->obj_ajax->halt_alert($_arr_cateRow["alert"]);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ajax_chkname() {
        $_str_cateName        = fn_getSafe(fn_get("cate_name"), "txt", "");
        $_num_cateId          = fn_getSafe(fn_get("cate_id"), "int", 0);
        $_num_cateParentId    = fn_getSafe(fn_get("cate_parent_id"), "int", 0);

        $_arr_cateRow = $this->mdl_cate->mdl_read($_str_cateName, "cate_name", $_num_cateId, $_num_cateParentId);

        if ($_arr_cateRow["alert"] == "y110102") {
            $this->obj_ajax->halt_re("x110203");
        }

        $arr_re = array(
            "re" => "ok"
        );

        exit(json_encode($arr_re));
    }


    /**
     * ajax_chkalias function.
     *
     * @access public
     * @return void
     */
    function ajax_chkalias() {
        $_str_cateAlias       = fn_getSafe(fn_get("cate_alias"), "txt", "");
        if ($_str_cateAlias) {
            $_num_cateId          = fn_getSafe(fn_get("cate_id"), "int", 0);
            $_num_cateParentId    = fn_getSafe(fn_get("cate_parent_id"), "int", 0);

            $_arr_cateRow = $this->mdl_cate->mdl_read($_str_cateAlias, "cate_alias", $_num_cateId, $_num_cateParentId);

            if ($_arr_cateRow["alert"] == "y110102") {
                $this->obj_ajax->halt_re("x110206");
            }
        }

        $arr_re = array(
            "re" => "ok"
        );

        exit(json_encode($arr_re));
    }
}
