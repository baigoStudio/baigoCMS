<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/**
 * fn_rand function.
 *
 * @access public
 * @param int $num_rand (default: 32)
 * @return void
 */
function fn_rand($num_rand = 32) {
    $_str_char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $_str_rnd  = '';
    while (strlen($_str_rnd) < $num_rand) {
        $_str_rnd .= substr($_str_char, (rand(0, strlen($_str_char))), 1);
    }
    return $_str_rnd;
}


/**
 * fn_getIp function.
 *
 * @access public
 * @return void
 */
function fn_getIp() {
    if (isset($_SERVER)) {
        if (fn_isEmpty(fn_server('REMOTE_ADDR'))) {
            $_str_ip = '0.0.0.0';
        } else {
            $_str_ip = fn_server('REMOTE_ADDR');
        }
    } else {
        if (fn_isEmpty(getenv('REMOTE_ADDR'))) {
            $_str_ip = '0.0.0.0';
        } else {
            $_str_ip = getenv('REMOTE_ADDR');
        }
    }
    return $_str_ip;
}


/**
 * fn_captcha function.
 *
 * @access public
 * @return void
 */
function fn_captcha() {
    $_str_captcha = strtolower(fn_getSafe(fn_post('captcha'), 'txt', ''));
    if ($_str_captcha != fn_session('captcha')) {
        return false;
    } else {
        return true;
    }
}


/**
 * fn_token function.
 *
 * @access public
 * @param string $token_action (default: 'mk')
 * @param string $token_method (default: 'post')
 * @param string $cookie_method (default: 'post')
 * @return void
 */
function fn_token($token_action = 'mk') {
    if (fn_isEmpty(fn_session('admin_hash'))) {
        $_str_nameSession   = 'token_session';
        $_str_nameCookie    = 'token_cookie';
    } else {
        $_str_tokenName     = fn_session('admin_hash');
        $_str_nameSession   = 'token_session_' . $_str_tokenName;
        $_str_nameCookie    = 'token_cookie_' . $_str_tokenName;
    }

    switch ($token_action) {
        case 'chk':
            $_str_inputSession  = fn_getSafe(fn_post($_str_nameSession), 'txt', '');
            $_str_inputCookie   = fn_cookie($_str_nameCookie);

            if (BG_SWITCH_TOKEN == 1) {
                 if ($_str_inputSession != fn_session($_str_nameSession) || $_str_inputCookie != fn_session($_str_nameCookie)) {
                    return false;
                 } else {
                    return true;
                 }
            } else {
                return true;
            }
        break;

        default:
            if (BG_SWITCH_TOKEN == 1) {
                if (fn_isEmpty(fn_session($_str_nameSession))) {
                    $_str_tokenSession = fn_rand();
                    fn_session($_str_nameSession, 'mk', $_str_tokenSession);
                } else {
                    $_str_tokenSession = fn_session($_str_nameSession);
                }

                if (fn_isEmpty(fn_session($_str_nameCookie))) {
                    $_str_tokenCookie = fn_rand();
                    fn_session($_str_nameCookie, 'mk', $_str_tokenCookie);
                } else {
                    $_str_tokenCookie = fn_session($_str_nameCookie);
                }

                $_str_return = $_str_tokenSession;
                fn_cookie($_str_nameCookie, 'mk', $_str_tokenCookie);
            }
        break;
    }

    return array(
        'token'         => $_str_return,
        'name_session'  => $_str_nameSession,
        'name_cookie'   => $_str_nameCookie,
    );
}

function fn_arrayMerge() {
    $_arr_args  = func_get_args();
    $array      = array();
    foreach ($_arr_args as $_key=>$_value) {
        if (is_array($_value)) {
            foreach ($_value as $k => $v) {
                if (is_array($v)) {
                    if (isset($array[$k])) {
                        $array[$k] = $array[$k];
                    } else {
                        $array[$k] = array();
                    }
                    $array[$k] = fn_arrayMerge($array[$k], $v);
                } else {
                    $array[$k] = $v;
                }
            }
        }
    }
    return $array;
}


/*============清除全部cookie============
无返回
*/
function fn_clearCookie() {
    fn_cookie('cookie_ui', 'unset');
    fn_cookie('cookie_lang', 'unset');
}


