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
class MODEL_TAG {

    private $obj_db;
    public $tagStatus = array();

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
    }


    function mdl_create_table() {
        foreach ($this->tagStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        $_arr_tagCreat = array(
            "tag_id"             => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "tag_name"           => "varchar(30) NOT NULL COMMENT '标题'",
            "tag_status"         => "enum('" . $_str_status . "') NOT NULL COMMENT '状态'",
            "tag_article_count"  => "int NOT NULL COMMENT '文章数'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "tag", $_arr_tagCreat, "tag_id", "标签");

        if ($_num_mysql > 0) {
            $_str_alert = "y130105"; //更新成功
        } else {
            $_str_alert = "x130105"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_create_index() {
        $_arr_indexRow    = $this->obj_db->show_index(BG_DB_TABLE . "tag");
        $is_exists        = false;

        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array("search", $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_tagIndex = array(
            "tag_article_count",
            "tag_id",
        );

        $_num_mysql = $this->obj_db->create_index("search", BG_DB_TABLE . "tag", $_arr_tagIndex, "BTREE", $is_exists);

        if ($_num_mysql > 0) {
            $_str_alert = "y130109"; //更新成功
        } else {
            $_str_alert = "x130109"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "tag");

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value["Field"];
        }

        return $_arr_col;
    }


    function mdl_alert_table() {
        foreach ($this->tagStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        $_arr_col     = $this->mdl_column();
        $_arr_alert   = array();

        if (in_array("tag_status", $_arr_col)) {
            $_arr_alert["tag_status"] = array("CHANGE", "enum('" . $_str_status . "') NOT NULL COMMENT '状态'", "tag_status");
        }

        if (in_array("tag_article_count", $_arr_col)) {
            $_arr_alert["tag_article_count"] = array("CHANGE", "int NOT NULL COMMENT '文章数'", "tag_article_count");
        }

        $_str_alert = "y130111";

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "tag", $_arr_alert);

            if ($_reselt) {
                $_str_alert = "y130106";
                $_arr_tagData = array(
                    "tag_status" => $_arr_status[0],
                );
                $this->obj_db->update(BG_DB_TABLE . "tag", $_arr_tagData, "LENGTH(tag_status) < 1"); //更新数据
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
     * @param mixed $num_tagId
     * @param mixed $str_tagName
     * @param mixed $str_tagType
     * @param mixed $str_tagStatus
     * @return void
     */
    function mdl_submit($str_tagName = "", $str_tagStatus = "") {
        $_arr_tagData = array();

        if (fn_isEmpty($str_tagName)) {
            $_arr_tagData["tag_name"] = $this->tagSubmit["tag_name"];
        } else {
            $_arr_tagData["tag_name"] = $str_tagName;
        }

        if (fn_isEmpty($str_tagStatus)) {
            $_arr_tagData["tag_status"] = $this->tagSubmit["tag_status"];
        } else {
            $_arr_tagData["tag_status"] = $str_tagStatus;
        }

        if (!isset($this->tagSubmit["tag_id"]) || $this->tagSubmit["tag_id"] < 1) {
            $_num_tagId = $this->obj_db->insert(BG_DB_TABLE . "tag", $_arr_tagData);

            if ($_num_tagId > 0) { //数据库插入是否成功
                $_str_alert = "y130101";
            } else {
                return array(
                    "alert" => "x130101",
                );
            }
        } else {
            $_num_tagId = $this->tagSubmit["tag_id"];
            $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag", $_arr_tagData, "tag_id=" . $_num_tagId);

            if ($_num_mysql > 0) {
                $_str_alert = "y130103";
            } else {
                return array(
                    "alert" => "x130103",
                );
            }
        }

        return array(
            "tag_id"     => $_num_tagId,
            "alert"  => $_str_alert,
        );
    }


    /**
     * mdl_countDo function.
     *
     * @access public
     * @param mixed $num_tagId
     * @param int $num_articleCount (default: 0)
     * @return void
     */
    function mdl_countDo($num_tagId, $num_articleCount = 0) {
        $_arr_tagData = array(
            "tag_article_count" => $num_articleCount,
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag", $_arr_tagData, "tag_id=" . $num_tagId);

        if ($_num_mysql > 0) {
            $_str_alert = "y130103";
        } else {
            return array(
                "alert" => "x130103",
            );
        }

        return array(
            "alert"  => $_str_alert,
        );
    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_tag
     * @param string $str_readBy (default: "tag_id")
     * @param int $num_notThisId (default: 0)
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_read($str_tag, $str_readBy = "tag_id", $num_notId = 0) {
        $_arr_tagSelect = array(
            "tag_id",
            "tag_name",
            "tag_status",
            "tag_article_count",
        );

        switch ($str_readBy) {
            case "tag_id":
                $_str_sqlWhere = $str_readBy . "=" . $str_tag;
            break;
            default:
                $_str_sqlWhere = $str_readBy . "='" . $str_tag . "'";
            break;
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= " AND tag_id<>" . $num_notId;
        }

        $_arr_tagRows = $this->obj_db->select(BG_DB_TABLE . "tag",  $_arr_tagSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_tagRows[0])) {
            $_arr_tagRow  = $_arr_tagRows[0];
        } else {
            return array(
                "alert" => "x130102", //不存在记录
            );
        }

        $_arr_tagRow["urlRow"]  = $this->url_process($_arr_tagRow);
        $_arr_tagRow["alert"]   = "y130102";

        return $_arr_tagRow;
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
        $_arr_tagSelect = array(
            "tag_id",
            "tag_name",
            "tag_article_count",
            "tag_status",
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_sqlGroup = array("tag_id");

        $_arr_sqlOrder = array(
            array("tag_id", "DESC"),
        );

        if (isset($arr_search["article_id"]) && $arr_search["article_id"] > 0) {
            $_view_name = "tag_view";
        } else {
            $_view_name = "tag";
        }

        if (isset($arr_search["type"]) && $arr_search["type"] == "tag_rank") {
            $_arr_sqlGroup = array("tag_article_count", "tag_id");
            $_arr_sqlOrder = array(
                array("tag_article_count", "DESC"),
                array("tag_id", "DESC"),
            );
        }

        $_arr_tagRows = $this->obj_db->select(BG_DB_TABLE . $_view_name,  $_arr_tagSelect, $_str_sqlWhere, $_arr_sqlGroup, $_arr_sqlOrder, $num_no, $num_except);

        foreach ($_arr_tagRows as $_key=>$_value) {
            $_arr_tagRows[$_key]["urlRow"] = $this->url_process($_value);
        }

        return $_arr_tagRows;
    }


    function mdl_count($arr_search = array()) {

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_tagCount = $this->obj_db->count(BG_DB_TABLE . "tag", $_str_sqlWhere); //查询数据

        /*print_r($_arr_userRow);
        exit;*/

        return $_num_tagCount;
    }


    /**
     * mdl_status function.
     *
     * @access public
     * @param mixed $this->tagIds["tag_ids"]
     * @param mixed $str_status
     * @return void
     */
    function mdl_status($str_status) {
        $_str_tagId = implode(",", $this->tagIds["tag_ids"]);

        $_arr_tagData = array(
            "tag_status" => $str_status,
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag",  $_arr_tagData, "tag_id IN (" . $_str_tagId . ")"); //更新数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y130103";
        } else {
            $_str_alert = "x130103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->tagIds["tag_ids"]
     * @return void
     */
    function mdl_del() {
        $_str_tagId = implode(",", $this->tagIds["tag_ids"]);

        $_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "tag",  "tag_id IN (" . $_str_tagId . ")"); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y130104";
            $this->obj_db->delete(BG_DB_TABLE . "tag_belong", "belong_tag_id IN (" . $_str_tagId . ")"); //更新数据
        } else {
            $_str_alert = "x130104";
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

        $this->tagSubmit["tag_id"] = fn_getSafe(fn_post("tag_id"), "int", 0);

        if ($this->tagSubmit["tag_id"] > 0) {
            $_arr_tagRow = $this->mdl_read($this->tagSubmit["tag_id"]);
            if ($_arr_tagRow["alert"] != "y130102") {
                return $_arr_tagRow;
            }
        }

        $_arr_tagName = validateStr(fn_post("tag_name"), 1, 30);
        switch ($_arr_tagName["status"]) {
            case "too_short":
                return array(
                    "alert" => "x130201",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x130202",
                );
            break;

            case "ok":
                $this->tagSubmit["tag_name"] = $_arr_tagName["str"];
            break;
        }

        $_arr_tagRow = $this->mdl_read($this->tagSubmit["tag_name"], "tag_name", $this->tagSubmit["tag_id"]);
        if ($_arr_tagRow["alert"] == "y130102") {
            return array(
                "alert" => "x130203",
            );
        }

        $_arr_tagStatus = validateStr(fn_post("tag_status"), 1, 0);
        switch ($_arr_tagStatus["status"]) {
            case "too_short":
                return array(
                    "alert" => "x130204",
                );
            break;

            case "ok":
                $this->tagSubmit["tag_status"] = $_arr_tagStatus["str"];
            break;
        }

        $this->tagSubmit["alert"] = "ok";

        return $this->tagSubmit;
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

        $_arr_tagIds = fn_post("tag_ids");

        if ($_arr_tagIds) {
            foreach ($_arr_tagIds as $_key=>$_value) {
                $_arr_tagIds[$_key] = fn_getSafe($_value, "int", 0);
            }
            $_str_alert = "ok";
        } else {
            $_str_alert = "x030202";
        }

        $this->tagIds = array(
            "alert"     => $_str_alert,
            "tag_ids"   => $_arr_tagIds
        );

        return $this->tagIds;
    }


    private function url_process($_arr_tagRow) {
        $_str_pageExt = "";

        switch (BG_VISIT_TYPE) {
            case "static":
            case "pstatic":
                $_str_tagUrl        = BG_URL_ROOT . "tag/tag-" . urlencode($_arr_tagRow["tag_name"]) . "/";
                $_str_pageAttach    = "page-";
            break;

            default:
                $_str_tagUrl        = BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=" . urlencode($_arr_tagRow["tag_name"]);
                $_str_pageAttach    = "&page=";
            break;
        }

        return array(
            "tag_url"       => $_str_tagUrl,
            "page_attach"   => $_str_pageAttach,
            "page_ext"      => $_str_pageExt,
        );
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = "1=1";

        if (isset($arr_search["key"]) && !fn_isEmpty($arr_search["key"])) {
            $_str_sqlWhere .= " AND tag_name LIKE '%" . $arr_search["key"] . "%'";
        }

        if (isset($arr_search["status"]) && !fn_isEmpty($arr_search["status"])) {
            $_str_sqlWhere .= " AND tag_status='" . $arr_search["status"] . "'";
        }

        if (isset($arr_search["article_id"]) && $arr_search["article_id"] > 0) {
            $_str_sqlWhere .= " AND belong_article_id=" . $arr_search["article_id"];
        }

        return $_str_sqlWhere;
    }
}
