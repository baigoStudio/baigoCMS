<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------文章类-------------*/
class MODEL_ARTICLE_PUB {

    private $obj_db;
    private $is_magic;
    public $custom_columns = array();

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS["obj_db"]; //设置数据库对象
        $this->is_magic   = get_magic_quotes_gpc();
    }


    function mdl_create_cate_view() {
        $_arr_articleCreat = array(
            array("article_id",         BG_DB_TABLE . "article"),
            array("article_title",      BG_DB_TABLE . "article"),
            array("article_excerpt",    BG_DB_TABLE . "article"),
            array("article_link",       BG_DB_TABLE . "article"),
            array("article_time",       BG_DB_TABLE . "article"),
            array("article_time_pub",   BG_DB_TABLE . "article"),
            array("article_time_hide",  BG_DB_TABLE . "article"),
            array("article_attach_id",  BG_DB_TABLE . "article"),
            array("article_mark_id",    BG_DB_TABLE . "article"),
            array("article_status",     BG_DB_TABLE . "article"),
            array("article_box",        BG_DB_TABLE . "article"),
            array("article_top",        BG_DB_TABLE . "article"),
            array("article_cate_id",    BG_DB_TABLE . "article"),
            array("article_is_gen",     BG_DB_TABLE . "article"),
            array("article_hits_day",   BG_DB_TABLE . "article"),
            array("article_hits_week",  BG_DB_TABLE . "article"),
            array("article_hits_month", BG_DB_TABLE . "article"),
            array("article_hits_year",  BG_DB_TABLE . "article"),
            array("article_hits_all",   BG_DB_TABLE . "article"),
            array("article_time_day",   BG_DB_TABLE . "article"),
            array("article_time_week",  BG_DB_TABLE . "article"),
            array("article_time_month", BG_DB_TABLE . "article"),
            array("article_time_year",  BG_DB_TABLE . "article"),
            array("belong_cate_id",     BG_DB_TABLE . "cate_belong"),
        );

        $_str_sqlJoin = "LEFT JOIN `" . BG_DB_TABLE . "cate_belong` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "cate_belong`.`belong_article_id`)";

        $_num_mysql = $this->obj_db->create_view(BG_DB_TABLE . "article_cate_view", $_arr_articleCreat, BG_DB_TABLE . "article", $_str_sqlJoin);

        if ($_num_mysql > 0) {
            $_str_alert = "y150108"; //更新成功
        } else {
            $_str_alert = "x150108"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_create_tag_view() {
        $_arr_articleCreat = array(
            array("article_id",         BG_DB_TABLE . "article"),
            array("article_title",      BG_DB_TABLE . "article"),
            array("article_excerpt",    BG_DB_TABLE . "article"),
            array("article_link",       BG_DB_TABLE . "article"),
            array("article_time",       BG_DB_TABLE . "article"),
            array("article_time_pub",   BG_DB_TABLE . "article"),
            array("article_time_hide",  BG_DB_TABLE . "article"),
            array("article_attach_id",  BG_DB_TABLE . "article"),
            array("article_mark_id",    BG_DB_TABLE . "article"),
            array("article_status",     BG_DB_TABLE . "article"),
            array("article_box",        BG_DB_TABLE . "article"),
            array("article_top",        BG_DB_TABLE . "article"),
            array("article_cate_id",    BG_DB_TABLE . "article"),
            array("article_is_gen",     BG_DB_TABLE . "article"),
            array("article_hits_day",   BG_DB_TABLE . "article"),
            array("article_hits_week",  BG_DB_TABLE . "article"),
            array("article_hits_month", BG_DB_TABLE . "article"),
            array("article_hits_year",  BG_DB_TABLE . "article"),
            array("article_hits_all",   BG_DB_TABLE . "article"),
            array("article_time_day",   BG_DB_TABLE . "article"),
            array("article_time_week",  BG_DB_TABLE . "article"),
            array("article_time_month", BG_DB_TABLE . "article"),
            array("article_time_year",  BG_DB_TABLE . "article"),
            array("belong_tag_id",      BG_DB_TABLE . "tag_belong"),
            array("belong_cate_id",     BG_DB_TABLE . "cate_belong"),
        );

        $_str_sqlJoin = "LEFT JOIN `" . BG_DB_TABLE . "tag_belong` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "tag_belong`.`belong_article_id`) LEFT JOIN `" . BG_DB_TABLE . "cate_belong` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "cate_belong`.`belong_article_id`)";

        $_num_mysql = $this->obj_db->create_view(BG_DB_TABLE . "article_tag_view", $_arr_articleCreat, BG_DB_TABLE . "article", $_str_sqlJoin);

        if ($_num_mysql > 0) {
            $_str_alert = "y160108"; //更新成功
        } else {
            $_str_alert = "x160108"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_create_custom_view($arr_customRows) {
        $_arr_articleCreat = array(
            array("article_id",          BG_DB_TABLE . "article"),
            array("article_title",       BG_DB_TABLE . "article"),
            array("article_excerpt",     BG_DB_TABLE . "article"),
            array("article_link",        BG_DB_TABLE . "article"),
            array("article_time",        BG_DB_TABLE . "article"),
            array("article_time_pub",    BG_DB_TABLE . "article"),
            array("article_time_hide",   BG_DB_TABLE . "article"),
            array("article_attach_id",   BG_DB_TABLE . "article"),
            array("article_mark_id",     BG_DB_TABLE . "article"),
            array("article_status",      BG_DB_TABLE . "article"),
            array("article_box",         BG_DB_TABLE . "article"),
            array("article_top",         BG_DB_TABLE . "article"),
            array("article_cate_id",     BG_DB_TABLE . "article"),
            array("article_is_gen",      BG_DB_TABLE . "article"),
            array("article_hits_day",    BG_DB_TABLE . "article"),
            array("article_hits_week",   BG_DB_TABLE . "article"),
            array("article_hits_month",  BG_DB_TABLE . "article"),
            array("article_hits_year",   BG_DB_TABLE . "article"),
            array("article_hits_all",    BG_DB_TABLE . "article"),
            array("article_time_day",    BG_DB_TABLE . "article"),
            array("article_time_week",   BG_DB_TABLE . "article"),
            array("article_time_month",  BG_DB_TABLE . "article"),
            array("article_time_year",   BG_DB_TABLE . "article"),
            array("belong_cate_id",      BG_DB_TABLE . "cate_belong"),
        );

        foreach ($arr_customRows as $_key=>$_value) {
            $_arr_articleCreat[] = array("custom_" . $_value["custom_id"], BG_DB_TABLE . "article_custom");
        }

        $_str_sqlJoin = "LEFT JOIN `" . BG_DB_TABLE . "article_custom` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "article_custom`.`article_id`) LEFT JOIN `" . BG_DB_TABLE . "cate_belong` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "cate_belong`.`belong_article_id`)";

        $_num_mysql = $this->obj_db->create_view(BG_DB_TABLE . "article_custom_view", $_arr_articleCreat, BG_DB_TABLE . "article", $_str_sqlJoin);

        if ($_num_mysql > 0) {
            $_str_alert = "y210108"; //更新成功
        } else {
            $_str_alert = "x210108"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_create_spec_view() {
        $_arr_articleCreat = array(
            array("article_id",         BG_DB_TABLE . "article"),
            array("article_title",      BG_DB_TABLE . "article"),
            array("article_excerpt",    BG_DB_TABLE . "article"),
            array("article_link",       BG_DB_TABLE . "article"),
            array("article_time",       BG_DB_TABLE . "article"),
            array("article_time_pub",   BG_DB_TABLE . "article"),
            array("article_time_hide",  BG_DB_TABLE . "article"),
            array("article_attach_id",  BG_DB_TABLE . "article"),
            array("article_mark_id",    BG_DB_TABLE . "article"),
            array("article_status",     BG_DB_TABLE . "article"),
            array("article_box",        BG_DB_TABLE . "article"),
            array("article_top",        BG_DB_TABLE . "article"),
            array("article_cate_id",    BG_DB_TABLE . "article"),
            array("article_is_gen",     BG_DB_TABLE . "article"),
            array("article_hits_day",   BG_DB_TABLE . "article"),
            array("article_hits_week",  BG_DB_TABLE . "article"),
            array("article_hits_month", BG_DB_TABLE . "article"),
            array("article_hits_year",  BG_DB_TABLE . "article"),
            array("article_hits_all",   BG_DB_TABLE . "article"),
            array("article_time_day",   BG_DB_TABLE . "article"),
            array("article_time_week",  BG_DB_TABLE . "article"),
            array("article_time_month", BG_DB_TABLE . "article"),
            array("article_time_year",  BG_DB_TABLE . "article"),
            array("article_admin_id",   BG_DB_TABLE . "article"),
            array("belong_spec_id",     BG_DB_TABLE . "spec_belong"),
            array("belong_cate_id",     BG_DB_TABLE . "cate_belong"),
        );

        $_str_sqlJoin = "LEFT JOIN `" . BG_DB_TABLE . "spec_belong` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "spec_belong`.`belong_article_id`) LEFT JOIN `" . BG_DB_TABLE . "cate_belong` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "cate_belong`.`belong_article_id`)";

        $_num_mysql = $this->obj_db->create_view(BG_DB_TABLE . "article_spec_view", $_arr_articleCreat, BG_DB_TABLE . "article", $_str_sqlJoin);

        if ($_num_mysql > 0) {
            $_str_alert = "y230108"; //更新成功
        } else {
            $_str_alert = "x230108"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_read($num_articleId, $not_gen = false, $is_max = false) {
        $_arr_articleSelect = array(
            "article_id",
            "article_cate_id",
            "article_title",
            "article_excerpt",
            "article_status",
            "article_box",
            "article_link",
            "article_admin_id",
            "article_is_gen",
            "article_hits_day",
            "article_hits_week",
            "article_hits_month",
            "article_hits_year",
            "article_hits_all",
            "article_time_day",
            "article_time_week",
            "article_time_month",
            "article_time_year",
            "article_time",
            "article_time_pub",
            "article_time_hide",
            "article_top",
            "article_mark_id",
            "article_attach_id",
        );

        $_str_sqlWhere = "article_status='pub' AND article_box='normal' AND article_time_pub<=" . time() . " AND (article_time_hide<1 OR article_time_hide>" . time() . ")";

        if ($is_max) {
            if ($num_articleId > 0) {
                $_str_sqlWhere .= " AND article_id<" . $num_articleId;
            }
        } else {
            $_str_sqlWhere .= " AND article_id=" . $num_articleId;
        }

        if ($not_gen) {
            $_str_sqlWhere .= " AND article_is_gen='not'";
        }

        $_arr_order = array(
            array("article_id", "DESC"),
        );

        $_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere, "", $_arr_order, 1, 0); //读取数据

        if (isset($_arr_articleRows[0])) {
            $_arr_articleRow = $_arr_articleRows[0];
        } else {
            return array(
                "alert" => "x120102",
            );
        }

        $_arr_articleSelect = array(
            "article_content",
        );

        $_str_sqlContent = "";

        if ($is_max) {
            if ($num_articleId > 0) {
                $_str_sqlContent = "article_id<" . $num_articleId;
            }
        } else {
            $_str_sqlContent = "article_id=" . $num_articleId;
        }

        $_arr_contentRows = $this->obj_db->select(BG_DB_TABLE . "article_content", $_arr_articleSelect, $_str_sqlContent, "", $_arr_order, 1, 0); //读取数据

        if (isset($_arr_contentRows[0])) {
            $_arr_contentRow = $_arr_contentRows[0];
            if (fn_isEmpty($_arr_contentRow["article_content"])) {
                $_arr_articleRow["article_content"] = "";
            } else {
                $_arr_articleRow["article_content"] = stripslashes($_arr_contentRow["article_content"]);
            }
        } else {
            $_arr_articleRow["article_content"] = "";
        }

        $_arr_customRow = $this->mdl_read_custom($num_articleId);
        if ($_arr_customRow["alert"] == "y120102") {
            $_arr_articleRow["article_customs"]   = $_arr_customRow["article_customs"];
        }

        //$_arr_articleRow["urlRow"]          = $this->url_process($_arr_articleRow);
        $_arr_articleRow["article_excerpt"] = fn_htmlcode($_arr_articleRow["article_excerpt"], "decode");
        $_arr_articleRow["alert"]           = "y120102";

        return $_arr_articleRow;
    }


    function mdl_read_custom($num_articleId) {

        $_arr_articleSelect = $this->custom_columns;

        $_arr_customRows = $this->obj_db->select(BG_DB_TABLE . "article_custom", $_arr_articleSelect, "article_id=" . $num_articleId, "", "", 1, 0); //读取数据

        if (isset($_arr_customRows[0])) {
            $_arr_customRow = $_arr_customRows[0];
        } else {
            return array(
                "alert" => "x120102",
            );
        }

        $_arr_articleRow["article_customs"]   = $_arr_customRow;

        $_arr_articleRow["alert"]             = "y120102";

        return $_arr_articleRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param string $str_key (default: "")
     * @param string $str_year (default: "")
     * @param string $str_month (default: "")
     * @param bool $arr_cateIds (default: false)
     * @param bool $arr_markIds (default: false)
     * @param string $str_attachType (default: "")
     * @param string $str_orderType (default: "")
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array(), $str_orderType = "") {
        $_arr_articleSelect = array(
            "article_id",
            "article_title",
            "article_excerpt",
            "article_link",
            "article_time_pub",
            "article_time_hide",
            "article_attach_id",
            "article_cate_id",
            "article_is_gen",
            "article_hits_day",
            "article_hits_week",
            "article_hits_month",
            "article_hits_year",
            "article_hits_all",
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        if (isset($arr_search["tag_ids"]) && $arr_search["tag_ids"]) {
            $_view_name = "tag";
        } else if (isset($arr_search["spec_ids"]) && $arr_search["spec_ids"]) {
            $_view_name = "spec";
        } else if (isset($arr_search["custom_rows"]) && $arr_search["custom_rows"]) {
            $_view_name = "custom";
        } else {
            $_view_name = "cate";
        }


        if (fn_isEmpty($str_orderType) || $str_orderType == "article") {
            $_arr_group = array("article_top", "article_time_pub", "article_id");
            $_arr_order = array(
                array("article_top", "DESC"),
                array("article_time_pub", "DESC"),
                array("article_id", "DESC"),
            );
        } else {
            $_arr_group = array("article_" . $str_orderType, "article_time_pub", "article_id");
            $_arr_order = array(
                array("article_" . $str_orderType, "DESC"),
                array("article_time_pub", "DESC"),
                array("article_id", "DESC"),
            );
        }

        //print_r($_str_sqlWhere);

        $_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article_" . $_view_name . "_view", $_arr_articleSelect, $_str_sqlWhere, $_arr_group, $_arr_order, $num_no, $num_except);

        if ($_arr_articleRows) {
            foreach ($_arr_articleRows as $_key=>$_value) {
                //$_arr_articleRows[$_key]["urlRow"]     = $this->url_process($_value);
                $_arr_articleRows[$_key]["article_excerpt"] = fn_htmlcode($_value["article_excerpt"], "decode");

                $_arr_customRow = $this->mdl_read_custom($_value["article_id"]);
                if ($_arr_customRow["alert"] == "y120102") {
                    $_arr_articleRows[$_key]["article_customs"]   = $_arr_customRow["article_customs"];
                }
            }
        }

        return $_arr_articleRows;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: "")
     * @param string $str_year (default: "")
     * @param string $str_month (default: "")
     * @param bool $arr_cateIds (default: false)
     * @param bool $arr_markIds (default: false)
     * @param string $str_attachType (default: "")
     * @param string $str_orderType (default: "")
     * @return void
     */
    function mdl_count($arr_search = array()) {

        $_str_sqlWhere = $this->sql_process($arr_search);

        if (isset($arr_search["tag_ids"]) && $arr_search["tag_ids"]) {
            $_view_name = "tag";
        } else if (isset($arr_search["spec_ids"]) && $arr_search["spec_ids"]) {
            $_view_name = "spec";
        } else if (isset($arr_search["custom_rows"]) && $arr_search["custom_rows"]) {
            $_view_name = "custom";
        } else {
            $_view_name = "cate";
        }

        //print_r($_str_sqlWhere);

        $_num_articleCount    = $this->obj_db->count(BG_DB_TABLE . "article_" . $_view_name . "_view", $_str_sqlWhere, array("article_id")); //查询数据

        return $_num_articleCount;
    }


    function mdl_isGen($num_articleId) {
        $_arr_update = array(
            "article_is_gen" => "yes",
        );
        $_str_sqlWhere      = "article_id=" . $num_articleId;
        $_arr_articleRow    = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_update, $_str_sqlWhere);

        return $_arr_articleRow;
    }


    function mdl_hits($num_articleId) {
        $_arr_articleRow = $this->mdl_read($num_articleId);

        $_arr_update = array(
            "article_hits_all" => $_arr_articleRow["article_hits_all"] + 1,
        );

        if (!isset($_arr_articleRow["article_time_day"]) || date("Y-m-d", $_arr_articleRow["article_time_day"]) != date("Y-m-d")) {
            $_arr_update["article_hits_day"] = 0;
            $_arr_update["article_time_day"] = time();
        } else {
            $_arr_update["article_hits_day"] = $_arr_articleRow["article_hits_day"] + 1;
        }

        if (!isset($_arr_articleRow["article_time_week"]) || date("Y-W", $_arr_articleRow["article_time_week"]) != date("Y-W")) {
            $_arr_update["article_hits_week"] = 0;
            $_arr_update["article_time_week"] = time();
        } else {
            $_arr_update["article_hits_week"] = $_arr_articleRow["article_hits_week"] + 1;
        }

        if (!isset($_arr_articleRow["article_time_month"]) || date("Y-m", $_arr_articleRow["article_time_month"]) != date("Y-m")) {
            $_arr_update["article_hits_month"] = 0;
            $_arr_update["article_time_month"] = time();
        } else {
            $_arr_update["article_hits_month"] = $_arr_articleRow["article_hits_month"] + 1;
        }

        if (!isset($_arr_articleRow["article_time_year"]) || date("Y", $_arr_articleRow["article_time_year"]) != date("Y")) {
            $_arr_update["article_hits_year"] = 0;
            $_arr_update["article_time_year"] = time();
        } else {
            $_arr_update["article_hits_year"] = $_arr_articleRow["article_hits_year"] + 1;
        }

        $_str_sqlWhere    = "article_id=" . $num_articleId;

        //print_r($_arr_update);

        $_arr_articleRow = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_update, $_str_sqlWhere);

        return $_arr_articleRow;
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = "article_status='pub' AND article_box='normal' AND article_time_pub<=" . time() . " AND (article_time_hide<1 OR article_time_hide>" . time() . ")";

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            $_str_sqlWhere .= " AND (article_is_gen='yes' OR LENGTH(article_link) > 0)";
        }

        if (isset($arr_search["key"]) && !fn_isEmpty($arr_search["key"])) {
            $_str_sqlWhere .= " AND article_title LIKE '%" . $arr_search["key"] . "%'";
        }

        if (isset($arr_search["year"]) && !fn_isEmpty($arr_search["year"])) {
            $_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%Y')='" . $arr_search["year"] . "'";
        }

        if (isset($arr_search["month"]) && !fn_isEmpty($arr_search["month"])) {
            $_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%m')='" . $arr_search["month"] . "'";
        }

        if (isset($arr_search["cate_ids"]) && $arr_search["cate_ids"]) {
            $_str_cateIds = implode(",", $arr_search["cate_ids"]);
            $_str_sqlWhere .= " AND belong_cate_id IN (" . $_str_cateIds . ")";
        }

        if (isset($arr_search["mark_ids"]) && $arr_search["mark_ids"]) {
            $_str_markIds = implode(",", $arr_search["mark_ids"]);
            $_str_sqlWhere .= " AND article_mark_id IN (" . $_str_markIds . ")";
        }

        if (isset($arr_search["tag_ids"]) && $arr_search["tag_ids"]) {
            $_str_tagIds    = implode(",", $arr_search["tag_ids"]);
            $_str_sqlWhere .= " AND belong_tag_id IN (" . $_str_tagIds . ")";
        } else if (isset($arr_search["spec_ids"]) && $arr_search["spec_ids"]) {
            $_str_specIds    = implode(",", $arr_search["spec_ids"]);
            $_str_sqlWhere  .= " AND belong_spec_id IN (" . $_str_specIds . ")";
        } else if (isset($arr_search["custom_rows"]) && $arr_search["custom_rows"]) {
            foreach ($arr_search["custom_rows"] as $_key=>$_value) {
                if ($_value) {
                    $_str_sqlWhere  .= " AND " . $_key . " LIKE '%" . $_value . "%'";
                }
            }
        }

        if (isset($arr_search["attach_type"])) {
            switch ($arr_search["attach_type"]) {
                case "attach":
                    $_str_sqlWhere .= " AND article_attach_id>0";
                break;

                case "none":
                    $_str_sqlWhere .= " AND article_attach_id=0";
                break;
            }
        }

        return $_str_sqlWhere;
    }
}
