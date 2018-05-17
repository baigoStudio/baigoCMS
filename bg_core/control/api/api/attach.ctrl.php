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
class CONTROL_API_API_ATTACH {

    function __construct() { //构造函数
        $this->general_api    = new GENERAL_API();
        //$this->general_api->chk_install();

        $this->mdl_attach = new MODEL_ATTACH();
        $this->mdl_thumb  = new MODEL_THUMB(); //设置上传信息对象
    }


    /**
     * ctrl_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_read() {
        $_arr_appChk = $this->general_api->app_chk_api();
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $_num_attachId = fn_getSafe(fn_get('attach_id'), 'int', 0);

        if ($_num_attachId < 1) {
            $_arr_return = array(
                'rcode' => 'x070201',
            );
            $this->general_api->show_result($_arr_return);
        }

        $this->mdl_attach->thumbRows = $this->mdl_thumb->mdl_cache();
        $_arr_attachRow   = $this->mdl_attach->mdl_url($_num_attachId);

        if ($_arr_attachRow['rcode'] != 'y070102') {
            $this->general_api->show_result($_arr_attachRow);
        }

        if ($_arr_attachRow['attach_box'] != 'normal') {
            $this->general_api->show_result('x070102');
        }

        unset($_arr_attachRow['attach_path']);

        //print_r($_arr_attachRow);

        $this->general_api->show_result($_arr_attachRow, $_arr_appChk['isBase64']);
    }
}
