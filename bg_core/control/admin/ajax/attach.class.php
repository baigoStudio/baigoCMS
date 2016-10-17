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
if (BG_MODULE_FTP > 0) {
    include_once(BG_PATH_CLASS . "ftp.class.php"); //载入 FTP 类
}
include_once(BG_PATH_CLASS . "upload.class.php"); //载入上传类
include_once(BG_PATH_MODEL . "attach.class.php");
include_once(BG_PATH_MODEL . "thumb.class.php");
include_once(BG_PATH_MODEL . "mime.class.php");
include_once(BG_PATH_MODEL . "article.class.php");

/*-------------用户类-------------*/
class AJAX_ATTACH {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_attach;
    private $attachMime;
    private $is_super = false;

    function __construct() { //构造函数
        $this->adminLogged  = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_ajax     = new CLASS_AJAX();
        $this->obj_ajax->chk_install();
        $this->obj_upload   = new CLASS_UPLOAD();
        $this->mdl_attach   = new MODEL_ATTACH();
        $this->mdl_thumb    = new MODEL_THUMB();
        $this->mdl_mime     = new MODEL_MIME();
        $this->mdl_admin    = new MODEL_ADMIN();
        $this->mdl_article  = new MODEL_ARTICLE(); //设置文章对象
        $this->setUpload();

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
    }


    function ajax_gen() {
        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->show_err($this->adminLogged["alert"], "err");
        }

        if (!isset($this->group_allow["attach"]["thumb"]) && !$this->is_super) {
            $this->show_err("x070304", "err");
        }

        $_num_thumbId     = fn_getSafe(fn_post("thumb_id"), "int", 0);
        $_arr_attachId    = fn_post("attach_range");

        $_arr_search = array(
            "min_id"    => fn_getSafe($_arr_attachId["min_id"], "int", 0),
            "max_id"    => fn_getSafe($_arr_attachId["max_id"], "int", 0),
        );

        if ($_num_thumbId < 1) {
            $this->show_err("x090207", "err");
        }

        $_arr_thumbRow = $this->mdl_thumb->mdl_read($_num_thumbId);
        if ($_arr_thumbRow["alert"] != "y090102") {
            $this->show_err($_arr_thumbRow["alert"], "err");
        }

