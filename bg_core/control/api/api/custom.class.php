<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------文章类-------------*/
class CONTROL_API_API_CUSTOM {

    function __construct() { //构造函数
        $this->obj_api    = new CLASS_API();
        //$this->obj_api->chk_install();

        $this->mdl_custom = new MODEL_CUSTOM();
    }


    /**
     * ctrl_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_list() {
        $_arr_appChk = $this->obj_api->app_chk();
        if ($_arr_appChk["rcode"] != "ok") {
            $this->obj_api->show_result($_arr_appChk);
        }

        $_arr_customRows = $this->mdl_custom->mdl_cache();

        $this->obj_api->show_result($_arr_customRows["custom_list"], true);
    }
}
