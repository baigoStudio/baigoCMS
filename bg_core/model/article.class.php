<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------文章类-------------*/
class MODEL_ARTICLE {

    private $obj_db;
    private $is_magic;
    public $custom_columns  = array();
    public $articleStatus   = array();

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS["obj_db"]; //设置数据库对象
        $this->is_magic   = get_magic_quotes_gpc();
    }


    /** 创建表
     * mdl_create_table function.
     *
     * @access public
     * @return void
     */
    function mdl_create_table() {
        foreach ($this->articleStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        $_str_alert = "y120105";

        $_arr_articleCreat = array(
            "article_id"         => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "article_cate_id"    => "smallint NOT NULL COMMENT '栏目ID'",
            "article_title"      => "varchar(300) NOT NULL COMMENT '标题'",
            "article_excerpt"    => "varchar(900) NOT NULL COMMENT '内容提要'",
            "article_status"     => "enum('" . $_str_status . "') NOT NULL COMMENT '状态'",
            "article_box"        => "enum('normal','draft','recycle') NOT NULL COMMENT '盒子'",
            "article_mark_id"    => "smallint NOT NULL COMMENT '标记 ID'",
            "article_spec_id"    => "int NOT NULL COMMENT '专题ID'",
            "article_attach_id"  => "int NOT NULL COMMENT '附件ID'",
            "article_link"       => "varchar(900) NOT NULL COMMENT '链接'",
            "article_time"       => "int NOT NULL COMMENT '时间'",
            "article_time_pub"   => "int NOT NULL COMMENT '定时发布'",
            "article_admin_id"   => "int NOT NULL COMMENT '发布用户'",
            "article_hits_day"   => "mediumint NOT NULL COMMENT '日点击'",
            "article_hits_week"  => "mediumint NOT NULL COMMENT '周点击'",
            "article_hits_month" => "mediumint NOT NULL COMMENT '月点击'",
            "article_hits_year"  => "mediumint NOT NULL COMMENT '年点击'",
            "article_hits_all"   => "int NOT NULL COMMENT '总点击'",
            "article_time_day"   => "int NOT NULL COMMENT '日点击重置时间'",
            "article_time_week"  => "int NOT NULL COMMENT '周点击重置时间'",
            "article_time_month" => "int NOT NULL COMMENT '月点击重置时间'",
            "article_time_year"  => "int NOT NULL COMMENT '年点击重置时间'",
            "article_top"        => "tinyint NOT NULL COMMENT '置顶'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "article", $_arr_articleCreat, "article_id", "文章");

        if ($_num_mysql < 1) {
            $_str_alert = "x120105";
        }

        $_arr_articleCreat = array(
            "article_id"         => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "article_content"    => "text NOT NULL COMMENT '内容'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "article_content", $_arr_articleCreat, "article_id", "文章");

        if ($_num_mysql < 1) {
            $_str_alert = "x120111";
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    /** 创建索引
     * mdl_create_index function.
     *
     * @access public
     * @return void
     */
    function mdl_create_index() {
        $_str_alert       = "y120109";
        $_arr_indexRow    = $this->obj_db->show_index(BG_DB_TABLE . "article");

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array("order_top", $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_articleIndex = array( //置顶
            "article_top",
            "article_time_pub",
            "article_id",
        );

        $_num_mysql = $this->obj_db->create_index("order_top", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

        if ($_num_mysql < 1) {
            $_str_alert = "x120109";
        }

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array("order_day", $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_articleIndex = array( //日排行
            "article_hits_day",
            "article_time_pub",
            "article_id",
        );

        $_num_mysql = $this->obj_db->create_index("order_day", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

        if ($_num_mysql < 1) {
            $_str_alert = "x120109";
        }

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array("order_week", $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_articleIndex = array( //周排行
            "article_hits_week",
            "article_time_pub",
            "article_id",
        );

        $_num_mysql = $this->obj_db->create_index("order_week", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

        if ($_num_mysql < 1) {
            $_str_alert = "x120109";
        }

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array("order_month", $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_articleIndex = array( //月排行
            "article_hits_month",
            "article_time_pub",
            "article_id",
        );

        $_num_mysql = $this->obj_db->create_index("order_month", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

        if ($_num_mysql < 1) {
            $_str_alert = "x120109";
        }

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array("order_year", $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_articleIndex = array( //年排行
            "article_hits_year",
            "article_time_pub",
            "article_id",
        );

        $_num_mysql = $this->obj_db->create_index("order_year", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

        if ($_num_mysql < 1) {
            $_str_alert = "x120109";
        }

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array("order_all", $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_articleIndex = array( //总排行
            "article_hits_all",
            "article_time_pub",
            "article_id",
        );

        $_num_mysql = $this->obj_db->create_index("order_all", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

        if ($_num_mysql < 1) {
            $_str_alert = "x120109";
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    /** 复制表, 主要用于将文章内容移到独立表
     * mdl_copy_table function.
     *
     * @access public
     * @return void
     */
    function mdl_copy_table() {
        $_arr_col   = $this->mdl_column();

        $_str_alert = "y120114";

        if (in_array("article_content", $_arr_col)) {
            $_arr_articleCreat = array(
                "article_id"        => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
                "article_content"   => "text NOT NULL COMMENT '内容'",
            );

            $_num_mysql = $this->obj_db->copy_table(BG_DB_TABLE . "article_content", BG_DB_TABLE . "article", $_arr_articleCreat, "article_id", "文章内容");

            if ($_num_mysql > 0) {
                $_str_alert = "y120112"; //更新成功
            } else {
                $_str_alert = "x120112"; //更新成功
            }
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
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "article");

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value["Field"];
        }

        return $_arr_col;
    }


    /** 列出内容表字段
     * mdl_column_content function.
     *
     * @access public
     * @return void
     */
    function mdl_column_content() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "article_content");

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
        foreach ($this->articleStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        $_arr_col   = $this->mdl_column();
        $_arr_alert = array();

        if (in_array("article_tag", $_arr_col)) {
            $_arr_alert["article_tag"] = array("DROP");
        }

        if (in_array("article_upfile_id", $_arr_col)) {
            $_arr_alert["article_upfile_id"] = array("CHANGE", "int NOT NULL COMMENT '附件ID'", "article_attach_id");
        }

        if (in_array("article_spec_id", $_arr_col)) {
            $_arr_alert["article_spec_id"] = array("CHANGE", "int NOT NULL COMMENT '专题ID'", "article_spec_id");
        } else {
            $_arr_alert["article_spec_id"] = array("ADD", "int NOT NULL COMMENT '专题ID'");
        }

        if (in_array("article_cate_id", $_arr_col)) {
            $_arr_alert["article_cate_id"] = array("CHANGE", "smallint NOT NULL COMMENT '隶属栏目ID'", "article_cate_id");
        }

        if (in_array("article_mark_id", $_arr_col)) {
            $_arr_alert["article_mark_id"] = array("CHANGE", "smallint NOT NULL COMMENT '标记ID'", "article_mark_id");
        }

        if (in_array("article_top", $_arr_col)) {
            $_arr_alert["article_top"] = array("CHANGE", "tinyint NOT NULL COMMENT '置顶'", "article_top");
        }

        if (in_array("article_status", $_arr_col)) {
            $_arr_alert["article_status"] = array("CHANGE", "enum('" . $_str_status . "') NOT NULL COMMENT '状态'", "article_status");
        }

        $_arr_articleData = array(
            "article_status" => $_arr_status[0],
        );
        $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleData, "LENGTH(article_status) < 1"); //更新数据

        if (in_array("article_box", $_arr_col)) {
            $_arr_alert["article_box"] = array("CHANGE", "enum('normal','draft','recycle') NOT NULL COMMENT '盒子'", "article_box");
        }

        $_arr_articleData = array(
            "article_box" => "normal",
        );
        $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleData, "LENGTH(article_box) < 1"); //更新数据

        if (in_array("article_hits_day", $_arr_col)) {
            $_arr_alert["article_hits_day"] = array("CHANGE", "mediumint NOT NULL COMMENT '日点击'", "article_hits_day");
        }

        if (in_array("article_hits_week", $_arr_col)) {
            $_arr_alert["article_hits_week"] = array("CHANGE", "mediumint NOT NULL COMMENT '周点击'", "article_hits_week");
        }

        if (in_array("article_hits_month", $_arr_col)) {
            $_arr_alert["article_hits_month"] = array("CHANGE", "mediumint NOT NULL COMMENT '月点击'", "article_hits_month");
        }

        if (in_array("article_hits_year", $_arr_col)) {
            $_arr_alert["article_hits_year"] = array("CHANGE", "mediumint NOT NULL COMMENT '年点击'", "article_hits_year");
        }

        if (!in_array("article_time_day", $_arr_col)) {
            $_arr_alert["article_time_day"] = array("ADD", "int NOT NULL COMMENT '日点击重置时间'");
        }

        if (!in_array("article_time_week", $_arr_col)) {
            $_arr_alert["article_time_week"] = array("ADD", "int NOT NULL COMMENT '周点击重置时间'");
        }

        if (!in_array("article_time_month", $_arr_col)) {
            $_arr_alert["article_time_month"] = array("ADD", "int NOT NULL COMMENT '月点击重置时间'");
        }

        if (!in_array("article_time_year", $_arr_col)) {
            $_arr_alert["article_time_year"] = array("ADD", "int NOT NULL COMMENT '年点击重置时间'");
        }

        $_str_alert = "y120116";

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "article", $_arr_alert);

            if ($_reselt) {
                $_str_alert = "y120106";
            }
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @param int $num_adminId (default: 0)
     * @param mixed $str_status
     * @return void
     */
    function mdl_submit($num_adminId = 0, $str_status) {
        $_arr_articleData = array(
            "article_title"      => $this->articleSubmit["article_title"],
            "article_excerpt"    => $this->articleSubmit["article_excerpt"],
            "article_cate_id"    => $this->articleSubmit["article_cate_id"],
            "article_mark_id"    => $this->articleSubmit["article_mark_id"],
            "article_status"     => $str_status,
            "article_box"        => $this->articleSubmit["article_box"],
            "article_link"       => $this->articleSubmit["article_link"],
            "article_time_pub"   => $this->articleSubmit["article_time_pub"],
            "article_attach_id"  => $this->articleSubmit["article_attach_id"],
            "article_spec_id"    => $this->articleSubmit["article_spec_id"],
        );

        //print_r($_arr_articleData);

        if ($this->articleSubmit["article_id"] < 1) {
            $_arr_articleData["article_admin_id"]    = $num_adminId;
            //$_arr_articleData["article_top"]         = 1;
            $_arr_articleData["article_time"]        = time();

            $_num_articleId = $this->obj_db->insert(BG_DB_TABLE . "article", $_arr_articleData); //插入数据

            if ($_num_articleId > 0) {
                $_str_alert     = "y120101";
                $_arr_contentData = array(
                    "article_id"       => $_num_articleId,
                    "article_content"  => $this->articleSubmit["article_content"],
                );
                $_num_contentArticleId = $this->obj_db->insert(BG_DB_TABLE . "article_content", $_arr_contentData); //插入数据

                if ($_num_contentArticleId < 1) {
                    $_str_alert     = "x120101";
                }

                $_arr_contentData = array(
                    "article_id"       => $_num_articleId,
                );

                foreach ($this->articleSubmit["article_customs"] as $_key=>$_value) {
                    $_arr_customData["custom_" . $_key] = $_value;
                }

                if ($_arr_customData) {
                    $_num_contentArticleId = $this->obj_db->insert(BG_DB_TABLE . "article_custom", $_arr_customData); //插入数据

                    if ($_num_contentArticleId < 1) {
                        $_str_alert     = "x120101";
                    }
                }
            } else {
                return array(
                    "article_id"    => $_num_articleId,
                    "alert"         => "x120101", //失败
                );
            }
        } else {
            $_str_alert          = "y120103";
            $_num_articleId      = $this->articleSubmit["article_id"];
            $_num_mysql          = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleData, "article_id=" . $_num_articleId); //更新数据

            if ($_num_mysql < 1) {
                $_str_alert      = "x120103";
            }

            $_arr_contentData    = array(
                "article_content"  => $this->articleSubmit["article_content"],
            );

            $_arr_contentRow = $this->mdl_read_content($_num_articleId);
            if ($_arr_contentRow["alert"] == "x120102") {
                $_arr_contentData["article_id"] = $_num_articleId;
                $_num_contentArticleId          = $this->obj_db->insert(BG_DB_TABLE . "article_content", $_arr_contentData); //插入数据

                if ($_num_contentArticleId > 0) {
                    $_str_alert      = "y120103";
                }
            } else {
                $_num_mysql     = $this->obj_db->update(BG_DB_TABLE . "article_content", $_arr_contentData, "article_id=" . $_num_articleId); //更新数据
                if ($_num_mysql > 0) {
                    $_str_alert      = "y120103";
                }
            }

            $_arr_customData = array();

            foreach ($this->articleSubmit["article_customs"] as $_key=>$_value) {
                $_arr_customData["custom_" . $_key] = $_value;
            }

            if ($_arr_customData) {
                $_arr_customRow = $this->mdl_read_custom($_num_articleId);
                if ($_arr_customRow["alert"] == "x120102") {
                    $_arr_customData["article_id"] = $_num_articleId;
                    $_num_customArticleId = $this->obj_db->insert(BG_DB_TABLE . "article_custom", $_arr_customData);

                    if ($_num_customArticleId > 0) {
                        $_str_alert      = "y120103";
                    }

                } else {
                    $_num_mysql          = $this->obj_db->update(BG_DB_TABLE . "article_custom", $_arr_customData, "article_id=" . $_num_articleId); //更新数据

                    if ($_num_mysql > 0) {
                        $_str_alert      = "y120103";
                    }
                }
            }

        }

        /*print_r($_arr_userRow);
        exit;*/

        return array(
            "article_id" => $_num_articleId,
            "alert"      => $_str_alert,
        );
    }


    /** 设置主图
     * mdl_primary function.
     *
     * @access public
     * @return void
     */
    function mdl_primary() {
        $_arr_articleData = array(
            "article_attach_id"  => $this->articlePrimary["article_attach_id"],
        );

        //print_r($_arr_articleData);

        $_num_articleId = $this->articlePrimary["article_id"];
        $_num_mysql     = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleData, "article_id=" . $_num_articleId); //更新数据

        if ($_num_mysql > 0) {
            $_str_alert  = "y120103";
        } else {
            $_str_alert  = "x120103";
        }

        /*print_r($_arr_userRow);
        exit;*/

        return array(
            "article_id" => $_num_articleId,
            "alert"  => $_str_alert,
        );
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_articleSelect = array(
            "article_id",
            "article_cate_id",
            "article_title",
            "article_excerpt",
            "article_status",
            "article_box",
            "article_link",
            "article_admin_id",
            "article_mark_id",
            "article_spec_id",
            "article_hits_day",
            "article_hits_week",
            "article_hits_month",
            "article_hits_year",
            "article_hits_all",
            "article_time",
            "article_time_pub",
            "article_top",
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        //print_r($_str_sqlWhere);

        $_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere, "", "article_top DESC, article_time_pub DESC", $num_no, $num_except);

        return $_arr_articleRows;
    }


    /** 统计
     * mdl_count function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_articleCount = $this->obj_db->count(BG_DB_TABLE . "article", $_str_sqlWhere); //查询数据

        return $_num_articleCount;
    }


    /** 读取
     * mdl_read function.
     *
     * @access public
     * @param mixed $num_articleId
     * @return void
     */
    function mdl_read($num_articleId) {
        $_arr_articleSelect = array(
            "article_id",
            "article_cate_id",
            "article_mark_id",
            "article_title",
            "article_excerpt",
            "article_status",
            "article_box",
            "article_link",
            "article_admin_id",
            "article_attach_id",
            "article_hits_day",
            "article_time_day",
            "article_hits_week",
            "article_time_week",
            "article_hits_month",
            "article_time_month",
            "article_hits_year",
            "article_time_year",
            "article_hits_all",
            "article_time",
            "article_time_pub",
            "article_top",
            "article_spec_id",
        );

        $_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article", $_arr_articleSelect, "article_id=" . $num_articleId, "", "", 1, 0); //读取数据

        if (isset($_arr_articleRows[0])) {
            $_arr_articleRow = $_arr_articleRows[0];
        } else {
            return array(
                "alert" => "x120102",
            );
        }

        $_arr_contentRow = $this->mdl_read_content($num_articleId);
        if ($_arr_contentRow["alert"] == "y120102") {
            $_arr_articleRow["article_content"]   = $_arr_contentRow["article_content"];
        }

        $_arr_customRow = $this->mdl_read_custom($num_articleId);
        //print_r($_arr_customRow);
        if ($_arr_customRow["alert"] == "y120102") {
            $_arr_articleRow["article_customs"]   = $_arr_customRow["article_customs"];
        }

        $_arr_articleRow["alert"]         = "y120102";

        return $_arr_articleRow;
    }


    /** 读出内容
     * mdl_read_content function.
     *
     * @access public
     * @param mixed $num_articleId
     * @return void
     */
    function mdl_read_content($num_articleId) {
        $_arr_articleSelect = array(
            "article_content",
        );

        $_arr_contentRows = $this->obj_db->select(BG_DB_TABLE . "article_content", $_arr_articleSelect, "article_id=" . $num_articleId, "", "", 1, 0); //读取数据

        $_arr_contentRow = array();

        if (isset($_arr_contentRows[0])) {
            $_arr_contentRow = $_arr_contentRows[0];
            $_str_alert = "y120102";
        } else {
            $_arr_contentRow = array(
                "article_content" => "",
            );
            $_str_alert = "x120102";
        }

        $_arr_articleRow["article_content"]   = stripslashes($_arr_contentRow["article_content"]);

        $_arr_articleRow["alert"]             = $_str_alert;

        return $_arr_articleRow;
    }


    /** 读出自定义字段
     * mdl_read_custom function.
     *
     * @access public
     * @param mixed $num_articleId
     * @return void
     */
    function mdl_read_custom($num_articleId) {

        $_arr_articleSelect = $this->custom_columns;

        $_arr_customRows = $this->obj_db->select(BG_DB_TABLE . "article_custom", $_arr_articleSelect, "article_id=" . $num_articleId, "", "", 1, 0); //读取数据

        $_arr_customRow = array();

        if (isset($_arr_customRows[0])) {
            $_arr_customRow = $_arr_customRows[0];
            $_str_alert = "y120102";
        } else {
            $_arr_customRow = array();
            $_str_alert = "x120102";
        }

        $_arr_articleRow["article_customs"]   = $_arr_customRow;

        $_arr_articleRow["alert"]             = $_str_alert;

        return $_arr_articleRow;
    }


    /** 置顶
     * mdl_top function.
     *
     * @access public
     * @param mixed $this->articleIds["article_ids"]
     * @param mixed $num_top
     * @param bool $arr_cateIds (default: false)
     * @return void
     */
    function mdl_top($num_top, $arr_cateIds = false) {

        $_arr_articleUpdate = array(
            "article_top" => $num_top,
        );

        $_str_articleId   = implode(",", $this->articleIds["article_ids"]);
        $_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

        if ($arr_cateIds) {
            $_str_cateIds    = implode(",", $arr_cateIds);
            $_str_sqlWhere   .= " AND article_cate_id IN (" . $_str_cateIds . ")";
        }

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y120103";
        } else {
            $_str_alert = "x120103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /** 编辑状态
     * mdl_status function.
     *
     * @access public
     * @param mixed $str_status
     * @param bool $arr_cateIds (default: false)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_status($str_status, $arr_cateIds = false, $num_adminId = 0) {
        $_arr_articleUpdate = array(
            "article_status" => $str_status,
        );

        $_str_articleId   = implode(",", $this->articleIds["article_ids"]);
        $_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

        if ($arr_cateIds) {
            $_str_cateIds    = implode(",", $arr_cateIds);
            $_str_sqlWhere  .= " AND article_cate_id IN (" . $_str_cateIds . ")";
        }

        if ($num_adminId > 0) {
            $_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
        }

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y120103";
        } else {
            $_str_alert = "x120103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /** 加入到专题
     * mdl_toSpec function.
     *
     * @access public
     * @param mixed $str_act
     * @param int $num_specId (default: 0)
     * @return void
     */
    function mdl_toSpec($str_act, $num_specId = 0) {
        if ($str_act != "to") {
            $num_specId = 0;
        }

        $_arr_articleUpdate = array(
            "article_spec_id" => $num_specId,
        );

        $_str_articleId   = implode(",", $this->articleIds["article_ids"]);
        $_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y120103";
        } else {
            $_str_alert = "x120103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /** 编辑所处盒子
     * mdl_box function.
     *
     * @access public
     * @param mixed $str_box
     * @param bool $arr_cateIds (default: false)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_box($str_box, $arr_cateIds = false, $num_adminId = 0) {

        $_arr_articleUpdate = array(
            "article_box"        => $str_box,
        );

        $_str_articleId   = implode(",", $this->articleIds["article_ids"]);
        $_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

        if ($arr_cateIds) {
            $_str_cateIds    = implode(",", $arr_cateIds);
            $_str_sqlWhere  .= " AND article_cate_id IN (" . $_str_cateIds . ")";
        }

        if ($num_adminId > 0) {
            $_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
        }

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y120103";
        } else {
            $_str_alert = "x120103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /** 删除
     * mdl_del function.
     *
     * @access public
     * @param bool $arr_cateIds (default: false)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_del($arr_cateIds = false, $num_adminId = 0) {

        $_str_articleId   = implode(",", $this->articleIds["article_ids"]);
        $_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

        if ($arr_cateIds) {
            $_str_cateIds    = implode(",", $arr_cateIds);
            $_str_sqlWhere   .= " AND article_cate_id IN (" . $_str_cateIds . ")";
        }

        if ($num_adminId > 0) {
            $_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
        }

        $_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "article", $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y120104";
        } else {
            $_str_alert = "x120104";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /** 清空回收站
     * mdl_empty function.
     *
     * @access public
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_empty($num_adminId = 0) {
        $_str_sqlWhere = "article_box='recycle'";

        if ($num_adminId > 0) {
            $_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
        }

        $_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "article", $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y120104";
        } else {
            $_str_alert = "x120104";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /** 处理不属于任何栏目的文章
     * mdl_unknownCate function.
     *
     * @access public
     * @return void
     */
    function mdl_unknownCate($arr_articleId) {

        $_arr_articleData = array(
            "article_cate_id" => -1,
        );

        $_str_articleId   = implode(",", $arr_articleId);
        $_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article",  $_arr_articleData, $_str_sqlWhere); //更新数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y120103";
        } else {
            $_str_alert = "x120103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /** 列出不重复的年份
     * mdl_year function.
     *
     * @access public
     * @return void
     */
    function mdl_year() {
        $_arr_articleSelect = array(
            "DISTINCT FROM_UNIXTIME(article_time_pub, '%Y') AS article_year",
        );

        $_str_sqlWhere = "article_time > 0";

        $_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere, "", "article_time ASC", 100, 0, false, true);

        return $_arr_articleRows;
    }


    /** 丢弃旧版本的文章内容字段
     * mdl_drop function.
     *
     * @access public
     * @return void
     */
    function mdl_drop() {
        $_arr_col   = $this->mdl_column();
        $_arr_alert = array();

        $_str_alert = "y120115";

        if (in_array("article_content", $_arr_col)) {
            $_arr_alert["article_content"] = array("DROP");
        }

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "article", $_arr_alert);

            if ($_reselt) {
                $_str_alert = "y120113";
            }
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
    function input_submit($is_draft = false) {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $this->articleSubmit["article_id"] = fn_getSafe(fn_post("article_id"), "int", 0);

        if ($this->articleSubmit["article_id"] > 0) {
            $_arr_articleRow = $this->mdl_read($this->articleSubmit["article_id"]);
            if ($_arr_articleRow["alert"] != "y120102") {
                return $_arr_articleRow;
            }
        }

        $_arr_articleTitle = validateStr(fn_post("article_title"), 1, 300);
        switch ($_arr_articleTitle["status"]) {
            case "too_short":
                return array(
                    "alert" => "x120201",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x120202",
                );
            break;

            case "ok":
                $this->articleSubmit["article_title"] = $_arr_articleTitle["str"];
            break;

        }

        $_arr_articleLink = validateStr(fn_post("article_link"), 0, 900, "str", "url");
        switch ($_arr_articleLink["status"]) {
            case "too_long":
                return array(
                    "alert" => "x120204",
                );
            break;

            case "format_err":
                return array(
                    "alert" => "x120204",
                );
            break;

            case "ok":
                $this->articleSubmit["article_link"] = $_arr_articleLink["str"];
            break;
        }

        $_arr_articleStatus = validateStr(fn_post("article_status"), 1, 0);
        switch ($_arr_articleStatus["status"]) {
            case "too_short":
                return array(
                    "alert" => "x120208",
                );
            break;

            case "ok":
                $this->articleSubmit["article_status"] = $_arr_articleStatus["str"];
            break;

        }

        $_arr_articleBox = validateStr(fn_post("article_box"), 1, 0);
        switch ($_arr_articleBox["status"]) {
            case "too_short":
                return array(
                    "alert" => "x120209",
                );
            break;

            case "ok":
                $this->articleSubmit["article_box"] = $_arr_articleBox["str"];
            break;

        }


        $_arr_articleTimePub = validateStr(fn_post("article_time_pub"), 1, 0, "str", "datetime");
        switch ($_arr_articleTimePub["status"]) {
            case "too_short":
                return array(
                    "alert" => "x120210",
                );
            break;

            case "format_err":
                return array(
                    "alert" => "x120211",
                );
            break;

            case "ok":
                $this->articleSubmit["article_time_pub"] = strtotime($_arr_articleTimePub["str"]);
            break;
        }

        $_arr_articleCateId = validateStr(fn_post("article_cate_id"), 1, 0);
        switch ($_arr_articleCateId["status"]) {
            case "too_short":
                return array(
                    "alert" => "x120207",
                );
            break;

            case "ok":
                $this->articleSubmit["article_cate_id"] = $_arr_articleCateId["str"];
            break;
        }


        $_is_ids = fn_getSafe(fn_post("cate_ids_checkbox"), "int", 0);

        $this->articleSubmit["cate_ids"] = array();

        if ($_is_ids == 1) {
            $_arr_cateIds = fn_post("cate_ids");
            if (isset($_arr_cateIds) && is_array($_arr_cateIds)) {
                foreach ($_arr_cateIds as $_key=>$_value) {
                    $this->articleSubmit["cate_ids"][] = fn_getSafe($_value, "int", 0);
                }
            }
        }

        $this->articleSubmit["cate_ids"][]        = $this->articleSubmit["article_cate_id"];
        $this->articleSubmit["cate_ids"]          = array_unique($this->articleSubmit["cate_ids"]);

        $this->articleSubmit["article_content"]   = fn_post("article_content");

        $_arr_attachIds = fn_getAttach($this->articleSubmit["article_content"]);
        if ($_arr_attachIds) {
            $this->articleSubmit["article_attach_id"] = $_arr_attachIds[0];
        } else {
            $this->articleSubmit["article_attach_id"] = 0;
        }

        $_str_excerptType = fn_getSafe(fn_post("article_excerpt_type"), "txt", "auto");

        switch ($_str_excerptType) {
            case "auto":
                $this->articleSubmit["article_excerpt"] = fn_substr_utf8($this->articleSubmit["article_content"], 0, BG_SITE_EXCERPT);
            break;

            case "txt":
                $_str_articleExcerpt = strip_tags($this->articleSubmit["article_content"]);
                $this->articleSubmit["article_excerpt"] = fn_substr_utf8($_str_articleExcerpt, 0, BG_SITE_EXCERPT);
            break;

            case "none":
                $this->articleSubmit["article_excerpt"] = "";
            break;

            case "manual":
                $_arr_articleExcerpt = validateStr(fn_post("article_excerpt"), 0, 900);
                switch ($_arr_articleExcerpt["status"]) {
                    case "too_long":
                        return array(
                            "alert" => "x120205",
                        );
                            break;

                    case "ok":
                        $this->articleSubmit["article_excerpt"] = $_arr_articleExcerpt["str"];
                    break;
                }
            break;
        }

        if (!$this->is_magic) {
            $this->articleSubmit["article_content"]   = addslashes($this->articleSubmit["article_content"]);
        }

        $this->articleSubmit["article_mark_id"]   = fn_getSafe(fn_post("article_mark_id"), "int", 0);
        $this->articleSubmit["article_spec_id"]   = fn_getSafe(fn_post("article_spec_id"), "int", 0);

        $_str_articleTags                     = fn_getSafe(fn_post("hidden-article_tag"), "txt", "");
        $_arr_articleTags                     = explode(",", $_str_articleTags);
        $this->articleSubmit["article_tags"]  = array();

        foreach ($_arr_articleTags as $_key=>$_value) {
            $this->articleSubmit["article_tags"][$_key] = fn_getSafe($_value, "txt", "");
        }

        $_arr_articleCustoms                      = fn_post("article_customs");
        $this->articleSubmit["article_customs"]   = array();

        if ($_arr_articleCustoms) {
            foreach ($_arr_articleCustoms as $_key=>$_value) {
                $this->articleSubmit["article_customs"][$_key] = fn_getSafe($_value, "txt", "");
            }
        }

        //print_r($_arr_articleCustoms);

        $this->articleSubmit["alert"]         = "ok";

        return $this->articleSubmit;
    }


    /** 列为主图输入
     * input_primary function.
     *
     * @access public
     * @return void
     */
    function input_primary() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $_arr_articleId = validateStr(fn_post("article_id"), 1, 0);
        switch ($_arr_articleId["status"]) {
            case "too_short":
                return array(
                    "alert" => "x120212",
                );
            break;

            case "ok":
                $this->articlePrimary["article_id"] = $_arr_articleId["str"];
            break;
        }

        $_arr_articleRow  = $this->mdl_read($this->articlePrimary["article_id"]);
        if ($_arr_articleRow["alert"] != "y120102") {
            return $_arr_articleRow;
        }

        $_arr_attachId = validateStr(fn_post("attach_id"), 1, 0);
        switch ($_arr_attachId["status"]) {
            case "too_short":
                return array(
                    "alert" => "x120214",
                );
            break;

            case "ok":
                $this->articlePrimary["article_attach_id"] = $_arr_attachId["str"];
            break;
        }

        $this->articlePrimary["article_cate_id"]   = $_arr_articleRow["article_cate_id"];
        $this->articlePrimary["alert"]         = "ok";

        return $this->articlePrimary;
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

        $_arr_articleIds = fn_post("article_ids");

        if ($_arr_articleIds) {
            foreach ($_arr_articleIds as $_key=>$_value) {
                $_arr_articleIds[$_key] = fn_getSafe($_value, "int", 0);
            }
            $_str_alert = "ok";
        } else {
            $_str_alert = "x030202";
        }

        $this->articleIds = array(
            "alert"         => $_str_alert,
            "article_ids"   => $_arr_articleIds
        );

        return $this->articleIds;
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

        if (isset($arr_search["key"]) && $arr_search["key"]) {
            $_str_sqlWhere .= " AND article_title LIKE '%" . $arr_search["key"] . "%'";
        }

        if (isset($arr_search["year"]) && $arr_search["year"]) {
            $_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%Y')='" . $arr_search["year"] . "'";
        }

        if (isset($arr_search["month"]) && $arr_search["month"]) {
            $_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%m')='" . $arr_search["month"] . "'";
        }

        if (isset($arr_search["status"]) && $arr_search["status"]) {
            $_str_sqlWhere .= " AND article_status='" . $arr_search["status"] . "'";
        }

        if (isset($arr_search["box"]) && $arr_search["box"]) {
            $_str_sqlWhere .= " AND article_box='" . $arr_search["box"] . "'";
        } else {
            $_str_sqlWhere .= " AND article_box='normal'";
        }

        if (isset($arr_search["cate_ids"]) && $arr_search["cate_ids"]) {
            $_str_cateIds = implode(",", $arr_search["cate_ids"]);
            $_str_sqlWhere .= " AND  article_cate_id IN (" . $_str_cateIds . ")";
        }

        if (isset($arr_search["mark_id"]) && $arr_search["mark_id"] > 0) {
            $_str_sqlWhere .= " AND article_mark_id=" . $arr_search["mark_id"];
        }

        if (isset($arr_search["spec_id"]) && $arr_search["spec_id"] > 0) {
            $_str_sqlWhere .= " AND article_spec_id=" . $arr_search["spec_id"];
        }

        if (isset($arr_search["not_spec_id"]) && $arr_search["not_spec_id"] > 0) {
            $_str_sqlWhere .= " AND article_spec_id<>" . $arr_search["not_spec_id"];
        }

        if (isset($arr_search["admin_id"]) && $arr_search["admin_id"] > 0) {
            $_str_sqlWhere .= " AND article_admin_id=" . $arr_search["admin_id"];
        }

        return $_str_sqlWhere;
    }
}
