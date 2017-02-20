<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}


/*-------------用户类-------------*/
class CONTROL_CONSOLE_UI_LOGIN {

    function __construct() { //构造函数
        $this->obj_console  = new CLASS_CONSOLE();
        $this->obj_console->chk_install();

        $this->obj_tpl      = $this->obj_console->obj_tpl;

        $this->obj_sso      = new CLASS_SSO(); //SSO
        $this->mdl_admin    = new MODEL_ADMIN(); //设置管理员对象
    }


    function ctrl_sync() {
        $_arr_adminLogged  = $this->obj_console->ssin_begin();
        $this->obj_console->is_admin($_arr_adminLogged);

        $_str_forward     = fn_getSafe(fn_get("forward"), "txt", "");

        if (defined("BG_SSO_SYNC") && BG_SSO_SYNC == "on" && fn_cookie("prefer_sync_sync") == "on") {
            $_arr_syncSubmit = array(
                "user_id"           => $_arr_adminLogged["admin_id"],
                "user_access_token" => $_arr_adminLogged["admin_access_token"],
            );
            $_arr_sync = $this->obj_sso->sso_sync_login($_arr_syncSubmit);
        }

        //print_r($_arr_sync);

        $_arr_tplData = array(
            "sync"       => $_arr_sync,
            "forward"    => fn_forward($_str_forward, "decode"),
        );

        $this->obj_tpl->tplDisplay("login_sync", $_arr_tplData);
    }


    /**
     * ctrl_login function.
     *
     * @access public
     */
    function ctrl_login() {
        $_str_forward     = fn_getSafe(fn_get("forward"), "txt", "");

        if (defined("BG_SSO_SYNC") && BG_SSO_SYNC == "on" && fn_cookie("prefer_sync_sync") == "on") {
            $_str_forward = BG_URL_CONSOLE . "index.php?mod=login&act=sync&forward=" . $_str_forward;
        } else {
            $_str_forward = fn_forward($_str_forward, "decode");
        }

        $_arr_tplData = array(
            "forward"    => $_str_forward,
        );

        $this->obj_tpl->tplDisplay("login_form", $_arr_tplData);
    }


    /**
     * ctrl_logout function.
     *
     * @access public
     */
    function ctrl_logout() {
        $this->obj_console->ssin_end();

        header("Location: " . BG_URL_CONSOLE . "index.php");
    }
}
