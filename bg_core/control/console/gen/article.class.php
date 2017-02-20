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
class CONTROL_CONSOLE_GEN_ARTICLE {

    function __construct() { //构造函数
        $this->obj_console  = new CLASS_CONSOLE();
        $this->obj_console->chk_install();

        $this->adminLogged  = $this->obj_console->ssin_begin();
        $this->obj_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->obj_console->obj_tpl;

        $this->obj_dir      = new CLASS_DIR();

        if (BG_MODULE_FTP > 0) {
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->mdl_cate         = new MODEL_CATE(); //设置文章对象
        $this->mdl_articlePub   = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->article_init();
        $this->mdl_attach       = new MODEL_ATTACH();
        $this->mdl_thumb        = new MODEL_THUMB();

        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_list(100);

        $this->tplData = array(
            "adminLogged"    => $this->adminLogged,
        );
    }


    /**
     * ajax_order function.
     *
     * @access public
     */
    function ctrl_single($num_articleId = 0, $is_gen = true) {
        if ($num_articleId > 0) {
            $_num_articleId = $num_articleId;
        } else {
            $_num_articleId = fn_getSafe(fn_get("article_id"), "int", 0); //ID
        }

        if ($_num_articleId < 1) {
            $this->tplData["rcode"] = "x120212";
            if ($is_gen) {
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            } else {
                return;
            }
        }

        $_arr_articleRow = $this->mdl_articlePub->mdl_read($_num_articleId);
        if ($_arr_articleRow["rcode"] != "y120102") {
            $this->tplData["rcode"] = $_arr_articleRow["rcode"];
            if ($is_gen) {
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            } else {
                return;
            }
        }

        if (fn_isEmpty($_arr_articleRow["article_title"]) || $_arr_articleRow["article_status"] != "pub" || $_arr_articleRow["article_box"] != "normal" || $_arr_articleRow["article_time_pub"] > time() || ($_arr_articleRow["article_time_hide"] > 0 && $_arr_articleRow["article_time_hide"] < time())) {
            $this->tplData["rcode"] = "x120404";
            if ($is_gen) {
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            } else {
                return;
            }
        }

        if (!fn_isEmpty($_arr_articleRow["article_link"])) {
            $this->mdl_articlePub->mdl_isGen($_arr_articleRow["article_id"]);
            $this->tplData["rcode"] = "x120404";
            if ($is_gen) {
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            } else {
                return;
            }
        }

        $_arr_cateRow = $this->cate_process($_arr_articleRow["article_cate_id"]);

        if ($_arr_cateRow["rcode"] != "y250102" || $_arr_cateRow["cate_status"] != "show" || (isset($_arr_cateRow["cate_type"]) && $_arr_cateRow["cate_type"] == "link" && isset($_arr_cateRow["cate_link"]) && !fn_isEmpty($_arr_cateRow["cate_link"]))) {
            $this->tplData["rcode"] = "x120404";
            if ($is_gen) {
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            } else {
                return;
            }
        }

        $_arr_articleRow["cateRow"] = $_arr_cateRow;
        $_arr_articleRow["urlRow"]  = $this->mdl_cate->article_url_process($_arr_articleRow, $_arr_cateRow);

        $this->output_process($_arr_articleRow);

        if ($num_articleId < 1) {
            $_str_status = "complete";

            $_arr_tpl = array(
                "articleRow"    => $_arr_articleRow,
                "status"        => $_str_status,
            );

            $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

            if ($is_gen) {
                $this->obj_tpl->tplDisplay("genArticle_single", $_arr_tplData);
            }
        }
    }


    function ctrl_1by1() {
        $_num_maxId     = fn_getSafe(fn_get("max_id"), "int", 0); //ID
        $_str_enforce   = fn_getSafe(fn_get("enforce"), "txt", ""); //ID
        $_str_overall   = fn_getSafe(fn_get("overall"), "txt", ""); //ID

        if ($_str_enforce == "true") {
            $_bool_isGen = false;
        } else {
            $_bool_isGen = true;
        }

        $_arr_articleRow = $this->mdl_articlePub->mdl_read($_num_maxId, $_bool_isGen, true);
        if ($_arr_articleRow["rcode"] != "y120102") {
            $_str_status = "complete";
        } else {
            if (fn_isEmpty($_arr_articleRow["article_title"]) || $_arr_articleRow["article_status"] != "pub" || $_arr_articleRow["article_box"] != "normal" || $_arr_articleRow["article_time_pub"] > time() || ($_arr_articleRow["article_time_hide"] > 0 && $_arr_articleRow["article_time_hide"] < time())) {
                $_str_status    = "without";
                $_num_maxId     = $_arr_articleRow["article_id"];
            } else if (!fn_isEmpty($_arr_articleRow["article_link"])) {
                $_str_status    = "without";
                $_num_maxId     = $_arr_articleRow["article_id"];
                $this->mdl_articlePub->mdl_isGen($_arr_articleRow["article_id"]);
            } else {
                $_arr_cateRow   = $this->cate_process($_arr_articleRow["article_cate_id"]);
                if ($_arr_cateRow["rcode"] != "y250102" || $_arr_cateRow["cate_status"] != "show" || ($_arr_cateRow["cate_type"] == "link" && !fn_isEmpty($_arr_cateRow["cate_link"]))) {
                    $_str_status    = "without";
                    $_num_maxId     = $_arr_articleRow["article_id"];
                } else {
                    $_arr_articleRow["cateRow"] = $_arr_cateRow;
                    $_arr_articleRow["urlRow"]  = $this->mdl_cate->article_url_process($_arr_articleRow, $_arr_cateRow);
                    $this->output_process($_arr_articleRow);
                    $_str_status    = "next";
                    $_num_maxId     = $_arr_articleRow["article_id"];
                }
            }
        }

        $_arr_tpl = array(
            "articleRow"    => $_arr_articleRow,
            "status"        => $_str_status,
            "max_id"        => $_num_maxId,
            "enforce"       => $_str_enforce,
            "overall"       => $_str_overall,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("genArticle_1by1", $_arr_tplData);
    }


    /**
     * cate_init function.
     *
     * @access private
     */
    private function article_init() {
        $_arr_searchCate = array(
            "status" => "show",
        );
        $this->cateRows     = $this->mdl_cate->mdl_listPub(1000, 0, $_arr_searchCate);
        $_arr_column_custom = $this->mdl_custom->mdl_column_custom();
        $this->mdl_articlePub->custom_columns   = $_arr_column_custom;

        $_arr_searchCustom = array(
            "status" => "enable",
        );
        $this->customRows = $this->mdl_custom->mdl_list(1000, 0, $_arr_searchCustom);
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

        if (BG_MODULE_FTP > 0) {
            $this->ftpRow = $this->mdl_cate->mdl_read($_arr_cateRow["cate_trees"][0]["cate_id"]);
            if (isset($this->ftpRow["cate_ftp_host"]) && !fn_isEmpty($this->ftpRow["cate_ftp_host"])) {
                if ($this->ftpRow["cate_ftp_pasv"] == "on") {
                    $_bool_pasv = true;
                } else {
                    $_bool_pasv = false;
                }
                $this->ftp_status_conn  = $this->obj_ftp->ftp_conn($this->ftpRow["cate_ftp_host"], $this->ftpRow["cate_ftp_port"]);
                $this->ftp_status_login = $this->obj_ftp->ftp_login($this->ftpRow["cate_ftp_user"], $this->ftpRow["cate_ftp_pass"], $_bool_pasv);
            }
        }

        return $_arr_cateRow;
    }


    private function output_process($arr_articleRow) {
        $_arr_cfg["pub"]    = true;
        $_obj_tpl           = new CLASS_TPL(BG_PATH_TPL . "pub/" . $arr_articleRow["cateRow"]["cate_tplDo"], $_arr_cfg); //初始化视图对象

        $_arr_searchTag = array(
            "status"        => "show",
            "article_id"    => $arr_articleRow["article_id"],
        );
        $arr_articleRow["tagRows"]    = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

        if ($arr_articleRow["article_attach_id"] > 0) {
            $_arr_attachRow = $this->mdl_attach->mdl_url($arr_articleRow["article_attach_id"]);
            if ($_arr_attachRow["rcode"] == "y070102") {
                if ($_arr_attachRow["attach_box"] != "normal") {
                    $_arr_attachRow = array(
                        "rcode" => "x070102",
                    );
                }
            }
            $arr_articleRow["attachRow"]   = $_arr_attachRow;
        }

        $_arr_tagIds    = array();
        $_arr_assRows   = array();

        foreach ($arr_articleRow["tagRows"] as $_key=>$_value) {
            $_arr_tagIds[] = $_value["tag_id"];
        }

        if (!fn_isEmpty($_arr_tagIds)) {
            $_arr_search = array(
                "tag_ids" => $_arr_tagIds,
            );
            $_arr_assRows = $this->mdl_articlePub->mdl_list(BG_SITE_ASSOCIATE, 0, $_arr_search);

            foreach ($_arr_assRows as $_key=>$_value) {
                $_arr_assCateRow = $this->cate_process($_value["article_cate_id"]);
                $_arr_searchTag = array(
                    "status"        => "show",
                    "tarticle_id"   => $_value["article_id"],
                );
                $_arr_assRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

                if ($_value["article_attach_id"] > 0) {
                    $_arr_attachRow = $this->mdl_attach->mdl_url($_value["article_attach_id"]);
                    if ($_arr_attachRow["rcode"] == "y070102") {
                        if ($_arr_attachRow["attach_box"] != "normal") {
                            $_arr_attachRow = array(
                                "rcode" => "x070102",
                            );
                        }
                    }
                    $_arr_assRows[$_key]["attachRow"]    = $_arr_attachRow;
                }

                $_arr_assRows[$_key]["cateRow"]  = $_arr_assCateRow;
                /*if ($_arr_assCateRow["cate_trees"][0]["cate_domain"]) {
                    $_arr_assRows[$_key]["urlRow"]["article_url"]  = $_arr_assCateRow["cate_trees"][0]["cate_domain"] . "/" . $_value["urlRow"]["article_url"];
                }*/
                $_arr_assRows[$_key]["urlRow"]   = $this->mdl_cate->article_url_process($_value, $_arr_assCateRow);
            }
        }


        $_arr_tplData = array(
            "customRows"    => $this->customRows,
            "cateRows"      => $this->cateRows,
            "articleRow"    => $arr_articleRow,
            "associateRows" => $_arr_assRows,
        );

        $_str_outPut    = $_obj_tpl->tplDisplay("article_show", $_arr_tplData, false);
        //$_str_outPut    = mb_convert_encoding($_str_outPut, "UTF-8");

        $_num_size      = $this->obj_dir->put_file($arr_articleRow["urlRow"]["article_path"] . $arr_articleRow["article_id"] . $arr_articleRow["urlRow"]["page_ext"], $_str_outPut);

        if ($_num_size > 0) {
            $this->mdl_articlePub->mdl_isGen($arr_articleRow["article_id"]);
        }

        if (BG_MODULE_FTP > 0 && isset($this->ftpRow["cate_ftp_host"]) && !fn_isEmpty($this->ftpRow["cate_ftp_host"])) {
            if (!$this->ftp_status_conn) {
                $this->tplData["rcode"] = "x030301";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
            if (!$this->ftp_status_login) {
                $this->tplData["rcode"] = "x030302";
                $this->obj_tpl->tplDisplay("error", $this->tplData);
            }
            $_ftp_status = $this->obj_ftp->up_file($arr_articleRow["urlRow"]["article_pathFull"], $this->ftpRow["cate_ftp_path"] . $arr_articleRow["urlRow"]["article_pathShort"]);
        }
    }
}
