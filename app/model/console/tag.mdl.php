<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Tag as Tag_Base;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------TAG 模型-------------*/
class Tag extends Tag_Base {

    public $inputSubmit = array();

    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_tagId
     * @param mixed $str_tagName
     * @param mixed $str_tagType
     * @param mixed $str_status
     * @return void
     */
    function submit() {
        $_arr_tagData = array();

        if (isset($this->inputSubmit['tag_name'])) {
            $_arr_tagData['tag_name'] = $this->inputSubmit['tag_name'];
        }

        if (isset($this->inputSubmit['tag_status'])) {
            $_arr_tagData['tag_status'] = $this->inputSubmit['tag_status'];
        }

        $_mix_vld = $this->validate($_arr_tagData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'tag_id'    => $this->inputSubmit['tag_id'],
                'rcode'     => 'x130201',
                'msg'       => end($_mix_vld),
            );
        }

        if (!isset($this->inputSubmit['tag_id']) && $this->inputSubmit['tag_id'] > 0) {
            $_num_tagId = $this->inputSubmit['tag_id'];

            $_num_count     = $this->where('tag_id', '=', $_num_tagId)->update($_arr_tagData);

            if ($_num_count > 0) {
                $_str_rcode = 'y130103';
                $_str_msg   = 'Update tag successfully';
            } else {
                $_str_rcode = 'x130103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_tagId     = $this->insert($_arr_tagData);

            if ($_num_tagId > 0) { //数据库插入是否成功
                $_str_rcode = 'y130101';
                $_str_msg   = 'Add tag successfully';
            } else {
                $_str_rcode = 'x130101';
                $_str_msg   = 'Add tag failed';
            }
        }

        return array(
            'tag_id'    => $_num_tagId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /**
     * mdl_status function.
     *
     * @access public
     * @param mixed $this->inputStatus['tag_ids']
     * @param mixed $str_status
     * @return void
     */
    function status() {
        $_arr_tagData = array(
            'tag_status' => $this->inputStatus['act'],
        );

        $_num_count     = $this->where('tag_id', 'IN', $this->inputStatus['tag_ids'])->update($_arr_tagData);

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y130103';
            $_str_msg   = 'Successfully updated {:count} tags';
        } else {
            $_str_rcode = 'x130103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->inputDelete['tag_ids']
     * @return void
     */
    function delete() {
        $_num_count     = $this->where('tag_id', 'IN', $this->inputDelete['tag_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y130104';
            $_str_msg   = 'Successfully deleted {:count} tags';

            $this->table('tag_belong')->where('belong_tag_id', 'IN', $this->inputDelete['tag_ids'])->delete();
        } else {
            $_str_rcode = 'x130104';
            $_str_msg   = 'No tag have been deleted';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        ); //成功
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'tag_id'       => array('int', 0),
            'tag_name'     => array('str', ''),
            'tag_status'   => array('str', ''),
            '__token__'    => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x130201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['tag_id'] > 0) {
            $_arr_tagRow = $this->check($_arr_inputSubmit['tag_id']);

            if ($_arr_tagRow['rcode'] != 'y130102') {
                return $_arr_tagRow;
            }
        }

        $_arr_checkResult = $this->check($_arr_inputSubmit['tag_name'], 'tag_name', $_arr_inputSubmit['tag_id']);
        if ($_arr_checkResult['rcode'] == 'y130102') {
            return $_arr_checkResult;
        }

        $_arr_inputSubmit['rcode'] = 'y130201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    /** 选择管理员
     * inputDelete function.
     *
     * @access public
     * @return void
     */
    function inputDelete() {
        $_arr_inputParam = array(
            'tag_ids' => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        $_arr_inputDelete['tag_ids'] = Func::arrayFilter($_arr_inputDelete['tag_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x130201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y130201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'tag_ids' => array('arr', array()),
            'act'       => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        $_arr_inputStatus['tag_ids'] = Func::arrayFilter($_arr_inputStatus['tag_ids']);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x130201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y130201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }
}
