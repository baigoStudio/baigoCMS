<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Link as Link_Base;
use ginkgo\Arrays;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------链接模型-------------*/
class Link extends Link_Base {

    public $inputSubmit  = array();
    public $linkRowDo  = array();

    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_linkId
     * @param mixed $str_linkName
     * @param mixed $str_linkType
     * @param mixed $str_status
     * @return void
     */
    function submit() {
        $_arr_linkData = array(
            'link_name'     => $this->inputSubmit['link_name'],
            'link_url'      => $this->inputSubmit['link_url'],
            'link_type'     => $this->inputSubmit['link_type'],
            'link_status'   => $this->inputSubmit['link_status'],
            'link_cate_id'  => $this->inputSubmit['link_cate_id'],
            'link_blank'    => $this->inputSubmit['link_blank'],
        );

        if ($this->inputSubmit['link_id'] > 0) {
            $_str_hook = 'edit'; //编辑文章时触发
        } else {
            $_str_hook = 'add';
        }

        $_arr_linkData    = Plugin::listen('filter_console_link_' . $_str_hook, $_arr_linkData);

        $_mix_vld = $this->validate($_arr_linkData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'link_id'   => $this->inputSubmit['link_id'],
                'rcode'     => 'x240201',
                'msg'       => end($_mix_vld),
            );
        }

        if ($this->inputSubmit['link_id'] > 0) {
            $_num_linkId    = $this->inputSubmit['link_id'];

            $_num_count     = $this->where('link_id', '=', $_num_linkId)->update($_arr_linkData);

            if ($_num_count > 0) {
                $_str_rcode = 'y240103';
                $_str_msg   = 'Update link successfully';
            } else {
                $_str_rcode = 'x240103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_linkId     = $this->insert($_arr_linkData);

            if ($_num_linkId > 0) { //数据库插入是否成功
                $_str_rcode = 'y240101';
                $_str_msg   = 'Add link successfully';
            } else {
                $_str_rcode = 'x240101';
                $_str_msg   = 'Add link failed';
            }
        }

        return array(
            'link_id'   => $_num_linkId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->inputDelete['link_ids']
     * @return void
     */
    function delete() {
        $_num_count     = $this->where('link_id', 'IN', $this->inputDelete['link_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y240104';
            $_str_msg   = 'Successfully deleted {:count} links';
        } else {
            $_str_rcode = 'x240104';
            $_str_msg   = 'No link have been deleted';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        ); //成功
    }


    function status() {
        $_arr_linkData = array(
            'link_status' => $this->inputStatus['act'],
        );

        $_num_count     = $this->where('link_id', 'IN', $this->inputStatus['link_ids'])->upate($_arr_linkData);

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y240103';
            $_str_msg   = 'Successfully updated {:count} links';
        } else {
            $_str_rcode = 'x240103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        ); //成功
    }


    function order() {
        $_num_count = 0;

        foreach ($this->inputOrder['link_orders'] as $_key=>$_value) {
            $_arr_linkData = array(
                'link_order' => $_value,
            );

            $_num_count += $this->where('link_id', '=', $_key)->update($_arr_linkData); //更新数
        }

        if ($_num_count > 0) {
            $_str_rcode = 'y240103';
            $_str_msg   = 'Sorted successfully';
        } else {
            $_str_rcode = 'x240103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'link_id'       => array('int', 0),
            'link_name'     => array('str', ''),
            'link_url'      => array('str', ''),
            'link_type'     => array('str', ''),
            'link_status'   => array('str', ''),
            'link_cate_id'  => array('int', 0),
            'link_blank'    => array('int', 0),
            '__token__'     => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x240201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['link_id'] > 0) {
            $_arr_linkRow = $this->check($_arr_inputSubmit['link_id']);

            if ($_arr_linkRow['rcode'] != 'y240102') {
                return $_arr_linkRow;
            }
        }

        $_arr_linkRow = $this->check($_arr_inputSubmit['link_name'], 'link_name', $_arr_inputSubmit['link_id'], $_arr_inputSubmit['link_cate_id'], $_arr_inputSubmit['link_type']);

        if ($_arr_linkRow['rcode'] == 'y240102') {
            return array(
                'msg'   => 'Link already exists',
                'rcode' => 'x240404', //不存在记录
            );
        }

        $_arr_inputSubmit['rcode'] = 'y240201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    function inputOrder() {
        $_arr_inputParam = array(
            'link_orders'   => array('arr', array()),
            '__token__'     => array('str', ''),
        );

        $_arr_inputOrder = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputOrder, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x240201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputOrder['rcode'] = 'y240201';

        $this->inputOrder = $_arr_inputOrder;

        return $_arr_inputOrder;
    }


    function inputCommon() {
        $_arr_inputParam = array(
            '__token__' => array('str', ''),
        );

        $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x240201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputCommon['rcode'] = 'y240201';

        $this->inputCommon = $_arr_inputCommon;

        return $_arr_inputCommon;
    }


    /**
     * input_ids function.
     *
     * @access public
     * @return void
     */
    function inputDelete() {
        $_arr_inputParam = array(
            'link_ids' => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['link_ids'] = Arrays::filter($_arr_inputDelete['link_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x240201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y240201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'link_ids' => array('arr', array()),
            'act'       => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputStatus);

        $_arr_inputStatus['link_ids'] = Arrays::filter($_arr_inputStatus['link_ids']);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x240201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y240201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }
}
