<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Gather as Gather_Base;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------文章模型-------------*/
class Gather extends Gather_Base {

    function store() {
        $_arr_gatherData = array(
            'gather_article_id' => $this->inputStore['article_id'],
        );

        $num_gatherId   = $this->inputStore['gather_id'];

        $_num_count     = $this->where('gather_id', '=', $num_gatherId)->update($_arr_gatherData);

        if ($_num_count > 0) { //数据库插入是否成功
            $_str_rcode = 'y280103';
            $_str_msg   = 'Stored successfully';
        } else {
            $_str_rcode = 'x280103';
            $_str_msg   = 'Stored failed';
        }

        /*print_r($_arr_userRow);
        exit;*/

        return array(
            'gather_id' => $num_gatherId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @param int $num_adminId (default: 0)
     * @param mixed $str_status
     * @return void
     */
    function submit($arr_gatherSubmit) {
        $_arr_gatherData = array(
            'gather_time'       => GK_NOW,
        );

        if (isset($arr_gatherSubmit['gather_title'])) {
            $_arr_gatherData['gather_title']      = $this->obj_request->input($arr_gatherSubmit['gather_title'], 'str', '');
        }

        if (isset($arr_gatherSubmit['gather_time_show'])) {
            $_arr_gatherData['gather_time_show']  = $this->obj_request->input($arr_gatherSubmit['gather_time_show'], 'int', 0);
        } else if (isset($arr_gatherSubmit['gather_time_show_format'])) {
            $_arr_gatherData['gather_time_show']  = Func::strtotime($this->obj_request->input($arr_gatherSubmit['gather_time_show_format'], 'str', ''));
        }

        if (isset($arr_gatherSubmit['gather_content'])) {
            $_arr_gatherData['gather_content']    = $this->obj_request->input($arr_gatherSubmit['gather_content'], 'str', '');
        }

        if (isset($arr_gatherSubmit['gather_source'])) {
            $_arr_gatherData['gather_source']     = $this->obj_request->input($arr_gatherSubmit['gather_source'], 'str', '');
        }

        if (isset($arr_gatherSubmit['gather_source_url'])) {
            $_arr_gatherData['gather_source_url'] = $this->obj_request->input($arr_gatherSubmit['gather_source_url'], 'str', '');
        }

        if (isset($arr_gatherSubmit['gather_author'])) {
            $_arr_gatherData['gather_author']     = $this->obj_request->input($arr_gatherSubmit['gather_author'], 'str', '');
        }

        if (isset($arr_gatherSubmit['gather_cate_id'])) {
            $_arr_gatherData['gather_cate_id']    = $this->obj_request->input($arr_gatherSubmit['gather_cate_id'], 'int', 0);
        }

        if (isset($arr_gatherSubmit['gather_gsite_id'])) {
            $_arr_gatherData['gather_gsite_id']   = $this->obj_request->input($arr_gatherSubmit['gather_gsite_id'], 'int', 0);
        }

        if (isset($arr_gatherSubmit['gather_admin_id'])) {
            $_arr_gatherData['gather_admin_id']   = $this->obj_request->input($arr_gatherSubmit['gather_admin_id'], 'int', 0);
        }

        $_mix_vld = $this->validate($_arr_gatherData, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'gather_id' => 0,
                'rcode'     => 'x280201',
                'msg'       => end($_mix_vld),
            );
        }

        $_num_gatherId     = $this->insert($_arr_gatherData);

        if ($_num_gatherId > 0) { //数据库插入是否成功
            $_str_rcode = 'y280101';
            $_str_msg   = 'Gather successfully';
        } else {
            $_str_rcode = 'x280101';
            $_str_msg   = 'Gather failed';
        }

        /*print_r($_arr_userRow);
        exit;*/

        return array(
            'gather_id' => $_num_gatherId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    /** 删除
     * mdl_del function.
     *
     * @access public
     * @param bool $arr_cateIds (default: false)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function delete($arr_cateIds = false, $num_adminId = 0) {
        $_arr_where[] = array('gather_id', 'IN', $this->inputDelete['gather_ids'], 'gather_ids');

        if (!Func::isEmpty($arr_cateIds)) {
            $arr_cateIds = Func::arrayFilter($arr_cateIds);

            $_arr_where[] = array('gather_cate_id', 'IN', $arr_cateIds, 'cate_ids');
        }

        if ($num_adminId > 0) {
            $_arr_where[] = array('gather_admin_id', '=', $num_adminId);
        }

        $_num_count     = $this->where('custom_id', '=', $_num_customId)->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y280104';
            $_str_msg   = 'Successfully deleted {:count} datas';
        } else {
            $_str_rcode = 'x280104';
            $_str_msg   = 'No data have been deleted';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        ); //成功
    }



    /** 列出不重复的年份
     * mdl_year function.
     *
     * @access public
     * @return void
     */
    function year() {
        $_arr_gatherSelect = array(
            'DISTINCT FROM_UNIXTIME(`gather_time_show`, \'%Y\') AS `gather_year`',
        );

        $_arr_gatherRows     = $this->where('gather_time_show', '>', 0)->order('gather_time', 'ASC')->limit(100)->select($_arr_gatherSelect);

        return $_arr_gatherRows;
    }


    function inputStore() {
        $_arr_inputParam = array(
            'gather_id' => array('int', 0),
            'enforce'   => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputStore = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputStore, '', 'store');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x280201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStore['rcode'] = 'y280201';

        $this->inputStore = $_arr_inputStore;

        return $_arr_inputStore;
    }


    function inputGrab() {
        $_arr_inputParam = array(
            'gsite_id'  => array('int', 0),
            'url'       => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputGrab = $this->obj_request->post($_arr_inputParam);

        //print_r($this->inputGrab);

        $_mix_vld = $this->validate($_arr_inputGrab, '', 'grab');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x280201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputGrab['rcode'] = 'y280201';

        $this->inputGrab = $_arr_inputGrab;

        return $_arr_inputGrab;
    }



    /** 批量操作选择
     * input_ids function.
     *
     * @access public
     * @return void
     */
    function inputDelete() {
        $_arr_inputParam = array(
            'gather_ids' => array('arr', array()),
            '__token__'  => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['gather_ids'] = Func::arrayFilter($_arr_inputDelete['gather_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x280201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y280201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }
}
