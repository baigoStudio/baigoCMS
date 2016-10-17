<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类

/*-------------提示信息控制器-------------*/
class GEN_ALERT {

    public $obj_tpl;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . BG_DEFAULT_UI, $_arr_cfg); //初始化视图对象
    }


    /** 显示提示信息
     * gen_show function.
     *
     * @access public
     * @return void
     */
    function gen_show() {
        $_str_alert   = fn_getSafe(fn_get("alert"), "txt", "");

        $arr_data = array(
            "adminLogged"    => $this->adminLogged,
            "alert"          => $_str_alert,
            "status"         => substr($_str_alert, 0, 1),
        );

        $this->obj_tpl->tplDisplay("genAlert.tpl", $arr_data);
    }

}
