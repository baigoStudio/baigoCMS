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
include_once(BG_PATH_MODEL . "tag.class.php");

/*-------------用户类-------------*/
class AJAX_TAG {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_tag;
    private $is_super = false;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax       = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_tag        = new MODEL_TAG();

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
        if (!isset($this->group_allow["article"]["tag"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x130303");
        }
        $_arr_tagSubmit = $this->mdl_tag->input_submit();
        if ($_arr_tagSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_tagSubmit["alert"]);
        }

        $_arr_tagRow = $this->mdl_tag->mdl_submit();

        $this->obj_ajax->halt_alert($_arr_tagRow["alert"]);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ajax_status() {
        if (!isset($this->group_allow["article"]["tag"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x130303");
        }

        $_arr_tagIds = $this->mdl_tag->input_ids();

        if ($_arr_tagIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_tagIds["alert"]);
        }

        $_str_tagStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");

        $_arr_tagRow = $this->mdl_tag->mdl_status($_str_tagStatus);

        $this->obj_ajax->halt_alert($_arr_tagRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->group_allow["article"]["tag"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x130304");
        }

        $_arr_tagIds = $this->mdl_tag->input_ids();
        if ($_arr_tagIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_tagIds["alert"]);
        }

        $_arr_tagRow = $this->mdl_tag->mdl_del();

        $this->obj_ajax->halt_alert($_arr_tagRow["alert"]);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ajax_chkname() {
        $_str_tagName = fn_getSafe(fn_get("tag_name"), "txt", "");
        $_num_tagId   = fn_getSafe(fn_get("tag_id"), "int", 0);

        if (!fn_isEmpty($_str_tagName)) {
            $_arr_tagRow  = $this->mdl_tag->mdl_read($_str_tagName, "tag_name", $_num_tagId);

            if ($_arr_tagRow["alert"] == "y130102") {
                $this->obj_ajax->halt_re("x130203");
            }
        }

        $arr_re = array(
            "re" => "ok"
        );

        exit(json_encode($arr_re));
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
        $_arr_tagRows = $this->mdl_tag->mdl_list(1000, 0, $_arr_search);
        $_arr_tagRow  = array();
        if ($_arr_tagRows) {
            foreach ($_arr_tagRows as $_key=>$_value) {
                $_arr_tagRow[] = $_value["tag_name"];
            }
        }
        exit(json_encode($_arr_tagRow));
    }
}