/**
 * fn_getSafe function.
 *
 * @access public
 * @param mixed $str_string
 * @param string $str_type (default: 'txt')
 * @param string $str_default (default: '')
 * @return void
 */
function fn_getSafe($str_string = '', $str_type = 'txt', $str_default = '') {
    if (fn_isEmpty($str_string)) {
        $_str_string = $str_default;
    } else {
        $_str_string = $str_string;
    }

    $_str_string = trim($_str_string);

    switch ($str_type) {
        case 'int': //数值型
            if (is_numeric($_str_string)) {
                $_str_return = intval($_str_string); //如果是数值型则赋值
            } else {
                $_str_return = 0; //如果默认值为空则赋值为0
            }
        break;

        default: //默认
            $_str_return = fn_safe($_str_string);
        break;

    }

    return $_str_return;
}


/**
 * fn_strlen_utf8 function.
 *
 * @access public
 * @param mixed $str_string
 * @return void
 */
function fn_strlen_utf8($str_string) {
    // 将字符串分解为单元
    preg_match_all('/./us', $str_string, $match);
    // 返回单元个数
    return count($match[0]);
}


/**
 * fn_substr_utf8 function.
 *
 * @access public
 * @param mixed $str_string
 * @param mixed $begin
 * @param mixed $length
 * @return void
 */
function fn_substr_utf8($str_string, $begin, $length) {
    preg_match_all('/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/i', $str_string, $_arr);

    return join('', array_slice($_arr[0], $begin, $length));
}


/**
 * fn_page function.
 *
 * @access public
 * @param mixed $_num_count
 * @param mixed $num_per (default: BG_DEFAULT_PERPAGE)
 * @return void
 */
function fn_page($_num_count, $num_per = BG_DEFAULT_PERPAGE, $method = 'get') {
    if ($num_per < 1) {
        $num_per = 1;
    }

    if (is_numeric($method)) {
        $_num_this = $method;
    } else {
        switch ($method) {
            case 'post':
                $_num_this = fn_getSafe(fn_post('page'), 'int', 1);
            break;

            default:
                $_num_this = fn_getSafe(fn_get('page'), 'int', 1);
            break;
        }
    }

    if ($_num_this < 1) {
        $_num_this = 1;
    }

    $_num_total = $_num_count / $num_per;

    if (intval($_num_total) < $_num_total) {
        $_num_total = intval($_num_total) + 1;
    } else if ($_num_total < 1) {
        $_num_total = 1;
    } else {
        $_num_total = intval($_num_total);
    }

    if ($_num_this > $_num_total) {
        $_num_this = $_num_total;
    }

    if ($_num_this <= 1) {
        $_num_except = 0;
    } else {
        $_num_except = ($_num_this - 1) * $num_per;
    }

    $_num_p     = intval(($_num_this - 1) / 10); //是否存在上十页、下十页参数
    $_num_begin = $_num_p * 10 + 1; //列表起始页
    $_num_end   = $_num_p * 10 + 10; //列表结束页

    if ($_num_end >= $_num_total) {
        $_num_end = $_num_total;
    }

    return array(
        'page'    => $_num_this,
        'p'       => $_num_p,
        'begin'   => $_num_begin,
        'end'     => $_num_end,
        'total'   => $_num_total,
        'except'  => $_num_except,
    );
}


/**
 * fn_jsonEncode function.
 *
 * @access public
 * @param string $arr_json (default: '')
 * @param string $method (default: '')
 * @return void
 */
function fn_jsonEncode($arr_json = '', $method = '') {
    if (fn_isEmpty($arr_json)) {
        $str_json = '';
    } else {
        $arr_json = fn_eachArray($arr_json, $method);
        //print_r($method);
        $str_json = json_encode($arr_json); //json编码
    }
    return $str_json;
}


/**
 * fn_jsonDecode function.
 *
 * @access public
 * @param string $str_json (default: '')
 * @param string $method (default: '')
 * @return void
 */
function fn_jsonDecode($str_json = '', $method = '') {
    if (fn_isEmpty($str_json)) {
        $arr_json = array();
    } else {
        $arr_json = json_decode($str_json, true); //json解码
        $arr_json = fn_eachArray($arr_json, $method);
    }
    return $arr_json;
}



