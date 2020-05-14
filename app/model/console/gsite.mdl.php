<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Gsite as Gsite_Base;
use ginkgo\Func;
use ginkgo\Json;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------采集点模型-------------*/
class Gsite extends Gsite_Base {

    function duplicate() {
        $_arr_gsiteData = array(
            'gsite_name',
            'gsite_url',
            'gsite_status',
            'gsite_keep_tag',
            'gsite_note',
            'gsite_cate_id',
            'gsite_charset',
            'gsite_list_selector',
            'gsite_title_selector',
            'gsite_title_attr',
            'gsite_title_filter',
            'gsite_title_replace',
            'gsite_content_selector',
            'gsite_content_attr',
            'gsite_content_filter',
            'gsite_content_replace',
            'gsite_time_selector',
            'gsite_time_attr',
            'gsite_time_filter',
            'gsite_time_replace',
            'gsite_source_selector',
            'gsite_source_attr',
            'gsite_source_filter',
            'gsite_source_replace',
            'gsite_author_selector',
            'gsite_author_attr',
            'gsite_author_filter',
            'gsite_author_replace',
            'gsite_page_list_selector',
            'gsite_page_content_selector',
            'gsite_page_content_attr',
            'gsite_page_content_filter',
            'gsite_page_content_replace',
            'gsite_img_filter',
            'gsite_img_src',
            'gsite_attr_allow',
            'gsite_ignore_tag',
            'gsite_attr_except',
        );

        $_num_gsiteId = $this->where('gsite_id', '=', $this->inputDuplicate['gsite_id'])->duplicate($_arr_gsiteData);

        if ($_num_gsiteId > 0) { //数据库更新是否成功
            $_str_rcode = 'y270112';
            $_str_msg   = 'Duplicate site successfully';
        } else {
            $_str_rcode = 'x270112';
            $_str_msg   = 'Duplicate site failed';
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_gsiteId
     * @param mixed $str_gsiteName
     * @param mixed $str_gsiteType
     * @param string $str_gsiteNote (default: '')
     * @param string $str_gsiteAllow (default: '')
     * @return void
     */
    function submit() {
        $_arr_gsiteData = array(
            'gsite_name'    => $this->inputSubmit['gsite_name'],
            'gsite_url'     => $this->inputSubmit['gsite_url'],
            'gsite_status'  => $this->inputSubmit['gsite_status'],
            'gsite_note'    => $this->inputSubmit['gsite_note'],
            'gsite_cate_id' => $this->inputSubmit['gsite_cate_id'],
            'gsite_charset' => strtoupper($this->inputSubmit['gsite_charset']),
        );

        $_mix_vld = $this->validate($_arr_gsiteData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270201',
                'msg'       => end($_mix_vld),
            );
        }

        if ($this->inputSubmit['gsite_id'] > 0) { //插入
            $_num_gsiteId   = $this->inputSubmit['gsite_id'];

            $_num_count     = $this->where('gsite_id', '=', $_num_gsiteId)->update($_arr_gsiteData);

            if ($_num_count > 0) { //数据库更新是否成功
                $_str_rcode = 'y270103';
                $_str_msg   = 'Update site successfully';
            } else {
                $_str_rcode = 'x270103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_gsiteId   = $this->insert($_arr_gsiteData);

            if ($_num_gsiteId > 0) { //数据库插入是否成功
                $_str_rcode = 'y270101';
                $_str_msg   = 'Add site successfully';
            } else {
                $_str_rcode = 'x270101';
                $_str_msg   = 'Add site failed';
            }
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    function status() {
        $_arr_gsiteUpdate = array(
            'gsite_status' => $this->inputStatus['act'],
        );

        $_num_count     = $this->where('gsite_id', 'IN', $this->inputStatus['gsite_ids'])->update($_arr_gsiteUpdate);

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y270103';
            $_str_msg   = 'Successfully updated {:count} sites';
        } else {
            $_str_rcode = 'x270103';
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
     * @param mixed $this->inputDelete['gsite_ids']
     * @return void
     */
    function delete() {
        $_num_count     = $this->where('gsite_id', 'IN', $this->inputDelete['gsite_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y270104';
            $_str_msg   = 'Successfully deleted {:count} sites';
        } else {
            $_str_rcode = 'x270104';
            $_str_msg   = 'No site have been deleted';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function inputDuplicate() {
        $_arr_inputParam = array(
            'gsite_id'   => array('int', 0),
            '__token__'  => array('str', ''),
        );

        $_arr_inputDuplicate = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputDuplicate, '', 'duplicate');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x270201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_gsiteRow = $this->check($_arr_inputDuplicate['gsite_id']);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_inputDuplicate['rcode'] = 'y270201';

        $this->inputDuplicate = $_arr_inputDuplicate;

        return $_arr_inputDuplicate;
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'gsite_id'      => array('int', 0),
            'gsite_name'    => array('str', ''),
            'gsite_url'     => array('str', ''),
            'gsite_cate_id' => array('int', 0),
            'gsite_status'  => array('str', ''),
            'gsite_note'    => array('str', ''),
            'gsite_charset' => array('str', ''),
            '__token__'     => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x270201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['gsite_id'] > 0) {
            $_arr_gsiteRow = $this->check($_arr_inputSubmit['gsite_id']);

            if ($_arr_gsiteRow['rcode'] != 'y270102') {
                return $_arr_gsiteRow;
            }
        }

        $_arr_inputSubmit['rcode'] = 'y270201';

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
            'gsite_ids' => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        $_arr_inputDelete['gsite_ids'] = Func::arrayFilter($_arr_inputDelete['gsite_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x270201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y270201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'gsite_ids' => array('arr', array()),
            'act'       => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputStatus);

        $_arr_inputStatus['gsite_ids'] = Func::arrayFilter($_arr_inputStatus['gsite_ids']);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x270201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y270201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }
}
