<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------用户类-------------*/
class MODEL_CATE {
    private $obj_db;
    private $is_magic;
    public $cateStatus = array();
    public $cateTypes = array();

    function __construct() { //构造函数
        $this->obj_db   = $GLOBALS["obj_db"]; //设置数据库对象
        $this->obj_dir  = new CLASS_DIR();
        $this->is_magic = get_magic_quotes_gpc();
    }


    function mdl_create_table() {
        foreach ($this->cateStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        foreach ($this->cateTypes as $_key=>$_value) {
            $_arr_types[] = $_key;
        }
        $_str_types = implode("','", $_arr_types);

        $_arr_cateCreat = array(
            "cate_id"        => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "cate_name"      => "varchar(300) NOT NULL COMMENT '站点名称'",
            "cate_domain"    => "varchar(3000) NOT NULL COMMENT '绑定域名'",
            "cate_type"      => "enum('" . $_str_types . "') NOT NULL COMMENT '类型'",
            "cate_tpl"       => "varchar(1000) NOT NULL COMMENT '模板'",
            "cate_content"   => "text NOT NULL COMMENT '栏目介绍'",
            "cate_link"      => "varchar(3000) NOT NULL COMMENT '链接地址'",
            "cate_parent_id" => "smallint NOT NULL COMMENT '父栏目'",
            "cate_alias"     => "varchar(300) NOT NULL COMMENT '别名'",
            "cate_perpage"   => "tinyint NOT NULL COMMENT '每页文章数'",
            "cate_ftp_host"  => "varchar(3000) NOT NULL COMMENT '站点 FTP 服务器'",
            "cate_ftp_port"  => "char(5) NOT NULL COMMENT 'FTP端口'",
            "cate_ftp_user"  => "varchar(300) NOT NULL COMMENT '站点 FTP 用户名'",
            "cate_ftp_pass"  => "varchar(300) NOT NULL COMMENT '站点 FTP 密码'",
            "cate_ftp_path"  => "varchar(3000) NOT NULL COMMENT '站点 FTP 目录'",
            "cate_status"    => "enum('" . $_str_status . "') NOT NULL COMMENT '状态'",
            "cate_order"     => "smallint NOT NULL COMMENT '排序'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "cate", $_arr_cateCreat, "cate_id", "栏目");

        if ($_num_mysql > 0) {
            $_str_alert = "y110105"; //更新成功
        } else {
            $_str_alert = "x110105"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_create_index() {
        $_str_alert = "y110109";
        $_arr_indexRow    = $this->obj_db->show_index(BG_DB_TABLE . "cate");

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array("order", $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_cateIndex = array(
            "cate_order",
            "cate_id",
        );

        $_num_mysql = $this->obj_db->create_index("order", BG_DB_TABLE . "cate", $_arr_cateIndex, "BTREE", $is_exists);

        if ($_num_mysql < 1) {
            $_str_alert = "x110109";
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "cate");

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value["Field"];
        }

        return $_arr_col;
    }


    function mdl_alert_table() {
        foreach ($this->cateStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        foreach ($this->cateTypes as $_key=>$_value) {
            $_arr_types[] = $_key;
        }
        $_str_types = implode("','", $_arr_types);

        $_arr_col     = $this->mdl_column();
        $_arr_alert   = array();

        if (in_array("cate_id", $_arr_col)) {
            $_arr_alert["cate_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "cate_id");
        }

        if (in_array("cate_type", $_arr_col)) {
            $_arr_alert["cate_type"] = array("CHANGE", "enum('" . $_str_types . "') NOT NULL COMMENT '类型'", "cate_type");
        }

        $_arr_cateData = array(
            "cate_type" => $_arr_types[0],
        );
        $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "LENGTH(cate_type) < 1"); //更新数据

        if (in_array("cate_parent_id", $_arr_col)) {
            $_arr_alert["cate_parent_id"] = array("CHANGE", "smallint NOT NULL COMMENT '父栏目'", "cate_parent_id");
        }

        if (in_array("cate_ftp_port", $_arr_col)) {
            $_arr_alert["cate_ftp_port"] = array("CHANGE", "char(5) NOT NULL COMMENT 'FTP端口'", "cate_ftp_port");
        }

        if (in_array("cate_status", $_arr_col)) {
            $_arr_alert["cate_status"] = array("CHANGE", "enum('" . $_str_status . "') NOT NULL COMMENT '状态'", "cate_status");
        }

        $_arr_cateData = array(
            "cate_status" => $_arr_status[0],
        );
        $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "LENGTH(cate_status) < 1"); //更新数据

        if (in_array("cate_order", $_arr_col)) {
            $_arr_alert["cate_order"] = array("CHANGE", "smallint NOT NULL COMMENT '排序'", "cate_order");
        }

        if (!in_array("cate_perpage", $_arr_col)) {
            $_arr_alert["cate_perpage"] = array("ADD", "tinyint NOT NULL COMMENT '每页文章数'");
        }

        $_str_alert = "y110111";

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "cate", $_arr_alert);

            if ($_reselt) {
                $_str_alert = "y110106";
            }
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    function mdl_submit() {
        $_arr_cateData = array(
            "cate_name"      => $this->cateSubmit["cate_name"],
            "cate_alias"     => $this->cateSubmit["cate_alias"],
            "cate_type"      => $this->cateSubmit["cate_type"],
            "cate_status"    => $this->cateSubmit["cate_status"],
            "cate_tpl"       => $this->cateSubmit["cate_tpl"],
            "cate_content"   => $this->cateSubmit["cate_content"],
            "cate_link"      => $this->cateSubmit["cate_link"],
            "cate_parent_id" => $this->cateSubmit["cate_parent_id"],
            "cate_domain"    => $this->cateSubmit["cate_domain"],
            "cate_perpage"   => $this->cateSubmit["cate_perpage"],
            "cate_ftp_host"  => $this->cateSubmit["cate_ftp_host"],
            "cate_ftp_port"  => $this->cateSubmit["cate_ftp_port"],
            "cate_ftp_user"  => $this->cateSubmit["cate_ftp_user"],
            "cate_ftp_pass"  => $this->cateSubmit["cate_ftp_pass"],
            "cate_ftp_path"  => $this->cateSubmit["cate_ftp_path"],
        );

        if ($this->cateSubmit["cate_id"] < 1) { //插入
            $_num_cateId = $this->obj_db->insert(BG_DB_TABLE . "cate", $_arr_cateData);

            if ($_num_cateId > 0) { //数据库插入是否成功
                $_str_alert = "y110101";
            } else {
                return array(
                    "cate_id"      => 0,
                    "alert"    => "x110101",
                );
            }

        } else {
            $_num_cateId = $this->cateSubmit["cate_id"];
            $_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "cate_id=" . $_num_cateId);

            if ($_num_mysql > 0) { //数据库更新是否成功
                $_str_alert = "y110103";
            } else {
                return array(
                    "cate_id"      => $_num_cateId,
                    "alert"    => "x110103",
                );
            }
        }

        return array(
            "cate_id"    => $_num_cateId,
            "alert"  => $_str_alert,
        );
    }


    /**
     * mdl_order function.
     *
     * @access public
     * @param string $str_orderType (default: "")
     * @param int $num_doId (default: 0)
     * @param int $num_targetId (default: 0)
     * @return void
     */
    function mdl_order($str_orderType = "", $num_doId = 0, $num_targetId = 0, $num_parentId = 0) {

        //处理重复排序号
        $_str_sqlDistinct = "SELECT cate_id FROM " . BG_DB_TABLE . "cate WHERE cate_order IN (SELECT cate_order FROM " . BG_DB_TABLE . "cate GROUP BY cate_order HAVING COUNT(cate_order) > 1) ORDER BY cate_id DESC" ;
        $_obj_reselt      = $this->obj_db->query($_str_sqlDistinct);
        $_arr_row         = $this->obj_db->fetch_assoc($_obj_reselt);

        if ($_arr_row) {
            $_arr_selectData = array(
                "cate_id",
            );

            $_arr_lastRows  = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_selectData, "", "", "cate_id DESC", 1, 0); //读取倒数第一排序号
            if (isset($_arr_lastRows[0])) {
                $_arr_lastRow   = $_arr_lastRows[0];

                $_arr_updateData = array(
                    "cate_order" => $_arr_row["cate_id"] + 1,
                );

                $_str_sqlWhere = "cate_id=" . $_arr_row["cate_id"];

                $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_updateData, $_str_sqlWhere, true); //所有小于本条大于目标记录的数据排序号加1
            }
        }
        //end

        //
        $_arr_selectData = array(
            "cate_order",
        );

        switch ($str_orderType) {
            case "order_first":
                $_str_sqlWhere = "cate_parent_id=" . $num_parentId;
                $_arr_firstRows = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, "", "cate_order ASC", 1, 0); //读取第一排序号
                if (isset($_arr_firstRows[0])) {
                    $_arr_firstRow  = $_arr_firstRows[0];
                }

                $_str_sqlWhere  = "cate_id=" . $num_doId . " AND cate_parent_id=" . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, "", "", 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        "alert" => "x110217",
                    );
                    }

