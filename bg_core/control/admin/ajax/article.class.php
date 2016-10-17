<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "article.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "cate.class.php");
include_once(BG_PATH_MODEL . "cateBelong.class.php");
include_once(BG_PATH_MODEL . "tag.class.php");
include_once(BG_PATH_MODEL . "tagBelong.class.php");
include_once(BG_PATH_MODEL . "spec.class.php");
include_once(BG_PATH_MODEL . "specBelong.class.php");
include_once(BG_PATH_MODEL . "custom.class.php");

/*-------------文章类-------------*/
class AJAX_ARTICLE {

    private $obj_base;
    private $config;
    private $adminLogged;
    private $obj_tpl;
    private $mdl_article;
    private $mdl_cate;
    private $mdl_cateBelong;
    private $allowCateIds;
    private $is_super = false;

    function __construct() { //构造函数
        $this->adminLogged      = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax         = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->mdl_article      = new MODEL_ARTICLE(); //设置文章对象
        $this->mdl_cate         = new MODEL_CATE();
        $this->mdl_cateBelong   = new MODEL_CATE_BELONG();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_tagBelong    = new MODEL_TAG_BELONG();
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_specBelong   = new MODEL_SPEC_BELONG();
        $this->mdl_custom       = new MODEL_CUSTOM();

        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        if (is_array($this->adminLogged["admin_allow_cate"])) {
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
        } else {
            $this->allowCateIds["add"]       = array();
            $this->allowCateIds["edit"]      = array();
            $this->allowCateIds["del"]       = array();
            $this->allowCateIds["approve"]   = array();
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            include_once(BG_PATH_MODEL . "articlePub.class.php");
            include_once(BG_PATH_MODEL . "attach.class.php");
            include_once(BG_PATH_MODEL . "thumb.class.php");
            include_once(BG_PATH_CLASS . "tpl.class.php");
            include_once(BG_PATH_FUNC . "callDisplay.func.php");
            include_once(BG_PATH_FUNC . "callAttach.func.php");
            include_once(BG_PATH_FUNC . "callCate.func.php");
            include_once(BG_PATH_FUNC . "ubb.func.php");
            include_once(BG_PATH_CONTROL . "admin/gen/article.class.php");
            $this->obj_dir      = new CLASS_DIR();
            $this->gen_article  = new GEN_ARTICLE();
        }

        if (BG_MODULE_FTP > 0) {
            include_once(BG_PATH_CLASS . "ftp.class.php"); //载入 FTP 类
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
    }


    function ajax_primary() {
        //从表单获取数据
        $_arr_articleAttach = $this->mdl_article->input_primary();
        if ($_arr_articleAttach["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_articleAttach["alert"]);
        }

        //判断权限
        if (!isset($this->group_allow["article"]["edit"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_articleAttach["article_cate_id"]]["edit"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x120303");
        }

        $_arr_articleRow  = $this->mdl_article->mdl_primary();

        $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ajax_submit() {
        //从表单获取数据
        $_arr_cateIds = array();
        $_arr_tagIds  = array();
        $_arr_specIds = array();

        $_arr_articleSubmit = $this->mdl_article->input_submit();
        if ($_arr_articleSubmit["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_articleSubmit["alert"]);
        }

        foreach ($_arr_articleSubmit["cate_ids"] as $_key=>$_value) {
            $_arr_cateRow = $this->mdl_cate->mdl_read($_value);
            if ($_arr_cateRow["alert"] != "y110102") {
                $this->obj_ajax->halt_alert($_arr_cateRow["alert"]);
            }
            if ($_arr_cateRow["cate_type"] != "normal") {
                $this->obj_ajax->halt_alert("x110222");
            }
        }

        if ($_arr_articleSubmit["article_id"] > 0) {
            //判断权限
            if (!isset($this->group_allow["article"]["edit"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_articleSubmit["article_cate_id"]]["edit"]) && !$this->is_super) {
                $this->obj_ajax->halt_alert("x120303");
            }
            foreach ($_arr_articleSubmit["cate_ids"] as $_key=>$_value) {
                if (($this->allowCateIds["edit"] && in_array($_value, $this->allowCateIds["edit"])) || isset($this->group_allow["article"]["edit"]) || $this->is_super) {
                    $_arr_cateIds[] = $_value;
                }
            }
        } else {
            if (!isset($this->group_allow["article"]["add"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_articleSubmit["article_cate_id"]]["add"]) && !$this->is_super) {
                $this->obj_ajax->halt_alert("x120302");
            }
            foreach ($_arr_articleSubmit["cate_ids"] as $_key=>$_value) {
                if (($this->allowCateIds["add"] && in_array($_value, $this->allowCateIds["add"])) || isset($this->group_allow["article"]["add"]) || $this->is_super) {
                    $_arr_cateIds[] = $_value;
                }
            }
        }

        if (isset($this->group_allow["article"]["approve"]) || isset($this->adminLogged["admin_allow_cate"][$_arr_articleSubmit["article_cate_id"]]["approve"]) || $this->is_super) {
            $_str_status = $_arr_articleSubmit["article_status"];
        } else {
            $_str_status = "wait";
        }

        $_arr_articleRow = $this->mdl_article->mdl_submit($this->adminLogged["admin_id"], $_str_status);

        foreach ($_arr_articleSubmit["article_tags"] as $_key=>$_value) {
            $_value = trim($_value);
            if (!fn_isEmpty($_value)) {
                $_arr_tagRow = $this->mdl_tag->mdl_read($_value, "tag_name");
                if ($_arr_tagRow["alert"] == "y130102") {
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

        foreach ($_arr_articleSubmit["article_spec_ids"] as $_key=>$_value) {
            $_value = trim($_value);
            if (!fn_isEmpty($_value) && is_numeric($_value)) {
                $_arr_specRow = $this->mdl_spec->mdl_read($_value);
                if ($_arr_specRow["alert"] == "y180102") {
                    $_arr_specIds[] = $_arr_specRow["spec_id"];
                }
            }
        }

        if ($_arr_articleSubmit["article_id"] > 0) {
            $_belong               = $this->belong_submit($_arr_articleSubmit["article_id"], $_arr_cateIds, $_arr_tagIds, $_arr_specIds);
            $_arr_cateBelongDel    = $this->mdl_cateBelong->mdl_del(0, $_arr_articleSubmit["article_id"], false, false, $_arr_cateIds);
            if ($_arr_tagIds) {
                $_arr_tagBelongDel = $this->mdl_tagBelong->mdl_del(0, $_arr_articleSubmit["article_id"], false, false, $_arr_tagIds);
            } else {
                $_arr_tagBelongDel = $this->mdl_tagBelong->mdl_del(0, $_arr_articleSubmit["article_id"]);
            }
            if ($_arr_specIds) {
                $_arr_specBelongDel = $this->mdl_specBelong->mdl_del(0, $_arr_articleSubmit["article_id"], false, false, $_arr_specIds);
            } else {
                $_arr_specBelongDel = $this->mdl_specBelong->mdl_del(0, $_arr_articleSubmit["article_id"]);
            }
        } else {
            $_belong               = $this->belong_submit($_arr_articleRow["article_id"], $_arr_cateIds, $_arr_tagIds, $_arr_specIds);
        }

        if ($_arr_articleRow["alert"] == "x120103") {
            if (isset($_belong) || (isset($_arr_cateBelongDel["alert"]) && $_arr_cateBelongDel["alert"] == "y150104") || (isset($_arr_tagBelongDel["alert"]) && $_arr_tagBelongDel["alert"] == "y160104") || (isset($_arr_specBelongDel["alert"]) && $_arr_specBelongDel["alert"] == "y230104")) {
                $_arr_articleRow["alert"] = "y120103";
            }
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            if ($_arr_articleRow["article_id"] > 0) {
                $this->gen_article->gen_single($_arr_articleRow["article_id"]);
            }
        }

        $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
    }


    /**
     * ajax_top function.
     *
     * @access public
     * @return void
     */
    function ajax_top() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_articleIds["alert"]);
        }

        $_str_articleStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");

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

        $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ajax_status() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_articleIds["alert"]);
        }

        $_str_articleStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");

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

        $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
    }


    /**
     * ajax_box function.
     *
     * @access public
     * @return void
     */
    function ajax_box() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_articleIds["alert"]);
        }

        $_str_articleBox = fn_getSafe($GLOBALS["act_post"], "txt", "");

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

        $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_articleIds["alert"]);
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

        $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
    }


