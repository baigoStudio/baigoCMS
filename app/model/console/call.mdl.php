<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Call as Call_Base;
use ginkgo\Func;
use ginkgo\Json;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------调用模型-------------*/
class Call extends Call_Base {

    function duplicate() {
        $_arr_callData = array(
            'call_name',
            'call_type',
            'call_file',
            'call_tpl',
            'call_status',
            'call_amount',
            'call_cate_ids',
            'call_cate_excepts',
            'call_cate_id',
            'call_spec_ids',
            'call_mark_ids',
            'call_attach',
            'call_period',
        );

        $_num_callId = $this->where('call_id', '=', $this->inputDuplicate['call_id'])->duplicate($_arr_callData);

        if ($_num_callId > 0) { //数据库更新是否成功
            $_str_rcode = 'y170112';
            $_str_msg   = 'Duplicate call successfully';
        } else {
            $_str_rcode = 'x170112';
            $_str_msg   = 'Duplicate call failed';
        }

        return array(
            'call_id'  => $_num_callId,
            'rcode'    => $_str_rcode,
            'msg'      => $_str_msg,
        );
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_callId
     * @param mixed $str_callName
     * @param mixed $str_callType
     * @param string $str_callShow (default: '')
     * @param string $str_cateIds (default: '')
     * @return void
     */
    function submit() {
        $_arr_callData = array(
            'call_name'          => $this->inputSubmit['call_name'],
            'call_type'          => $this->inputSubmit['call_type'],
            'call_file'          => $this->inputSubmit['call_file'],
            'call_tpl'           => $this->inputSubmit['call_tpl'],
            'call_status'        => $this->inputSubmit['call_status'],
            'call_amount'        => $this->inputSubmit['call_amount'],
            'call_cate_ids'      => $this->inputSubmit['call_cate_ids'],
            'call_cate_excepts'  => $this->inputSubmit['call_cate_excepts'],
            'call_cate_id'       => $this->inputSubmit['call_cate_id'],
            'call_mark_ids'      => $this->inputSubmit['call_mark_ids'],
            'call_spec_ids'      => $this->inputSubmit['call_spec_ids'],
            'call_attach'        => $this->inputSubmit['call_attach'],
            'call_period'        => $this->inputSubmit['call_period'],
        );

        $_mix_vld = $this->validate($_arr_callData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'call_id'   => $this->inputSubmit['call_id'],
                'rcode'     => 'x170201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_callData['call_amount']          = Json::encode($_arr_callData['call_amount']);
        $_arr_callData['call_cate_ids']        = Json::encode($_arr_callData['call_cate_ids']);
        $_arr_callData['call_cate_excepts']    = Json::encode($_arr_callData['call_cate_excepts']);
        $_arr_callData['call_spec_ids']        = Json::encode($_arr_callData['call_spec_ids']);
        $_arr_callData['call_mark_ids']        = Json::encode($_arr_callData['call_mark_ids']);

        if ($this->inputSubmit['call_id'] > 0) { //插入
            $_num_callId = $this->inputSubmit['call_id'];

            $_num_count  = $this->where('call_id', '=', $_num_callId)->update($_arr_callData);

            if ($_num_count > 0) { //数据库更新是否成功
                $_str_rcode = 'y170103';
                $_str_msg   = 'Update call successfully';
            } else {
                $_str_rcode = 'x170103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_callId  = $this->insert($_arr_callData);

            if ($_num_callId > 0) { //数据库插入是否成功
                $_str_rcode = 'y170101';
                $_str_msg   = 'Add call successfully';
            } else {
                $_str_rcode = 'x170101';
                $_str_msg   = 'Add call failed';
            }
        }

        return array(
            'call_id'   => $_num_callId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /**
     * mdl_status function.
     *
     * @access public
     * @param mixed $this->inputStatus['call_ids']
     * @param mixed $str_status
     * @return void
     */
    function status() {
        $_arr_callData = array(
            'call_status' => $this->inputStatus['act'],
        );

        $_num_count  = $this->where('call_id', 'IN', $this->inputStatus['call_ids'])->update($_arr_callData);

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y170103';
            $_str_msg   = 'Successfully updated {:count} calls';
        } else {
            $_str_rcode = 'x170103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        ); //成功
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @return void
     */
    function delete() {
        $_num_count  = $this->where('call_id', 'IN', $this->inputDelete['call_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y170104';
            $_str_msg   = 'Successfully deleted {:count} calls';
        } else {
            $_str_rcode = 'x170104';
            $_str_msg   = 'No call have been deleted';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function inputDuplicate() {
        $_arr_inputParam = array(
            'call_id'   => array('int', 0),
            '__token__' => array('str', ''),
        );

        $_arr_inputDuplicate = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputDuplicate, '', 'duplicate');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x170201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_callRow = $this->check($_arr_inputDuplicate['call_id']);

        if ($_arr_callRow['rcode'] != 'y170102') {
            return $_arr_callRow;
        }

        $_arr_inputDuplicate['rcode'] = 'y170201';

        $this->inputDuplicate = $_arr_inputDuplicate;

        return $_arr_inputDuplicate;
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'call_id'           => array('int', 0),
            'call_name'         => array('str', ''),
            'call_type'         => array('str', ''),
            'call_file'         => array('str', ''),
            'call_tpl'          => array('str', ''),
            'call_status'       => array('str', ''),
            'call_cate_id'      => array('str', ''),
            'call_amount'       => array('arr', array()),
            'call_cate_ids'     => array('arr', array()),
            'call_cate_excepts' => array('arr', array()),
            'call_spec_ids'     => array('arr', array()),
            'call_mark_ids'     => array('arr', array()),
            'call_attach'       => array('str', ''),
            'call_period'       => array('int', 0),
            '__token__'         => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x170201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['call_id'] > 0) {
            $_arr_callRow = $this->check($_arr_inputSubmit['call_id']);

            if ($_arr_callRow['rcode'] != 'y170102') {
                return $_arr_callRow;
            }
        }

        $_arr_inputSubmit['rcode'] = 'y170201';

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
            'call_ids' => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        $_arr_inputDelete['call_ids'] = Func::arrayFilter($_arr_inputDelete['call_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x170201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y170201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'call_ids' => array('arr', array()),
            'act'       => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        $_arr_inputStatus['call_ids'] = Func::arrayFilter($_arr_inputStatus['call_ids']);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x170201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y170201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }


    function inputCommon() {
        $_arr_inputParam = array(
            '__token__' => array('str', ''),
        );

        $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x170201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputCommon['rcode'] = 'y170201';

        $this->inputCommon = $_arr_inputCommon;

        return $_arr_inputCommon;
    }
}
