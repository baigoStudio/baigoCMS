<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

class CONTROL_CONSOLE_UI_CAPTCHA {

    function ctrl_make() {
        header('Content-type: image/png');
        $obj_captcha = new CLASS_CAPTCHA();
        $obj_captcha->secSet();
        $obj_captcha->secDo();
    }
}