    /**
     * ajax_empty function.
     *
     * @access public
     * @return void
     */
    function ajax_empty() {
        $_arr_articleRow = $this->mdl_article->mdl_empty($this->adminLogged["admin_id"]);

        $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
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
        if (is_array($arr_cateIds)) {
            foreach ($arr_cateIds as $_key=>$_value) {
                if (!fn_isEmpty($_value)) {
                    $_arr_cateBelongRow = $this->mdl_cateBelong->mdl_submit($num_articleId, $_value);
                    if (!$_is_submit && $_arr_cateBelongRow["alert"] == "y150101") {
                        $_is_submit = true;
                    }
                }
            }
        }

        if (is_array($arr_tagIds)) {
            foreach ($arr_tagIds as $_key=>$_value) {
                if (!fn_isEmpty($_value)) {
                    $_arr_tagBelongRow = $this->mdl_tagBelong->mdl_submit($num_articleId, $_value);
                    if (!$_is_submit && $_arr_tagBelongRow["alert"] == "y160101") {
                        $_is_submit = true;
                    }
                }
            }
        }

        if (is_array($arr_specIds)) {
            foreach ($arr_specIds as $_key=>$_value) {
                if (!fn_isEmpty($_value)) {
                    $_arr_specBelongRow = $this->mdl_specBelong->mdl_submit($num_articleId, $_value);
                    if (!$_is_submit && $_arr_specBelongRow["alert"] == "y230101") {
                        $_is_submit = true;
                    }
                }
            }
        }

        return $_is_submit;
    }
}
