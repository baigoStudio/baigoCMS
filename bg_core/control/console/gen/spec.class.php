<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

if (!defined("BG_VISIT_PAGE")) {
    define("BG_VISIT_PAGE", 10);
}

class CONTROL_CONSOLE_GEN_SPEC {

    function __construct() { //构造函数
        $this->obj_console  = new CLASS_CONSOLE();
        $this->obj_console->chk_install();

        $this->adminLogged  = $this->obj_console->ssin_begin();
        $this->obj_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->obj_console->obj_tpl;

        $this->obj_dir      = new CLASS_DIR();

        if (BG_MODULE_FTP > 0 && defined("BG_SPEC_FTPHOST") && !fn_isEmpty(BG_SPEC_FTPHOST)) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象

            if (BG_SPEC_FTPPASV == "on") {
                $_bool_pasv = true;
            } else {
                $_bool_pasv = false;
            }
            $this->ftp_status_conn  = $this->obj_ftp->ftp_conn(BG_SPEC_FTPHOST, BG_SPEC_FTPPORT);
            $this->ftp_status_login = $this->obj_ftp->ftp_login(BG_SPEC_FTPUSER, BG_SPEC_FTPPASS, $_bool_pasv);
        }

        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->mdl_articlePub   = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->spec_init();
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_attach       = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象

        $this->urlRow           = $this->mdl_spec->url_process_global();
        $this->arr_cfg["pub"]   = true;

        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_list(100);

