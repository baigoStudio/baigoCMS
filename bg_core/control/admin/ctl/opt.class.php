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
include_once(BG_PATH_CLASS . "tpl.class.php");
include_once(BG_PATH_MODEL . "opt.class.php");

/*-------------管理员控制器-------------*/
class CONTROL_OPT {

    private $adminLogged;
    private $obj_base;
    private $config; //配置
    private $obj_tpl;
    private $tplData;
    private $is_super = false;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"];
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->mdl_opt        = new MODEL_OPT();
        $this->obj_dir        = new CLASS_DIR(); //初始化目录对象
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . BG_DEFAULT_UI, $_arr_cfg); //初始化视图对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
    }


    function ctl_chkver() {
        if (!isset($this->group_allow["opt"]["chkver"]) && !$this->is_super) {
            return array(
                "alert" => "x060301",
            );
        }

        $this->tplData["act_get"]       = $GLOBALS["act_get"];
        $this->tplData["latest_ver"]    = $this->mdl_opt->chk_ver();
        $this->tplData["install_pub"]   = strtotime(BG_INSTALL_PUB);

        $this->obj_tpl->tplDisplay("opt_chkver.tpl", $this->tplData);

        return array(
            "alert" => "y060301",
        );
    }


    function ctl_dbconfig() {
        if (!isset($this->group_allow["opt"]["dbconfig"]) && !$this->is_super) {
            return array(
                "alert" => "x060301",
            );
        }

        $this->tplData["act_get"] = $GLOBALS["act_get"];

        $this->obj_tpl->tplDisplay("opt_dbconfig.tpl", $this->tplData);

        return array(
            "alert" => "y060301",
        );
    }


    function ctl_form() {
        $_act_get = fn_getSafe(fn_get("act_get"), "txt", "base");

        if (!isset($this->group_allow["opt"][$_act_get]) && !$this->is_super) {
            return array(
                "alert" => "x060301",
            );
        }

        if ($_act_get == "base") {
            $this->tplData["tplRows"]     = $this->obj_dir->list_dir(BG_PATH_TPL . "pub/");;
            $this->tplData["excerptType"] = $this->obj_tpl->type["excerpt"];;

            $_arr_timezoneRows  = include_once(BG_PATH_LANG . $this->config["lang"] . "/timezone.php");

            $_arr_timezone[] = "";

            if (stristr(BG_SITE_TIMEZONE, "/")) {
                $_arr_timezone = explode("/", BG_SITE_TIMEZONE);
            }

            $this->tplData["timezoneRows"]  = $_arr_timezoneRows;
            $this->tplData["timezoneJson"]  = json_encode($_arr_timezoneRows);
            $this->tplData["timezoneType"]  = $_arr_timezone[0];
        }

        $this->tplData["act_get"] = $_act_get;

        $this->obj_tpl->tplDisplay("opt_form.tpl", $this->tplData);

        return array(
            "alert" => "y060301",
        );
    }
}
