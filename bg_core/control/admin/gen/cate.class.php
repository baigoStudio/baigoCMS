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

/*-------------用户类-------------*/
class GEN_CATE {

    private $mdl_cate;

    function __construct() { //构造函数
        $this->obj_base         = $GLOBALS["obj_base"]; //获取界面类型
        $this->config           = $this->obj_base->config;
        $this->adminLogged      = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->mdl_cate         = new MODEL_CATE();
        $this->mdl_custom       = new MODEL_CUSTOM();
        $this->mdl_articlePub   = new MODEL_ARTICLE_PUB(); //设置文章对象
        $this->cate_init();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_attach       = new MODEL_ATTACH(); //设置文章对象
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象
        $this->mdl_attach->thumbRows    = $this->mdl_thumb->mdl_list(100);
        $_arr_cfg["admin"]  = true;
        $this->obj_tpl      = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . BG_DEFAULT_UI, $_arr_cfg); //初始化视图对象

        $this->obj_dir      = new CLASS_DIR();

        if (BG_MODULE_FTP > 0) {
            include_once(BG_PATH_CLASS . "ftp.class.php"); //载入 FTP 类
            $this->obj_ftp  = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->tplData = array(
            "adminLogged"    => $this->adminLogged,
        );
    }


    /**
     * ajax_order function.
     *
     * @access public
     * @return void
     */
    function gen_single() {
        $_num_cateId = fn_getSafe(fn_get("cate_id"), "int", 0); //ID

        if ($_num_cateId < 1) {
            return array(
                "alert" => "x110217"
            );
        }

        $_arr_cateRow = $this->mdl_cate->mdl_readPub($_num_cateId);
        if ($_arr_cateRow["alert"] != "y110102") {
            return $_arr_cateRow;
        }

        if ($_arr_cateRow["cate_status"] != "show" || ($_arr_cateRow["cate_type"] == "link" && !fn_isEmpty($_arr_cateRow["cate_link"]))) {
            return array(
                "alert" => "x110404"
            );
        }

        $_arr_cateRow   = $this->cate_process($_arr_cateRow);
        $_arr_page      = $this->data_process($_arr_cateRow);

        if ($_arr_page["page"] == $_arr_page["total"] || $_arr_page["page"] >= BG_VISIT_PAGE) {
            $this->output_process($_arr_cateRow, $_arr_page);
            $_str_status = "complete";
        } else if ($_arr_page["page"] < $_arr_page["total"]) {
            $this->output_process($_arr_cateRow, $_arr_page);
            $_str_status = "loading";
        } else {
            $_str_status = "complete";
        }

        //print_r($_arr_cateIds);

        $_arr_tpl = array(
            "cateRow"   => $_arr_cateRow,
            "pageRow"   => $_arr_page,
            "status"    => $_str_status,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("genCate_single.tpl", $_arr_tplData);

        return array(
            "alert" => "y110402"
        );
    }


    function gen_1by1() {
        $_num_minId     = fn_getSafe(fn_get("min_id"), "int", 0); //ID
        $_str_overall   = fn_getSafe(fn_get("overall"), "txt", ""); //ID

        $_arr_page = array();

        $_arr_cateRow = $this->mdl_cate->mdl_readPub($_num_minId, "cate_id", 0, 0, true);
        if ($_arr_cateRow["alert"] != "y110102") {
            $_str_status = "complete";
        } else {
            if ($_arr_cateRow["cate_status"] != "show" || ($_arr_cateRow["cate_type"] == "link" && !fn_isEmpty($_arr_cateRow["cate_link"]))) {
                $_str_status    = "without";
                $_num_minId     = $_arr_cateRow["cate_id"];
            } else {
                $_arr_cateRow   = $this->cate_process($_arr_cateRow);
                $_arr_page      = $this->data_process($_arr_cateRow);

                if ($_arr_page["page"] >= $_arr_page["total"] || $_arr_page["page"] >= BG_VISIT_PAGE) {
                    $_str_status    = "next";
                    $_num_minId     = $_arr_cateRow["cate_id"];
                } else {
                    $_str_status    = "loading";
                }
                $this->output_process($_arr_cateRow, $_arr_page);
            }
        }

        $_arr_tpl = array(
            "cateRow"   => $_arr_cateRow,
            "pageRow"   => $_arr_page,
            "status"    => $_str_status,
            "min_id"    => $_num_minId,
            "overall"   => $_str_overall,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("genCate_1by1.tpl", $_arr_tplData);

        return array(
            "alert" => "y110402"
        );
    }


    /**
     * cate_init function.
     *
     * @access private
     * @return void
     */
    private function cate_init() {
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


    private function cate_process($arr_cateRow) {
        $arr_cateRow["cate_tplDo"] = $this->mdl_cate->tpl_process($arr_cateRow["cate_id"]);
        $arr_cateRow["cate_ids"]   = $this->mdl_cate->mdl_ids($arr_cateRow["cate_id"]);;
        if (is_array($arr_cateRow["cate_trees"])) {
            foreach ($arr_cateRow["cate_trees"] as $_key_tree=>$_value_tree) {
                $_arr_cate = $this->mdl_cate->mdl_readPub($_value_tree["cate_id"]);
                $arr_cateRow["cate_trees"][$_key_tree]["urlRow"] = $_arr_cate["urlRow"];
            }
        }
        $arr_cateRow["is_static"] = true;

        if (BG_MODULE_FTP > 0) {
            $this->ftpRow = $this->mdl_cate->mdl_read($arr_cateRow["cate_trees"][0]["cate_id"]);
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

        return $arr_cateRow;
    }


    private function data_process($arr_cateRow) {
        //每页记录数
        if ($arr_cateRow["cate_perpage"] > 0 && $arr_cateRow["cate_perpage"] != BG_SITE_PERPAGE) {
            $_num_perpage = $arr_cateRow["cate_perpage"];
        } else {
            $_num_perpage = BG_SITE_PERPAGE;
        }

        $_arr_search = array(
            "cate_ids" => $arr_cateRow["cate_ids"],
        );
        $_num_articleCount  = $this->mdl_articlePub->mdl_count($_arr_search); //统计
        $_arr_page          = fn_page($_num_articleCount, $_num_perpage); //取得分页数据

        if ($_arr_page["total"] >= BG_VISIT_PAGE) {
            $_arr_page["total"] = BG_VISIT_PAGE;
        }

        if ($_arr_page["end"] >= BG_VISIT_PAGE) {
            $_arr_page["end"] = BG_VISIT_PAGE;
        }

        $_arr_page["perpage"]       = $_num_perpage;

        return $_arr_page;
    }

    private function output_process($arr_cateRow, $arr_page) {
        $_arr_cfg["pub"]   = true;
        $_obj_tpl = new CLASS_TPL(BG_PATH_TPL . "pub/" . $arr_cateRow["cate_tplDo"], $_arr_cfg); //初始化视图对象

        $_arr_search = array(
            "cate_ids" => $arr_cateRow["cate_ids"],
        );
        $_arr_articleRows   = $this->mdl_articlePub->mdl_list($arr_page["perpage"], $arr_page["except"], $_arr_search); //列出

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleCateRow = $this->mdl_cate->mdl_readPub($_value["article_cate_id"]);
            $_arr_articleCateRow = $this->cate_process($_arr_articleCateRow);
            $_arr_searchTag = array(
                "status"        => "show",
                "article_id"    => $_value["article_id"],
            );
            $_arr_articleRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, $_arr_searchTag);

            if ($_value["article_attach_id"] > 0) {
                $_arr_attachRow = $this->mdl_attach->mdl_url($_value["article_attach_id"]);
                if ($_arr_attachRow["alert"] == "y070102") {
                    if ($_arr_attachRow["attach_box"] != "normal") {
                        $_arr_attachRow = array(
                            "alert" => "x070102",
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
            "customRows"    => $this->customRows,
            "cateRows"      => $this->cateRows,
            "cateRow"       => $arr_cateRow,
            "pageRow"       => $arr_page,
            "articleRows"   => $_arr_articleRows,
        );

        switch ($arr_cateRow["cate_type"]) {
            case "single":
                $_str_tplFile = "single";
            break;

            default:
                $_str_tplFile = "show";
            break;
        }

        $_str_outPut    = $_obj_tpl->tplDisplay("cate_" . $_str_tplFile . ".tpl", $_arr_tplData, false);
        //$_str_outPut    = mb_convert_encoding($_str_outPut, "UTF-8");

        $_num_size      = $this->obj_dir->put_file($arr_cateRow["urlRow"]["cate_path"] . $arr_cateRow["urlRow"]["page_attach"] . $arr_page["page"] . $arr_cateRow["urlRow"]["page_ext"], $_str_outPut);

        $this->obj_dir->copy_file($arr_cateRow["urlRow"]["cate_path"] . $arr_cateRow["urlRow"]["page_attach"] . "1" . $arr_cateRow["urlRow"]["page_ext"], $arr_cateRow["urlRow"]["cate_path"] . "index" . $arr_cateRow["urlRow"]["page_ext"]);

        if (BG_MODULE_FTP > 0 && isset($this->ftpRow["cate_ftp_host"]) && !fn_isEmpty($this->ftpRow["cate_ftp_host"])) {
            if (!$this->ftp_status_conn) {
                return array(
                    "alert" => "x030301",
                );
            }
            if (!$this->ftp_status_login) {
                return array(
                    "alert" => "x030302",
                );
            }
            $_ftp_status = $this->obj_ftp->up_file($arr_cateRow["urlRow"]["cate_path"] . $arr_cateRow["urlRow"]["page_attach"] . $arr_page["page"] . $arr_cateRow["urlRow"]["page_ext"], $this->ftpRow["cate_ftp_path"] . $arr_cateRow["urlRow"]["cate_pathShort"] . $arr_cateRow["urlRow"]["page_attach"] . $arr_page["page"] . $arr_cateRow["urlRow"]["page_ext"]);

            $_ftp_status = $this->obj_ftp->up_file($arr_cateRow["urlRow"]["cate_path"] . "index" . $arr_cateRow["urlRow"]["page_ext"], $this->ftpRow["cate_ftp_path"] . $arr_cateRow["urlRow"]["cate_pathShort"] . "index" . $arr_cateRow["urlRow"]["page_ext"]);
        }
    }
}