/**
 * fn_eachArray function.
 *
 * @access public
 * @param mixed $arr
 * @param string $method (default: 'encode')
 * @return void
 */
function fn_eachArray($arr, $method = 'encode') {
    $_is_magic = get_magic_quotes_gpc();
    if (is_array($arr) && !fn_isEmpty($arr)) {
        foreach ($arr as $_key=>$_value) {
            if (is_array($_value) && !fn_isEmpty($_value)) {
                $arr[$_key] = fn_eachArray($_value, $method);
            } else if (!fn_isEmpty($_value)) {
                switch ($method) {
                    case 'encode':
                        if ($_is_magic) {
                            $_str = $_value;
                        } else {
                            $_str = addslashes($_value);
                        }
                        $arr[$_key] = base64_encode($_str);
                    break;

                    case 'decode':
                        $_str = base64_decode($_value);
                        //if (!$_is_magic) {
                            $arr[$_key] = stripslashes($_str);
                        //} else {
                            //$arr[$_key] = $_str;
                        //}
                    break;

                    default:
                        if ($_is_magic) {
                            $_str = $_value;
                        } else {
                            $_str = addslashes($_value);
                        }
                        $arr[$_key] = $_str;
                    break;
                }
            } else {
                $arr[$_key] = '';
            }
        }
    } else {
        $arr = array();
    }

    return $arr;
}


/**
 * fn_baigoCrypt function.
 *
 * @access public
 * @param mixed $str
 * @param mixed $salt
 * @return void
 */
function fn_baigoCrypt($str, $salt) {
    $key_pub = $GLOBALS['obj_base']->key_pub;

    $_str           = md5($str);
    $_salt          = md5($salt); //用 md5 加密盐
    $_key_pub       = md5($key_pub); //用 md5 加密公钥
    $_str_return    = sha1($_key_pub . $_salt . sha1(md5($_str)) . $_salt . $_key_pub); //初步加密
    $_str_return    = crypt($_str_return, $_salt); //php 内置加密
    $_str_return    = md5($_str_return); //最终加密

    return $_str_return;
}


/**
 * fn_regChk function.
 *
 * @access public
 * @param mixed $str_chk
 * @param mixed $str_reg
 * @param bool $str_wild (default: false)
 * @return void
 */
function fn_regChk($str_chk, $str_reg, $str_wild = false) {
    $_str_reg = trim($str_reg);
    $_str_reg = preg_quote($_str_reg, '/');

    if ($str_wild == true) {
        $_str_reg = str_ireplace('\\*', '.*', $_str_reg);
        $_str_reg = str_ireplace(' ', '', $_str_reg);
        $_str_reg = '/^(' . $_str_reg . ')$/i';
    } else {
        $_str_reg = '/(' . $_str_reg . ')$/i';
    }

    $_str_reg = str_ireplace('\|', '|', $_str_reg);
    $_str_reg = str_ireplace('|)', ')', $_str_reg);

    /*print_r($_str_reg . '<br>');
    preg_match($_str_reg, $str_chk, $aaaa);
    print_r($aaaa);*/

    return preg_match($_str_reg, $str_chk);
}


/**
 * fn_get function.
 *
 * @access public
 * @param mixed $key
 * @return void
 */
function fn_get($key) {
    if (isset($_GET[$key])) {
        return $_GET[$key];
    } else {
        return null;
    }
}


/**
 * fn_post function.
 *
 * @access public
 * @param mixed $key
 * @return void
 */
function fn_post($key) {
    if (isset($_POST[$key])) {
        return $_POST[$key];
    } else {
        return null;
    }
}


/**
 * fn_cookie function.
 *
 * @access public
 * @param mixed $key
 * @param string $method (default: 'get')
 * @param string $value (default: '')
 * @return void
 */
function fn_cookie($key, $method = 'get', $value = '', $tm = 3600, $path = '') {
    switch ($method) {
        case 'mk':
            setcookie($key . '_' . BG_SITE_SSIN, $value, time() + $tm, $path);
        break;

        case 'unset':
            setcookie($key . '_' . BG_SITE_SSIN, null, time() - 3600, $path);
        break;

        default:
            if (isset($_COOKIE[$key . '_' . BG_SITE_SSIN])) {
                return fn_safe($_COOKIE[$key . '_' . BG_SITE_SSIN]);
            } else {
                return null;
            }
        break;
    }
}


