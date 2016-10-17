<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "api.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "cate.class.php"); //载入后台用户类

/*-------------文章类-------------*/
class API_CATE {

    private $obj_api;
    private $mdl_app;
    private $mdl_cate;

    function __construct() { //构造函数
        $this->obj_api  = new CLASS_API();
        $this->obj_api->chk_install();
        $this->mdl_app  = new MODEL_APP(); //设置管理组模型
        $this->mdl_cate = new MODEL_CATE(); //设置文章对象
    }


    /**
     * api_show function.
     *
     * @access public
     * @return void
     */
    function api_read() {
        $this->app_check("get");

        $_num_cateId  = fn_getSafe(fn_get("cate_id"), "int", 0);

        if ($_num_cateId < 1) {
            $_arr_return = array(
                "alert" => "x110217",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_num_cateId);

        if ($_arr_cateRow["alert"] != "y110102") {
            $this->obj_api->halt_re($_arr_cateRow);
        }

        if ($_arr_cateRow["cate_status"] != "show") {
            $_arr_return = array(
                "alert" => "x110102",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        unset($_arr_cateRow["urlRow"]);

        if (isset($_arr_cateRow["cate_type"]) && $_arr_cateRow["cate_type"] == "link" && isset($_arr_cateRow["cate_link"]) && !fn_isEmpty($_arr_cateRow["cate_link"])) {
            $_arr_return = array(
                "alert"     => "x110218",
                "cate_link" => $_arr_cateRow["cate_link"],
            );
            $this->obj_api->halt_re($_arr_cateRow);
        }

        $this->obj_api->halt_re($_arr_cateRow, true);
    }


    function api_list() {
        $this->app_check("get");

        $_arr_search = array(
            "status"    => "show",
            "type"      => fn_getSafe(fn_get("type"), "txt", ""),
            "parent_id" => fn_getSafe(fn_get("parent_id"), "int", 0),
        );
        $_arr_cateRows    = $this->mdl_cate->mdl_listPub(1000, 0, $_arr_search);

        $this->obj_api->halt_re($_arr_cateRows, true);
    }


    /**
     * app_check function.
     *
     * @access private
     * @param mixed $num_appId
     * @param string $str_method (default: "get")
     * @return void
     */
    private function app_check($str_method = "get") {
        $this->appGet = $this->obj_api->app_get($str_method);

        if ($this->appGet["alert"] != "ok") {
            $this->obj_api->halt_re($this->appGet);
        }

        $_arr_appRow = $this->mdl_app->mdl_read($this->appGet["app_id"]);
        if ($_arr_appRow["alert"] != "y190102") {
            $this->obj_api->halt_re($_arr_appRow);
        }
        $this->appAllow = $_arr_appRow["app_allow"];

        $_arr_appChk = $this->obj_api->app_chk($this->appGet, $_arr_appRow);
        if ($_arr_appChk["alert"] != "ok") {
            $this->obj_api->halt_re($_arr_appChk);
        }
    }
}