        $_arr_attachIds   = array();
        $_num_perPage     = 10;
        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_attachCount, $_num_perPage, "post");
        $_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, $_arr_page["except"], $_arr_search);

        //$_obj_finfo       = new finfo();

        $_str_status = "complete";
        $_str_msg    = $this->obj_ajax->alert["y070409"];

        if ($_arr_page["page"] <= $_arr_page["total"]) {
            foreach ($_arr_attachRows as $_key=>$_value) {
                if (file_exists($_value["attach_path"])) {
                    if ($_value["attach_type"] == "image") { //如果是图片，则生成缩略图

                        $this->obj_upload->thumb_do($_arr_thumbRow["thumb_width"], $_arr_thumbRow["thumb_height"], $_arr_thumbRow["thumb_type"], $_value);
                    }
                }
            }
            $_str_status = "loading";
            $_str_msg    = $this->obj_ajax->alert["x070409"];
        }

        $_arr_re = array(
            "page"   => $_arr_page["page"],
            "msg"    => $_str_msg,
            "count"  => $_arr_page["total"],
            "status" => $_str_status,
        );

        exit(json_encode($_arr_re));
    }


    function ajax_empty() {
        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->show_err($this->adminLogged["alert"], "err");
        }

        if (!isset($this->group_allow["attach"]["del"]) && !$this->is_super) {
            $this->show_err("x070304", "err");
        }

        if (!fn_token("chk")) { //令牌
            $this->show_err("x030206", "err");
        }

        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status["alert"] != "y070403") {
            $this->show_err($_arr_status["alert"], "err");
        }

        $_arr_search = array(
            "box" => "recycle",
        );

        $_arr_attachIds   = array();
        $_num_perPage     = 10;
        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_attachCount, $_num_perPage, "post");
        $_arr_attachRows  = $this->mdl_attach->mdl_list(1000, 0, $_arr_search);

        $_arr_search = array(
            "box"           => "recycle",
            "attach_ids"    => $_arr_attachIds,
        );

        if ($_num_attachCount > 0) {
            foreach ($_arr_attachRows as $_key=>$_value) {
                $_arr_attachIds[] = $_value["attach_id"];
            }

            $_arr_attachRows  = $this->mdl_attach->mdl_list(1000, 0, $_arr_search);
            //print_r($_arr_attachRows);
            $this->obj_upload->upload_del($_arr_attachRows);
            //exit;

            $_arr_attachDel  = $this->mdl_attach->mdl_del(0, $_arr_attachIds);
            $_str_status     = "loading";
            $_str_msg        = $this->obj_ajax->alert["x070408"];
        } else {
            $_str_status = "complete";
            $_str_msg    = $this->obj_ajax->alert["y070408"];
        }

        $_arr_re = array(
            "msg"    => $_str_msg,
            "count"  => $_arr_page["total"],
            "status" => $_str_status,
        );

        exit(json_encode($_arr_re));
    }


    function ajax_clear() {
        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->show_err($this->adminLogged["alert"], "err");
        }

        if (!isset($this->group_allow["attach"]["del"]) && !$this->is_super) {
            $this->show_err("x070304", "err");
        }

        $_num_maxId = fn_getSafe(fn_post("max_id"), "int", 0);

        $_arr_searchCount = array(
            "box"   => "normal",
        );

        $_arr_searchList = array(
            "box"       => "normal",
            "max_id"    => $_num_maxId,
        );

        $_num_perPage     = 10;
        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_searchCount);
        $_arr_page        = fn_page($_num_attachCount, $_num_perPage, "post");
        $_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, 0, $_arr_searchList);

        if ($_arr_attachRows) {
            foreach ($_arr_attachRows as $_key=>$_value) {
                $_arr_attachRow = $this->mdl_attach->mdl_chkAttach($_value["attach_id"], $_value["attach_ext"], $_value["attach_time"]);
                //print_r($_arr_attachRow);
                if ($_arr_attachRow["alert"] == "x070406") {
                    $this->mdl_attach->mdl_box("recycle", array($_value["attach_id"]));
                }
            }
            $_str_status    = "loading";
            $_str_msg       = $this->obj_ajax->alert["x070407"];
            $_num_maxId     = $_value["attach_id"];
        } else {
            $_str_status    = "complete";
            $_str_msg       = $this->obj_ajax->alert["y070407"];
        }

        $_arr_re = array(
            "msg"       => $_str_msg,
            "count"     => $_arr_page["total"],
            "max_id"    => $_num_maxId,
            "status"    => $_str_status,
        );

        exit(json_encode($_arr_re));
    }


    function ajax_box() {
        if (!isset($this->group_allow["attach"]["del"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x170303");
        }

        $_arr_attachIds = $this->mdl_attach->input_ids();
        if ($_arr_attachIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_attachIds["alert"]);
        }

        $_str_attachStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");

        $_arr_attachRow = $this->mdl_attach->mdl_box($_str_attachStatus);

        $this->obj_ajax->halt_alert($_arr_attachRow["alert"]);
    }

    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ajax_submit() {
        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->show_err($this->adminLogged["alert"]);
        }

        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status["alert"] != "y070403") {
            $this->show_err($_arr_status["alert"]);
        }

        if (!isset($this->group_allow["attach"]["upload"]) && !$this->is_super) {
            $this->show_err("x070302");
        }

        if (!fn_token("chk")) { //令牌
            $this->show_err("x030206");
        }

        if (!is_array($this->attachMime)) {
            $this->show_err("x070405");
        }

        $_arr_uploadRow = $this->obj_upload->upload_pre();

        if ($_arr_uploadRow["alert"] != "y100201") {
            $this->show_err($_arr_uploadRow["alert"], "err", $_arr_uploadRow["attach_name"]);
        }

        $_arr_attachRow = $this->mdl_attach->mdl_submit(0, $_arr_uploadRow["attach_name"], $_arr_uploadRow["attach_ext"], $_arr_uploadRow["attach_mime"], $_arr_uploadRow["attach_size"], $this->adminLogged["admin_id"]);

        if ($_arr_attachRow["alert"] != "y070101") {
            $this->show_err($_arr_attachRow["alert"], "err", $_arr_uploadRow["attach_name"]);
        }

        $_arr_uploadRowSubmit = $this->obj_upload->upload_submit($_arr_attachRow["attach_time"], $_arr_attachRow["attach_id"]);
        if ($_arr_uploadRowSubmit["alert"] != "y070401") {
            $this->show_err($_arr_uploadRowSubmit["alert"], "err", $_arr_uploadRow["attach_name"]);
        }
        $_arr_uploadRowSubmit["attach_id"]    = $_arr_attachRow["attach_id"];
        $_arr_uploadRowSubmit["attach_ext"]   = $_arr_uploadRow["attach_ext"];
        $_arr_uploadRowSubmit["attach_name"]  = $_arr_uploadRow["attach_name"];

        exit(json_encode($_arr_uploadRowSubmit));
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ajax_del() {
        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status["alert"] != "y070403") {
            $this->obj_ajax->halt_alert($_arr_status["alert"]);
        }

        if (isset($this->group_allow["attach"]["del"]) && !$this->is_super) {
            $_num_adminId = 0;
        } else {
            $_num_adminId = $this->adminLogged["admin_id"];
        }

        $_arr_attachIds = $this->mdl_attach->input_ids();
        if ($_arr_attachIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_attachIds["alert"]);
        }

        $_arr_search = array(
            "admin_id"      => $_num_adminId,
            "attach_ids"    => $_arr_attachIds["attach_ids"],
        );

        $_arr_attachRows = $this->mdl_attach->mdl_list(1000, 0, $_arr_search);
        $this->obj_upload->upload_del($_arr_attachRows);

        $_arr_attachDel = $this->mdl_attach->mdl_del($_num_adminId);

        $this->obj_ajax->halt_alert($_arr_attachDel["alert"]);
    }


    /**
     * ajax_list function.
     *
     * @access public
     * @return void
     */
    function ajax_list() {
        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        if (!isset($this->group_allow["attach"]["browse"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x070301");
        }

        $_arr_search = array(
            "key"   => fn_getSafe(fn_get("key"), "txt", ""),
            "year"  => fn_getSafe(fn_get("year"), "txt", ""),
            "month" => fn_getSafe(fn_get("month"), "txt", ""),
            "ext"   => fn_getSafe(fn_get("ext"), "txt", ""),
            "box"   => "normal",
        );

        $_num_perPage     = 8;
        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_attachCount, $_num_perPage);
        $_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, $_arr_page["except"], $_arr_search);

        foreach ($_arr_attachRows as $_key=>$_value) {
            if ($_value["attach_type"] == "image") {
                $_arr_attachRows[$_key]["attach_thumb"] = $this->mdl_attach->thumb_process($_value["attach_id"], $_value["attach_time"], $_value["attach_ext"]);
            }
            $_arr_attachRows[$_key]["adminRow"]  = $this->mdl_admin->mdl_read($_value["attach_admin_id"]);
        }

        //print_r($_arr_page);

        $_arr_tpl = array(
            "pageRow"    => $_arr_page,
            "attachRows" => $_arr_attachRows, //上传信息
        );

        exit(json_encode($_arr_tpl));
    }


    function ajax_article() {
        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        if (!isset($this->group_allow["attach"]["browse"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x070301");
        }

        $_num_articleId = fn_getSafe(fn_get("article_id"), "int", 0);
        if ($_num_articleId < 1) {
            $this->obj_ajax->halt_alert("x120212");
        }

        $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
        if ($_arr_articleRow["alert"] != "y120102") {
            $this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
        }

        $_num_perPage     = 8;
        $_arr_attachIds   = fn_getAttach($_arr_articleRow["article_content"]);
        $_arr_attachRows  = array();

        $_arr_search = array(
            "attach_ids"    => $_arr_attachIds,
            "box"           => "normal",
        );

        if ($_arr_attachIds) {
            $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
            $_arr_page        = fn_page($_num_attachCount, $_num_perPage);
            $_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, $_arr_page["except"], $_arr_search);

            foreach ($_arr_attachRows as $_key=>$_value) {
                if ($_value["attach_type"] == "image") {
                    $_arr_attachRows[$_key]["attach_thumb"] = $this->mdl_attach->thumb_process($_value["attach_id"], $_value["attach_time"], $_value["attach_ext"]);
                }
                $_arr_attachRows[$_key]["adminRow"]  = $this->mdl_admin->mdl_read($_value["attach_admin_id"]);
            }
        }

        //print_r($_arr_page);

        $_arr_tpl = array(
            "pageRow"    => $_arr_page,
            "attachRows" => $_arr_attachRows, //上传信息
        );

        exit(json_encode($_arr_tpl));
    }


    /**
     * show_err function.
     *
     * @access private
     * @param mixed $str_alert
     * @return void
     */
    private function show_err($str_alert, $status = "ok", $str_attachName = "") {
        $_arr_re = array(
            "alert"         => $str_alert,
            "msg"           => $this->obj_ajax->alert[$str_alert],
            "status"        => $status,
            "attach_name"   => $str_attachName,
        );
        if ($str_alert == "x070203") {
            $_arr_re["msg"] = $this->obj_ajax->alert[$str_alert] . " " . BG_UPLOAD_SIZE . " " . BG_UPLOAD_UNIT;
        }
        exit(json_encode($_arr_re));
    }


    /**
     * setUpload function.
     *
     * @access private
     * @return void
     */
    private function setUpload() {
        $_arr_mimeRows = $this->mdl_mime->mdl_list(100);
        foreach ($_arr_mimeRows as $_key=>$_value) {
            $this->attachMime[$_value["mime_name"]] = $_value["mime_ext"];
        }

        $this->mdl_attach->thumbRows  = $this->mdl_thumb->mdl_list(100);
        $this->obj_upload->thumbRows  = $this->mdl_attach->thumbRows;
        $this->obj_upload->mimeRows   = $this->attachMime;
        $this->obj_upload->mime_image = $this->mdl_attach->mime_image;
    }
}
