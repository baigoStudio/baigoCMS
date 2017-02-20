<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}


/*-------------NOTIFY 接口类-------------*/
class CLASS_NOTIFY {

    function __construct() { //构造函数
        $this->obj_dir = new CLASS_DIR();
    }

    /** 验证 app
     * app_chk function.
     *
     * @access public
     * @param mixed $arr_appGet
     * @param mixed $arr_appRow
     * @return void
     */
    function app_chk($num_appId, $str_appKey) {

        $_arr_appId = validateStr($num_appId, 1, 0, "str", "int");
        switch ($_arr_appId["status"]) {
            case "too_short":
                return array(
                    "rcode" => "x220206",
                );
            break;

            case "format_err":
                return array(
                    "rcode" => "x220207",
                );
            break;

            case "ok":
                $_arr_appChk["app_id"] = $_arr_appId["str"];
            break;
        }

        if ($_arr_appChk["app_id"] != BG_SSO_APPID) {
            return array(
                "rcode" => "x220208",
            );
        }

        $_arr_appKey = validateStr($str_appKey, 1, 32, "str", "alphabetDigit");
        switch ($_arr_appKey["status"]) {
            case "too_short":
                return array(
                    "rcode" => "x220209",
                );
            break;

            case "too_long":
                return array(
                    "rcode" => "x220210",
                );
            break;

            case "format_err":
                return array(
                    "rcode" => "x220211",
                );
            break;

            case "ok":
                $_arr_appChk["app_key"] = $_arr_appKey["str"];
            break;
        }

        if ($_arr_appChk["app_key"] != BG_SSO_APPKEY) {
            return array(
                "rcode" => "x220212",
            );
        }

        $_arr_appChk["rcode"] = "ok";

        return $_arr_appChk;
    }


    /** 读取 app 信息
     * app_get function.
     *
     * @access public
     * @param bool $chk_token (default: false)
     * @return void
     */
    function notify_input($str_method = "get", $chk_token = false) {

        switch ($str_method) {
            case "post":
                $_str_time                  = fn_post("time");
                $_str_signature             = fn_post("signature");
                $_str_code                  = fn_post("code");
                $this->jsonp_callback       = fn_getSafe(fn_post("c"), "txt", "f");
                $_arr_notifyInput["act"]    = fn_getSafe($GLOBALS["act"], "txt", "");
            break;

            default:
                $_str_time                  = fn_get("time");
                $_str_signature             = fn_get("signature");
                $_str_code                  = fn_get("code");
                $this->jsonp_callback       = fn_getSafe(fn_get("c"), "txt", "f");
                $_arr_notifyInput["act"]    = fn_getSafe($GLOBALS["act"], "txt", "");
            break;
        }

        $_arr_time = validateStr($_str_time, 1, 0);
        switch ($_arr_time["status"]) {
            case "too_short":
                return array(
                    "rcode" => "x220201",
                );
            break;

            case "ok":
                $_arr_notifyInput["time"] = $_arr_time["str"];
            break;
        }

        $_arr_signature = validateStr($_str_signature, 1, 0);
        switch ($_arr_signature["status"]) {
            case "too_short":
                return array(
                    "rcode" => "x220203",
                );
            break;

            case "ok":
                $_arr_notifyInput["signature"] = $_arr_signature["str"];
            break;
        }

        $_arr_code = validateStr($_str_code, 1, 0);
        switch ($_arr_code["status"]) {
            case "too_short":
                return array(
                    "rcode" => "x220204",
                );
            break;

            case "ok":
                $_arr_notifyInput["code"] = $_arr_code["str"];
            break;
        }

        $_arr_notifyInput["rcode"] = "ok";

        return $_arr_notifyInput;
    }


    function show_result($arr_tplData = array(), $is_encode = false, $type = "json") {
        header("Content-type: application/json; charset=utf-8");
        header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");

        $_str_msg = "";

        if (isset($arr_tplData["msg"]) && !fn_isEmpty($arr_tplData["msg"])) {
            $_str_msg = $arr_tplData["msg"];
        } else if (isset($arr_tplData["rcode"]) && !fn_isEmpty($arr_tplData["rcode"]) && isset($this->rcode[$arr_tplData["rcode"]])) {
            $_str_msg = $this->rcode[$arr_tplData["rcode"]];
        }

        $arr_tplData["msg"] = $_str_msg;

        if ($is_encode) {
            $_str_return = fn_jsonEncode($arr_tplData, "encode");
        } else {
            $_str_return = json_encode($arr_tplData);
        }

        switch($type) {
            case "jsonp":
                $_str_return = $this->jsonp_callback . "(" . $_str_return . ")";
            break;
        }

        exit($_str_return); //输出错误信息
    }


    function chk_install() {
        $_str_rcode = "";

        if (file_exists(BG_PATH_CONFIG . "installed.php")) { //如果新文件存在
            require(BG_PATH_CONFIG . "installed.php"); //载入
        } else if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //如果旧文件存在
            $this->obj_dir->copy_file(BG_PATH_CONFIG . "is_install.php", BG_PATH_CONFIG . "installed.php"); //拷贝
            require(BG_PATH_CONFIG . "installed.php"); //载入
        } else { //如已安装文件不存在
            $_str_rcode = "x030416";
        }

        if (defined("BG_INSTALL_PUB") && PRD_CMS_PUB > BG_INSTALL_PUB) { //如果小于当前版本
            $_str_rcode = "x030415";
        }

        if (!fn_isEmpty($_str_rcode)) {
            $_arr_tplData = array(
                "rcode" => $_str_rcode,
            );
            $this->show_result($_arr_tplData);
        }
    }
}