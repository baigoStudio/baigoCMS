<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入管理帐号模型

/*-------------管理员控制器-------------*/
class CONTROL_APP {

    private $adminLogged;
    private $obj_base;
    private $config; //配置
    private $obj_tpl;
    private $mdl_app;
    private $mdl_appBelong;
    private $mdl_user;
    private $tplData;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->mdl_app        = new MODEL_APP(); //设置管理员模型
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }

    /*============编辑管理员界面============
    返回提示
    */
    function ctl_show() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"])) {
            return array(
                "alert" => "x190301",
            );
        }

        $_num_appId = fn_getSafe(fn_get("app_id"), "int", 0);

        if ($_num_appId < 1) {
            return array(
                "alert" => "x190203",
            );
        }

        $_arr_appRow = $this->mdl_app->mdl_read($_num_appId);
        if ($_arr_appRow["alert"] != "y190102") {
            return $_arr_appRow;
        }

        $this->tplData["appRow"] = $_arr_appRow;

        $this->obj_tpl->tplDisplay("app_show.tpl", $this->tplData);

        return array(
            "alert" => "y190102",
        );
    }


    /*============编辑管理员界面============
    返回提示
    */
    function ctl_form() {
        $_num_appId = fn_getSafe(fn_get("app_id"), "int", 0);

        if ($_num_appId > 0) {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"])) {
                return array(
                    "alert" => "x190303",
                );
            }
            $_arr_appRow = $this->mdl_app->mdl_read($_num_appId);
            if ($_arr_appRow["alert"] != "y190102") {
                return $_arr_appRow;
            }
        } else {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"])) {
                return array(
                    "alert" => "x190302",
                );
            }
            $_arr_appRow = array(
                "app_id"        => 0,
                "app_name"      => "",
                "app_notice"    => "",
                "app_ip_allow"  => "",
                "app_ip_bad"    => "",
                "app_note"      => "",
                "app_status"    => "enable",
            );
        }

        $this->tplData["appRow"] = $_arr_appRow; //管理员信息

        $this->obj_tpl->tplDisplay("app_form.tpl", $this->tplData);

        return array(
            "alert" => "y190102",
        );
    }


    /*============列出管理员界面============
    无返回
    */
    function ctl_list() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["app"])) {
            return array(
                "alert" => "x190301",
            );
        }

        $_arr_search = array(
            "key"    => fn_getSafe(fn_get("key"), "txt", ""),
            "status" => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_appCount    = $this->mdl_app->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_appCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_appRows     = $this->mdl_app->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "appRows"    => $_arr_appRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("app_list.tpl", $_arr_tplData);
        return array(
            "alert" => "y190302",
        );
    }
}
