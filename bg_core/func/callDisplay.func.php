<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

function fn_callDisplay($call_id, $template = false) {
    if ($template) {
        $call_id = $call_id["call_id"];
    }

    $_obj_call     = new CLASS_CALL_DISPLAY();
    $_arr_return   = array();
    $_arr_callRow  = $_obj_call->display_init($call_id); //读取调用信息

    if ($_arr_callRow["rcode"] == "y170102" && $_arr_callRow["call_status"] == "enable") {
        switch ($_arr_callRow["call_type"]) {
            //专题
            case "spec":
                $_arr_return = $_obj_call->display_spec();
            break;

            //栏目列表
            case "cate":
                $_arr_return = $_obj_call->display_cate();
            break;

            //TAG 列表
            case "tag_list":
            case "tag_rank":
                $_arr_return = $_obj_call->display_tag();
            break;

            case "link":
                $_arr_return = $_obj_call->display_link();
            break;

            //文章列表
            default:
                $_arr_return = $_obj_call->display_article();
            break;
        }
    }

    if ($template) {
        $callRows[$call_id] = $_arr_return;
        $template->assign("callRows", $callRows);
    } else {
        return $_arr_return;
    }
}

class CLASS_CALL_DISPLAY {

    private $mdl_call;
    private $mdl_cate;
    private $mdl_article;
    private $mdl_tag;
    private $mdl_attach;
    private $callRow;

    function __construct() { //构造函数
        $this->mdl_call           = new MODEL_CALL();
        $this->mdl_spec           = new MODEL_SPEC();
        $this->mdl_cate           = new MODEL_CATE();
        $this->mdl_articlePub     = new MODEL_ARTICLE_PUB();
        $this->mdl_tag            = new MODEL_TAG();
        $this->mdl_attach         = new MODEL_ATTACH();
        $this->mdl_thumb          = new MODEL_THUMB();
        $this->mdl_link           = new MODEL_LINK();
    }


    /**
     * display_init function.
     *
     * @access public
     * @param mixed $num_callId
     * @return void
     */
    function display_init($num_callId) {
        $this->callRow = $this->mdl_call->mdl_read($num_callId);
        return $this->callRow;
    }


    /**
     * display_cate function.
     *
     * @access public
     * @return void
     */
    function display_cate() {
        $_arr_searchCate = array(
            "status"        => "show",
            "excepts"       => $this->callRow["call_cate_excepts"],
            "parent_id"     => $this->callRow["call_cate_id"],
        );

        $_arr_cateRows = $this->mdl_cate->mdl_listPub($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_searchCate);

        return $_arr_cateRows;
    }


    /**
     * display_spec function.
     *
     * @access public
     * @return void
     */
    function display_spec() {
        $_arr_searchSpec = array(
            "status"        => "show",
        );

        $_arr_specRows = $this->mdl_spec->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_searchSpec);

        return $_arr_specRows;
    }


    /**
     * display_tag function.
     *
     * @access public
     * @return void
     */
    function display_tag() {
        $_arr_searchTag = array(
            "status"    => "show",
            "type"      => $this->callRow["call_type"],
        );
        $_arr_tagRows = $this->mdl_tag->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_searchTag);

        return $_arr_tagRows;
    }


    function display_link() {
        $_arr_searchLink = array(
            "status"    => "enable",
            "type"      => "friend",
        );
        $_arr_linkRows = $this->mdl_link->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_searchLink);

        return $_arr_linkRows;
    }


    /**
     * display_article function.
     *
     * @access public
     * @return void
     */
    function display_article() {
        $_arr_search = array(
            "cate_ids"      => $this->callRow["call_cate_ids"],
            "mark_ids"      => $this->callRow["call_mark_ids"],
            "spec_ids"      => $this->callRow["call_spec_ids"],
            "attach_type"   => $this->callRow["call_attach"],
        );

        $_arr_articleRows = $this->mdl_articlePub->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], $_arr_search, $this->callRow["call_type"]);

        //print_r($_arr_articleRows);
        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleCateRow = $this->mdl_cate->mdl_cache(false, $_value["article_cate_id"]);

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
            $_arr_articleRows[$_key]["urlRow"]  = $this->mdl_cate->article_url_process($_value, $_arr_articleCateRow);
        }

        return $_arr_articleRows;
    }
}
