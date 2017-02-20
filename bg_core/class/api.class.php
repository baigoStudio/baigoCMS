<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}


/*-------------API 接口类-------------*/
class CLASS_API {

    function __construct() { //构造函数
        $this->obj_base = $GLOBALS["obj_base"];
        $this->config   = $this->obj_base->config;

        $this->mdl_app  = new MODEL_APP(); //设置管理组模型

        $this->rcode    = require(BG_PATH_LANG . $this->config["lang"] . "/rcode.php"); //载入返回代码

        $this->obj_dir  = new CLASS_DIR();
    }

    /** 验证 app
     * app_chk function.
     *
     * @access public
     * @return void
     */
    function app_chk($str_method = "get") {
        $this->appInput = $this->mdl_app->input_api($str_method);
        if ($this->appInput["rcode"] != "ok") {
            return $this->appInput;
        }

        $this->appRow = $this->mdl_app->mdl_read($this->appInput["app_id"]);
        if ($this->appRow["rcode"] != "y190102") {
            return $this->appRow;
        }

        if ($this->appRow["app_status"] != "enable") {
            return array(
                "rcode" => "x190402",
            );
        }

        $_str_ip = fn_getIp();

        if (!fn_isEmpty($this->appRow["app_ip_allow"])) {
            $_str_ipAllow = str_ireplace(PHP_EOL, "|", $this->appRow["app_ip_allow"]);
            if (!fn_regChk($_str_ip, $_str_ipAllow, true)) {
                return array(
                    "rcode" => "x190212",
                );
            }
        } else if (!fn_isEmpty($this->appRow["app_ip_bad"])) {
            $_str_ipBad = str_ireplace(PHP_EOL, "|", $this->appRow["app_ip_bad"]);
            if (fn_regChk($_str_ip, $_str_ipBad)) {
                return array(
                    "rcode" => "x190213",
                );
            }
        }

        if ($this->appInput["app_key"] != fn_baigoCrypt($this->appRow["app_key"], $this->appRow["app_name"])) {
            return array(
                "rcode" => "x190217",
            );
        }

        return array(
            "rcode"     => "ok",
            "appInput"  => $this->appInput,
            "appRow"    => $this->appRow,
        );
    }


    function show_result($arr_tplData = array(), $is_encode = false, $type = "json") {
        header("Content-type: application/json; charset=utf-8");
        header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");

        $_str_msg   = "";
        $_str_rcode = "";
        $_arr_tpl   = array();

        if (isset($arr_tplData["rcode"])) {
            $_str_rcode = $arr_tplData["rcode"];
        }

        if (!fn_isEmpty($_str_rcode) && isset($this->rcode[$_str_rcode])) {
            $_str_msg = $this->rcode[$arr_tplData["rcode"]];
        }

        if (isset($arr_tplData["msg"]) && !fn_isEmpty($arr_tplData["msg"])) {
            $_str_msg = $arr_tplData["msg"];
        }

        if (!fn_isEmpty($_str_rcode)) {
            $_arr_tpl["rcode"] = $_str_rcode;
        }

        if (!fn_isEmpty($_str_msg)) {
            $_arr_tpl["msg"] = $_str_msg;
        }

        $_arr_tplData = array_merge($arr_tplData, $_arr_tpl);

        if ($is_encode) {
            $_str_return = fn_jsonEncode($_arr_tplData, "encode");
        } else {
            $_str_return = json_encode($_arr_tplData);
        }

        exit($_str_return); //输出错误信息
    }
}