                $_arr_targetData = array(
                    "cate_order" => "cate_order+1",
                );
                $_str_sqlWhere = "cate_order<" . $_arr_doRow["cate_order"] . " AND cate_parent_id=" . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有小于本条的数据排序号加1

                $_arr_doData = array(
                    "cate_order" => $_arr_firstRow["cate_order"],
                );
                $_str_sqlWhere = "cate_id=" . $num_doId . " AND cate_parent_id=" . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_doData, $_str_sqlWhere); //更新本条排序号为1
            break;

            case "order_last":
                $_str_sqlWhere = "cate_parent_id=" . $num_parentId;
                $_arr_lastRows  = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, "", "cate_order DESC", 1, 0); //读取倒数第一排序号
                if (isset($_arr_lastRows[0])) {
                    $_arr_lastRow   = $_arr_lastRows[0];
                }

                $_str_sqlWhere  = "cate_id=" . $num_doId . " AND cate_parent_id=" . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, "", "", 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        "alert" => "x110217",
                    );
                    }

                $_arr_targetData = array(
                    "cate_order" => "cate_order-1",
                );
                $_str_sqlWhere = "cate_order>" . $_arr_doRow["cate_order"] . " AND cate_parent_id=" . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条的数据排序号减1

                $_arr_doData = array(
                    "cate_order" => $_arr_lastRow["cate_order"],
                );
                $_str_sqlWhere = "cate_id=" . $num_doId . " AND cate_parent_id=" . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_doData, $_str_sqlWhere); //更新本条排序号为最大
            break;

            case "order_after":
                $_str_sqlWhere = "cate_id=" . $num_targetId . " AND cate_parent_id=" . $num_parentId;
                $_arr_targetRows    = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, "", "", 1, 0); //读取目标记录排序号
                if (isset($_arr_targetRows[0])) {
                    $_arr_targetRow     = $_arr_targetRows[0];
                } else {
                    return array(
                        "alert" => "x110220",
                    );
                    }

                $_str_sqlWhere      = "cate_id=" . $num_doId . " AND cate_parent_id=" . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, "", "", 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        "alert" => "x110217",
                    );
                    }

                //print_r($_arr_doRow);

                if ($_arr_targetRow["cate_order"] > $_arr_doRow["cate_order"]) { //往下移
                    $_arr_targetData = array(
                        "cate_order" => "cate_order-1",
                    );
                    $_str_sqlWhere = "cate_order>" . $_arr_doRow["cate_order"] . " AND cate_order<=" . $_arr_targetRow["cate_order"] . " AND cate_parent_id=" . $num_parentId;
                    $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

                    $_arr_doData = array(
                        "cate_order" => $_arr_targetRow["cate_order"],
                    );
                } else {
                    $_arr_targetData = array(
                        "cate_order" => "cate_order+1",
                    );
                    $_str_sqlWhere = "cate_order<" . $_arr_doRow["cate_order"] . " AND cate_order>" . $_arr_targetRow["cate_order"] . " AND cate_parent_id=" . $num_parentId;
                    $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

                    $_arr_doData = array(
                        "cate_order" => $_arr_targetRow["cate_order"] + 1,
                    );
                }

                $_str_sqlWhere = "cate_id=" . $num_doId . " AND cate_parent_id=" . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_doData, $_str_sqlWhere); //更新本条排序号为目标记录排序号
            break;
        }

        return array(
            "alert" => "y110103",
        );
    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_cate
     * @param string $str_readBy (default: "cate_id")
     * @param int $num_notThisId (default: 0)
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_read($str_cate, $str_readBy = "cate_id", $num_notThisId = 0, $num_parentId = -1) {
        $_arr_cateSelect = array(
            "cate_id",
            "cate_name",
            "cate_alias",
            "cate_type",
            "cate_tpl",
            "cate_content",
            "cate_link",
            "cate_parent_id",
            "cate_domain",
            "cate_perpage",
            "cate_ftp_host",
            "cate_ftp_port",
            "cate_ftp_user",
            "cate_ftp_pass",
            "cate_ftp_path",
            "cate_status",
        );

        switch ($str_readBy) {
            case "cate_id":
                $_str_sqlWhere = $str_readBy . "=" . $str_cate;
            break;
            default:
                $_str_sqlWhere = $str_readBy . "='" . $str_cate . "'";
            break;
        }

        if ($num_notThisId > 0) {
            $_str_sqlWhere .= " AND cate_id<>" . $num_notThisId;
        }

        if ($num_parentId >= 0) {
            $_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
        }

        $_arr_cateRows    = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_cateRows[0])) {
            $_arr_cateRow     = $_arr_cateRows[0];
        } else {
            return array(
                "alert" => "x110102", //不存在记录
            );
        }

        //if (!$this->is_magic) {
            $_arr_cateRow["cate_content"] = stripslashes($_arr_cateRow["cate_content"]);
        //}

        $_arr_cateRow["cate_trees"]   = $this->trees_process($_arr_cateRow["cate_id"]);
        ksort($_arr_cateRow["cate_trees"]);
        $_arr_cateRow["urlRow"]       = $this->url_process($_arr_cateRow);

        $_arr_cateRow["alert"]        = "y110102";

        return $_arr_cateRow;
    }


    function mdl_readPub($str_cate, $str_readBy = "cate_id", $num_notThisId = 0, $num_parentId = 0) {
        $_arr_cateSelect = array(
            "cate_id",
            "cate_name",
            "cate_alias",
            "cate_type",
            "cate_tpl",
            "cate_content",
            "cate_link",
            "cate_parent_id",
            "cate_domain",
            "cate_status",
            "cate_perpage",
        );

        switch ($str_readBy) {
            case "cate_id":
                $_str_sqlWhere = $str_readBy . "=" . $str_cate;
            break;
            default:
                $_str_sqlWhere = $str_readBy . "='" . $str_cate . "'";
            break;
        }

        if ($num_notThisId > 0) {
            $_str_sqlWhere .= " AND cate_id<>" . $num_notThisId;
        }

        if ($num_parentId > 0) {
            $_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
        }

        $_arr_cateRows    = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_cateRows[0])) {
            $_arr_cateRow     = $_arr_cateRows[0];
        } else {
            return array(
                "alert" => "x110102", //不存在记录
            );
        }

        //if (!$this->is_magic) {
            $_arr_cateRow["cate_content"] = stripslashes($_arr_cateRow["cate_content"]);
        //}

        $_arr_cateRow["cate_trees"]   = $this->trees_process($_arr_cateRow["cate_id"]);
        ksort($_arr_cateRow["cate_trees"]);
        $_arr_cateRow["urlRow"]       = $this->url_process($_arr_cateRow);

        $_arr_cateRow["alert"]    = "y110102";

        return $_arr_cateRow;
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
    function mdl_list($num_no, $num_except = 0, $arr_search = array(), $num_level = 1) {
        $_arr_updateData = array(
            "cate_order" => "cate_id",
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_updateData, "cate_order=0", true); //更新数据

        $_arr_cateSelect = array(
            "cate_id",
            "cate_name",
            "cate_link",
            "cate_alias",
            "cate_status",
            "cate_type",
            "cate_parent_id",
            "cate_domain",
        );

        $_str_sqlWhere  = $this->sql_process($arr_search);

        $_arr_cateRows  = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, "", "cate_order ASC, cate_id ASC", $num_no, $num_except);

        //print_r($_arr_cateRows);

        foreach ($_arr_cateRows as $_key=>$_value) {
            $_value["cate_trees"]     = $this->trees_process($_value["cate_id"]);
            ksort($_value["cate_trees"]);
            $_arr_cateRows[$_key]["urlRow"]         = $this->url_process($_value);
            $_arr_cateRows[$_key]["cate_level"]     = $num_level;
            $arr_search["parent_id"] = $_value["cate_id"];
            $_arr_cateRows[$_key]["cate_childs"]    = $this->mdl_list(1000, 0, $arr_search, $num_level + 1);
        }

        return $_arr_cateRows;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_status (default: "")
     * @param string $str_type (default: "")
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_count($arr_search = array()) {

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_cateCount = $this->obj_db->count(BG_DB_TABLE . "cate", $_str_sqlWhere); //查询数据

        /*print_r($_arr_userRow);
        exit;*/

        return $_num_cateCount;
    }


    function mdl_ids($num_cateId) {
        $_arr_cateRows  = $this->mdl_list(1000, 0, "show", "", false, $num_cateId);
        $_arr_cateIds   = $this->ids_process($_arr_cateRows);
        $_arr_cateIds[] = $num_cateId;
        return array_unique($_arr_cateIds);
    }


    function mdl_list_ids() {
        $_arr_cateSelect = array(
            "cate_id",
        );

        $_str_sqlWhere = "1=1";

        $_arr_cateRows = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, "", "cate_id ASC", 1000, 0);

        foreach ($_arr_cateRows as $_key=>$_value) {
            $_arr_list_id[] = $_value["cate_id"];
        }

        return $_arr_list_id;
    }


    /**
     * mdl_status function.
     *
     * @access public
     * @param mixed $this->cateIds["cate_ids"]
     * @param mixed $str_status
     * @return void
     */
    function mdl_status($str_status) {
        $_str_cateId = implode(",", $this->cateIds["cate_ids"]);

        $_arr_cateData = array(
            "cate_status" => $str_status,
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "cate_id IN (" . $_str_cateId . ")"); //更新数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y110103";
        } else {
            $_str_alert = "x110103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }

    /**
     * mdl_del function.
     *
     * @access public
     * @return void
     */
    function mdl_del() {
        $_str_cateId = implode(",", $this->cateIds["cate_ids"]);

        $_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "cate", "cate_id IN (" . $_str_cateId . ")"); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y110104";

            $_arr_cateData = array(
                "cate_parent_id" => 0
            );
            $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "cate_parent_id IN (" . $_str_cateId . ")"); //更新数据

            $_arr_articleData = array(
                "article_cate_id" => -1
            );
            $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleData, "article_cate_id IN (" . $_str_cateId . ")"); //更新数据

            $this->obj_db->delete(BG_DB_TABLE . "cate_belong", "belong_cate_id IN (" . $_str_cateId . ")"); //更新数据
        } else {
            $_str_alert = "x110104";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功
    }


    /**
     * cache_generate function.
     *
     * @access public
     * @return void
     */
    function mdl_cache($is_reGen = false, $num_cateId = false) {
        $_arr_cacheReturn = array();
        if ($is_reGen || !file_exists(BG_PATH_CACHE . "sys/cate_trees.php")) {
            $_arr_cateRows    = $this->mdl_list(1000, 0, "show");

            $_str_outPut      = "<?php" . PHP_EOL;
            $_str_outPut     .= "return array(" . PHP_EOL;
            $_str_outPut     .= $this->cache_tree_process($_arr_cateRows);
            $_str_outPut     .= ");";

            $_num_size = $this->obj_dir->put_file(BG_PATH_CACHE . "sys/", "cate_trees.php", $_str_outPut);
        }

        if ($is_reGen) {
            $arr_cateIds = $this->mdl_list_ids();

            foreach ($arr_cateIds as $_key=>$_value) {
                $_str_outPut = $this->cache_row_process($_value);
                $_num_size = $this->obj_dir->put_file(BG_PATH_CACHE . "sys/", "cate_" . $_value . ".php", $_str_outPut);
            }
        }

        if ($num_cateId) {
            if (!file_exists(BG_PATH_CACHE . "sys/cate_" . $num_cateId . ".php")) {
                $_str_outPut    = $this->cache_row_process($num_cateId);
                $_num_size      = $this->obj_dir->put_file(BG_PATH_CACHE . "sys/", "cate_" . $num_cateId . ".php", $_str_outPut);
            }

            $_arr_cacheReturn = include_once(BG_PATH_CACHE . "sys/cate_" . $num_cateId . ".php");

        } else {
            $_arr_cacheReturn = include_once(BG_PATH_CACHE . "sys/cate_trees.php");
        }

        return $_arr_cacheReturn;
    }


    function mdl_cache_del($arr_cateDels) {
        foreach ($arr_cateDels as $_key=>$_value) {
            if (file_exists(BG_PATH_CACHE . "sys/cate_" . $_value . ".php")) {
                unlink(BG_PATH_CACHE . "sys/cate_" . $_value . ".php");
            }
        }
    }


    /**
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

        $this->cateSubmit["cate_id"] = fn_getSafe(fn_post("cate_id"), "int", 0);

        if ($this->cateSubmit["cate_id"] > 0) {
            $_arr_cateRow = $this->mdl_read($this->cateSubmit["cate_id"]);
            if ($_arr_cateRow["alert"] != "y110102") {
                return $_arr_cateRow;
            }
        }

        $_arr_cateName = validateStr(fn_post("cate_name"), 1, 300);
        switch ($_arr_cateName["status"]) {
            case "too_short":
                return array(
                    "alert" => "x110201",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x110202",
                );
            break;

            case "ok":
                $this->cateSubmit["cate_name"] = $_arr_cateName["str"];
            break;

        }

        $_arr_cateParentId = validateStr(fn_post("cate_parent_id"), 1, 0);
        switch ($_arr_cateParentId["status"]) {
            case "too_short":
                return array(
                    "alert" => "x110213",
                );
            break;

            case "ok":
                $this->cateSubmit["cate_parent_id"] = $_arr_cateParentId["str"];
            break;
        }

        if ($this->cateSubmit["cate_parent_id"] > 0 && $this->cateSubmit["cate_parent_id"] == $this->cateSubmit["cate_id"]) {
            return array(
                "alert" => "x110221",
            );
        }

        $_arr_cateRow = $this->mdl_read($this->cateSubmit["cate_name"], "cate_name", $this->cateSubmit["cate_id"], $this->cateSubmit["cate_parent_id"]);

        if ($_arr_cateRow["alert"] == "y110102") {
            return array(
                "alert" => "x110203",
            );
        }

        $_arr_cateAlias = validateStr(fn_post("cate_alias"), 0, 300, "str", "alphabetDigit");
        switch ($_arr_cateAlias["status"]) {
            case "too_long":
                return array(
                    "alert" => "x110204",
                );
            break;

            case "format_err":
                return array(
                    "alert" => "x110205",
                );
            break;

            case "ok":
                $this->cateSubmit["cate_alias"] = $_arr_cateAlias["str"];
            break;
        }

        if ($this->cateSubmit["cate_alias"]) {
            $_arr_cateRow = $this->mdl_read($this->cateSubmit["cate_alias"], "cate_alias", $this->cateSubmit["cate_id"], $this->cateSubmit["cate_parent_id"]);
            if ($_arr_cateRow["alert"] == "y110102") {
                return array(
                    "alert" => "x110206",
                );
            }
        }

        $_arr_cateLink = validateStr(fn_post("cate_link"), 0, 3000);
        switch ($_arr_cateLink["status"]) {
            case "too_long":
                return array(
                    "alert" => "x110211",
                );
            break;

            case "ok":
                $this->cateSubmit["cate_link"] = $_arr_cateLink["str"];
            break;
        }

        $_arr_cateTpl = validateStr(fn_post("cate_tpl"), 1, 0);
        switch ($_arr_cateTpl["status"]) {
            case "too_short":
                return array(
                    "alert" => "x110214",
                );
            break;

            case "ok":
                $this->cateSubmit["cate_tpl"] = $_arr_cateTpl["str"];
            break;

        }

        $_arr_cateType = validateStr(fn_post("cate_type"), 1, 0);
        switch ($_arr_cateType["status"]) {
            case "too_short":
                return array(
                    "alert" => "x110215",
                );
            break;

            case "ok":
                $this->cateSubmit["cate_type"] = $_arr_cateType["str"];
            break;

        }

        $_arr_cateStatus = validateStr(fn_post("cate_status"), 1, 0);
        switch ($_arr_cateStatus["status"]) {
            case "too_short":
                return array(
                    "alert" => "x110216",
                );
            break;

            case "ok":
                $this->cateSubmit["cate_status"] = $_arr_cateStatus["str"];
            break;

        }

        $_arr_cateDomain = validateStr(fn_post("cate_domain"), 0, 3000);
        switch ($_arr_cateDomain["status"]) {
            case "too_long":
                return array(
                    "alert" => "x110207",
                );
            break;

            case "format_err":
                return array(
                    "alert" => "x110208",
                );
            break;

            case "ok":
                $this->cateSubmit["cate_domain"] = $_arr_cateDomain["str"];
            break;
        }

        $this->cateSubmit["cate_content"]     = fn_post("cate_content");

        if (!$this->is_magic) {
            $this->cateSubmit["cate_content"]    = addslashes($this->cateSubmit["cate_content"]);
        }

        $this->cateSubmit["cate_perpage"]     = fn_getSafe(fn_post("cate_perpage"), "int", BG_SITE_PERPAGE);
        $this->cateSubmit["cate_ftp_host"]    = fn_getSafe(fn_post("cate_ftp_host"), "txt", "");
        $this->cateSubmit["cate_ftp_port"]    = fn_getSafe(fn_post("cate_ftp_port"), "txt", "");
        $this->cateSubmit["cate_ftp_user"]    = fn_getSafe(fn_post("cate_ftp_user"), "txt", "");
        $this->cateSubmit["cate_ftp_pass"]    = fn_getSafe(fn_post("cate_ftp_pass"), "txt", "");
        $this->cateSubmit["cate_ftp_path"]    = fn_getSafe(fn_post("cate_ftp_path"), "txt", "");

        $this->cateSubmit["alert"]            = "ok";

        return $this->cateSubmit;
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

        $_arr_cateIds = fn_post("cate_ids");

        if ($_arr_cateIds) {
            foreach ($_arr_cateIds as $_key=>$_value) {
                $_arr_cateIds[$_key] = fn_getSafe($_value, "int", 0);
            }
            $_str_alert = "ok";
        } else {
            $_str_alert = "x030202";
        }

        $this->cateIds = array(
            "alert"   => $_str_alert,
            "cate_ids"    => $_arr_cateIds
        );

        return $this->cateIds;
    }


    private function db_read($_num_cateId) {
        $_arr_cateSelect = array(
            "cate_id",
            "cate_name",
            "cate_alias",
            "cate_type",
            "cate_tpl",
            "cate_content",
            "cate_link",
            "cate_parent_id",
            "cate_domain",
            "cate_status",
        );

        $_str_sqlWhere    = "cate_id=" . $_num_cateId;

        $_arr_cateRows    = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_cateRows[0])) {
            $_arr_cateRow     = $_arr_cateRows[0];
        } else {
            return array(
                "alert" => "x110102", //不存在记录
            );
        }

        //if (!$this->is_magic) {
            $_arr_cateRow["cate_content"] = stripslashes($_arr_cateRow["cate_content"]);
        //}

        $_arr_cateRow["alert"]    = "y110102";

        return $_arr_cateRow;
    }


    private function url_process($_arr_cateRow) {
        $_str_cateUrlParent = "";

        if ($_arr_cateRow["cate_type"] == "link" && $_arr_cateRow["cate_link"]) {
            $_str_cateUrl = $_arr_cateRow["cate_link"];
        } else {
            switch (BG_VISIT_TYPE) {
                case "static":
                    foreach ($_arr_cateRow["cate_trees"] as $_key_tree=>$_value_tree) {
                        if ($_value_tree["cate_alias"]) {
                            $_str_cateUrlParent .= $_value_tree["cate_alias"] . "/";
                        } else {
                            $_str_cateUrlParent .= $_value_tree["cate_id"] . "/";
                        }
                    }

                    if ($_arr_cateRow["cate_trees"][0]["cate_domain"]) {
                        $_str_urlPrefix = $_arr_cateRow["cate_domain"] . "/";
                    } else {
                        $_str_urlPrefix = BG_URL_ROOT;
                    }

                    $_str_cateUrl      = $_str_urlPrefix . "cate/" . $_str_cateUrlParent;
                    $_str_pageAttach   = "page-";
                break;

                case "pstatic":
                    foreach ($_arr_cateRow["cate_trees"] as $_key_tree=>$_value_tree) {
                        if ($_value_tree["cate_alias"]) {
                            $_str_cateUrlParent .= $_value_tree["cate_alias"] . "/";
                        } else {
                            $_str_cateUrlParent .= $_value_tree["cate_id"] . "/";
                        }
                    }

                    if ($_arr_cateRow["cate_trees"][0]["cate_domain"]) {
                        $_str_urlPrefix = $_arr_cateRow["cate_domain"] . "/";
                    } else {
                        $_str_urlPrefix = BG_URL_ROOT;
                    }

                    $_str_cateUrl      = $_str_urlPrefix . "cate/" . $_str_cateUrlParent . "id-" . $_arr_cateRow["cate_id"] . "/";
                    $_str_pageAttach   = "page-";
                break;

                default:
                    if ($_arr_cateRow["cate_trees"][0]["cate_domain"]) {
                        $_str_urlPrefix = $_arr_cateRow["cate_domain"] . "/";
                    } else {
                        $_str_urlPrefix = BG_URL_ROOT;
                    }

                    $_str_cateUrl      = $_str_urlPrefix . "index.php?mod=cate&act_get=show&cate_id=" . $_arr_cateRow["cate_id"];
                    $_str_pageAttach   = "&page=";
                break;
            }
        }

        return array(
            "cate_url"       => $_str_cateUrl,
            "page_attach"    => $_str_pageAttach,
        );
    }


    private function ids_process($_arr_cateRows) {
        $_arr_ids = array();
        foreach ($_arr_cateRows as $_key=>$_value) {
            if ($_value["cate_id"] > 0) {
                $_arr_ids[] = $_value["cate_id"];
            }
            if ($_value["cate_childs"]) {
                $_arr_cate  = $this->ids_process($_value["cate_childs"]);
                $_arr_ids   = array_merge($_arr_cate, $_arr_ids);
            }
        }

        return $_arr_ids;
    }


    private function trees_process($_num_cateId) {
        $_arr_cateTrees     = array();
        $_arr_cateRow       = $this->db_read($_num_cateId);
        $_arr_cateTrees[]   = $_arr_cateRow;

        if ($_arr_cateRow["cate_parent_id"] > 0 && $_arr_cateRow["cate_parent_id"] != $_arr_cateRow["cate_id"]) {
            $_arr_cate = $this->trees_process($_arr_cateRow["cate_parent_id"]);
            $_arr_cateTrees   = array_merge($_arr_cate, $_arr_cateTrees);
        }

        return $_arr_cateTrees;
    }


    private function cache_row_process($num_cateId) {
        $_str_outPut = "<?php" . PHP_EOL;
        $_str_outPut .= "return array(" . PHP_EOL;

        $_arr_cateRow = $this->mdl_readPub($num_cateId);
        print_r($_arr_cateRow);

        $_str_outPut .= "\"alert\" => \"" . $_arr_cateRow["alert"] . "\"," . PHP_EOL;

        if ($_arr_cateRow["alert"] == "y110102" && $_arr_cateRow["cate_status"] == "show") {

            $_str_outPut .= "\"cate_id\" => " . $_arr_cateRow["cate_id"] . "," . PHP_EOL;
            $_str_outPut .= "\"cate_name\" => \"" . $_arr_cateRow["cate_name"] . "\"," . PHP_EOL;
            $_str_outPut .= "\"cate_alias\" => \"" . $_arr_cateRow["cate_alias"] . "\"," . PHP_EOL;
            $_str_outPut .= "\"cate_parent_id\" => " . $_arr_cateRow["cate_parent_id"] . "," . PHP_EOL;
            $_str_outPut .= "\"cate_perpage\" => " . $_arr_cateRow["cate_perpage"] . "," . PHP_EOL;
            $_str_outPut .= "\"cate_domain\" => \"" . $_arr_cateRow["cate_domain"] . "\"," . PHP_EOL;
            $_str_outPut .= "\"cate_status\" => \"" . $_arr_cateRow["cate_status"] . "\"," . PHP_EOL;
            $_str_outPut .= "\"cate_type\" => \"" . $_arr_cateRow["cate_type"] . "\"," . PHP_EOL;

            $_str_tplDo    = $this->tpl_process($_arr_cateRow["cate_id"]);
            $_str_outPut  .= "\"cate_tplDo\" => \"" . $_str_tplDo . "\"," . PHP_EOL;

            //if (!$this->is_magic) {
                $_arr_cateRow["cate_content"] = addslashes($_arr_cateRow["cate_content"]);
            //}

            $_str_outPut .= "\"cate_content\" => \"" . $_arr_cateRow["cate_content"] . "\"," . PHP_EOL;

            $_str_outPut .= "\"cate_ids\" => array(" . PHP_EOL;

                $_arr_ids   = $this->mdl_ids($_arr_cateRow["cate_id"]);
                $_arr_ids[] = $_arr_cateRow["cate_id"];
                $_arr_ids   = array_unique($_arr_ids);

                foreach ($_arr_ids as $_key_ids=>$_value_ids) {
                    $_str_outPut .= $_value_ids . "," . PHP_EOL;
                }

            $_str_outPut .= ")," . PHP_EOL;

            $_str_outPut .= "\"urlRow\" => array(" . PHP_EOL;
                $_str_outPut .= "\"cate_url\" => \"" . $_arr_cateRow["urlRow"]["cate_url"] . "\"," . PHP_EOL;
                $_str_outPut .= "\"page_attach\" => \"" . $_arr_cateRow["urlRow"]["page_attach"] . "\"," . PHP_EOL;
            $_str_outPut .= ")," . PHP_EOL;

            if (is_array($_arr_cateRow["cate_trees"])) {
                $_str_outPut .= "\"cate_trees\" => array(" . PHP_EOL;
                foreach ($_arr_cateRow["cate_trees"] as $_key_tree=>$_value_tree) {
                    $_arr_cate = $this->mdl_readPub($_value_tree["cate_id"]);
                    $_str_outPut .= $_key_tree . " => array(" . PHP_EOL;

                    if ($_arr_cate["alert"] == "y110102" && $_arr_cate["cate_status"] == "show") {
                        //$_arr_cateRow["cate_trees"][$_key_tree]["urlRow"] = $_arr_cate["urlRow"];

                        $_str_outPut .= "\"cate_id\" => " . $_arr_cate["cate_id"] . "," . PHP_EOL;
                        $_str_outPut .= "\"cate_name\" => \"" . $_arr_cate["cate_name"] . "\"," . PHP_EOL;
                        $_str_outPut .= "\"cate_alias\" => \"" . $_arr_cate["cate_alias"] . "\"," . PHP_EOL;
                        $_str_outPut .= "\"cate_domain\" => \"" . $_arr_cate["cate_domain"] . "\"," . PHP_EOL;

                        $_str_outPut .= "\"urlRow\" => array(" . PHP_EOL;
                            $_str_outPut .= "\"cate_url\" => \"" . $_arr_cate["urlRow"]["cate_url"] . "\"," . PHP_EOL;
                            $_str_outPut .= "\"page_attach\" => \"" . $_arr_cate["urlRow"]["page_attach"] . "\"," . PHP_EOL;
                        $_str_outPut .= ")," . PHP_EOL;

                    }

                    $_str_outPut .= ")," . PHP_EOL;
                }
                $_str_outPut .= ")," . PHP_EOL;
            }
        }
        $_str_outPut .= ");";

        return $_str_outPut;
    }

    private function cache_tree_process($_arr_cateRows) {
        $_str_outPut = "";

        foreach ($_arr_cateRows as $_key=>$_value) {
            $_str_outPut .= $_value["cate_id"] . " => array(" . PHP_EOL;
                $_str_outPut .= "\"cate_id\" => " . $_value["cate_id"] . "," . PHP_EOL;
                $_str_outPut .= "\"cate_name\" => \"" . $_value["cate_name"] . "\"," . PHP_EOL;
                $_str_outPut .= "\"cate_alias\" => \"" . $_value["cate_alias"] . "\"," . PHP_EOL;
                $_str_outPut .= "\"cate_parent_id\" => " . $_value["cate_parent_id"] . "," . PHP_EOL;

                $_str_outPut .= "\"urlRow\" => array(" . PHP_EOL;
                    $_str_outPut .= "\"cate_url\" => \"" . $_value["urlRow"]["cate_url"] . "\"," . PHP_EOL;
                    $_str_outPut .= "\"page_attach\" => \"" . $_value["urlRow"]["page_attach"] . "\"," . PHP_EOL;
                $_str_outPut .= ")," . PHP_EOL;

                if ($_value["cate_childs"]) {
                    $_str_childs = $this->cache_tree_process($_value["cate_childs"]);
                    $_str_outPut .= "\"cate_childs\" => array(" . PHP_EOL;
                    $_str_outPut .= $_str_childs . PHP_EOL;
                    $_str_outPut .= ")," . PHP_EOL;
                }

            $_str_outPut .= ")," . PHP_EOL;
        }

        return $_str_outPut;
    }


    function tpl_process($num_cateId) {
        if(defined("BG_SITE_TPL")) {
            $_str_tpl = BG_SITE_TPL;
        } else {
            $_str_tpl = "default";
        }

        $_arr_cateRow = $this->mdl_readPub($num_cateId);
        if ($_arr_cateRow["alert"] == "y110102" && $_arr_cateRow["cate_status"] == "show") {
            $_str_cateTpl = $_arr_cateRow["cate_tpl"];

            if ($_str_cateTpl == "inherit" && $_arr_cateRow["cate_parent_id"] > 0) {
                $_str_cateTpl = $this->tpl_process($_arr_cateRow["cate_parent_id"]);
            }
        } else {
            $_str_cateTpl = BG_SITE_TPL;
        }

        if ($_str_cateTpl == "inherit") {
            $_str_cateTpl = $_str_tpl;
        } else {
            $_str_cateTpl = $_str_cateTpl;
        }
        if (!$_str_cateTpl) {
            $_str_cateTpl = $_str_tpl;
        }

        return $_str_cateTpl;
    }


    private function sql_process($arr_search = array()) {
        if (!isset($arr_search["parent_id"])) {
            $_str_sqlWhere = "cate_parent_id=0";
        } else {
            $_str_sqlWhere = "cate_parent_id=" . $arr_search["parent_id"];
        }

        if (isset($arr_search["status"]) && $arr_search["status"]) {
            $_str_sqlWhere .= " AND cate_status='" . $arr_search["status"] . "'";
        }

        if (isset($arr_search["type"]) && $arr_search["type"]) {
            $_str_sqlWhere .= " AND cate_type='" . $arr_search["type"] . "'";
        }

        if (isset($arr_search["excepts"]) && $arr_search["excepts"]) {
            $_str_excepts    = implode(",", $arr_search["excepts"]);
            $_str_sqlWhere  .= " AND cate_id NOT IN (" . $_str_excepts . ")";
        }

        return $_str_sqlWhere;
    }
}
