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
class CONTROL_API_API_CATE {

    function __construct() { //构造函数
        $this->general_api  = new GENERAL_API();
        //$this->general_api->chk_install();

        $this->mdl_cate = new MODEL_CATE(); //设置文章对象
    }


    /**
     * ctrl_show function.
     *
     * @access public
     * @return void
     */
    function ctrl_read() {
        $_arr_appChk = $this->general_api->app_chk_api();
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $_num_cateId  = fn_getSafe(fn_get('cate_id'), 'int', 0);

        if ($_num_cateId < 1) {
            $_arr_return = array(
                'rcode' => 'x250217',
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_cateRow = $this->mdl_cate->mdl_cache($_num_cateId);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            $this->general_api->show_result($_arr_cateRow);
        }

        if ($_arr_cateRow['cate_status'] != 'show') {
            $_arr_return = array(
                'rcode' => 'x250102',
            );
            $this->general_api->show_result($_arr_return);
        }

        unset($_arr_cateRow['urlRow']);

        if (isset($_arr_cateRow['cate_type']) && $_arr_cateRow['cate_type'] == 'link' && isset($_arr_cateRow['cate_link']) && !fn_isEmpty($_arr_cateRow['cate_link'])) {
            $_arr_return = array(
                'rcode'     => 'x250218',
                'cate_link' => $_arr_cateRow['cate_link'],
            );
            $this->general_api->show_result($_arr_cateRow);
        }

        $this->general_api->show_result($_arr_cateRow, $_arr_appChk['isBase64']);
    }


    function ctrl_list() {
        $_arr_appChk = $this->general_api->app_chk_api();
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $_arr_search = array(
            'status'    => 'show',
            'type'      => fn_getSafe(fn_get('type'), 'txt', ''),
            'parent_id' => fn_getSafe(fn_get('parent_id'), 'int', 0),
        );
        $_arr_cateRows    = $this->mdl_cate->mdl_listPub(1000, 0, $_arr_search);

        $this->general_api->show_result($_arr_cateRows, $_arr_appChk['isBase64']);
    }
}
