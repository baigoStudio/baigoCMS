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
include_once(BG_PATH_CLASS . "sso.class.php");
include_once(BG_PATH_MODEL . "cate.class.php"); //载入栏目模型

/*-------------管理员控制器-------------*/
class CONTROL_PROFILE {

    private $obj_base;
    private $config;
    private $adminLogged;
    private $obj_tpl;
    private $obj_sso;
    private $mdl_cate;
    private $tplData;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"];
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . BG_DEFAULT_UI, $_arr_cfg); //初始化视图对象
        $this->obj_sso        = new CLASS_SSO(); //初始化单点登录
        $this->mdl_cate       = new MODEL_CATE(); //设置栏目对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }

    /** 修改个人信息表单
     * ctl_my function.
     *
     * @access public
     * @return void
     */
    function ctl_info() {
        $_arr_ssoRow    = $this->obj_sso->sso_user_read($this->adminLogged["admin_id"]);
        $_arr_cateRows  = $this->mdl_cate->mdl_list(1000);

        $_arr_tpl = array(
            "ssoRow"    => $_arr_ssoRow,
            "cateRows"  => $_arr_cateRows, //栏目信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("profile_info.tpl", $_arr_tplData);

        return array(
            "alert" => "y020108",
        );
    }


    function ctl_pass() {
        $_arr_ssoRow    = $this->obj_sso->sso_user_read($this->adminLogged["admin_id"]);
        $_arr_cateRows  = $this->mdl_cate->mdl_list(1000);

        $_arr_tpl = array(
            "ssoRow"    => $_arr_ssoRow,
            "cateRows"  => $_arr_cateRows, //栏目信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("profile_pass.tpl", $_arr_tplData);

        return array(
            "alert" => "y020109",
        );
    }


    function ctl_prefer() {
        $_arr_ssoRow    = $this->obj_sso->sso_user_read($this->adminLogged["admin_id"]);
        $_arr_prefer    = include_once(BG_PATH_LANG . $this->config["lang"] . "/prefer.php");

        foreach ($_arr_prefer as $key=>$value) {
            foreach ($value["list"] as $key_s=>$value_s) {
                if (!fn_isEmpty(fn_cookie("prefer_" . $key . "_" . $key_s))) {
                    $_arr_prefer[$key]["list"][$key_s]["default"] = fn_cookie("prefer_" . $key . "_" . $key_s);
                }
            }
        }

        $_arr_tpl = array(
            "ssoRow"    => $_arr_ssoRow,
            "prefer"    => $_arr_prefer,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("profile_prefer.tpl", $_arr_tplData);

        return array(
            "alert" => "y020112",
        );
    }
}
