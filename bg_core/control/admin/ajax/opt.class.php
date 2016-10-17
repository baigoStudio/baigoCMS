<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入模板类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "opt.class.php");
include_once(BG_PATH_MODEL . "cate.class.php"); //载入栏目类

/*-------------管理员控制器-------------*/
class AJAX_OPT {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_opt;
    private $is_super = false;

    function __construct() { //构造函数
        $this->obj_dir      = new CLASS_DIR();
        $this->adminLogged  = $GLOBALS["adminLogged"]; //已登录商家信息
        $this->obj_ajax     = new CLASS_AJAX(); //初始化 AJAX 基对象
        $this->obj_ajax->chk_install();
        $this->mdl_opt      = new MODEL_OPT();
        $this->mdl_cate     = new MODEL_CATE();

        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
    }


    function ajax_chkver() {
        if (!isset($this->group_allow["opt"]["chkver"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x060301");
        }

        $this->mdl_opt->chk_ver(true, "manual");

        $this->obj_ajax->halt_alert("y060402");
    }


    function ajax_dbconfig() {
        if (!isset($this->group_allow["opt"]["dbconfig"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x060301");
        }

        $_arr_dbconfigSubmit = $this->mdl_opt->input_dbconfig();

        if ($_arr_dbconfigSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_dbconfigSubmit["alert"]);
        }

        $_arr_return = $this->mdl_opt->mdl_dbconfig();

        $this->obj_ajax->halt_alert($_arr_return["alert"]);
    }


    function ajax_submit() {
        $_act_post = fn_getSafe($GLOBALS["act_post"], "txt", "base");

        if (!isset($this->group_allow["opt"][$_act_post]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x060301");
        }

        $_num_countSrc = 0;

        foreach ($this->obj_ajax->opt[$_act_post]["list"] as $_key=>$_value) {
            if ($_value["min"] > 0) {
                $_num_countSrc++;
            }
        }

        $_arr_const = $this->mdl_opt->input_const($_act_post);

        $_num_countInput = count(array_filter($_arr_const));

        if ($_num_countInput < $_num_countSrc) {
            $this->obj_ajax->halt_alert("x030204");
        }

        $_arr_return = $this->mdl_opt->mdl_const($_act_post);

        if ($_arr_return["alert"] != "y060101") {
            $this->obj_ajax->halt_alert($_arr_return["alert"]);
        }

        if ($_act_post == "base") {
            $this->mdl_cate->mdl_cache(true);
        }

        if ($_act_post == "visit") {
            switch ($_arr_const["BG_VISIT_TYPE"]) {
                case "static":
                case "pstatic":
                    $_arr_return = $this->mdl_opt->mdl_htaccess();

                    if ($_arr_return["alert"] != "y060101") {
                        $this->obj_ajax->halt_alert($_arr_return["alert"]);
                    }
                break;

                default:
                    $this->obj_dir->del_file(BG_PATH_ROOT . ".htaccess");
                break;
            }
        }

        $this->obj_ajax->halt_alert("y060401");
    }
}