/**
 * fn_session function.
 *
 * @access public
 * @param mixed $key
 * @param string $method (default: 'get')
 * @param string $value (default: '')
 * @return void
 */
function fn_session($key, $method = 'get', $value = '') {
    switch ($method) {
        case 'mk':
            $_SESSION[$key . '_' . BG_SITE_SSIN] = $value;
        break;

        case 'unset':
            unset($_SESSION[$key . '_' . BG_SITE_SSIN]);
        break;

        default:
            if (isset($_SESSION[$key . '_' . BG_SITE_SSIN])) {
                return fn_safe($_SESSION[$key . '_' . BG_SITE_SSIN]);
            } else {
                return null;
            }
        break;
    }
}


/**
 * fn_request function.
 *
 * @access public
 * @param mixed $key
 * @return void
 */
function fn_request($key) {
    if (isset($_REQUEST[$key])) {
        return $_REQUEST[$key];
    } else {
        return null;
    }
}


/**
 * fn_server function.
 *
 * @access public
 * @param mixed $key
 * @return void
 */
function fn_server($key) {
    if (isset($_SERVER[$key])) {
        return fn_safe($_SERVER[$key]);
    } else {
        return null;
    }
}


function fn_safe($str_string) {
    //正则剔除
    $_arr_dangerRegs = array(
        /* -------- 跨站 --------*/

        //html 标签
        '/<(script|frame|iframe|bgsound|link|blink|object|applet|embed|style|layer|ilayer|base|meta)(\s+\S*)*>/i',

        //html 标签结束
        '/<\/(script|frame|iframe|blink|object|applet|embed|style|layer|ilayer)>/i',

        //html 事件
        '/on\w+\s*=\s*("|\')?\S*("|\')?/i',

        //html 属性包含脚本
        '/(java|vb)script:\s*\S*/i',

        //js 对象
        '/(document|location)\s*\.\s*\S*/i',

        //js 函数
        '/(eval|alert|prompt|msgbox)\s*\(.*\)/i',

        //css
        '/expression\s*:\s*\S*/i',

        /* -------- sql 注入 --------*/

        //显示 数据库 | 表 | 索引 | 字段
        '/show\s+(databases|tables|index|columns)/i',

        //创建 数据库 | 表 | 索引 | 视图 | 存储过程 | 存储过程
        '/create\s+(database|table|(unique\s+)?index|view|procedure|proc)/i',

        //更新 数据库 | 表
        '/alter\s+(database|table)/i',

        //丢弃 数据库 | 表 | 索引 | 视图 | 字段
        '/drop\s+(database|table|index|view|column)/i',

        //备份 数据库 | 日志
        '/backup\s+(database|log)/i',

        //初始化 表
        '/truncate\s+table/i',

        //替换 视图
        '/replace\s+view/i',

        //创建 | 更改 字段
        '/(add|change)\s+column/i',

        //选择 | 更新 | 删除 记录
        '/(select|update|delete)\s+\S*\s+from/i',

        //插入 记录 | 选择到文件
        '/insert\s+into/i',

        //sql 函数
        '/load_file\s*\(.*\)/i',

        //sql 其他
        '/(outfile|infile)\s+("|\')?\S*("|\')/i',
    );

    //特殊字符 直接剔除
    $_arr_dangerChars = array(
        '\t', '\r', '\n', PHP_EOL
    );

    $_str_return = trim($str_string);

    $_str_return = str_ireplace(',', '|', $_str_return); //特殊字符，内部保留

    foreach ($_arr_dangerRegs as $_key=>$_value) {
        $_str_return = preg_replace($_value, '', $_str_return);
    }

    foreach ($_arr_dangerChars as $_key=>$_value) {
        $_str_return = str_ireplace($_value, '', $_str_return);
    }

    $_str_return = fn_htmlcode($_str_return);

    $_str_return = str_ireplace('!', '&#33;', $_str_return);
    $_str_return = str_ireplace('$', '&#36;', $_str_return);
    $_str_return = str_ireplace('%', '&#37;', $_str_return);
    $_str_return = str_ireplace('\'', '&#39;', $_str_return);
    $_str_return = str_ireplace('(', '&#40;', $_str_return);
    $_str_return = str_ireplace(')', '&#41;', $_str_return);
    $_str_return = str_ireplace('+', '&#43;', $_str_return);
    $_str_return = str_ireplace('-', '&#45;', $_str_return);
    $_str_return = str_ireplace(':', '&#58;', $_str_return);
    $_str_return = str_ireplace('=', '&#61;', $_str_return);
    $_str_return = str_ireplace('?', '&#63;', $_str_return);
    $_str_return = str_ireplace('[', '&#91;', $_str_return);
    $_str_return = str_ireplace(']', '&#93;', $_str_return);
    $_str_return = str_ireplace('^', '&#94;', $_str_return);
    $_str_return = str_ireplace('`', '&#96;', $_str_return);
    $_str_return = str_ireplace('{', '&#123;', $_str_return);
    $_str_return = str_ireplace('}', '&#125;', $_str_return);
    $_str_return = str_ireplace('~', '&#126;', $_str_return);

    return trim($_str_return);
}


