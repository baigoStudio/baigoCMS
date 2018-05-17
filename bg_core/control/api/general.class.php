<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------API 接口类-------------*/
class GENERAL_API {

    function __construct() { //构造函数
        $this->config   = $GLOBALS['obj_base']->config;

        $this->mdl_app  = new MODEL_APP(); //设置管理组模型

        $this->lang['rcode'] = fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'rcode.php'); //载入返回代码
    }

    /** 验证 app
     * app_chk_api function.
     *
     * @access public
     * @return void
     */
    function app_chk_api($str_method = 'get') {
        $this->appInput = $this->mdl_app->input_api($str_method);
        if ($this->appInput['rcode'] != 'ok') {
            return $this->appInput;
        }

        $this->appRow = $this->mdl_app->mdl_read($this->appInput['app_id']);
        if ($this->appRow['rcode'] != 'y050102') {
            return $this->appRow;
        }

        if ($this->appRow['app_status'] != 'enable') {
            return array(
                'rcode' => 'x050402',
            );
        }

        $_str_ip = fn_getIp();

        if (!fn_isEmpty($this->appRow['app_ip_allow'])) {
            $_str_ipAllow = str_ireplace(PHP_EOL, '|', $this->appRow['app_ip_allow']);
            if (!fn_regChk($_str_ip, $_str_ipAllow, true)) {
                return array(
                    'rcode' => 'x050212',
                );
            }
        } else if (!fn_isEmpty($this->appRow['app_ip_bad'])) {
            $_str_ipBad = str_ireplace(PHP_EOL, '|', $this->appRow['app_ip_bad']);
            if (fn_regChk($_str_ip, $_str_ipBad)) {
                return array(
                    'rcode' => 'x050213',
                );
            }
        }

        if ($this->appInput['app_key'] != fn_baigoCrypt($this->appRow['app_key'], $this->appRow['app_name'])) {
            return array(
                'rcode' => 'x050217',
            );
        }

        if ($str_method == 'post') {
            $_is_base64 = fn_getSafe(fn_post('isBase64'), 'txt', 'true');
        } else {
            $_is_base64 = fn_getSafe(fn_get('isBase64'), 'txt', 'true');
        }

        switch ($_is_base64) {
            case 'false':
                $_bool_isBase64 = false;
            break;

            default:
                $_bool_isBase64 = true;
            break;
        }

        return array(
            'rcode'     => 'ok',
            'appInput'  => $this->appInput,
            'appRow'    => $this->appRow,
            'isBase64'  => $_bool_isBase64,
        );
    }


    /** 验证 app
     * app_chk_sso function.
     *
     * @access public
     * @param mixed $arr_appGet
     * @param mixed $arr_appRow
     * @return void
     */
    function app_chk_sso($num_appId, $str_appKey) {

        $_arr_appId = fn_validate($num_appId, 1, 0, 'str', 'int');
        switch ($_arr_appId['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x220206',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x220207',
                );
            break;

            case 'ok':
                $_arr_appChk['app_id'] = $_arr_appId['str'];
            break;
        }

        if ($_arr_appChk['app_id'] != BG_SSO_APPID) {
            return array(
                'rcode' => 'x220208',
            );
        }

        $_arr_appKey = fn_validate($str_appKey, 1, 32, 'str', 'alphabetDigit');
        switch ($_arr_appKey['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x220209',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x220210',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x220211',
                );
            break;

            case 'ok':
                $_arr_appChk['app_key'] = $_arr_appKey['str'];
            break;
        }

        if ($_arr_appChk['app_key'] != BG_SSO_APPKEY) {
            return array(
                'rcode' => 'x220212',
            );
        }

        $_arr_appChk['rcode'] = 'ok';

        return $_arr_appChk;
    }


    function show_result($arr_tplData = array(), $is_base64 = false, $type = 'json') {
        header('Content-type: application/json; charset=utf-8');
        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');

        $_str_msg   = '';
        $_str_rcode = '';
        $_arr_tpl   = array();

        if (isset($arr_tplData['rcode'])) {
            $_str_rcode = $arr_tplData['rcode'];
        }

        if (!fn_isEmpty($_str_rcode) && isset($this->lang['rcode'][$_str_rcode])) {
            $_str_msg = $this->lang['rcode'][$arr_tplData['rcode']];
        }

        if (isset($arr_tplData['msg']) && !fn_isEmpty($arr_tplData['msg'])) {
            $_str_msg = $arr_tplData['msg'];
        }

        if (!fn_isEmpty($_str_rcode)) {
            $_arr_tpl['rcode'] = $_str_rcode;
        }

        if (!fn_isEmpty($_str_msg)) {
            $_arr_tpl['msg'] = $_str_msg;
        }

        $_arr_tplData = array_merge($arr_tplData, $_arr_tpl);

        //print_r($is_base64);

        if ($is_base64) {
            $_str_return = fn_jsonEncode($_arr_tplData, true);
        } else {
            $_str_return = json_encode($_arr_tplData);
        }

        $_str_return = fn_htmlcode($_str_return, 'decode');

        switch ($type) {
            case 'jsonp':
                $_str_return = $this->jsonp_callback . '(' . $_str_return . ')';
            break;
        }

        exit($_str_return); //输出错误信息
    }


    /** 读取 app 信息
     * app_get function.
     *
     * @access public
     * @param bool $chk_token (default: false)
     * @return void
     */
    function notify_input($str_method = 'get', $chk_token = false) {
        switch ($str_method) {
            case 'post':
                $_str_time                  = fn_post('time');
                $_str_sign                  = fn_post('sign');
                $_str_code                  = fn_post('code');
                $this->jsonp_callback       = fn_getSafe(fn_post('callback'), 'txt', 'f');
                $_arr_notifyInput['act']    = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');
            break;

            default:
                $_str_time                  = fn_get('time');
                $_str_sign                  = fn_get('sign');
                $_str_code                  = fn_get('code');
                $this->jsonp_callback       = fn_getSafe(fn_get('callback'), 'txt', 'f');
                $_arr_notifyInput['act']    = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');
            break;
        }

        $_arr_time = fn_validate($_str_time, 1, 0);
        switch ($_arr_time['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x220201',
                );
            break;

            case 'ok':
                $_arr_notifyInput['time'] = $_arr_time['str'];
            break;
        }

        $_arr_sign = fn_validate($_str_sign, 1, 0);
        switch ($_arr_sign['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x220203',
                );
            break;

            case 'ok':
                $_arr_notifyInput['sign'] = $_arr_sign['str'];
            break;
        }

        $_arr_code = fn_validate($_str_code, 1, 0);
        switch ($_arr_code['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x220204',
                );
            break;

            case 'ok':
                $_arr_notifyInput['code'] = $_arr_code['str'];
            break;
        }

        $_arr_notifyInput['rcode'] = 'ok';

        return $_arr_notifyInput;
    }
}