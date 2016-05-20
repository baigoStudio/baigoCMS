<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "api.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "call.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "spec.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "cate.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "tag.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "attach.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "articleCustom.class.php"); //载入后台用户类


class API_CALL {

    private $mdl_call;
    private $mdl_cate;
    private $mdl_article;
    private $mdl_tag;
    private $mdl_attach;
    private $callRow;

    function __construct() { //构造函数
        $this->obj_api          = new CLASS_API();
        $this->obj_api->chk_install();
        $this->mdl_app          = new MODEL_APP(); //设置管理组模型
        $this->mdl_call         = new MODEL_CALL();
        $this->mdl_spec         = new MODEL_SPEC();
        $this->mdl_cate         = new MODEL_CATE();
        $this->mdl_articlePub   = new MODEL_ARTICLE_PUB();
        $this->mdl_tag          = new MODEL_TAG();
        $this->mdl_attach       = new MODEL_ATTACH();
        $this->mdl_thumb        = new MODEL_THUMB(); //设置上传信息对象
    }


    function api_read() {
        $this->app_check("get");

        $_num_callId = fn_getSafe(fn_get("call_id"), "int", 0);

        if ($_num_callId < 1) {
            $_arr_return = array(
                "alert" => "x170201",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $this->callRow = $this->mdl_call->mdl_read($_num_callId);

        if ($this->callRow["alert"] != "y170102") {
            $this->obj_api->halt_re($this->callRow);
        }


        if ($this->callRow["call_status"] != "enable") {
            $_arr_return = array(
                "alert" => "x170201",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        switch ($this->callRow["call_type"]) {
            case "spec":
                $_arr_return = $this->call_spec();
            break;

        //栏目列表
            case "cate":
                $_arr_return = $this->call_cate();
            break;

            //TAG 列表
            case "tag_list":
            case "tag_rank":
                $_arr_return = $this->call_tag();
            break;

            //文章列表
            default:
                $_arr_return = $this->call_article();
            break;
        }



        //print_r($_arr_return);

        $this->obj_api->halt_re($_arr_return, true);
    }

    /**
     * call_cate function.
     *
     * @access public
     * @return void
     */
    private function call_cate() {
        $_arr_searchCate = array(
            "status"        => "show",
            "excepts"       => $this->callRow["call_cate_excepts"],
            "call_cate_id"  => $this->callRow["call_cate_id"],
        );

        $_arr_cateRows = $this->mdl_cate->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_searchCate);

        return $_arr_cateRows;
    }


    /**
     * call_spec function.
     *
     * @access public
     * @return void
     */
    private function call_spec() {
        $_arr_search = array(
            "status" => "show",
        );
        $_arr_specRows = $this->mdl_spec->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_search);

        foreach ($_arr_specRows as $_key=>$_value) {
            unset($_arr_specRows[$_key]["urlRow"]);
        }

        return $_arr_specRows;
    }


    /**
     * call_tag function.
     *
     * @access public
     * @return void
     */
    private function call_tag() {
        $_arr_searchTag = array(
            "status"        => "show",
            "type"          => $this->callRow["call_type"],
        );
        $_arr_tagRows = $this->mdl_tag->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_searchTag);

        foreach ($_arr_tagRows as $_key=>$_value) {
            unset($_arr_tagRows[$_key]["urlRow"]);
        }

        return $_arr_tagRows;
    }


    /**
     * call_article function.
     *
     * @access public
     * @return void
     */
    private function call_article() {
        $_arr_search = array(
            "cate_ids"      => $this->callRow["call_cate_ids"],
            "mark_ids"      => $this->callRow["call_mark_ids"],
            "spec_id"       => $this->callRow["call_spec_id"],
            "attach_type"   => $this->callRow["call_attach"],
        );

        $_arr_articleRows = $this->mdl_articlePub->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_search, $this->callRow["call_type"]);

        if ($_arr_articleRows) {
            foreach ($_arr_articleRows as $_key=>$_value) {
                unset($_arr_articleRows[$_key]["article_url"]);

                $_arr_cateRow = $this->mdl_cate->mdl_cache(false, $_value["article_cate_id"]);

                if ($_arr_cateRow["alert"] == "y110102") {
                    unset($_arr_cateRow["urlRow"]);
                }
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

                $_arr_articleRows[$_key]["cateRow"] = $_arr_cateRow;
            }
        }

        //print_r($_arr_articleRows);

        return $_arr_articleRows;
    }


    private function app_check($str_method = "get") {
        $this->appGet = $this->obj_api->app_get($str_method);

        if ($this->appGet["alert"] != "ok") {
            $this->obj_api->halt_re($this->appGet);
        }

        $_arr_appRow = $this->mdl_app->mdl_read($this->appGet["app_id"]);
        if ($_arr_appRow["alert"] != "y190102") {
            $this->obj_api->halt_re($_arr_appRow);
        }
        $this->appAllow = $_arr_appRow["app_allow"];

        $_arr_appChk = $this->obj_api->app_chk($this->appGet, $_arr_appRow);
        if ($_arr_appChk["alert"] != "ok") {
            $this->obj_api->halt_re($_arr_appChk);
        }

        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();
    }
}
