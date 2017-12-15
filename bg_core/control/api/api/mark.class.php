<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------文章类-------------*/
class CONTROL_API_API_MARK {

    private $general_api;
    private $mdl_app;
    private $mdl_mark;

    function __construct() { //构造函数
        $this->general_api        = new GENERAL_API();
        //$this->general_api->chk_install();

        $this->mdl_mark       = new MODEL_MARK();
    }


    /**
     * ctrl_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_list() {
        $_arr_appChk = $this->general_api->app_chk_api();
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $_arr_markRows    = $this->mdl_mark->mdl_list(1000);

        //print_r($_arr_return);

        $this->general_api->show_result($_arr_markRows, $_arr_appChk['isBase64']);
    }
}
