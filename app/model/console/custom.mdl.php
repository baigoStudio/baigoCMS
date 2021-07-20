<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Custom as Custom_Base;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------自定义字段模型-------------*/
class Custom extends Custom_Base {

    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_customId
     * @param mixed $str_customName
     * @param mixed $str_customType
     * @param mixed $str_status
     * @return void
     */
    function submit() {
        $_arr_customData = array(
            'custom_name'        => $this->inputSubmit['custom_name'],
            'custom_type'        => $this->inputSubmit['custom_type'],
            'custom_opt'         => $this->inputSubmit['custom_opt'],
            'custom_status'      => $this->inputSubmit['custom_status'],
            'custom_parent_id'   => $this->inputSubmit['custom_parent_id'],
            'custom_cate_id'     => $this->inputSubmit['custom_cate_id'],
            'custom_format'      => $this->inputSubmit['custom_format'],
            'custom_size'        => $this->inputSubmit['custom_size'],
        );

        $_mix_vld = $this->validate($_arr_customData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'custom_id' => $this->inputSubmit['custom_id'],
                'rcode'     => 'x200201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_customData['custom_opt'] = Arrays::toJson($_arr_customData['custom_opt']);

        if ($this->inputSubmit['custom_id'] > 0) {
            $_num_customId = $this->inputSubmit['custom_id'];

            $_num_count     = $this->where('custom_id', '=', $_num_customId)->update($_arr_customData); //更新数

            if ($_num_count > 0) {
                $_str_rcode = 'y200103';
                $_str_msg   = 'Update field successfully';
            } else {
                $_str_rcode = 'x200103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_customId     = $this->insert($_arr_customData);

            if ($_num_customId > 0) { //数据库插入是否成功
                $_str_rcode = 'y200101';
                $_str_msg   = 'Add field successfully';
            } else {
                $_str_rcode = 'x200101';
                $_str_msg   = 'Add field failed';
            }
        }

        return array(
            'custom_id' => $_num_customId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    function order() {
        $_num_count = 0;

        foreach ($this->inputOrder['custom_orders'] as $_key=>$_value) {
            $_arr_customData = array(
                'custom_order' => $_value,
            );

            $_num_count += $this->where('custom_id', '=', $_key)->update($_arr_customData); //更新数
        }

        if ($_num_count > 0) {
            $_str_rcode = 'y200103';
            $_str_msg   = 'Sorted successfully';
        } else {
            $_str_rcode = 'x200103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function status() {
        $_arr_customData = array(
            'custom_status' => $this->inputStatus['act'],
        );

        $_num_count = $this->where('custom_id', 'IN', $this->inputStatus['custom_ids'])->update($_arr_customData); //更新数

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y200103';
            $_str_msg   = 'Successfully updated {:count} fields';
        } else {
            $_str_rcode = 'x200103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->inputDelete['custom_ids']
     * @return void
     */
    function delete() {
        $_num_count = $this->where('custom_id', 'IN', $this->inputDelete['custom_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y200104';
            $_str_msg   = 'Successfully deleted {:count} fields';
        } else {
            $_str_rcode = 'x200104';
            $_str_msg   = 'No field have been deleted';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'custom_id'         => array('int', 0),
            'custom_name'       => array('str', ''),
            'custom_type'       => array('str', ''),
            'custom_opt'        => array('arr', array()),
            'custom_status'     => array('str', ''),
            'custom_parent_id'  => array('int', 0),
            'custom_cate_id'    => array('int', 0),
            'custom_format'     => array('str', ''),
            'custom_size'       => array('int', 0),
            '__token__'         => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x200201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['custom_id'] > 0) {
            if ($_arr_inputSubmit['custom_parent_id'] > 0 && $_arr_inputSubmit['custom_id'] == $_arr_inputSubmit['custom_parent_id']) {
                return array(
                    'rcode' => 'x250201',
                    'msg'   => 'Can not belong to current field',
                );
            }

            $_arr_customRow = $this->check($_arr_inputSubmit['custom_id']);

            if ($_arr_customRow['rcode'] != 'y200102') {
                return $_arr_customRow;
            }
        }

        if ($_arr_inputSubmit['custom_parent_id'] > 0) {
            $_arr_checkResult = $this->check($_arr_inputSubmit['custom_parent_id']);
            if ($_arr_checkResult['rcode'] != 'y200102') {
                return array(
                    'rcode' => $_arr_checkResult['rcode'],
                    'msg'   => 'Parent field not found',
                );
            }
        }

        $_arr_checkResult = $this->check($_arr_inputSubmit['custom_name'], 'custom_name', $_arr_inputSubmit['custom_id']);
        if ($_arr_checkResult['rcode'] == 'y200102') {
            return array(
                'rcode' => 'x200404',
                'msg'   => 'Field already exists',
            );
        }

        $_arr_inputSubmit['rcode'] = 'y200201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    function inputCommon() {
        $_arr_inputParam = array(
            '__token__' => array('str', ''),
        );

        $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

        //print_r($this->inputCommon);

        $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x200201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputCommon['rcode'] = 'y200201';

        $this->inputCommon = $_arr_inputCommon;

        return $_arr_inputCommon;
    }


    function inputOrder() {
        $_arr_inputParam = array(
            'custom_orders'  => array('arr', array()),
            '__token__'      => array('str', ''),
        );

        $_arr_inputOrder = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputOrder, '', 'order');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x200201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputOrder['rcode'] = 'y200201';

        $this->inputOrder = $_arr_inputOrder;

        return $_arr_inputOrder;
    }


    /** 选择管理员
     * inputDelete function.
     *
     * @access public
     * @return void
     */
    function inputDelete() {
        $_arr_inputParam = array(
            'custom_ids' => array('arr', array()),
            '__token__'  => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['custom_ids'] = Arrays::filter($_arr_inputDelete['custom_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x200201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y200201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'custom_ids' => array('arr', array()),
            'act'        => array('str', ''),
            '__token__'  => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputStatus);

        $_arr_inputStatus['custom_ids'] = Arrays::filter($_arr_inputStatus['custom_ids']);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x200201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y200201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }
}
