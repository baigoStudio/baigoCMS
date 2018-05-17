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
class CONTROL_API_API_SPEC {

    function __construct() { //构造函数
        $this->general_api        = new GENERAL_API();
        //$this->general_api->chk_install();

        $this->mdl_spec       = new MODEL_SPEC();
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

        $_num_specId  = fn_getSafe(fn_get('spec_id'), 'int', 0);

        if ($_num_specId < 1) {
            $_arr_return = array(
                'rcode' => 'x180204',
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
        if ($_arr_specRow['rcode'] != 'y180102') {
            $this->general_api->show_result($_arr_specRow);
        }

        if ($_arr_specRow['spec_status'] != 'show') {
            $_arr_return = array(
                'rcode' => 'x180102',
            );
            $this->general_api->show_result($_arr_return);
        }

        unset($_arr_specRow['urlRow']);

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_spec_read', $_arr_specRow); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_spec_read'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_spec_read'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_specRow = $_arr_pluginReturnDo['return'];
            }
        }

        $this->general_api->show_result($_arr_specRow, $_arr_appChk['isBase64']);
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

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'status'    => 'show',
        );

        $_num_perPage     = fn_getSafe(fn_get('per_page'), 'int', BG_SITE_PERPAGE);
        $_num_specCount   = $this->mdl_spec->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_specCount, $_num_perPage); //取得分页数据
        $_arr_specRows    = $this->mdl_spec->mdl_list($_num_perPage, $_arr_page['except'], $_arr_search);

        foreach ($_arr_specRows as $_key=>$_value) {
            unset($_arr_specRows[$_key]['urlRow']);
        }

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_api_spec_list', $_arr_specRows); //编辑文章时触发
        if (isset($_arr_pluginReturn['filter_api_spec_list'])) {
            $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_api_spec_list'];

            if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
                $_arr_specRows = $_arr_pluginReturnDo['return'];
            }
        }

        $_arr_return = array(
            'pageRow'    => $_arr_page,
            'specRows'   => $_arr_specRows,
        );

        //print_r($_arr_return);

        $this->general_api->show_result($_arr_return, $_arr_appChk['isBase64']);
    }
}
