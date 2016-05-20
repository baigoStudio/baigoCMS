<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

if(!defined("BG_UPLOAD_URL")) {
    define("BG_UPLOAD_URL", "");
}

/*-------------上传类-------------*/
class MODEL_ATTACH {

    private $obj_db;
    private $attachPre;
    private $is_magic;
    public $mime_image;
    public $thumbRows = array();

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS["obj_db"]; //设置数据库对象
        $this->is_magic   = get_magic_quotes_gpc();

        $this->mime_image = array(
            "image/jpeg"             => "jpg",
            "image/pjpeg"            => "jpg",
            "image/gif"              => "gif",
            "image/x-png"            => "png",
            "image/png"              => "png",
            "image/x-ms-bmp"         => "bmp",
            "image/x-windows-bmp"    => "bmp",
            "image/bmp"              => "bmp",
        );


        if (BG_MODULE_FTP == 1 && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) {
            $this->attachPre = BG_UPLOAD_URL . "/";
        } else {
            $this->attachPre = BG_URL_ATTACH;
        }
    }


    function mdl_create_table() {
        $_arr_attachCreat = array(
            "attach_id"          => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "attach_ext"         => "varchar(5) NOT NULL COMMENT '扩展名'",
            "attach_mime"        => "varchar(100) NOT NULL COMMENT 'MIME'",
            "attach_time"        => "int NOT NULL COMMENT '时间'",
            "attach_size"        => "mediumint NOT NULL COMMENT '大小'",
            "attach_name"        => "varchar(1000) NOT NULL COMMENT '原始文件名'",
            "attach_admin_id"    => "int NOT NULL COMMENT '上传用户 ID'",
            "attach_box"         => "enum('normal','recycle') NOT NULL COMMENT '盒子'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "attach", $_arr_attachCreat, "attach_id", "附件");

        if ($_num_mysql > 0) {
            $_str_alert = "y070105"; //更新成功
        } else {
            $_str_alert = "x070105"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "attach");

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value["Field"];
        }

        return $_arr_col;
    }


    function mdl_alert_table() {
        $_arr_col     = $this->mdl_column();
        $_arr_alert   = array();

        if (in_array("upfile_id", $_arr_col)) {
            $_arr_alert["upfile_id"] = array("CHANGE", "int NOT NULL AUTO_INCREMENT COMMENT 'ID'", "attach_id");
        }

        if (in_array("upfile_ext", $_arr_col)) {
            $_arr_alert["upfile_ext"] = array("CHANGE", "char(5) NOT NULL COMMENT '扩展名'", "attach_ext");
        }

        if (in_array("upfile_time", $_arr_col)) {
            $_arr_alert["upfile_time"] = array("CHANGE", "int NOT NULL COMMENT '时间'", "attach_time");
        }

        if (in_array("upfile_size", $_arr_col)) {
            $_arr_alert["upfile_size"] = array("CHANGE", "mediumint NOT NULL COMMENT '大小'", "attach_size");
        }

        if (in_array("attach_size", $_arr_col)) {
            $_arr_alert["attach_size"] = array("CHANGE", "mediumint NOT NULL COMMENT '大小'", "attach_size");
        }

        if (in_array("upfile_name", $_arr_col)) {
            $_arr_alert["upfile_name"] = array("CHANGE", "varchar(1000) NOT NULL COMMENT '原始文件名'", "attach_name");
        }

        if (in_array("upfile_admin_id", $_arr_col)) {
            $_arr_alert["upfile_admin_id"] = array("CHANGE", "smallint NOT NULL COMMENT '上传用户 ID'", "attach_admin_id");
        }

        if (in_array("attach_admin_id", $_arr_col)) {
            $_arr_alert["attach_admin_id"] = array("CHANGE", "smallint NOT NULL COMMENT '上传用户 ID'", "attach_admin_id");
        }

        if (!in_array("attach_box", $_arr_col)) {
            $_arr_alert["attach_box"] = array("ADD", "enum('normal','recycle') NOT NULL COMMENT '盒子'");
        }

        $_arr_attachData = array(
            "attach_box" => "normal",
        );
        $this->obj_db->update(BG_DB_TABLE . "attach", $_arr_attachData, "LENGTH(attach_box) < 1"); //更新数据

        if (!in_array("attach_mime", $_arr_col)) {
            $_arr_alert["attach_mime"] = array("ADD", "varchar(30) NOT NULL COMMENT 'MIME'");
        }

        $_str_alert = "y070111";

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "attach", $_arr_alert);

            if ($_reselt) {
                $_str_alert = "y070106";
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
     * @param mixed $str_attachName
     * @param mixed $str_attachExt
     * @param int $num_attachSize (default: 0)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_submit($num_attachId, $str_attachName, $str_attachExt, $str_attachMime, $num_attachSize = 0, $num_adminId = 0) {

        $_arr_attachData = array(
            "attach_name"    => $str_attachName,
            "attach_ext"     => $str_attachExt,
            "attach_mime"    => $str_attachMime,
        );

        $_tm_time = time();

        if ($num_attachId < 1) {
            $_arr_attachData["attach_time"]      = $_tm_time;
            $_arr_attachData["attach_admin_id"]  = $num_adminId;
            $_arr_attachData["attach_size"]      = $num_attachSize;
            $_arr_attachData["attach_box"]       = "normal";
            $_num_attachId = $this->obj_db->insert(BG_DB_TABLE . "attach", $_arr_attachData);

            if ($_num_attachId > 0) { //数据库插入是否成功
                $_str_alert = "y070101";
            } else {
                return array(
                    "alert" => "x070101",
                );
            }
        } else {
            $_num_attachId   = $num_attachId;
            $_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "attach", $_arr_attachData, "attach_id=" . $num_attachId);

            if ($_num_mysql > 0) { //数据库插入是否成功
                $_str_alert = "y070103";
            } else {
                return array(
                    "alert" => "x070103",
                );
            }
        }

        return array(
            "attach_id"      => $_num_attachId,
            "attach_time"    => $_tm_time,
            "alert"          => $_str_alert,
        );
    }

    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $num_attachId
     * @return void
     */
    function mdl_read($num_attachId) {
        $_arr_attachSelect = array(
            "attach_id",
            "attach_name",
            "attach_time",
            "attach_ext",
            "attach_mime",
            "attach_size",
            "attach_box",
        );

        $_arr_attachRows  = $this->obj_db->select(BG_DB_TABLE . "attach", $_arr_attachSelect, "attach_id=" . $num_attachId, "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_attachRows[0])) {
            $_arr_attachRow   = $_arr_attachRows[0];
        } else {
            return array(
                "alert" => "x070102", //不存在记录
            );
        }

        $_arr_mimeImage = array_flip($this->mime_image);

        if (!$_arr_attachRow["attach_mime"]) {
            $_arr_attachRow["attach_mime"]   = $_arr_mimeImage[$_arr_attachRow["attach_ext"]];
        }

        if (array_key_exists($_arr_attachRow["attach_mime"], $this->mime_image)) {
            $_arr_attachRow["attach_type"] = "image";
        } else {
            $_arr_attachRow["attach_type"] = "file";
        }

        $_arr_attachRow["attach_url"] = $this->attachPre . date("Y", $_arr_attachRow["attach_time"]) . "/" . date("m", $_arr_attachRow["attach_time"]) . "/" . $_arr_attachRow["attach_id"] . "." . $_arr_attachRow["attach_ext"];

        $_arr_attachRow["attach_path"] = BG_PATH_ATTACH . date("Y", $_arr_attachRow["attach_time"]) . "/" . date("m", $_arr_attachRow["attach_time"]) . "/" . $_arr_attachRow["attach_id"] . "." . $_arr_attachRow["attach_ext"];

        $_arr_attachRow["alert"] = "y070102";

        return $_arr_attachRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param string $str_year (default: "")
     * @param string $str_month (default: "")
     * @param string $str_ext (default: "")
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_attachSelect = array(
            "attach_id",
            "attach_name",
            "attach_time",
            "attach_ext",
            "attach_mime",
            "attach_size",
            "attach_admin_id",
            "attach_box",
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_attachRows = $this->obj_db->select(BG_DB_TABLE . "attach", $_arr_attachSelect, $_str_sqlWhere, "", "attach_id DESC", $num_no, $num_except);

        $_arr_mimeImage = array_flip($this->mime_image);

        foreach ($_arr_attachRows as $_key=>$_value) {
            if (!$_value["attach_mime"]) {
                $_value["attach_mime"]                  = $_arr_mimeImage[$_value["attach_ext"]];
                $_arr_attachRows[$_key]["attach_mime"]  = $_value["attach_mime"];
            }

            if (array_key_exists($_value["attach_mime"], $this->mime_image)) {
                $_arr_attachRows[$_key]["attach_type"] = "image";
            } else {
                $_arr_attachRows[$_key]["attach_type"] = "file";
            }

            $_arr_attachRows[$_key]["attach_url"] = $this->attachPre . date("Y", $_value["attach_time"]) . "/" . date("m", $_value["attach_time"]) . "/" . $_value["attach_id"] . "." . $_value["attach_ext"];

            $_arr_attachRows[$_key]["attach_path"] = BG_PATH_ATTACH . date("Y", $_value["attach_time"]) . "/" . date("m", $_value["attach_time"]) . "/" . $_value["attach_id"] . "." . $_value["attach_ext"];
        }

        return $_arr_attachRows;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_year (default: "")
     * @param string $str_month (default: "")
     * @param string $str_ext (default: "")
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_attachCount = $this->obj_db->count(BG_DB_TABLE . "attach", $_str_sqlWhere);

        return $_num_attachCount;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->attachIds["attach_ids"]
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_del($num_adminId = 0, $arr_attachIds = false) {
        if ($arr_attachIds) {
            $this->attachIds["attach_ids"] = $arr_attachIds;
        }
        $_str_attachIds = implode(",", $this->attachIds["attach_ids"]);

        $_str_sqlWhere = "attach_id IN (" . $_str_attachIds . ")";

        if ($num_adminId > 0) {
            $_str_sqlWhere .= " AND attach_admin_id=" . $num_adminId;
        }

        $_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "attach", $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y070104";
        } else {
            $_str_alert = "x070104";
        }

        return array(
            "alert" => $_str_alert
        ); //成功
    }


    /**
     * mdl_ext function.
     *
     * @access public
     * @param mixed $num_no
     * @return void
     */
    function mdl_ext() {
        $_arr_attachSelect = array(
            "DISTINCT attach_ext",
        );

        $_str_sqlWhere    = "LENGTH(attach_ext) > 0";
        $_arr_attachRows  = $this->obj_db->select(BG_DB_TABLE . "attach", $_arr_attachSelect, $_str_sqlWhere, "", "", 100, 0, false, true);

        return $_arr_attachRows;
    }


    /**
     * mdl_year function.
     *
     * @access public
     * @param mixed $num_no
     * @return void
     */
    function mdl_year() {
        $_arr_attachSelect = array(
            "DISTINCT FROM_UNIXTIME(attach_time, '%Y') AS attach_year",
        );

        $_str_sqlWhere = "attach_time > 0";

        $_arr_yearRows = $this->obj_db->select(BG_DB_TABLE . "attach", $_arr_attachSelect, $_str_sqlWhere, "", "attach_time ASC", 100, 0, false, true);

        return $_arr_yearRows;
    }


    function mdl_url($num_attachId) {
        $_arr_attachRow = $this->mdl_read($num_attachId);
        if ($_arr_attachRow["alert"] != "y070102") {
            return $_arr_attachRow;
        }

        foreach ($this->thumbRows as $_key=>$_value) {
            $_arr_attachRow["thumb_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" . $_value["thumb_type"]] = $this->attachPre . date("Y", $_arr_attachRow["attach_time"]) . "/" . date("m", $_arr_attachRow["attach_time"]) . "/" . $num_attachId . "_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" .$_value["thumb_type"] . "." . $_arr_attachRow["attach_ext"];
        }

        return $_arr_attachRow;
    }


    function mdl_chkAttach($num_attachId, $str_attachExt, $tm_attachTime) {
        $_str_attachUrl = date("Y", $tm_attachTime) . "/" . date("m", $tm_attachTime) . "/" . $num_attachId . "." . $str_attachExt;

        if (!$this->is_magic) {
            $_str_chk   = addslashes($_str_attachUrl);
        } else {
            $_str_chk   = $_str_attachUrl;
        }

        $_arr_articleSelect = array(
            "article_id",
        );

        $_str_sqlWhere    = "article_attach_id=" . $num_attachId;
        //print_r($_str_sqlWhere . "<br>");
        $_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere, "", "article_id ASC", 1, 0);

        //print_r($_arr_articleRows);
        if (isset($_arr_articleRows[0])) {
            return array(
                "attach_id" => $num_attachId,
                "alert" => "y070406",
            );
        }

        $_str_sqlWhere    = "article_excerpt LIKE '%" . $_str_chk . "%'";
        //print_r($_str_sqlWhere . "<br>");
        $_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere, "", "article_id ASC", 1, 0);

        //print_r($_arr_articleRows);
        if (isset($_arr_articleRows[0])) {
            return array(
                "attach_id" => $num_attachId,
                "alert" => "y070406",
            );
        }

        $_str_sqlWhere    = "article_content LIKE '%" . $_str_chk . "%'";
        //print_r($_str_sqlWhere . "<br>");
        $_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article_content", $_arr_articleSelect, $_str_sqlWhere, "", "article_id ASC", 1, 0);

        //print_r($_arr_articleRows);
        if (isset($_arr_articleRows[0])) {
            return array(
                "attach_id" => $num_attachId,
                "alert" => "y070406",
            );
        }

        $_arr_cateSelect = array(
            "cate_id",
        );

        $_str_sqlWhere    = "cate_content LIKE '%" . $_str_chk . "%'";
        //print_r($_str_sqlWhere . "<br>");
        $_arr_cateRows = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, "", "cate_id ASC", 1, 0);

        //print_r($_arr_cateRows);
        if (isset($_arr_cateRows[0])) {
            return array(
                "attach_id" => $num_attachId,
                "alert" => "y070406",
            );
        }

        $_arr_specSelect = array(
            "spec_id",
        );

        $_str_sqlWhere    = "spec_content LIKE '%" . $_str_chk . "%'";
        //print_r($_str_sqlWhere . "<br>");
        $_arr_specRows = $this->obj_db->select(BG_DB_TABLE . "spec", $_arr_specSelect, $_str_sqlWhere, "", "spec_id ASC", 1, 0);

        //print_r($_arr_specRows);
        if (isset($_arr_specRows[0])) {
            return array(
                "attach_id" => $num_attachId,
                "alert"     => "y070406",
            );
        }

        $_arr_customSelect = array(
            "value_id",
        );

        $_str_sqlWhere   = "value_custom_value=" . $num_attachId;
        //print_r($_str_sqlWhere . "<br>");
        $_arr_customRows = $this->obj_db->select(BG_DB_TABLE . "custom_value", $_arr_customSelect, $_str_sqlWhere, "", "value_id ASC", 1, 0);

        //print_r($_arr_customRows);
        if (isset($_arr_customRows[0])) {
            return array(
                "attach_id" => $num_attachId,
                "alert"     => "y070406",
            );
        }

        return array(
            "attach_id"  => $num_attachId,
            "alert"      => "x070406",
        );
    }


    function mdl_box($str_box, $arr_attachIds = false) {
        if ($arr_attachIds) {
            $this->attachIds["attach_ids"] = $arr_attachIds;
        }

        $_str_attachIds = implode(",", $this->attachIds["attach_ids"]);

        $_arr_attachData = array(
            "attach_box" => $str_box,
        );

        $_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "attach", $_arr_attachData, "attach_id IN (" . $_str_attachIds . ")");

        if ($_num_mysql > 0) {
            $_str_alert = "y070103";
        } else {
            $_str_alert = "x070103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /**
     * fn_thumbDo function.
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

        $_arr_attachIds = fn_post("attach_ids");

        if ($_arr_attachIds) {
            foreach ($_arr_attachIds as $_key=>$_value) {
                $_arr_attachIds[$_key] = fn_getSafe($_value, "int", 0);
            }
            $_str_alert = "ok";
        } else {
            $_str_alert = "x030202";
        }

        $this->attachIds = array(
            "alert"  => $_str_alert,
            "attach_ids" => $_arr_attachIds,
        );

        return $this->attachIds;
    }


    function thumb_process($num_attachId, $num_attachTime, $num_attachExt) {

        foreach ($this->thumbRows as $_key=>$_value) {
            $_arr_attach[$_key]["thumb_url"]     = $this->attachPre . date("Y", $num_attachTime) . "/" . date("m", $num_attachTime) . "/" . $num_attachId . "_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" .$_value["thumb_type"] . "." . $num_attachExt;
            $_arr_attach[$_key]["thumb_width"]   = $_value["thumb_width"];
            $_arr_attach[$_key]["thumb_height"]  = $_value["thumb_height"];
            $_arr_attach[$_key]["thumb_type"]    = $_value["thumb_type"];
        }

        return $_arr_attach;
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = "1=1";

        if (isset($arr_search["key"]) && $arr_search["key"]) {
            $_str_sqlWhere .= " AND attach_name LIKE '%" . $arr_search["key"] . "%'";
        }

        if (isset($arr_search["year"]) && $arr_search["year"]) {
            $_str_sqlWhere .= " AND FROM_UNIXTIME(attach_time, '%Y')='" . $arr_search["year"] . "'";
        }

        if (isset($arr_search["month"]) && $arr_search["month"]) {
            $_str_sqlWhere .= " AND FROM_UNIXTIME(attach_time, '%m')='" . $arr_search["month"] . "'";
        }

        if (isset($arr_search["ext"]) && $arr_search["ext"]) {
            $_str_sqlWhere .= " AND attach_ext='" . $arr_search["ext"] . "'";
        }

        if (isset($arr_search["box"]) && $arr_search["box"]) {
            $_str_sqlWhere .= " AND attach_box='" . $arr_search["box"] . "'";
        }

        if (isset($arr_search["attach_ids"]) && $arr_search["attach_ids"]) {
            $_str_attachIds  = implode(",", $arr_search["attach_ids"]);
            $_str_sqlWhere  .= " AND attach_id IN (" . $_str_attachIds . ")";
        }

        if (isset($arr_search["admin_id"]) && $arr_search["admin_id"]) {
            $_str_sqlWhere .= " AND attach_admin_id=" . $arr_search["admin_id"];
        }

        if (isset($arr_search["begin_id"]) && $arr_search["begin_id"] > 0) {
            $_str_sqlWhere .= " AND attach_id>=" . $arr_search["begin_id"];
        }

        if (isset($arr_search["end_id"]) && $arr_search["end_id"] > 0) {
            $_str_sqlWhere .= " AND attach_id<=" . $arr_search["end_id"];
        }

        return $_str_sqlWhere;
    }
}
