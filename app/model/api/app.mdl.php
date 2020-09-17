<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\api;

use app\model\App as App_Base;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------应用模型-------------*/
class App extends App_Base {

    /** 表单验证
     * inputCommon function.
     *
     * @access public
     * @return void
     */
    function inputCommon($is_submit = false) {
        $_arr_inputParam = array(
            'app_id'    => array('int', 0),
            'app_key'   => array('str', ''),
            'sign'      => array('str', ''),
            'code'      => array('str', ''),
        );

        if ($is_submit) {
            $_str_scene = 'submit';
        } else {
            $_str_scene = 'common';
        }

        $_arr_inputCommon = $this->obj_request->get($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputCommon, '', $_str_scene);

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x050201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputCommon['rcode'] = 'y050201';

        $this->inputCommon = $_arr_inputCommon;

        return $_arr_inputCommon;
    }
}
