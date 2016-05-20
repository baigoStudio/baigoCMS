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
include_once(BG_PATH_MODEL . "mime.class.php");

/*-------------允许类-------------*/
class CONTROL_MIME {

    public $obj_tpl;
    public $mdl_mime;
    public $adminLogged;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"];
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $this->mdl_mime       = new MODEL_MIME();
        $_arr_cfg["admin"] = true;
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
        $this->mime           = include_once(BG_PATH_LANG . $this->config["lang"] . "/mime.php");
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    function ctl_form() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["mime"])) {
            return array(
                "alert" => "x080301",
            );
        }

        $_num_mimeId  = fn_getSafe(fn_get("mime_id"), "int", 0);

        $_arr_mimeRows    = $this->mdl_mime->mdl_list(1000);

        foreach ($_arr_mimeRows as $_key=>$_value) {
            unset($this->mime[$_value["mime_name"]]);
        }

        if ($_num_mimeId > 0) {
            $_arr_mimeRow = $this->mdl_mime->mdl_read($_num_mimeId);
            if ($_arr_mimeRow["alert"] != "y080102") {
                return $_arr_mimeRow;
            }
        } else {
            $_arr_mimeRow = array(
                "mime_id"   => 0,
                "mime_name" => "",
                "mime_ext"  => "",
                "mime_note" => "",
            );
        }

        $_arr_tpl = array(
            "mimeJson"   => json_encode($this->mime),
            "mimeOften"  => $this->mime,
            "mimeRow"    => $_arr_mimeRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("mime_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y080102",
        );
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["mime"])) {
            return array(
                "alert" => "x080301",
            );
        }

        $_num_mimeCount   = $this->mdl_mime->mdl_count();
        $_arr_page        = fn_page($_num_mimeCount); //取得分页数据
        $_arr_mimeRows    = $this->mdl_mime->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"]);

        $_arr_tpl = array(
            "pageRow"    => $_arr_page,
            "mimeRows"   => $_arr_mimeRows, //上传信息信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("mime_list.tpl", $_arr_tplData);

        return array(
            "alert" => "y080301",
        );
    }

}
