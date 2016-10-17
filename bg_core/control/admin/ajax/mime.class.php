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
include_once(BG_PATH_MODEL . "mime.class.php");

/*-------------用户类-------------*/
class AJAX_MIME {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_mime;
    private $is_super = false;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax       = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_mime       = new MODEL_MIME();

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
        if (!isset($this->group_allow["attach"]["mime"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x080302");
        }

        $_arr_mimeSubmit = $this->mdl_mime->input_submit();

        if ($_arr_mimeSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_mimeSubmit["alert"]);
        }

        $_arr_mimeRow = $this->mdl_mime->mdl_submit();

        $this->obj_ajax->halt_alert($_arr_mimeRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if (!isset($this->group_allow["attach"]["mime"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x080304");
        }

        $_arr_mimeIds = $this->mdl_mime->input_ids();
        if ($_arr_mimeIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_mimeIds["alert"]);
        }

        $_arr_mimeRow = $this->mdl_mime->mdl_del();

        $this->obj_ajax->halt_alert($_arr_mimeRow["alert"]);
    }



    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ajax_chkname() {
        $_str_mimeName    = fn_getSafe(fn_get("mime_name"), "txt", "");
        $_num_mimeId      = fn_getSafe(fn_get("mime_id"), "int", 0);

        if (!fn_isEmpty($_str_mimeName)) {
            $_arr_mimeRow     = $this->mdl_mime->mdl_read($_str_mimeName, "mime_name", $_num_mimeId);

            if ($_arr_mimeRow["alert"] == "y080102") {
                $this->obj_ajax->halt_re("x080206");
            }
        }

        $arr_re = array(
            "re" => "ok"
        );

        exit(json_encode($arr_re));
    }
}
