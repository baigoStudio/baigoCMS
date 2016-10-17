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
class MODEL_MARK {

    private $obj_db;

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
    }



    function mdl_create_table() {
        $_arr_markCreat = array(
            "mark_id"    => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "mark_name"  => "varchar(30) NOT NULL COMMENT '标记名称'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "mark", $_arr_markCreat, "mark_id", "标记");

        if ($_num_mysql > 0) {
            $_str_alert = "y140105"; //更新成功
        } else {
            $_str_alert = "x140105"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "mark");

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value["Field"];
        }

        return $_arr_col;
    }


    function mdl_alert_table() {
        $_arr_col     = $this->mdl_column();
        $_arr_alert   = array();

        if (in_array("mark_id", $_arr_col)) {
            $_arr_alert["mark_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "mark_id");
        }

        $_str_alert = "y140111";

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "mark", $_arr_alert);

            if ($_reselt) {
                $_str_alert = "y140106";
            }
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_markId
     * @param mixed $str_markName
     * @param mixed $str_markType
     * @param mixed $str_markStatus
     * @return void
     */
    function mdl_submit() {

        $_arr_markData = array(
            "mark_name"   => $this->markSubmit["mark_name"],
        );

        if ($this->markSubmit["mark_id"] < 1) {

            $_num_markId = $this->obj_db->insert(BG_DB_TABLE . "mark", $_arr_markData);

            if ($_num_markId > 0) { //数据库插入是否成功
                $_str_alert = "y140101";
            } else {
                return array(
                    "alert" => "x140101",
                );
            }

        } else {
            $_num_markId = $this->markSubmit["mark_id"];
            $_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "mark", $_arr_markData, "mark_id=" . $_num_markId);

            if ($_num_mysql > 0) {
                $_str_alert = "y140103";
            } else {
                return array(
                    "alert" => "x140103",
                );
            }
        }

        return array(
            "mark_id"   => $_num_markId,
            "alert"     => $_str_alert,
        );
    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_mark
     * @param string $str_readBy (default: "mark_id")
     * @param int $num_notThisId (default: 0)
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_read($str_mark, $str_readBy = "mark_id", $num_notId = 0) {
        $_arr_markSelect = array(
            "mark_id",
            "mark_name",
        );

        switch ($str_readBy) {
            case "mark_id":
                $_str_sqlWhere = $str_readBy . "=" . $str_mark;
            break;
            default:
                $_str_sqlWhere = $str_readBy . "='" . $str_mark . "'";
            break;
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= " AND mark_id<>" . $num_notId;
        }

        $_arr_markRows = $this->obj_db->select(BG_DB_TABLE . "mark",  $_arr_markSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_markRows[0])) {
            $_arr_markRow = $_arr_markRows[0];
        } else {
            return array(
                "alert" => "x140102", //不存在记录
            );
        }

        $_arr_markRow["alert"] = "y140102";

        return $_arr_markRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_status (default: "")
     * @param string $str_type (default: "")
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_markSelect = array(
            "mark_id",
            "mark_name",
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array("mark_id", "DESC"),
        );

        $_arr_markRows = $this->obj_db->select(BG_DB_TABLE . "mark",  $_arr_markSelect, $_str_sqlWhere, "", $_arr_order, $num_no, $num_except);

        return $_arr_markRows;
    }


    function mdl_count($arr_search = array()) {

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_markCount = $this->obj_db->count(BG_DB_TABLE . "mark", $_str_sqlWhere);

        return $_num_markCount;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->markIds["mark_ids"]
     * @return void
     */
    function mdl_del() {
        $_str_markIds = implode(",", $this->markIds["mark_ids"]);

        $_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "mark",  "mark_id IN (" . $_str_markIds . ")"); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y140104";
        } else {
            $_str_alert = "x140104";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    function input_submit() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $this->markSubmit["mark_id"] = fn_getSafe(fn_post("mark_id"), "int", 0);

        if ($this->markSubmit["mark_id"] > 0) {
            $_arr_markRow = $this->mdl_read($this->markSubmit["mark_id"]);
            if ($_arr_markRow["alert"] != "y140102") {
                return $_arr_markRow;
            }
        }

        $_arr_markName = validateStr(fn_post("mark_name"), 1, 30);
        switch ($_arr_markName["status"]) {
            case "too_short":
                return array(
                    "alert" => "x140201",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x140202",
                );
            break;

            case "ok":
                $this->markSubmit["mark_name"] = $_arr_markName["str"];
            break;

        }

        $_arr_markRow = $this->mdl_read($this->markSubmit["mark_name"], "mark_name", $this->markSubmit["mark_id"]);
        if ($_arr_markRow["alert"] == "y140102") {
            return array(
                "alert" => "x140203",
            );
        }

        $this->markSubmit["alert"] = "ok";
        return $this->markSubmit;
    }


    /**
     * input_ids function.
     *
     * @access public
     * @return void
     */
    function input_ids() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $_arr_markIds = fn_post("mark_ids");

        if ($_arr_markIds) {
            foreach ($_arr_markIds as $_key=>$_value) {
                $_arr_markIds[$_key] = fn_getSafe($_value, "int", 0);
            }
            $_str_alert = "ok";
        } else {
            $_str_alert = "x030202";
        }

        $this->markIds = array(
            "alert"     => $_str_alert,
            "mark_ids"  => $_arr_markIds
        );

        return $this->markIds;
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = "1=1";

        if (isset($arr_search["key"]) && !fn_isEmpty($arr_search["key"])) {
            $_str_sqlWhere .= " AND mark_name LIKE '%" . $arr_search["key"] . "%'";
        }

        return $_str_sqlWhere;
    }
}
