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

/*-------------用户类-------------*/
class CONTROL_GROUP {

    public $obj_tpl;
    public $mdl_group;
    public $adminLogged;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $this->mdl_group      = new MODEL_GROUP();
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    /**
     * ctl_form function.
     *
     * @access public
     * @return void
     */
    function ctl_show() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["group"]["browse"])) {
            return array(
                "alert" => "x040301",
            );
        }

        $_num_groupId = fn_getSafe(fn_get("group_id"), "int", 0);

        if ($_num_groupId < 1) {
            return array(
                "alert" => "x040206",
            );
        }

        $_arr_groupRow = $this->mdl_group->mdl_read($_num_groupId);
        if ($_arr_groupRow["alert"] != "y040102") {
            return $_arr_groupRow;
        }

        $_arr_tpl = array(
            "groupRow" => $_arr_groupRow, //管理员信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("group_show.tpl", $_arr_tplData);

        return array(
            "alert" => "y040102",
        );
    }


    /**
     * ctl_form function.
     *
     * @access public
     * @return void
     */
    function ctl_form() {
        $_num_groupId = fn_getSafe(fn_get("group_id"), "int", 0);

        if ($_num_groupId > 0) {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["group"]["edit"])) {
                return array(
                    "alert" => "x040303",
                );
            }
            $_arr_groupRow = $this->mdl_group->mdl_read($_num_groupId);
            if ($_arr_groupRow["alert"] != "y040102") {
                return $_arr_groupRow;
            }
        } else {
            if (!isset($this->adminLogged["groupRow"]["group_allow"]["group"]["add"])) {
                return array(
                    "alert" => "x040302",
                );
            }
            $_arr_groupRow = array(
                "group_id"      => 0,
                "group_name"    => "",
                "group_note"    => "",
                "group_type"    => "admin",
                "group_status"  => "enable",
            );
        }


        $_arr_tpl = array(
            "groupRow" => $_arr_groupRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("group_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y040102",
        );
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["group"]["browse"])) {
            return array(
                "alert" => "x040301",
            );
        }

        $_arr_search = array(
            "key"       => fn_getSafe(fn_get("key"), "txt", ""),
            "type"      => fn_getSafe(fn_get("type"), "txt", ""),
            "status"    => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_groupCount  = $this->mdl_group->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_groupCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_groupRows   = $this->mdl_group->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "groupRows"  => $_arr_groupRows, //管理员列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("group_list.tpl", $_arr_tplData);

        return array(
            "alert" => "y040301",
        );

    }
}