        $this->tplData = array(
            "adminLogged"    => $this->adminLogged,
        );
    }


    function ctrl_list() {
        $_arr_search = array(
            "status"    => "show",
        );
        $_num_specCount = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page      = fn_page($_num_specCount, BG_SITE_PERPAGE); //取得分页数据
        $_str_query     = http_build_query($_arr_search);
        $_arr_page      = $this->page_process($_arr_page);

        if ($_arr_page["page"] == $_arr_page["total"] || $_arr_page["page"] >= BG_VISIT_PAGE) {
            $this->list_process($_arr_page, $_arr_search);
            $_str_status = "complete";
        } else if ($_arr_page["page"] < $_arr_page["total"]) {
            $this->list_process($_arr_page, $_arr_search);
            $_str_status = "loading";
        } else {
            $_str_status = "complete";
        }

        $_arr_tplData = array(
            "pageRow"   => $_arr_page,
            "status"    => $_str_status,
        );

        $this->obj_tpl->tplDisplay("genSpec_list", $_arr_tplData);
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function ctrl_single() {
        $_num_specId = fn_getSafe(fn_get("spec_id"), "int", 0); //ID

        if ($_num_specId < 1) {
            $this->tplData["rcode"] = "x180204";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
        if ($_arr_specRow["rcode"] != "y180102") {
            $this->tplData["rcode"] = $_arr_specRow["rcode"];
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        if ($_arr_specRow["spec_status"] != "show") {
            $this->tplData["rcode"] = "x180404";
            $this->obj_tpl->tplDisplay("error", $this->tplData);
        }

        $_arr_specRow["is_static"] = true;

        $_arr_page = $this->data_process($_arr_specRow);

        if ($_arr_page["page"] = $_arr_page["total"] && $_arr_page["page"] = BG_VISIT_PAGE) {
            $this->output_process($_arr_specRow, $_arr_page);
            $_str_status = "complete";
        } else if ($_arr_page["page"] < $_arr_page["total"] && $_arr_page["page"] < BG_VISIT_PAGE) {
            $this->output_process($_arr_specRow, $_arr_page);
            $_str_status = "loading";
        } else {
            $_str_status = "complete";
        }

        $_arr_tplData = array(
            "specRow"   => $_arr_specRow,
            "pageRow"   => $_arr_page,
            "status"    => $_str_status,
        );

        $this->obj_tpl->tplDisplay("genSpec_single", $_arr_tplData);
    }


    function ctrl_1by1() {
        $_num_maxId     = fn_getSafe(fn_get("max_id"), "int", 0); //ID
        $_str_overall   = fn_getSafe(fn_get("overall"), "txt", ""); //ID

        $_arr_specRow   = array();
        $_arr_page      = array();

        $_arr_searchLimit = array(
            "status"     => "show",
        );
        $_arr_specMin     = $this->mdl_spec->mdl_list(1, BG_VISIT_PAGE * BG_DEFAULT_PERPAGE, $_arr_searchLimit);
        if (isset($_arr_specMin[0])) {
            $_num_minId = $_arr_specMin[0]["spec_id"];
        } else {
            $_num_minId = 0;
        }

        if ($_num_maxId > 0 && $_num_maxId <= $_num_minId) {
            $_str_status = "complete";
        } else {
            $_arr_specRow = $this->mdl_spec->mdl_read($_num_maxId, true);
            if ($_arr_specRow["rcode"] != "y180102") {
                $_str_status = "complete";
            } else {
                if ($_arr_specRow["spec_status"] != "show") {
                    $_str_status    = "without";
                    $_num_maxId     = $_arr_specRow["spec_id"];
                } else {
                    $_arr_specRow["is_static"] = true;

                    $_arr_page = $this->data_process($_arr_specRow);

                    if ($_arr_page["page"] >= $_arr_page["total"] || $_arr_page["page"] >= BG_VISIT_PAGE) {
                        $_str_status    = "next";
                        $_num_maxId     = $_arr_specRow["spec_id"];
                    } else {
                        $_str_status    = "loading";
                    }

                    $this->output_process($_arr_specRow, $_arr_page);
                }
            }
        }

        $_arr_tplData = array(
            "specRow"   => $_arr_specRow,
            "pageRow"   => $_arr_page,
            "status"    => $_str_status,
            "max_id"    => $_num_maxId,
            "overall"   => $_str_overall,
        );

        $this->obj_tpl->tplDisplay("genSpec_1by1", $_arr_tplData);
    }


    /**
     * spec_init function.
     *
     * @access private
     */
    private function spec_init() {
        $_arr_searchCate = array(
            "status" => "show",
        );
        $this->cateRows     = $this->mdl_cate->mdl_listPub(1000, 0, $_arr_searchCate);
        $_arr_column_custom = $this->mdl_custom->mdl_column_custom();
        $this->mdl_articlePub->custom_columns = $_arr_column_custom;

        $_arr_searchCustom = array(
            "status" => "enable",
        );
        $this->customRows   = $this->mdl_custom->mdl_list(1000, 0, $_arr_searchCustom);
    }


    private function cate_process($num_cateId) {
        $_arr_cateRow               = $this->mdl_cate->mdl_readPub($num_cateId);
        $_arr_cateRow["cate_tplDo"] = $this->mdl_cate->tpl_process($_arr_cateRow["cate_id"]);

        if (!fn_isEmpty($_arr_cateRow["cate_trees"])) {
            foreach ($_arr_cateRow["cate_trees"] as $_key_tree=>$_value_tree) {
                $_arr_cate = $this->mdl_cate->mdl_readPub($_value_tree["cate_id"]);
                $_arr_cateRow["cate_trees"][$_key_tree]["urlRow"] = $_arr_cate["urlRow"];
            }
        }

        return $_arr_cateRow;
    }

    private function data_process($arr_specRow) {
        $_arr_search = array(
            "spec_ids" => array($arr_specRow["spec_id"]),
        );
        $_num_articleCount  = $this->mdl_articlePub->mdl_count($_arr_search); //统计
        $_arr_page          = fn_page($_num_articleCount, BG_SITE_PERPAGE); //取得分页数据

        $_arr_page = $this->page_process($_arr_page);

        return $_arr_page;
    }


    private function output_process($arr_specRow, $arr_page) {
        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . "pub/" . $this->urlRow["spec_tpl"], $this->arr_cfg); //初始化视图对象

        $_arr_search = array(
            "spec_ids" => array($arr_specRow["spec_id"]),
        );
        $_arr_articleRows   = $this->mdl_articlePub->mdl_list(BG_SITE_PERPAGE, $arr_page["except"], $_arr_search); //列出

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleCateRow = $this->cate_process($_value["article_cate_id"]);

            $_arr_searchTag = array(
                "status"        => "show",
                "article_id"    => $_value["article_id"],
            );
            $_arr_articleRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

            if ($_value["article_attach_id"] > 0) {
                $_arr_attachRow = $this->mdl_attach->mdl_url($_value["article_attach_id"]);
                if ($_arr_attachRow["rcode"] == "y070102") {
                    if ($_arr_attachRow["attach_box"] != "normal") {
                        $_arr_attachRow = array(
                            "rcode" => "x070102",
                        );
                    }
                }
                $_arr_articleRows[$_key]["attachRow"]    = $_arr_attachRow;
            }

            $_arr_articleRows[$_key]["cateRow"]  = $_arr_articleCateRow;
            /*if ($_arr_articleCateRow["cate_trees"][0]["cate_domain"]) {
                $_arr_articleRows[$_key]["urlRow"]["article_url"]  = $_arr_articleCateRow["cate_trees"][0]["cate_domain"] . "/" . $_value["urlRow"]["article_url"];
            }*/
            $_arr_articleRows[$_key]["urlRow"]  = $this->mdl_cate->article_url_process($_value, $_arr_articleCateRow);
        }

        $_arr_tplData = array(
            "urlRow"        => $this->urlRow,
            "customRows"    => $this->customRows,
            "cateRows"      => $this->cateRows,
            "specRow"       => $arr_specRow,
            "pageRow"       => $arr_page,
            "articleRows"   => $_arr_articleRows,
        );

        $_str_outPut    = $_obj_tpl->tplDisplay("spec_show", $_arr_tplData, false);
        //$_str_outPut    = mb_convert_encoding($_str_outPut, "UTF-8");

        $_num_size      = $this->obj_dir->put_file($arr_specRow["urlRow"]["spec_path"] . $arr_specRow["urlRow"]["page_attach"] . $arr_page["page"] . $arr_specRow["urlRow"]["page_ext"], $_str_outPut);

        $this->obj_dir->copy_file($arr_specRow["urlRow"]["spec_path"] . $arr_specRow["urlRow"]["page_attach"] . "1" . $arr_specRow["urlRow"]["page_ext"], $arr_specRow["urlRow"]["spec_path"] . "index" . $arr_specRow["urlRow"]["page_ext"]);


        if (BG_MODULE_FTP > 0 && defined("BG_SPEC_FTPHOST") && !fn_isEmpty(BG_SPEC_FTPHOST)) {
            if (!$this->ftp_status_conn) {
                $this->tplData["rcode"] = "x030301";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
            if (!$this->ftp_status_login) {
                $this->tplData["rcode"] = "x030302";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
            $_ftp_status = $this->obj_ftp->up_file($arr_specRow["urlRow"]["spec_path"] . $arr_specRow["urlRow"]["page_attach"] . $arr_page["page"] . $arr_specRow["urlRow"]["page_ext"], BG_SPEC_FTPPATH . $arr_specRow["urlRow"]["spec_pathShort"] . $arr_specRow["urlRow"]["page_attach"] . $arr_page["page"] . $arr_specRow["urlRow"]["page_ext"]);

            $_ftp_status = $this->obj_ftp->up_file($arr_specRow["urlRow"]["spec_path"] . "index" . $arr_specRow["urlRow"]["page_ext"], BG_SPEC_FTPPATH . $arr_specRow["urlRow"]["spec_pathShort"] . "index" . $arr_specRow["urlRow"]["page_ext"]);
        }
    }


    private function page_process($arr_page) {
        if ($arr_page["total"] >= BG_VISIT_PAGE) {
            $arr_page["total"] = BG_VISIT_PAGE;
        }

        if ($arr_page["end"] >= BG_VISIT_PAGE) {
            $arr_page["end"] = BG_VISIT_PAGE;
        }

        return $arr_page;
    }


    private function list_process($arr_page, $arr_search) {
        $_arr_specRows  = $this->mdl_spec->mdl_list(BG_DEFAULT_PERPAGE, $arr_page["except"], $arr_search);

        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . "pub/" . $this->urlRow["spec_tpl"], $this->arr_cfg); //初始化视图对象

        $_arr_tplData = array(
            "urlRow"        => $this->urlRow,
            "customRows"    => $this->customRows,
            "cateRows"      => $this->cateRows,
            "pageRow"       => $arr_page,
            "specRows"      => $_arr_specRows,
        );

        $_str_outPut = $_obj_tpl->tplDisplay("spec_list", $_arr_tplData, false);

        $_num_size      = $this->obj_dir->put_file($this->urlRow["spec_path"] . $this->urlRow["page_attach"] . $arr_page["page"] . $this->urlRow["page_ext"], $_str_outPut);

        $this->obj_dir->copy_file($this->urlRow["spec_path"] . $this->urlRow["page_attach"] . "1" . $this->urlRow["page_ext"], $this->urlRow["spec_path"] . "index" . $this->urlRow["page_ext"]);

        if (BG_MODULE_FTP > 0 && defined("BG_SPEC_FTPHOST") && !fn_isEmpty(BG_SPEC_FTPHOST)) {
            if (!$this->ftp_status_conn) {
                $this->tplData["rcode"] = "x030301";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
            if (!$this->ftp_status_login) {
                $this->tplData["rcode"] = "x030302";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
            $_ftp_status = $this->obj_ftp->up_file($this->urlRow["spec_path"] . $this->urlRow["page_attach"] . $arr_page["page"] . $this->urlRow["page_ext"], BG_SPEC_FTPPATH . $this->urlRow["spec_pathShort"] . $this->urlRow["page_attach"] . $arr_page["page"] . $this->urlRow["page_ext"]);

            $_ftp_status = $this->obj_ftp->up_file($this->urlRow["spec_path"] . "index" . $this->urlRow["page_ext"], BG_SPEC_FTPPATH . $this->urlRow["spec_pathShort"] . "index" . $this->urlRow["page_ext"]);
        }
    }
}
