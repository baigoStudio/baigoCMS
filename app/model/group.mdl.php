<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Json;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------群组模型-------------*/
class Group extends Model {

    public $arr_status = array('enable', 'disabled');
    public $arr_target   = array('admin'/*, 'user'*/);

    function check($mix_group, $str_by = 'group_id', $str_target = '') {
        $_arr_select = array(
            'group_id',
        );

        $_arr_groupRow = $this->read($mix_group, $str_by, $str_target, $_arr_select);

        return $_arr_groupRow;
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $mix_group
     * @param string $str_by (default: 'group_id')
     * @param int $str_target (default: 0)
     * @return void
     */
    function read($mix_group, $str_by = 'group_id', $str_target = '', $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'group_id',
                'group_name',
                'group_note',
                'group_allow',
                'group_target',
                'group_status',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_group, $str_by, $str_target);

        $_arr_groupRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_groupRow) {
            return array(
                'msg'   => 'Group not found',
                'rcode' => 'x040102', //不存在记录
            );
        }

        $_arr_groupRow['rcode'] = 'y040102';
        $_arr_groupRow['msg']   = '';

        //print_r($_arr_groupRow);

        return $this->rowProcess($_arr_groupRow);
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param string $str_key (default: '')
     * @param string $str_target (default: '')
     * @return void
     */
    function lists($num_no, $num_except = 0, $arr_search = array()) {

        $_arr_groupSelect = array(
            'group_id',
            'group_name',
            'group_note',
            'group_target',
            'group_status',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_groupRows = $this->where($_arr_where)->order('group_id', 'DESC')->limit($num_except, $num_no)->select($_arr_groupSelect);

        return $_arr_groupRows;

    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_status (default: '')
     * @return void
     */
    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        $_num_groupCount = $this->where($_arr_where)->count();

        return $_num_groupCount;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('group_name|group_note', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['target']) && !Func::isEmpty($arr_search['target'])) {
            $_arr_where[] = array('group_target', '=', $arr_search['target']);
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('group_status', '=', $arr_search['status']);
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_group, $str_by = 'group_id', $str_target = '') {
        $_arr_where[] = array($str_by, '=', $mix_group);

        if (!Func::isEmpty($str_target)) {
            $_arr_where[] = array('group_target', '=', $str_target);
        }

        return $_arr_where;
    }


    protected function rowProcess($arr_groupRow = array()) {
        if (isset($arr_groupRow['group_allow'])) {
            $arr_groupRow['group_allow'] = Json::decode($arr_groupRow['group_allow']); //json解码
        } else {
            $arr_groupRow['group_allow'] = array();
        }

        return $arr_groupRow;
    }
}
