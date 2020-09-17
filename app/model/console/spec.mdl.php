<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Spec as Spec_Base;
use ginkgo\Func;
use ginkgo\Plugin;
use ginkgo\Html;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------专题模型-------------*/
class Spec extends Spec_Base {

    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_specId
     * @param mixed $str_specName
     * @param mixed $str_specType
     * @param mixed $str_status
     * @return void
     */
    function submit() {
        $_arr_specData = array(
            'spec_name'         => $this->inputSubmit['spec_name'],
            'spec_status'       => $this->inputSubmit['spec_status'],
            'spec_content'      => $this->inputSubmit['spec_content'],
            'spec_tpl'          => $this->inputSubmit['spec_tpl'],
        );

        if (isset($this->inputSubmit['spec_attach_id'])) {
            $_arr_specData['spec_attach_id'] = $this->inputSubmit['spec_attach_id'];
        }

        if (isset($this->inputSubmit['spec_time_update'])) {
            $_arr_specData['spec_time_update'] = $this->inputSubmit['spec_time_update'];
        } else if (isset($this->inputSubmit['spec_time_update_format'])) {
            $_arr_specData['spec_time_update'] = Func::strtotime($this->inputSubmit['spec_time_update_format']);
        } else {
            $_arr_specData['spec_time_update'] = GK_NOW;
        }

        if ($this->inputSubmit['spec_id'] > 0) {
            $_str_hook = 'edit'; //编辑文章时触发
        } else {
            $_str_hook = 'add';
        }

        $_mix_result    = Plugin::listen('filter_console_spec_' . $_str_hook, $_arr_specData); //编辑文章时触发
        $_arr_specData  = Plugin::resultProcess($_arr_specData, $_mix_result);

        $_mix_vld = $this->validate($_arr_specData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'spec_id'   => $this->inputSubmit['spec_id'],
                'rcode'     => 'x180201',
                'msg'       => end($_mix_vld),
            );
        }

        if ($this->inputSubmit['spec_id'] > 0) {
            $_num_specId = $this->inputSubmit['spec_id'];

            $_num_count     = $this->where('spec_id', '=', $_num_specId)->update($_arr_specData);

            if ($_num_count > 0) {
                $_str_rcode = 'y180103';
                $_str_msg   = 'Update topic successfully';
            } else {
                $_str_rcode = 'x180103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_arr_specData['spec_time'] = GK_NOW;

            $_num_specId     = $this->insert($_arr_specData);

            if ($_num_specId > 0) { //数据库插入是否成功
                $_str_rcode = 'y180101';
                $_str_msg   = 'Add topic successfully';
            } else {
                $_str_rcode = 'x180101';
                $_str_msg   = 'Add topic failed';
            }
        }

        return array(
            'spec_id'   => $_num_specId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    function status() {
        $_arr_specUpdate = array(
            'spec_status' => $this->inputStatus['act'],
        );

        $_num_count     = $this->where('spec_id', 'IN', $this->inputStatus['spec_ids'])->update($_arr_specUpdate);

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y180103';
            $_str_msg   = 'Successfully updated {:count} topics';
        } else {
            $_str_rcode = 'x180103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function updatedTime($num_specId) {
        $_arr_specData = array(
            'spec_time_update'  => GK_NOW,
        );

        $_num_count     = $this->where('spec_id', '=', $num_specId)->update($_arr_specData);

        if ($_num_count > 0) { //数据库更新是否成功
            $_str_rcode = 'y180103';
        } else {
            $_str_rcode = 'x180103';
        }

        return array(
            'spec_id'   => $num_specId,
            'rcode'     => $_str_rcode,
        );
    }


    function cover() {
        $_arr_specData = array(
            'spec_attach_id'    => $this->inputCover['attach_id'],
            'spec_time_update'  => GK_NOW,
        );

        $_num_specId    = $this->inputCover['spec_id'];

        $_num_count     = $this->where('spec_id', '=', $_num_specId)->update($_arr_specData);

        if ($_num_count > 0) { //数据库更新是否成功
            $_str_rcode = 'y180103';
            $_str_msg   = 'Set cover successfully';
        } else {
            $_str_rcode = 'x180103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'spec_id'   => $_num_specId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->inputDelete['spec_ids']
     * @return void
     */
    function delete() {
        $_num_count     = $this->where('spec_id', 'IN', $this->inputDelete['spec_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y180104';
            $_str_msg   = 'Successfully deleted {:count} topics';
        } else {
            $_str_rcode = 'x180104';
            $_str_msg   = 'No topic have been deleted';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功
    }


    function chkAttach($arr_attachRow) {
        $_arr_where = array(
            array('spec_attach_id', '=', $arr_attachRow['attach_id'], 'spec_attach_id', 'int', 'OR'),
            array('spec_content', 'LIKE', '%' . $arr_attachRow['attach_url_name'] . '%', 'spec_content', 'str', 'OR'),
        );

        return $this->where($_arr_where)->find('spec_id');
    }

    function inputCover() {
        $_arr_inputParam = array(
            'spec_id'   => array('int', 0),
            'attach_id' => array('int', 0),
            '__token__' => array('str', ''),
        );

        $_arr_inputCover = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputCover, '', 'cover');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x180201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_specRow = $this->check($_arr_inputCover['spec_id']);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $_arr_specRow;
        }

        $_arr_inputCover['rcode'] = 'y180201';

        $this->inputCover = $_arr_inputCover;

        return $_arr_inputCover;
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'spec_id'                   => array('int', 0),
            'spec_name'                 => array('str', ''),
            'spec_status'               => array('str', ''),
            'spec_content'              => array('str', '', true),
            'spec_tpl'                  => array('str', ''),
            'spec_time_update_format'   => array('str', ''),
            '__token__'                 => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_arr_inputSubmit['spec_time_update_format'] = Html::decode($_arr_inputSimple['spec_time_update_format'], 'date_time');

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x180201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['spec_id'] > 0) {
            $_arr_specRow = $this->check($_arr_inputSubmit['spec_id']);

            if ($_arr_specRow['rcode'] != 'y180102') {
                return $_arr_specRow;
            }
        }

        $_arr_inputSubmit['rcode'] = 'y180201';

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
            'spec_ids'  => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['spec_ids'] = Func::arrayFilter($_arr_inputDelete['spec_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x180201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y180201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'spec_ids'  => array('arr', array()),
            'act'       => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputStatus);

        $_arr_inputStatus['spec_ids'] = Func::arrayFilter($_arr_inputStatus['spec_ids']);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x180201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y180201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }
}
