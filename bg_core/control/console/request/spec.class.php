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
class CONTROL_CONSOLE_REQUEST_SPEC {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->obj_console  = new CLASS_CONSOLE();
        $this->obj_console->dspType = "result";
        $this->obj_console->chk_install();

        $this->adminLogged  = $this->obj_console->ssin_begin();
        $this->obj_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->obj_console->obj_tpl;

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }

        if (isset($this->adminLogged["groupRow"]["group_allow"])) {
            $this->group_allow = $this->adminLogged["groupRow"]["group_allow"];
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            $this->obj_dir = new CLASS_DIR();
        }

        if (BG_MODULE_FTP > 0) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_article      = new MODEL_ARTICLE();
        $this->mdl_specBelong   = new MODEL_SPEC_BELONG();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        if (!isset($this->group_allow["article"]["spec"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x180302",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_specInput = $this->mdl_spec->input_submit();

        if ($_arr_specInput["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_specInput);
        }

        $_arr_specRow = $this->mdl_spec->mdl_submit();

        $_arr_tplData = array(
            "rcode"     => $_arr_specRow["rcode"],
            "spec_id"   => $_arr_specRow["spec_id"],
        );
        $this->obj_tpl->tplDisplay("result", $_arr_tplData);
    }


    function ctrl_status() {
        if (!isset($this->group_allow["article"]["spec"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x180302",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_specIds = $this->mdl_spec->input_ids();
        if ($_arr_specIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_specIds);
        }

        $_str_specStatus = fn_getSafe($GLOBALS["act"], "txt", "");

        $_arr_specRow = $this->mdl_spec->mdl_status($_str_specStatus);

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            if ($_str_specStatus != "show") {
                $arr_search = array(
                    "spec_ids" => $_arr_specIds["spec_ids"],
                );
                $_arr_specRows = $this->mdl_spec->mdl_list(1000, 0, $arr_search);
                foreach ($_arr_specRows as $_key=>$_value) {
                    $this->obj_dir->del_dir($_value["urlRow"]["spec_path"]);
                    if (defined("BG_MODULE_FTP") && !fn_isEmpty(BG_MODULE_FTP)) {
                        if (defined("BG_SPEC_FTPHOST") && !fn_isEmpty(BG_SPEC_FTPHOST)) {
                            if (BG_SPEC_FTPPASV == "on") {
                                $_bool_pasv = true;
                            } else {
                                $_bool_pasv = false;
                            }
                            $this->ftp_status_conn  = $this->obj_ftp->ftp_conn(BG_SPEC_FTPHOST, BG_SPEC_FTPPORT);
                            $this->ftp_status_login = $this->obj_ftp->ftp_login(BG_SPEC_FTPUSER, BG_SPEC_FTPPASS, $_bool_pasv);

                            $this->obj_ftp->del_dir(BG_SPEC_FTPPATH . $_value["urlRow"]["spec_pathShort"]);
                        }
                    }
                }
            }
        }

        $this->obj_tpl->tplDisplay("result", $_arr_specRow);
    }


    function ctrl_belongDel() {
        if (!isset($this->group_allow["article"]["spec"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x180302",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_str_rcode = "x180406";

        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleIds);
        }

        $_nun_specId  = fn_getSafe(fn_post("spec_id"), "int", 0);

        $_arr_specBelongRow = $this->mdl_specBelong->mdl_del(0, $_nun_specId, false, $_arr_articleIds["article_ids"]);

        if ($_arr_specBelongRow["rcode"] == "y230104") {
            $_str_rcode = "y180406";
        }

        //$_arr_articleRow = $this->mdl_article->mdl_toSpec($_str_act, $_nun_specId);

        $_arr_tplData = array(
            "rcode" => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay("result", $_arr_tplData);
    }


    function ctrl_belongAdd() {
        if (!isset($this->group_allow["article"]["spec"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x180302",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_str_rcode = "x180405";

        $_arr_articleIds = $this->mdl_article->input_ids();
        if ($_arr_articleIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_articleIds);
        }

        $_nun_specId  = fn_getSafe(fn_post("spec_id"), "int", 0);

        foreach ($_arr_articleIds["article_ids"] as $_key=>$_value) {
            if (!fn_isEmpty($_value)) {
                $_arr_specBelongRow = $this->mdl_specBelong->mdl_submit(intval($_value), $_nun_specId);
                if ($_arr_specBelongRow["rcode"] == "y230101") {
                    $_str_rcode = "y180405";
                }
            }
        }

        //$_arr_articleRow = $this->mdl_article->mdl_toSpec($_str_act, $_nun_specId);

        $_arr_tplData = array(
            "rcode" => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay("result", $_arr_tplData);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow["article"]["spec"]) && !$this->is_super) {
            $_arr_tplData = array(
                "rcode" => "x180304",
            );
            $this->obj_tpl->tplDisplay("result", $_arr_tplData);
        }

        $_arr_specIds = $this->mdl_spec->input_ids();
        if ($_arr_specIds["rcode"] != "ok") {
            $this->obj_tpl->tplDisplay("result", $_arr_specIds);
        }

        if (defined("BG_MODULE_GEN") && BG_MODULE_GEN > 0 && defined("BG_VISIT_TYPE") && BG_VISIT_TYPE == "static") {
            $arr_search = array(
                "spec_ids" => $_arr_specIds["spec_ids"],
            );
            $_arr_specRows = $this->mdl_spec->mdl_list(1000, 0, $arr_search);
            foreach ($_arr_specRows as $_key=>$_value) {
                $this->obj_dir->del_dir($_value["urlRow"]["spec_path"]);
                if (defined("BG_MODULE_FTP") && !fn_isEmpty(BG_MODULE_FTP)) {
                    if (defined("BG_SPEC_FTPHOST") && !fn_isEmpty(BG_SPEC_FTPHOST)) {
                        if (BG_SPEC_FTPPASV == "on") {
                            $_bool_pasv = true;
                        } else {
                            $_bool_pasv = false;
                        }
                        $this->ftp_status_conn  = $this->obj_ftp->ftp_conn(BG_SPEC_FTPHOST, BG_SPEC_FTPPORT);
                        $this->ftp_status_login = $this->obj_ftp->ftp_login(BG_SPEC_FTPUSER, BG_SPEC_FTPPASS, $_bool_pasv);

                        $this->obj_ftp->del_dir(BG_SPEC_FTPPATH . $_value["urlRow"]["spec_pathShort"]);
                    }
                }
            }
        }

        $_arr_specRow = $this->mdl_spec->mdl_del();

        $this->obj_tpl->tplDisplay("result", $_arr_specRow);
    }


    /**
     * ajax_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_list() {
        $_arr_search = array(
            "key" => fn_getSafe(fn_get("key"), "txt", ""),
        );
        $_num_perPage     = 10;
        $_num_specCount   = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_specCount, $_num_perPage); //取得分页数据
        $_arr_specRows    = $this->mdl_spec->mdl_list($_num_perPage, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "pageRow"    => $_arr_page,
            "specRows"   => $_arr_specRows, //上传信息
        );

        exit(json_encode($_arr_tpl));
    }
}
