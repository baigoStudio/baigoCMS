<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Attach as Attach_Base;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------栏目模型-------------*/
class Attach extends Attach_Base {


    function read($mix_attach, $str_by = 'attach_id', $str_box = '', $arr_select = array()) {
        $_arr_select = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            'attach_mime',
            'attach_size',
        );

        $_arr_attachRow = parent::read($mix_attach, $str_by, $str_box, $_arr_select);

        if (!$_arr_attachRow) {
            return $_arr_attachRow;
        }

        //print_r($_arr_attachRow['thumbRows']);

        if (isset($_arr_attachRow['thumbRows'][$this->configBase['site_thumb_default']]['thumb_url'])) {
            $_arr_attachRow['thumb_default'] = $_arr_attachRow['thumbRows'][$this->configBase['site_thumb_default']]['thumb_url'];
        }

        return $_arr_attachRow;
    }


    function lists($pagination = 0, $arr_search = array(), $arr_order = array(), $arr_select = array()) {
        $arr_select = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            'attach_mime',
            'attach_size',
        );

        $arr_search['box'] = 'normal';

        $_arr_getData = parent::lists($pagination, $arr_search, $arr_order, $arr_select);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_eachData = &$_arr_getData['dataRows'];
        } else {
            $_arr_eachData = &$_arr_getData;
        }

        foreach ($_arr_eachData as $_key=>&$_value) {
            if (isset($_value['thumbRows'][$this->configBase['site_thumb_default']]['thumb_url'])) {
                $_value['thumb_default'] = $_value['thumbRows'][$this->configBase['site_thumb_default']]['thumb_url'];
            } else {
                $_value['thumb_default'] = '';
            }
        }

        return $_arr_getData;
    }
}
