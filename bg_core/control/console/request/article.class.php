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
class CONTROL_CONSOLE_REQUEST_ARTICLE {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->obj_console      = new CLASS_CONSOLE();
        $this->obj_console->dspType = "result";
        $this->obj_console->chk_install();

        $this->adminLogged      = $this->obj_console->ssin_begin();
        $this->obj_console->is_admin($this->adminLogged);

        $this->obj_tpl          = $this->obj_console->obj_tpl;

        if (fn_isEmpty($this->adminLogged["admin_allow_cate"])) {
            $this->allowCateIds["add"]       = array();
            $this->allowCateIds["edit"]      = array();
            $this->allowCateIds["del"]       = array();
            $this->allowCateIds["approve"]   = array();
        } else {
            foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
                if (isset($_value["add"])) {
                    $this->allowCateIds["add"][]       = $_key;
                }
                if (isset($_value["edit"])) {
                    $this->allowCateIds["edit"][]      = $_key;
                }
                if (isset($_value["del"])) {
                    $this->allowCateIds["del"][]       = $_key;
                }
                if (isset($_value["approve"])) {
                    $this->allowCateIds["approve"][]   = $_key;
                }
            }
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            require(BG_PATH_FUNC . "callDisplay.func.php");
            require(BG_PATH_FUNC . "callAttach.func.php");
            require(BG_PATH_FUNC . "callCate.func.php");
            require(BG_PATH_FUNC . "ubb.func.php");
            $this->obj_dir          = new CLASS_DIR();
            $this->ctrl_gen_article = new CONTROL_CONSOLE_GEN_ARTICLE();
        }

        if (BG_MODULE_FTP > 0) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        if (isset($this->adminLogged["groupRow"]["group_allow"])) {
            $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
        }

        $this->mdl_article      = new MODEL_ARTICLE(); //设置文章对象
        $this->mdl_cate         = new MODEL_CATE();
        $this->mdl_cateBelong   = new MODEL_CATE_BELONG();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_tagBelong    = new MODEL_TAG_BELONG();
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_specBelong   = new MODEL_SPEC_BELONG();
        $this->mdl_custom       = new MODEL_CUSTOM();
    }


    function ctrl_primary() {
        //从表单获取数据
        $_arr_articleAttach = $this->mdl_article->input_primary();
        if ($_arr_articleAttach["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleAttach);
        }

        //判断权限
        if (!isset($this->group_allow["article"]["edit"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_articleAttach["article_cate_id"]]["edit"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x120303",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_articleRow  = $this->mdl_article->mdl_primary();

        $this->obj_tpl->tplDisplay("result", $_arr_articleRow);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        //从表单获取数据
        $_arr_cateIds = array();
        $_arr_tagIds  = array();
        $_arr_specIds = array();

        $_arr_articleInput = $this->mdl_article->input_submit();
        if ($_arr_articleInput["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleInput);
        }

        foreach ($_arr_articleInput["article_cate_ids"] as $_key=>$_value) {
            $_arr_cateRow = $this->mdl_cate->mdl_read($_value);
            if ($_arr_cateRow["rcode"] != "y250102") {
                $this->obj_tpl->tplDisplay("result", $_arr_cateRow);
            }
            if ($_arr_cateRow["cate_type"] != "normal") {
                $_arr_tplData = array(
                    "rcode" => "x250222",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
        }

        if ($_arr_articleInput["article_id"] > 0) {
            //判断权限
            if (!isset($this->group_allow["article"]["edit"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_articleInput["article_cate_id"]]["edit"]) && !$this->is_super) {
                $_arr_tplData = array(
                    "rcode" => "x120303",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
            foreach ($_arr_articleInput["article_cate_ids"] as $_key=>$_value) {
                if ((isset($this->allowCateIds["edit"]) && in_array($_value, $this->allowCateIds["edit"])) || isset($this->group_allow["article"]["edit"]) || $this->is_super) {
                    $_arr_cateIds[] = $_value;
                }
            }
        } else {
            if (!isset($this->group_allow["article"]["add"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_articleInput["article_cate_id"]]["add"]) && !$this->is_super) {
                $_arr_tplData = array(
                    "rcode" => "x120302",
                );
                $this->obj_tpl->tplDisplay("result", $_arr_tplData);
            }
            foreach ($_arr_articleInput["article_cate_ids"] as $_key=>$_value) {
                if ((isset($this->allowCateIds["add"]) && in_array($_value, $this->allowCateIds["add"])) || isset($this->group_allow["article"]["add"]) || $this->is_super) {
                    $_arr_cateIds[] = $_value;
                }
            }
        }

        if (isset($this->group_allow["article"]["approve"]) || isset($this->adminLogged["admin_allow_cate"][$_arr_articleInput["article_cate_id"]]["approve"]) || $this->is_super) {
            $_str_status = $_arr_articleInput["article_status"];
        } else {
            $_str_status = "wait";
        }

        $_arr_articleRow = $this->mdl_article->mdl_submit($this->adminLogged["admin_id"], $_str_status);

        foreach ($_arr_articleInput["article_tags"] as $_key=>$_value) {
            $_value = trim($_value);
            if (!fn_isEmpty($_value)) {
                $_arr_tagRow = $this->mdl_tag->mdl_read($_value, "tag_name");
                if ($_arr_tagRow["rcode"] == "y130102") {
                    $_arr_tagIds[]      = $_arr_tagRow["tag_id"];
                    //统计 tag 文章数
                    $_num_articleCount  = $this->mdl_tagBelong->mdl_count($_arr_tagRow["tag_id"]);
                    $this->mdl_tag->mdl_countDo($_arr_tagRow["tag_id"], $_num_articleCount); //更新
                } else {
                    $_arr_tagRow    = $this->mdl_tag->mdl_submit($_value, "show");
                    $_arr_tagIds[]  = $_arr_tagRow["tag_id"];
                }
            }
        }

        foreach ($_arr_articleInput["article_spec_ids"] as $_key=>$_value) {
            $_value = trim($_value);
            if (!fn_isEmpty($_value) && is_numeric($_value)) {
                $_arr_specRow = $this->mdl_spec->mdl_read($_value);
                if ($_arr_specRow["rcode"] == "y180102") {
                    $_arr_specIds[] = $_arr_specRow["spec_id"];
                }
            }
        }

        if ($_arr_articleInput["article_id"] > 0) {
            $_belong               = $this->belong_submit($_arr_articleInput["article_id"], $_arr_cateIds, $_arr_tagIds, $_arr_specIds);
            $_arr_cateBelongDel    = $this->mdl_cateBelong->mdl_del(0, $_arr_articleInput["article_id"], false, false, $_arr_cateIds);
            if (fn_isEmpty($_arr_tagIds)) {
                $_arr_tagBelongDel = $this->mdl_tagBelong->mdl_del(0, $_arr_articleInput["article_id"]);
            } else {
                $_arr_tagBelongDel = $this->mdl_tagBelong->mdl_del(0, $_arr_articleInput["article_id"], false, false, $_arr_tagIds);
            }
            if (fn_isEmpty($_arr_specIds)) {
                $_arr_specBelongDel = $this->mdl_specBelong->mdl_del(0, $_arr_articleInput["article_id"]);
            } else {
                $_arr_specBelongDel = $this->mdl_specBelong->mdl_del(0, $_arr_articleInput["article_id"], false, false, $_arr_specIds);
            }
        } else {
            $_belong               = $this->belong_submit($_arr_articleRow["article_id"], $_arr_cateIds, $_arr_tagIds, $_arr_specIds);
        }

        if ($_arr_articleRow["rcode"] == "x120103") {
            if (isset($_belong) || (isset($_arr_cateBelongDel["rcode"]) && $_arr_cateBelongDel["rcode"] == "y150104") || (isset($_arr_tagBelongDel["rcode"]) && $_arr_tagBelongDel["rcode"] == "y160104") || (isset($_arr_specBelongDel["rcode"]) && $_arr_specBelongDel["rcode"] == "y230104")) {
                $_arr_articleRow["rcode"] = "y120103";
            }
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            if ($_arr_articleRow["article_id"] > 0) {
                $this->ctrl_gen_article->ctrl_single($_arr_articleRow["article_id"], false);
            }
        }

        $this->obj_tpl->tplDisplay("result", $_arr_articleRow);
    }


    function ctrl_move() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleIds);
        }

        $_num_cateId = fn_getSafe(fn_post("cate_id"), "int", 0);
        if ($_num_cateId < 1) {
            $_arr_tplData = array(
                "rcode" => "x250225",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);
        if ($_arr_cateRow["rcode"] != "y250102") {
            $this->obj_tpl->tplDisplay("result", $_arr_cateRow);
        }
        if ($_arr_cateRow["cate_type"] != "normal") {
            $_arr_tplData = array(
                "rcode" => "x250222",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        if (isset($this->group_allow["article"]["approve"]) || $this->is_super) {
            $_arr_cateId = false;
        } else {
            foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
                if (isset($_value["approve"])) {
                    $_arr_cateId[] = $_key;
                }
            }
        }

        $_arr_articleRow = $this->mdl_article->mdl_move($_num_cateId, $_arr_cateId);

        $this->obj_tpl->tplDisplay("result", $_arr_articleRow);
    }


    /**
     * ajax_top function.
     *
     * @access public
     * @return void
     */
    function ctrl_top() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleIds);
        }

        $_str_articleStatus = fn_getSafe($GLOBALS["act"], "txt", "");

        switch ($_str_articleStatus) {
            case "top":
                $_num_articleTop = 1;
            break;

            default:
                $_num_articleTop = 0;
            break;
        }

        if (isset($this->group_allow["article"]["approve"]) || $this->is_super) {
            $_arr_cateId = false;
        } else {
            foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
                if (isset($_value["approve"])) {
                    $_arr_cateId[] = $_key;
                }
            }
        }

        $_arr_articleRow = $this->mdl_article->mdl_top($_num_articleTop, $_arr_cateId);

        $this->obj_tpl->tplDisplay("result", $_arr_articleRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleIds);
        }

        $_str_articleStatus = fn_getSafe($GLOBALS["act"], "txt", "");

        if (isset($this->group_allow["article"]["approve"]) || $this->is_super) {
            $_arr_cateId     = false;
            $_num_adminId    = 0;
        } else {
            $_arr_cateId     = array();
            foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
                if (isset($_value["approve"])) {
                    $_arr_cateId[] = $_key;
                }
            }
            $_num_adminId = $this->adminLogged["admin_id"];
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            if ($_str_articleStatus != "pub") {
                $_arr_search = array(
                    "article_ids" => $_arr_articleIds["article_ids"],
                );
                $_arr_articleRows = $this->mdl_article->mdl_list(1000, 0, $_arr_search);
                foreach ($_arr_articleRows as $_key=>$_value) {
                    $_arr_urlRow = $this->mdl_cate->article_url_process($_value);
                    $this->obj_dir->del_file($_arr_urlRow["article_pathFull"]);

                    if (defined("BG_MODULE_FTP") && BG_MODULE_FTP > 0) {
                        $_arr_cateRow   = $this->mdl_cate->mdl_readPub($_value["article_cate_id"]);
                        $_arr_ftpRow    = $this->mdl_cate->mdl_read($_arr_cateRow["cate_trees"][0]["cate_id"]);
                        if (isset($_arr_ftpRow["cate_ftp_host"]) && !fn_isEmpty($_arr_ftpRow["cate_ftp_host"])) {
                            if ($_arr_ftpRow["cate_ftp_pasv"] == "on") {
                                $_bool_pasv = true;
                            } else {
                                $_bool_pasv = false;
                            }
                            $this->ftp_status_conn  = $this->obj_ftp->ftp_conn($_arr_ftpRow["cate_ftp_host"], $_arr_ftpRow["cate_ftp_port"]);
                            $this->ftp_status_login = $this->obj_ftp->ftp_login($_arr_ftpRow["cate_ftp_user"], $_arr_ftpRow["cate_ftp_pass"], $_bool_pasv);

                            $this->obj_ftp->del_file($_arr_ftpRow["cate_ftp_path"] . $_arr_urlRow["article_pathShort"]);
                        }
                    }
                }
            }
        }

        $_arr_articleRow = $this->mdl_article->mdl_status($_str_articleStatus, $_arr_cateId, $_num_adminId);

        $this->obj_tpl->tplDisplay("result", $_arr_articleRow);
    }


    /**
     * ajax_box function.
     *
     * @access public
     * @return void
     */
    function ctrl_box() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleIds);
        }

        $_str_articleBox = fn_getSafe($GLOBALS["act"], "txt", "");

        if (isset($this->group_allow["article"]["edit"]) || $this->is_super) {
            $_arr_cateId     = false;
            $_num_adminId    = 0;
        } else {
            $_arr_cateId     = array();
            foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
                if (isset($_value["edit"])) {
                    $_arr_cateId[] = $_key;
                }
            }
            $_num_adminId = $this->adminLogged["admin_id"];
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            if ($_str_articleBox != "normal") {
                $_arr_search = array(
                    "article_ids" => $_arr_articleIds["article_ids"],
                );
                $_arr_articleRows = $this->mdl_article->mdl_list(1000, 0, $_arr_search);
                foreach ($_arr_articleRows as $_key=>$_value) {
                    $_arr_urlRow = $this->mdl_cate->article_url_process($_value);
                    $this->obj_dir->del_file($_arr_urlRow["article_pathFull"]);

                    if (defined("BG_MODULE_FTP") && BG_MODULE_FTP > 0) {
                        $_arr_cateRow   = $this->mdl_cate->mdl_readPub($_value["article_cate_id"]);
                        $_arr_ftpRow    = $this->mdl_cate->mdl_read($_arr_cateRow["cate_trees"][0]["cate_id"]);
                        if (isset($_arr_ftpRow["cate_ftp_host"]) && !fn_isEmpty($_arr_ftpRow["cate_ftp_host"])) {
                            if ($_arr_ftpRow["cate_ftp_pasv"] == "on") {
                                $_bool_pasv = true;
                            } else {
                                $_bool_pasv = false;
                            }
                            $this->ftp_status_conn  = $this->obj_ftp->ftp_conn($_arr_ftpRow["cate_ftp_host"], $_arr_ftpRow["cate_ftp_port"]);
                            $this->ftp_status_login = $this->obj_ftp->ftp_login($_arr_ftpRow["cate_ftp_user"], $_arr_ftpRow["cate_ftp_pass"], $_bool_pasv);

                            $this->obj_ftp->del_file($_arr_ftpRow["cate_ftp_path"] . $_arr_urlRow["article_pathShort"]);
                        }
                    }
                }
            }
        }

        $_arr_articleRow = $this->mdl_article->mdl_box($_str_articleBox, $_arr_cateId, $_num_adminId);

        $this->obj_tpl->tplDisplay("result", $_arr_articleRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleIds);
        }

        if (isset($this->group_allow["article"]["del"]) || $this->is_super) {
            $_arr_cateId     = false;
            $_num_adminId    = 0;
        } else {
            foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
                if (isset($_value["del"])) {
                    $_arr_cateId[] = $_key;
                }
            }
            $_num_adminId = $this->adminLogged["admin_id"];
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            $_arr_search = array(
                "article_ids" => $_arr_articleIds["article_ids"],
            );
            $_arr_articleRows = $this->mdl_article->mdl_list(1000, 0, $_arr_search);
            foreach ($_arr_articleRows as $_key=>$_value) {
                $_arr_urlRow = $this->mdl_cate->article_url_process($_value);
                $this->obj_dir->del_file($_arr_urlRow["article_pathFull"]);

                if (defined("BG_MODULE_FTP") && BG_MODULE_FTP > 0) {
                    $_arr_cateRow   = $this->mdl_cate->mdl_readPub($_value["article_cate_id"]);
                    $_arr_ftpRow    = $this->mdl_cate->mdl_read($_arr_cateRow["cate_trees"][0]["cate_id"]);
                    if (isset($_arr_ftpRow["cate_ftp_host"]) && !fn_isEmpty($_arr_ftpRow["cate_ftp_host"])) {
                        if ($_arr_ftpRow["cate_ftp_pasv"] == "on") {
                            $_bool_pasv = true;
                        } else {
                            $_bool_pasv = false;
                        }
                        $this->ftp_status_conn  = $this->obj_ftp->ftp_conn($_arr_ftpRow["cate_ftp_host"], $_arr_ftpRow["cate_ftp_port"]);
                        $this->ftp_status_login = $this->obj_ftp->ftp_login($_arr_ftpRow["cate_ftp_user"], $_arr_ftpRow["cate_ftp_pass"], $_bool_pasv);

                        $this->obj_ftp->del_file($_arr_ftpRow["cate_ftp_path"] . $_arr_urlRow["article_pathShort"]);
                    }
                }
            }
        }

        $_arr_articleRow = $this->mdl_article->mdl_del($_arr_cateId, $_num_adminId);

        $this->mdl_cateBelong->mdl_del(0, 0, 0, $_arr_articleIds["article_ids"]);
        $this->mdl_tagBelong->mdl_del(0, 0, 0, $_arr_articleIds["article_ids"]);
        $this->mdl_specBelong->mdl_del(0, 0, 0, $_arr_articleIds["article_ids"]);

        $this->obj_tpl->tplDisplay("result", $_arr_articleRow);
    }


    /**
     * ajax_empty function.
     *
     * @access public
     * @return void
     */
    function ctrl_empty() {
        $_arr_articleRow = $this->mdl_article->mdl_empty($this->adminLogged["admin_id"]);

        $this->obj_tpl->tplDisplay("result", $_arr_articleRow);
    }


    /**
     * belong_submit function.
     *
     * @access private
     * @param mixed $num_articleId
     * @param mixed $_arr_cateIds
     * @param mixed $_arr_tagIds
     * @return void
     */
    private function belong_submit($num_articleId, $arr_cateIds, $arr_tagIds, $arr_specIds) {
        $_is_submit = false;
        if (!fn_isEmpty($arr_cateIds)) {
            foreach ($arr_cateIds as $_key=>$_value) {
                if (!fn_isEmpty($_value)) {
                    $_arr_cateBelongRow = $this->mdl_cateBelong->mdl_submit($num_articleId, $_value);
                    if (!$_is_submit && $_arr_cateBelongRow["rcode"] == "y150101") {
                        $_is_submit = true;
                    }
                }
            }
        }

        if (!fn_isEmpty($arr_tagIds)) {
            foreach ($arr_tagIds as $_key=>$_value) {
                if (!fn_isEmpty($_value)) {
                    $_arr_tagBelongRow = $this->mdl_tagBelong->mdl_submit($num_articleId, $_value);
                    if (!$_is_submit && $_arr_tagBelongRow["rcode"] == "y160101") {
                        $_is_submit = true;
                    }
                }
            }
        }

        if (!fn_isEmpty($arr_specIds)) {
            foreach ($arr_specIds as $_key=>$_value) {
                if (!fn_isEmpty($_value)) {
                    $_arr_specBelongRow = $this->mdl_specBelong->mdl_submit($num_articleId, $_value);
                    if (!$_is_submit && $_arr_specBelongRow["rcode"] == "y230101") {
                        $_is_submit = true;
                    }
                }
            }
        }

        return $_is_submit;
    }
}
