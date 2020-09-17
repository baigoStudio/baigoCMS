<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Json;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------管理员模型-------------*/
class Admin extends Model {

    public $arr_status  = array('enable', 'disabled'); //状态
    public $arr_type    = array('normal', 'super'); //类型


    function check($mix_admin, $str_by = 'admin_id', $num_notId = 0) {
        $_arr_select = array(
            'admin_id',
        );

        return $this->readProcess($mix_admin, $str_by, $num_notId, $_arr_select);
    }


    /** 读取
     * read function.
     *
     * @access public
     * @param mixed $mix_admin
     * @param string $str_by (default: 'admin_id')
     * @param int $num_notId (default: 0)
     * @return void
     */
    function read($mix_admin, $str_by = 'admin_id', $num_notId = 0, $arr_select = array()) {
        $_arr_adminRow = $this->readProcess($mix_admin, $str_by, $num_notId, $arr_select);;

        if ($_arr_adminRow['rcode'] != 'y020102') {
            return $_arr_adminRow;
        }

        return $this->rowProcess($_arr_adminRow);
    }


    function readProcess($mix_admin, $str_by = 'admin_id', $num_notId = 0, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'admin_id',
                'admin_name',
                'admin_note',
                'admin_nick',
                'admin_allow_cate',
                'admin_allow_profile',
                'admin_prefer',
                'admin_status',
                'admin_type',
                'admin_time',
                'admin_time_login',
                'admin_ip',
                'admin_shortcut',
                'admin_group_id',
                'admin_access_token',
                'admin_access_expire',
                'admin_refresh_token',
                'admin_refresh_expire',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_admin, $str_by, $num_notId);

        $_arr_adminRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_adminRow) {
            return array(
                'msg'   => 'Administrator not found',
                'rcode' => 'x020102', //不存在记录
            );
        }

        $_arr_adminRow['rcode']   = 'y020102';
        $_arr_adminRow['msg']     = '';

        return $_arr_adminRow;
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function lists($pagination = 0, $arr_search = array()) {
        $_arr_adminSelect = array(
            'admin_id',
            'admin_name',
            'admin_note',
            'admin_nick',
            'admin_status',
            'admin_type',
            'admin_group_id',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('admin_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_adminSelect);

        return $_arr_getData;
    }



    /** 计数
     * mdl_count function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        $_num_adminCount = $this->where($_arr_where)->count();

        return $_num_adminCount;
    }


    function login() {
        $_tm_timeLogin  = GK_NOW;
        $_str_adminIp   = $this->obj_request->ip();

        $_arr_adminData = array(
            'admin_time_login'  => $_tm_timeLogin,
            'admin_ip'          => $_str_adminIp,
        );

        if ($this->inputSubmit['admin_access_token']) {
            $_arr_adminData['admin_access_token'] = $this->inputSubmit['admin_access_token'];
        }

        if ($this->inputSubmit['admin_access_expire']) {
            $_arr_adminData['admin_access_expire'] = $this->inputSubmit['admin_access_expire'];
        }

        if ($this->inputSubmit['admin_refresh_token']) {
            $_arr_adminData['admin_refresh_token'] = $this->inputSubmit['admin_refresh_token'];
        }

        if ($this->inputSubmit['admin_refresh_expire']) {
            $_arr_adminData['admin_refresh_expire'] = $this->inputSubmit['admin_refresh_expire'];
        }

        $_num_count     = $this->where('admin_id', '=', $this->inputSubmit['admin_id'])->update($_arr_adminData); //更新数

        if ($_num_count > 0) {
            $_str_rcode = 'y020103'; //更新成功
            $_str_msg   = 'Update administrator successfully';
        } else {
            $_str_rcode = 'x020103'; //更新成功
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'admin_id'          => $this->inputSubmit['admin_id'],
            //'admin_name'        => $arr_adminSubmit['admin_name'],
            'admin_ip'          => $_str_adminIp,
            'admin_time_login'  => $_tm_timeLogin,
            'rcode'             => $_str_rcode, //成功
        );
    }


    /** 列出及统计 SQL 处理
     * sqlProcess function.
     *
     * @access private
     * @param array $arr_search (default: array())
     * @return void
     */
    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('admin_name|admin_note|admin_nick', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['group_id']) && $arr_search['group_id'] > 0) {
            $_arr_where[] = array('admin_group_id', '=', $arr_search['group_id']);
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('admin_status', '=', $arr_search['status']);
        }

        if (isset($arr_search['type']) && !Func::isEmpty($arr_search['type'])) {
            $_arr_where[] = array('admin_type', '=', $arr_search['type']);
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_admin, $str_by = 'admin_id', $num_notId = 0) {
        $_arr_where[] = array($str_by, '=', $mix_admin);

        if ($num_notId > 0) {
            $_arr_where[] = array('admin_id', '<>', $num_notId);
        }

        return $_arr_where;
    }


    protected function rowProcess($arr_adminRow = array()) {
        if (isset($arr_adminRow['admin_allow_cate'])) {
            $arr_adminRow['admin_allow_cate'] = Json::decode($arr_adminRow['admin_allow_cate']); //json 解码
        } else {
            $arr_adminRow['admin_allow_cate'] = array();
        }

        //print_r($arr_adminRow['admin_allow_cate']);

        if (isset($arr_adminRow['admin_allow_profile'])) {
            $arr_adminRow['admin_allow_profile'] = Json::decode($arr_adminRow['admin_allow_profile']); //json 解码
        } else {
            $arr_adminRow['admin_allow_profile'] = array();
        }

        if (isset($arr_adminRow['admin_shortcut'])) {
            $arr_adminRow['admin_shortcut'] = Json::decode($arr_adminRow['admin_shortcut']); //json 解码
        } else {
            $arr_adminRow['admin_shortcut'] = array();
        }

        if (isset($arr_adminRow['admin_prefer'])) {
            $arr_adminRow['admin_prefer'] = Json::decode($arr_adminRow['admin_prefer']); //json 解码
        } else {
            $arr_adminRow['admin_prefer'] = array();
        }

        return $arr_adminRow;
    }
}