function fn_htmlcode($str_html, $method = 'encode', $spec = false) {
    switch ($method) {
        case 'decode':
            $str_html = html_entity_decode($str_html, ENT_QUOTES, 'UTF-8');

            switch ($spec) {
                case 'json': //转换 json 特殊字符
                    $str_html = str_ireplace('&#58;', ':', $str_html);
                    $str_html = str_ireplace('&#91;', '[', $str_html);
                    $str_html = str_ireplace('&#93;', ']', $str_html);
                    $str_html = str_ireplace('&#123;', '{', $str_html);
                    $str_html = str_ireplace('&#125;', '}', $str_html);
                    $str_html = str_ireplace('|', ',', $str_html);
                break;
                case 'url': //转换 加密 特殊字符
                    $str_html = str_ireplace('&#58;', ':', $str_html);
                    $str_html = str_ireplace('&#45;', '-', $str_html);
                    $str_html = str_ireplace('&#61;', '=', $str_html);
                    $str_html = str_ireplace('&#63;', '?', $str_html);
                break;
                case 'base64': //转换 base64 特殊字符
                    $str_html = str_ireplace('&#61;', '=', $str_html);
                break;
                case 'selector': //转换 选择器 特殊字符
                    $str_html = str_ireplace('&#58;', ':', $str_html);
                    $str_html = str_ireplace('&#45;', '-', $str_html);
                    $str_html = str_ireplace('&#61;', '=', $str_html);
                    $str_html = str_ireplace('&#33;', '!', $str_html);
                    $str_html = str_ireplace('|', ',', $str_html);
                break;
                default:
                    $str_html = str_ireplace('|', '&#44;', $str_html);
                break;
            }
        break;
        default:
            $str_html = htmlentities($str_html, ENT_QUOTES, 'UTF-8');
        break;
    }

    return trim($str_html);
}


function fn_strtotime($str_time) {
    $str_time   = str_ireplace('&#45;', '-', $str_time);
    $str_time   = str_ireplace('&#58;', ':', $str_time);
    $_tm_return = strtotime($str_time);

    return $_tm_return;
}


function fn_isEmpty($data) {
    if (!isset($data)) {
    	return true;
    }
	if ($data === null) {
		return true;
	}
	if (is_array($data) || is_object($data)) {
    	if (empty($data)) {
    		return true;
    	}
	} else {
    	if (empty($data) || trim($data) === '') {
    		return true;
    	}
	}

	return false;
}


function fn_forward($str_forward, $method = 'encode') {
    switch ($method) {
        case 'decode':
            $str_forward = fn_htmlcode($str_forward, 'decode', 'crypt');
            $str_forward = urldecode($str_forward);
            $str_forward = fn_htmlcode($str_forward, 'decode', 'base64');
            $str_forward = base64_decode($str_forward);
            $str_forward = fn_htmlcode($str_forward, 'decode', 'url');
            $str_forward = fn_safe($str_forward);
            $str_forward = fn_htmlcode($str_forward, 'decode', 'url');
            return $str_forward;
        break;

        default:
            return urlencode(base64_encode($str_forward));
        break;
    }
}


function fn_numFormat($str_num, $fload = 0) {
    if (!is_numeric($str_num)) {
        $str_num = floatval($str_num);
    }
    return number_format($str_num, $fload);
}


