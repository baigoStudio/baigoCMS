<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Mime as Mime_Base;
use ginkgo\Func;
use ginkgo\Json;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------MIME 模型-------------*/
class Mime extends Mime_Base {

    /*============提交允许类型============
    @str_mimeName 允许类型

    返回多维数组
        num_mimeId ID
        str_rcode 提示
    */
    function submit() {
        $_arr_mimeData = array(
            'mime_content'  => $this->inputSubmit['mime_content'],
            'mime_ext'      => $this->inputSubmit['mime_ext'],
            'mime_note'     => $this->inputSubmit['mime_note'],
        );

        $_mix_vld = $this->validate($_arr_mimeData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'mime_id'   => $this->inputSubmit['mime_id'],
                'rcode'     => 'x080201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_mimeData['mime_content']    = Json::encode($_arr_mimeData['mime_content']);

        if ($this->inputSubmit['mime_id'] > 0) {
            $_num_mimeId = $this->inputSubmit['mime_id'];

            $_num_count     = $this->where('mime_id', '=', $_num_mimeId)->update($_arr_mimeData);

            if ($_num_count > 0) { //数据库插入是否成功
                $_str_rcode = 'y080103';
                $_str_msg   = 'Update MIME successfully';
            } else {
                $_str_rcode = 'x080103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_mimeId    = $this->insert($_arr_mimeData);

            if ($_num_mimeId > 0) { //数据库插入是否成功
                $_str_rcode = 'y080101';
                $_str_msg   = 'Add MIME successfully';
            } else {
                $_str_rcode = 'x080101';
                $_str_msg   = 'Add MIME failed';
            }
        }

        return array(
            'mime_id'   => $_num_mimeId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /*============删除允许类型============
    @arr_mimeId 允许类型 ID 数组

    返回提示信息
    */
    function delete() {
        $_num_count     = $this->where('mime_id', 'IN', $this->inputDelete['mime_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y080104';
            $_str_msg   = 'Successfully deleted {:count} MIME';
        } else {
            $_str_rcode = 'x080104';
            $_str_msg   = 'No MIME have been deleted';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'mime_id'       => array('int', 0),
            'mime_ext'      => array('str', ''),
            'mime_note'     => array('str', ''),
            'mime_content'  => array('arr', array()),
            '__token__'     => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x080201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['mime_id'] > 0) {
            $_arr_mimeRow = $this->check($_arr_inputSubmit['mime_id']);

            if ($_arr_mimeRow['rcode'] != 'y080102') {
                return $_arr_mimeRow;
            }
        }

        $_arr_checkResult = $this->check($_arr_inputSubmit['mime_ext'], 'mime_ext', $_arr_inputSubmit['mime_id']);
        if ($_arr_checkResult['rcode'] == 'y080102') {
            return array(
                'rcode' => 'x080404',
                'msg'   => 'MIME already exists',
            );
        }

        $_arr_inputSubmit['rcode'] = 'y080201';

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
            'mime_ids' => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['mime_ids'] = Func::arrayFilter($_arr_inputDelete['mime_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x080201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y080201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }
}
