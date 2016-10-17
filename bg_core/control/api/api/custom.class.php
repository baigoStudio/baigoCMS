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
include_once(BG_PATH_MODEL . "custom.class.php"); //载入后台用户类


/*-------------文章类-------------*/
class API_CUSTOM {

    private $obj_api;
    private $mdl_app;
    private $mdl_custom;

    function __construct() { //构造函数
        $this->obj_api    = new CLASS_API();
        $this->obj_api->chk_install();
        $this->mdl_app    = new MODEL_APP(); //设置管理组模型
        $this->mdl_custom = new MODEL_CUSTOM();
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function api_list() {
        $this->app_check("get");

        $_arr_customRows = $this->mdl_custom->mdl_cache();

        $this->obj_api->halt_re($_arr_customRows["custom_list"], true);
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