function fn_formatUrl($str_url, $str_baseUrl) {
    $str_url        = strtolower($str_url);
    $str_url        = str_replace('\\', '/', $str_url);

    $str_baseUrl    = strtolower($str_baseUrl);
    $str_baseUrl    = str_replace('\\', '/', $str_baseUrl);
    //判断类型
    if (substr($str_url, 0, 8) != 'https://' && substr($str_url, 0, 7) != 'http://' && substr($str_url, 0, 7) != 'mailto:' && substr($str_url, 0, 11) != 'javascript:' && substr($str_url, 0, 1) != '#') { //http mailto javascript 开头的 url 类型要跳过
        $_str_urlRoot   = '';
        $_arr_urlParsed = parse_url($str_baseUrl);

        if (isset($_arr_urlParsed['scheme']) && !fn_isEmpty($_arr_urlParsed['scheme'])) {
            $_str_urlRoot = $_arr_urlParsed['scheme'] . '://';
        }

        if (isset($_arr_urlParsed['host']) && !fn_isEmpty($_arr_urlParsed['host'])) {
            $_str_urlRoot = $_str_urlRoot . $_arr_urlParsed['host'];
        }

        if (isset($_arr_urlParsed['port']) && !fn_isEmpty($_arr_urlParsed['port'])) {
            $_str_urlRoot = $_str_urlRoot . ':' . $_arr_urlParsed['port'];
        }

        if (fn_isEmpty($_str_urlRoot)) {
            return $str_url;
        }

        $_str_basePath = '';

        if (isset($_arr_urlParsed['path']) && $_arr_urlParsed['path'] != '\\') {
            $_str_basePath = $_arr_urlParsed['path'];

            if (stristr(basename($_str_basePath), '.')) {
                $_str_basePath = dirname($_str_basePath);
            }
        }

        if (substr($str_url, 0, 1) == '/') { //绝对路径
            $_str_urlEnd = $str_url;
        } else if (substr($str_url, 0, 3) == '../') { //相对路径
            while (substr($str_url, 0, 3) == '../') {
                $str_url = substr($str_url, strlen($str_url) - (strlen($str_url) - 3), strlen($str_url) - 3);
                if (!fn_isEmpty($_str_basePath)) {
                    $_str_basePath = dirname($_str_basePath);
                }
            }
            $_str_urlEnd = $_str_basePath . '/' . $str_url;
        } else if (substr($str_url, 0, 2) == './') {
            $_str_urlEnd = $_str_basePath . substr($str_url, strlen($str_url) - (strlen($str_url) - 1), strlen($str_url) - 1);
        } else {
            $_str_urlEnd = $_str_basePath . '/' . $str_url;
        }

        $str_url = $_str_urlRoot . str_ireplace('//', '/', $_str_urlEnd);
    }

    return $str_url;
}


function fn_formatSrc($str_content, $str_baseUrl) {
    $_pattern_1         = '/<img.*?src=["|\']?.*?["|\']?\s.*?>/i'; //匹配系统内置图片
    $_pattern_2         = '/\ssrc=["|\']?.*?["|\']?\s/i'; //匹配图片src
    $_str_contentTemp   = fn_htmlcode($str_content, 'decode'); //html解码
    $_str_contentTemp   = str_ireplace('\\', '', $_str_contentTemp); //替换反斜杠

    preg_match_all($_pattern_1, $_str_contentTemp, $_arr_match);

    $_num_attachId     = 0;
    $_arr_attachIds    = array();

    if (isset($_arr_match[0])) { //匹配成功
        foreach ($_arr_match[0] as $_key=>$_value) { //遍历匹配结果
            preg_match($_pattern_2, $_value, $_match_2);
            $_str_urlSrc    = trim($_match_2[0]);
            $_str_urlSrc    = str_ireplace('src=', '', $_str_urlSrc); //剔除属性
            $_str_urlSrc    = str_ireplace('"', '', $_str_urlSrc);
            $_str_urlSrc    = str_ireplace('\'', '', $_str_urlSrc);
            $_str_urlSrc    = trim($_str_urlSrc);

            $_str_urlDst =  fn_formatUrl($_str_urlSrc, $str_baseUrl);

            $str_content = str_replace($_str_urlSrc, $_str_urlDst, $str_content);
        }
    }

    return $str_content;
}