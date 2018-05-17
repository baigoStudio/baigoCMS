<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------前台通用类-------------*/
class GENERAL_PUB {

    public $config;
    public $dspType = '';

    function __construct($str_tpl = BG_SITE_TPL) { //构造函数
        $this->config   = $GLOBALS['obj_base']->config;
        $this->obj_tpl  = new CLASS_TPL(BG_PATH_TPL . 'pub' . DS . $str_tpl); //初始化视图对象

        //语言文件
        $this->obj_tpl->lang = array(
            'rcode'     => fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'rcode.php'), //返回代码
        );

        $GLOBALS['obj_plugin']->trigger('action_pub_init'); //前台初始化时触发
    }
}
