<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------自定义字段值类-------------*/
class MODEL_ARTICLE_CUSTOM {

    private $obj_db;

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
    }


    function mdl_create_table($arr_customRows) {
        $_str_alert = "x210105";

        $_arr_articleCreat = array(
            "article_id" => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
        );

        foreach ($arr_customRows as $_key=>$_value) {
            $_arr_articleCreat["custom_" . $_value["custom_id"]] = "varchar(90) NOT NULL COMMENT '自定义字段 " . $_value["custom_id"] . "'";;
        }

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "article_custom", $_arr_articleCreat, "article_id", "自定义字段");

        if ($_num_mysql > 1) {
            $_str_alert = "y210105";
        }

        $_arr_col     = $this->mdl_column();
        $_arr_alert   = array();
        $_arr_custom  = array();

        foreach ($arr_customRows as $_key=>$_value) {
            if (!in_array("custom_" . $_value["custom_id"], $_arr_col)) {
                $_arr_alert["custom_" . $_value["custom_id"]] = array("ADD", "varchar(90) NOT NULL COMMENT '" . $_value["custom_id"] . " " . $_value["custom_name"] . "'");
            }
            $_arr_custom[] = "custom_" . $_value["custom_id"];
        }

        foreach ($_arr_col as $_key=>$_value) {
            if (!in_array($_value, $_arr_custom) && $_value != "article_id") {
                $_arr_alert[$_value] = array("DROP");
            }
        }

        if (!in_array("article_id", $_arr_col)) {
            $_arr_alert["article_id"] = array("ADD", "int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'ID'");
        }

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "article_custom", $_arr_alert);
            if ($_reselt) {
                $_str_alert = "y210105";
            }
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "article_custom");

        $_arr_col = array();

        if ($_arr_colRows) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value["Field"];
            }
        }

        return $_arr_col;
    }
}
