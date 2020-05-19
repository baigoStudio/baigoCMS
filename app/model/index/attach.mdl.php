<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Attach as Attach_Base;
use ginkgo\Config;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------栏目模型-------------*/
class Attach extends Attach_Base {

    function m_init() { //构造函数
        parent::m_init();

        $_arr_configBase  = Config::get('base', 'var_extra');

        if (!isset($_arr_configBase['site_thumb_default'])) {
            $_arr_configBase['site_thumb_default'] = 0;
        }

        $this->configBase  = $_arr_configBase;
    }


    function read($mix_attach, $str_by = 'attach_id', $str_box = '', $arr_select = array()) {
        $_arr_select = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            'attach_mime',
            'attach_size',
        );

        $_arr_attachRow = parent::read($mix_attach, $str_by, $str_box, $arr_select);

        if (!$_arr_attachRow) {
            return array(
                'rcode' => 'x070102', //不存在记录
            );
        }

        //print_r($_arr_attachRow['thumbRows']);

        if (isset($_arr_attachRow['thumbRows'][$this->configBase['site_thumb_default']]['thumb_url'])) {
            $_arr_attachRow['thumb_default'] = $_arr_attachRow['thumbRows'][$this->configBase['site_thumb_default']]['thumb_url'];
        }

        return $_arr_attachRow;
    }


    function lists($num_no, $num_except = 0, $arr_search = array(), $arr_select = array()) {
        $arr_select = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            'attach_mime',
            'attach_size',
        );

        $arr_search['box'] = 'normal';

        $_arr_attachRows = parent::lists($num_no, $num_except, $arr_search, $arr_select);

        foreach ($_arr_attachRows as $_key=>$_value) {
            if (isset($_value['thumbRows'][$this->configBase['site_thumb_default']]['thumb_url'])) {
                $_arr_attachRows[$_key]['thumb_default'] = $_value['thumbRows'][$this->configBase['site_thumb_default']]['thumb_url'];
            }
        }

        return $_arr_attachRows;
    }
}
