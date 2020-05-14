<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Cate as Cate_Base;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Plugin;
use ginkgo\Cache;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------栏目模型-------------*/
class Cate extends Cate_Base {

    function m_init() { //构造函数
        parent::m_init();

        $this->configDefault = Config::get('var_default');

        $this->obj_cache     = Cache::instance();
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $mix_cate
     * @param string $str_by (default: 'cate_id')
     * @param int $num_notId (default: 0)
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function read($mix_cate, $str_by = 'cate_id') {
        $_arr_select = array(
            'cate_id',
            'cate_name',
            'cate_alias',
            'cate_tpl',
            'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_prefix',
            'cate_perpage',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
            'cate_status',
            'cate_order',
        );

        $_arr_cateRow = $this->readProcess($mix_cate, $str_by, 0, -1, $_arr_select);

        if (!$_arr_cateRow) {
            return array(
                'rcode' => 'x250102', //不存在记录
            );
        }

        $_arr_cateRow['rcode']    = 'y250102';

        return $this->rowProcess($_arr_cateRow);
    }


    function lists($num_no, $num_except = 0, $arr_search = array(), $arr_select = array()) {
        $_arr_select = array(
            'cate_id',
            'cate_name',
            'cate_link',
            'cate_alias',
            'cate_status',
            'cate_parent_id',
            'cate_prefix',
            'cate_order',
            'cate_perpage',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
        );

        $_arr_cateRows = parent::lists($num_no, $num_except, $arr_search, $_arr_select);

        //print_r($_arr_cateRows);

        return $_arr_cateRows;
    }


    function submit() {
        $_arr_cateData = array(
            'cate_name'         => $this->inputSubmit['cate_name'],
            'cate_alias'        => $this->inputSubmit['cate_alias'],
            'cate_status'       => $this->inputSubmit['cate_status'],
            'cate_tpl'          => $this->inputSubmit['cate_tpl'],
            'cate_content'      => $this->inputSubmit['cate_content'],
            'cate_link'         => $this->inputSubmit['cate_link'],
            'cate_parent_id'    => $this->inputSubmit['cate_parent_id'],
            'cate_prefix'       => $this->inputSubmit['cate_prefix'],
            'cate_perpage'      => $this->inputSubmit['cate_perpage'],
            'cate_ftp_host'     => $this->inputSubmit['cate_ftp_host'],
            'cate_ftp_port'     => $this->inputSubmit['cate_ftp_port'],
            'cate_ftp_user'     => $this->inputSubmit['cate_ftp_user'],
            'cate_ftp_pass'     => $this->inputSubmit['cate_ftp_pass'],
            'cate_ftp_path'     => $this->inputSubmit['cate_ftp_path'],
            'cate_ftp_pasv'     => $this->inputSubmit['cate_ftp_pasv'],
        );

        if ($this->inputSubmit['cate_id'] > 0) {
            $_str_hook = 'edit'; //编辑文章时触发
        } else {
            $_str_hook = 'add';
        }

        $_mix_result    = Plugin::listen('filter_console_cate_' . $_str_hook, $_arr_cateData); //编辑文章时触发
        $_arr_cateData  = Plugin::resultProcess($_arr_cateData, $_mix_result);

        $_mix_vld = $this->validate($_arr_cateData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'cate_id'   => $this->inputSubmit['cate_id'],
                'rcode'     => 'x250201',
                'msg'       => end($_mix_vld),
            );
        }

            //print_r($_arr_cateData);

        if ($this->inputSubmit['cate_id'] > 0) { //插入
            $_num_cateId = $this->inputSubmit['cate_id'];

            $_num_count     = $this->where('cate_id', '=', $_num_cateId)->update($_arr_cateData); //更新数

            if ($_num_count > 0) { //数据库更新是否成功
                $_str_rcode = 'y250103';
                $_str_msg   = 'Update category successfully';
            } else {
                $_str_rcode = 'x250103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_cateId    = $this->insert($_arr_cateData); //更新数

            if ($_num_cateId > 0) { //数据库插入是否成功
                $_str_rcode = 'y250101';
                $_str_msg   = 'Add category successfully';
            } else {
                $_str_rcode = 'x250101';
                $_str_msg   = 'Add category failed';
            }
        }

        return array(
            'cate_id'   => $_num_cateId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    function order() {
        $_num_count = 0;

        foreach ($this->inputOrder['cate_orders'] as $_key=>$_value) {
            $_arr_cateData = array(
                'cate_order' => $_value,
            );

            $_num_count += $this->where('cate_id', '=', $_key)->update($_arr_cateData); //更新数
        }

        if ($_num_count > 0) {
            $_str_rcode = 'y250103';
            $_str_msg   = 'Sorted successfully';
        } else {
            $_str_rcode = 'x250103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    /**
     * status function.
     *
     * @access public
     * @param mixed $this->cateIds['cate_ids']
     * @param mixed $str_status
     * @return void
     */
    function status() {
        $_arr_cateData = array(
            'cate_status' => $this->inputStatus['act'],
        );

        $_num_count = $this->where('cate_id', 'IN', $this->inputStatus['cate_ids'])->update($_arr_cateData); //更新数

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y250103';
            $_str_msg   = 'Successfully updated {:count} categories';
        } else {
            $_str_rcode = 'x250103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功
    }

    /**
     * del function.
     *
     * @access public
     * @return void
     */
    function delete() {
        $_num_count = $this->where('cate_id', 'IN', $this->inputDelete['cate_ids'])->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y250104';
            $_str_msg   = 'Successfully deleted {:count} categories';

            $_arr_cateData = array(
                'cate_parent_id' => 0
            );

            $this->where('cate_parent_id', 'IN', $this->inputDelete['cate_ids'])->update($_arr_cateData);

            $_arr_articleData = array(
                'article_cate_id' => -1
            );

            $this->table('article')->where('article_cate_id', 'IN', $this->inputDelete['cate_ids'])->update($_arr_articleData);

            $this->table('cate_belong')->where('belong_cate_id', 'IN', $this->inputDelete['cate_ids'])->delete();

            foreach ($this->inputDelete['cate_ids'] as $_key=>$_value) {
                $this->obj_cache->delete('cate_' . $_value);
            }
        } else {
            $_str_rcode = 'x250104';
            $_str_msg   = 'No category have been deleted';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功
    }


    function duplicate() {
        $_arr_cateData = array(
            'cate_name',
            //'cate_alias',
            'cate_tpl',
            'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_prefix',
            'cate_perpage',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
            'cate_status',
        );

        $_num_cateId = $this->where('cate_id', '=', $this->inputDuplicate['cate_id'])->duplicate($_arr_cateData);

        if ($_num_cateId > 0) { //数据库更新是否成功
            $_str_rcode = 'y250101';
            $_str_msg   = 'Duplicate category successfully';
        } else {
            $_str_rcode = 'x250101';
            $_str_msg   = 'Duplicate category failed';
        }


        return array(
            'cate_id'   => $_num_cateId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    function chkAttach($arr_attachRow) {
        return $this->where('cate_content', 'LIKE', '%' . $arr_attachRow['attach_url_name'] . '%')->find('cate_id');
    }


    /**
     * input_submit function.
     *
     * @access public
     * @return void
     */
    function inputSubmit() {
        $_arr_inputParam = array(
            'cate_id'           => array('int', 0),
            'cate_name'         => array('str', ''),
            'cate_prefix'       => array('str', ''),
            'cate_tpl'          => array('str', ''),
            'cate_content'      => array('str', '', true),
            'cate_link'         => array('str', ''),
            'cate_parent_id'    => array('int', 0),
            'cate_alias'        => array('str', ''),
            'cate_perpage'      => array('int', 0),
            'cate_status'       => array('str', ''),
            'cate_ftp_host'     => array('str', ''),
            'cate_ftp_port'     => array('str', ''),
            'cate_ftp_user'     => array('str', ''),
            'cate_ftp_pass'     => array('str', ''),
            'cate_ftp_path'     => array('str', ''),
            'cate_ftp_pasv'     => array('str', ''),
            '__token__'         => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x250201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['cate_id'] > 0) {
            if ($_arr_inputSubmit['cate_parent_id'] > 0 && $_arr_inputSubmit['cate_id'] == $_arr_inputSubmit['cate_parent_id']) {
                return array(
                    'rcode' => 'x250201',
                    'msg'   => 'Can not belong to current category',
                );
            }

            $_arr_cateRow = $this->check($_arr_inputSubmit['cate_id']);

            if ($_arr_cateRow['rcode'] != 'y250102') {
                return $_arr_cateRow;
            }
        }

        if ($_arr_inputSubmit['cate_parent_id'] > 0) {
            $_arr_cateRow = $this->check($_arr_inputSubmit['cate_parent_id']);

            if ($_arr_cateRow['rcode'] != 'y250102') {
                return array(
                    'rcode' => $_arr_cateRow['rcode'],
                    'msg'   => 'Parent category not found',
                );
            }
        }

        if (!Func::isEmpty($_arr_inputSubmit['cate_alias'])) {
            $_arr_cateRow = $this->check($_arr_inputSubmit['cate_alias'], 'cate_alias', $_arr_inputSubmit['cate_id'], $_arr_inputSubmit['cate_parent_id']);

            if ($_arr_cateRow['rcode'] == 'y250102') {
                return array(
                    'rcode' => 'x250404',
                    'msg'   => 'Alias already exists',
                );
            }
        }

        if (is_numeric($_arr_inputSubmit['cate_alias'])) {
            $_arr_cateRow = $this->check($_arr_inputSubmit['cate_alias'], 'cate_id', $_arr_inputSubmit['cate_id'], $_arr_inputSubmit['cate_parent_id']);
            if ($_arr_cateRow['rcode'] == 'y250102') {
                return array(
                    'rcode' => 'x250404',
                    'msg'   => 'Alias already exists',
                );
            }
        }

        $_arr_inputSubmit['rcode'] = 'y250201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    function inputCommon() {
        $_arr_inputParam = array(
            '__token__' => array('str', ''),
        );

        $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x250201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputCommon['rcode'] = 'y250201';

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
            'cate_ids'  => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['cate_ids'] = Func::arrayFilter($_arr_inputDelete['cate_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x250201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y250201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'cate_ids'  => array('arr', array()),
            'act'       => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputStatus);

        $_arr_inputStatus['cate_ids'] = Func::arrayFilter($_arr_inputStatus['cate_ids']);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x250201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y250201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }


    function inputDuplicate() {
        $_arr_inputParam = array(
            'cate_id'   => array('int', 0),
            '__token__' => array('str', ''),
        );

        $_arr_inputDuplicate = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputDuplicate, '', 'duplicate');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x250201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_cateRow = $this->check($_arr_inputDuplicate['cate_id']);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $_arr_cateRow;
        }

        $_arr_inputDuplicate['rcode'] = 'y250201';

        $this->inputDuplicate = $_arr_inputDuplicate;

        return $_arr_inputDuplicate;
    }


    function inputOrder() {
        $_arr_inputParam = array(
            'cate_orders'   => array('arr', array()),
            '__token__'     => array('str', ''),
        );

        $_arr_inputOrder = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputOrder, '', 'order');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x250201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputOrder['rcode'] = 'y250201';

        $this->inputOrder = $_arr_inputOrder;

        return $_arr_inputOrder;
    }
}
