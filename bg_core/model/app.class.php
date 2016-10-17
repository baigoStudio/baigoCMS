<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------应用模型-------------*/
class MODEL_APP {
    private $obj_db;
    public $appStatus = array();

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
    }


    /** 创建表
     * mdl_create function.
     *
     * @access public
     * @return void
     */
    function mdl_create_table() {
        foreach ($this->appStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);
        $_arr_appCreate = array(
            "app_id"        => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "app_name"      => "varchar(30) NOT NULL COMMENT '应用名'",
            "app_key"       => "char(64) NOT NULL COMMENT '校验码'",
            "app_status"    => "enum('" . $_str_status . "') NOT NULL COMMENT '状态'",
            "app_note"      => "varchar(30) NOT NULL COMMENT '备注'",
            "app_time"      => "int NOT NULL COMMENT '创建时间'",
            "app_ip_allow"  => "varchar(1000) NOT NULL COMMENT '允许调用IP地址'",
            "app_ip_bad"    => "varchar(1000) NOT NULL COMMENT '禁止IP'",
            "app_allow"     => "varchar(3000) NOT NULL COMMENT '权限'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "app", $_arr_appCreate, "app_id", "应用");

        if ($_num_mysql > 0) {
            $_str_alert = "y190105"; //更新成功
        } else {
            $_str_alert = "x190105"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    /** 列出字段
     * mdl_column function.
     *
     * @access public
     * @return void
     */
    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "app");

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value["Field"];
        }

        return $_arr_col;
    }


    /** 修改表
     * mdl_alert_table function.
     *
     * @access public
     * @return void
     */
    function mdl_alert_table() {
        foreach ($this->appStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);
        $_arr_col     = $this->mdl_column();
        $_arr_alert   = array();

        if (in_array("app_id", $_arr_col)) {
            $_arr_alert["app_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "app_id");
        }

        if (in_array("app_key", $_arr_col)) {
            $_arr_alert["app_key"] = array("CHANGE", "char(64) NOT NULL COMMENT '校验码'", "app_key");
        }

        if (in_array("app_status", $_arr_col)) {
            $_arr_alert["app_status"] = array("CHANGE", "enum('" . $_str_status . "') NOT NULL COMMENT '状态'", "app_status");
        }

        $_str_alert = "y190111";

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "app", $_arr_alert);

            if ($_reselt) {
                $_str_alert = "y190106";
                $_arr_appData = array(
                    "app_status" => $_arr_status[0],
                );
                $this->obj_db->update(BG_DB_TABLE . "app", $_arr_appData, "LENGTH(app_status) < 1"); //更新数据
            }
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    /** 重置 app key
     * mdl_reset function.
     *
     * @access public
     * @param mixed $num_appId
     * @return void
     */
    function mdl_reset($num_appId) {
        $_arr_appData = array(
            "app_key" => fn_rand(64),
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "app", $_arr_appData, "app_id=" . $num_appId); //更新数据

        if ($_num_mysql > 0) {
            $_str_alert = "y190103"; //更新成功
        } else {
            return array(
                "alert" => "x190103", //更新失败
            );
        }

        return array(
            "app_id"    => $num_appId,
            "alert"     => $_str_alert, //成功
        );
    }


    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @return void
     */
    function mdl_submit() {
        $_arr_appData = array(
            "app_name"      => $this->appSubmit["app_name"],
            "app_note"      => $this->appSubmit["app_note"],
            "app_status"    => $this->appSubmit["app_status"],
            "app_ip_allow"  => $this->appSubmit["app_ip_allow"],
            "app_ip_bad"    => $this->appSubmit["app_ip_bad"],
            "app_allow"     => $this->appSubmit["app_allow"],
        );

        if ($this->appSubmit["app_id"] < 1) {
            $_arr_insert = array(
                "app_key"   => fn_rand(64),
                "app_time"  => time(),
            );
            $_arr_data = array_merge($_arr_appData, $_arr_insert);

            $_num_appId = $this->obj_db->insert(BG_DB_TABLE . "app", $_arr_data); //更新数据
            if ($_num_appId > 0) {
                $_str_alert = "y190101"; //更新成功
            } else {
                return array(
                    "alert" => "x190101", //更新失败
                );

            }
        } else {
            $_num_appId = $this->appSubmit["app_id"];
            $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "app", $_arr_appData, "app_id=" . $_num_appId); //更新数据
            if ($_num_mysql > 0) {
                $_str_alert = "y190103"; //更新成功
            } else {
                return array(
                    "alert" => "x190103", //更新失败
                );

            }
        }

        return array(
            "app_id"    => $_num_appId,
            "alert"     => $_str_alert, //成功
        );
    }


    /** 更改状态
     * mdl_status function.
     *
     * @access public
     * @param mixed $str_status
     * @return void
     */
    function mdl_status($str_status) {
        $_str_appId = implode(",", $this->appIds["app_ids"]);

        $_arr_appUpdate = array(
            "app_status" => $str_status,
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "app", $_arr_appUpdate, "app_id IN (" . $_str_appId . ")"); //删除数据

        //如影响行数大于0则返回成功
        if ($_num_mysql > 0) {
            $_str_alert = "y190103"; //成功
        } else {
            $_str_alert = "x190103"; //失败
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    /** 读取
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_app
     * @param string $str_readBy (default: "app_id")
     * @param int $num_notId (default: 0)
     * @return void
     */
    function mdl_read($str_app, $str_readBy = "app_id", $num_notId = 0) {
        $_arr_appSelect = array(
            "app_id",
            "app_name",
            "app_key",
            "app_note",
            "app_status",
            "app_time",
            "app_ip_allow",
            "app_ip_bad",
            "app_allow",
        );

        switch ($str_readBy) {
            case "app_id":
                $_str_sqlWhere = $str_readBy . "=" . $str_app;
            break;
            default:
                $_str_sqlWhere = $str_readBy . "='" . $str_app . "'";
            break;
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= " AND app_id<>" . $num_notId;
        }

        $_arr_appRows = $this->obj_db->select(BG_DB_TABLE . "app", $_arr_appSelect, $_str_sqlWhere, "", "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_appRows[0])) { //用户名不存在则返回错误
            $_arr_appRow = $_arr_appRows[0];
        } else {
            return array(
                "alert" => "x190102", //不存在记录
            );
        }

        if (fn_isEmpty($_arr_appRow["app_allow"])) {
            $_arr_appRow["app_allow"] = array();
        } else {
            $_arr_appRow["app_allow"] = fn_jsonDecode($_arr_appRow["app_allow"], "no");

        }
        $_arr_appRow["alert"] = "y190102";

        return $_arr_appRow;
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_appNo
     * @param int $num_appExcept (default: 0)
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_list($num_appNo, $num_appExcept = 0, $arr_search = array()) {
        $_arr_appSelect = array(
            "app_id",
            "app_key",
            "app_name",
            "app_note",
            "app_status",
            "app_time",
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array("app_id", "DESC"),
        );

        $_arr_appRows = $this->obj_db->select(BG_DB_TABLE . "app", $_arr_appSelect, $_str_sqlWhere, "", $_arr_order, $num_appNo, $num_appExcept); //查询数据

        return $_arr_appRows;
    }


    /** 计数
     * mdl_count function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_appCount = $this->obj_db->count(BG_DB_TABLE . "app", $_str_sqlWhere); //查询数据

        return $_num_appCount;
    }


    /** 删除
     * mdl_del function.
     *
     * @access public
     * @return void
     */
    function mdl_del() {
        $_str_appId = implode(",", $this->appIds["app_ids"]);

        $_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "app", "app_id IN (" . $_str_appId . ")"); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y190104"; //成功
        } else {
            $_str_alert = "x190104"; //失败
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    /** 提交输入
     * input_submit function.
     *
     * @access public
     * @return void
     */
    function input_submit() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $this->appSubmit["app_id"] = fn_getSafe(fn_post("app_id"), "int", 0);

        if ($this->appSubmit["app_id"] > 0) {
            //检查用户是否存在
            $_arr_appRow = $this->mdl_read($this->appSubmit["app_id"]);
            if ($_arr_appRow["alert"] != "y190102") {
                return $_arr_appRow;
            }
        }

        $_arr_appName = validateStr(fn_post("app_name"), 1, 30);
        switch ($_arr_appName["status"]) {
            case "too_short":
                return array(
                    "alert" => "x190201",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x190202",
                );
            break;

            case "ok":
                $this->appSubmit["app_name"] = $_arr_appName["str"];
            break;

        }

        $_arr_appNote = validateStr(fn_post("app_note"), 0, 30);
        switch ($_arr_appNote["status"]) {
            case "too_long":
                return array(
                    "alert" => "x190205",
                );
            break;

            case "ok":
                $this->appSubmit["app_note"] = $_arr_appNote["str"];
            break;

        }

        $_arr_appStatus = validateStr(fn_post("app_status"), 1, 0);
        switch ($_arr_appStatus["status"]) {
            case "too_short":
                return array(
                    "alert" => "x190206",
                );
            break;

            case "ok":
                $this->appSubmit["app_status"] = $_arr_appStatus["str"];
            break;
        }

        $_arr_appIpAllow = validateStr(fn_post("app_ip_allow"), 0, 3000);
        switch ($_arr_appIpAllow["status"]) {
            case "too_long":
                return array(
                    "alert" => "x190210",
                );
            break;

            case "ok":
                $this->appSubmit["app_ip_allow"] = $_arr_appIpAllow["str"];
            break;
        }

        $_arr_appIpBad = validateStr(fn_post("app_ip_bad"), 0, 3000);
        switch ($_arr_appIpBad["status"]) {
            case "too_long":
                return array(
                    "alert" => "x190211",
                );
            break;

            case "ok":
                $this->appSubmit["app_ip_bad"] = $_arr_appIpBad["str"];
            break;
        }

        $this->appSubmit["app_allow"] = fn_jsonEncode(fn_post("app_allow"), "no");
        $this->appSubmit["alert"] = "ok";

        return $this->appSubmit;
    }


    /** 批量操作选择
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

        $_arr_appIds = fn_post("app_ids");

        if ($_arr_appIds) {
            foreach ($_arr_appIds as $_key=>$_value) {
                $_arr_appIds[$_key] = fn_getSafe($_value, "int", 0);
            }
            $_str_alert = "ok";
        } else {
            $_str_alert = "x030202";
        }

        $this->appIds = array(
            "alert"     => $_str_alert,
            "app_ids"   => $_arr_appIds
        );

        return $this->appIds;
    }


    /** 列出及统计 SQL 处理
     * sql_process function.
     *
     * @access private
     * @param array $arr_search (default: array())
     * @return void
     */
    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = "1=1";

        if (isset($arr_search["key"]) && !fn_isEmpty($arr_search["key"])) {
            $_str_sqlWhere .= " AND (app_name LIKE '%" . $arr_search["key"] . "%' OR app_note LIKE '%" . $arr_search["key"] . "%')";
        }

        if (isset($arr_search["status"]) && !fn_isEmpty($arr_search["status"])) {
            $_str_sqlWhere .= " AND app_status='" . $arr_search["status"] . "'";
        }

        return $_str_sqlWhere;
    }
}
