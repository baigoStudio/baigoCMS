<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Thumb as Thumb_Base;
use ginkgo\Config;
use ginkgo\File;
use ginkgo\Arrays;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------缩略图模型-------------*/
class Thumb extends Thumb_Base {


    /*============提交缩略图============
    @num_thumbWidth 宽度
    @num_thumbHeight 高度
    @str_thumbType 缩略图类型

    返回多维数组
        num_thumbId ID
        str_rcode 提示
    */
    function submit() {
        $_arr_thumbData = array(
            'thumb_width'    => $this->inputSubmit['thumb_width'],
            'thumb_height'   => $this->inputSubmit['thumb_height'],
            'thumb_type'     => $this->inputSubmit['thumb_type'],
            'thumb_quality'  => $this->inputSubmit['thumb_quality'],
        );

        $_mix_vld = $this->validate($_arr_thumbData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'thumb_id'  => $this->inputSubmit['thumb_id'],
                'rcode'     => 'x090201',
                'msg'       => end($_mix_vld),
            );
        }

        if ($this->inputSubmit['thumb_id'] > 0) {
            $_num_thumbId   = $this->inputSubmit['thumb_id'];

            $_num_count     = $this->where('thumb_id', '=', $_num_thumbId)->update($_arr_thumbData);

            if ($_num_count > 0) { //数据库插入是否成功
                $_str_rcode = 'y090103';
                $_str_msg   = 'Update thumbnail successfully';
            } else {
                $_str_rcode = 'x090103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_thumbId     = $this->insert($_arr_thumbData);

            if ($_num_thumbId > 0) { //数据库插入是否成功
                $_str_rcode = 'y090101';
                $_str_msg   = 'Add thumbnail successfully';
            } else {
                $_str_rcode = 'x090101';
                $_str_msg   = 'Add thumbnail failed';
            }
        }

        return array(
            'thumb_id'  => $_num_thumbId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->inputDelete['thumb_ids']
     * @return void
     */
    function delete() {
        $_num_count     = $this->where('thumb_id', 'IN', $this->inputDelete['thumb_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y090104';
            $_str_msg   = 'Successfully deleted {:count} thumbnails';
        } else {
            $_str_rcode = 'x090104';
            $_str_msg   = 'No thumbnail have been deleted';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function setDefault() {
        $_arr_configBase = Config::get('base', 'var_extra');

        $_arr_configBase['site_thumb_default'] = $this->inputDefault['thumb_id'];

        $_num_size   = Config::write(GK_APP_CONFIG . 'extra_base' . GK_EXT_INC, $_arr_configBase);

        if ($_num_size > 0) {
            $_str_rcode = 'y030401';
            $_str_msg   = 'Set successfully';
        } else {
            $_str_rcode = 'x030401';
            $_str_msg   = 'Set failed';
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'thumb_id'      => array('int', 0),
            'thumb_width'   => array('int', 0),
            'thumb_height'  => array('int', 0),
            'thumb_type'    => array('str', ''),
            'thumb_quality' => array('int', 0),
            '__token__'     => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x090201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['thumb_id'] > 0) {
            $_arr_thumbRow = $this->check($_arr_inputSubmit['thumb_id']);

            if ($_arr_thumbRow['rcode'] != 'y090102') {
                return $_arr_thumbRow;
            }
        }

        $_arr_checkResult  = $this->check(false, $_arr_inputSubmit['thumb_width'], $_arr_inputSubmit['thumb_height'], $_arr_inputSubmit['thumb_type'], $_arr_inputSubmit['thumb_id']);

        if ($_arr_checkResult['rcode'] == 'y090102') {
            return array(
                'rcode' => 'x090404',
                'msg'   => 'Thumbnail already exists',
            );
        }

        $_arr_inputSubmit['rcode'] = 'y090201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    /**
     * input_ids function.
     *
     * @access public
     * @return void
     */
    function inputDelete() {
        $_arr_inputParam = array(
            'thumb_ids' => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['thumb_ids'] = Arrays::filter($_arr_inputDelete['thumb_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x090201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y090201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputDefault() {
        $_arr_inputParam = array(
            '__token__' => array('str', ''),
            'thumb_id'  => array('int', 0),
        );

        $_arr_inputDefault = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDefault);

        $_mix_vld = $this->validate($_arr_inputDefault, '', 'default');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x090201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_thumbRow = $this->check($_arr_inputDefault['thumb_id']);

        if ($_arr_thumbRow['rcode'] != 'y090102') {
            return $_arr_thumbRow;
        }

        $_arr_inputDefault['rcode'] = 'y090201';

        $this->inputDefault = $_arr_inputDefault;

        return $_arr_inputDefault;
    }


    function inputCommon() {
        $_arr_inputParam = array(
            '__token__' => array('str', ''),
        );

        $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputCommon);

        $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x090201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputCommon['rcode'] = 'y090201';

        $this->inputCommon = $_arr_inputCommon;

        return $_arr_inputCommon;
    }
}
