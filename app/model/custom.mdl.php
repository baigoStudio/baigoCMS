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

/*-------------自定义字段模型-------------*/
class Custom extends Model {

    public $arr_status = array('enable', 'disabled');
    public $arr_type   = array('str', 'radio', 'select');
    public $arr_format = array('text', 'date', 'date_time', 'int', 'digit', 'url', 'email');


    function check($mix_custom, $str_by = 'custom_id', $num_notId = 0) {
        $_arr_select = array(
            'custom_id',
        );

        return $this->readProcess($mix_custom, $str_by, $num_notId, $_arr_select);
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $mix_custom
     * @param string $str_by (default: 'custom_id')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function read($mix_custom, $str_by = 'custom_id', $num_notId = 0) {
        $_arr_customRow = $this->readProcess($mix_custom, $str_by, $num_notId);

        if ($_arr_customRow['rcode'] != 'y200102') {
            return $_arr_customRow;
        }

        return $this->rowProcess($_arr_customRow);
    }


    function readProcess($mix_custom, $str_by = 'custom_id', $num_notId = 0, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'custom_id',
                'custom_name',
                'custom_type',
                'custom_opt',
                'custom_status',
                'custom_parent_id',
                'custom_cate_id',
                'custom_format',
                'custom_size',
                'custom_order',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_custom, $str_by, $num_notId);

        $_arr_customRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_customRow) {
            return array(
                'rcode' => 'x200102', //不存在记录
                'msg'   => 'Field not found', //不存在记录
            );
        }

        $_arr_customRow['rcode']    = 'y200102';
        $_arr_customRow['msg']      = '';

        return $_arr_customRow;
    }


    function listsTree($arr_search = array(), $num_level = 1) {
        $_arr_customs    = array();

        $_arr_getData = $this->lists(array(1000, 'limit'), $arr_search);

        foreach ($_arr_getData as $_key=>$_value) {
            $_arr_customs[$_value['custom_id']]                     = $_value;
            $_arr_customs[$_value['custom_id']]['custom_level']     = $num_level;
            $arr_search['parent_id']                                = $_value['custom_id'];
            $_arr_customs[$_value['custom_id']]['custom_childs']    = $this->listsTree($arr_search, $num_level + 1);
        }

        return $_arr_customs;
    }


    function lists($pagination = 0, $arr_search = array()) {
        $_arr_customSelect = array(
            'custom_id',
            'custom_name',
            'custom_type',
            'custom_opt',
            'custom_status',
            'custom_parent_id',
            'custom_cate_id',
            'custom_format',
            'custom_size',
            'custom_order',
        );

        $_arr_order = array(
            array('custom_order', 'ASC'),
            array('custom_id', 'ASC'),
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order($_arr_order)->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_customSelect);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_eachData = &$_arr_getData['dataRows'];
        } else {
            $_arr_eachData = &$_arr_getData;
        }

        foreach ($_arr_eachData as $_key=>&$_value) {
            $_value = $this->rowProcess($_value);
        }

        return $_arr_getData;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_target (default: '')
     * @return void
     */
    function count($arr_search = array()) {

        $_arr_where = $this->queryProcess($arr_search);

        $_num_customCount = $this->where($_arr_where)->count();

        return $_num_customCount;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['parent_id'])) {
            $_arr_where[] = array('custom_parent_id', '=', $arr_search['parent_id']);
        }

        if (isset($arr_search['cate_id']) && $arr_search['cate_id'] > 0) {
            $_arr_where[] = array('custom_cate_id', '=', $arr_search['cate_id']);
        }

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('custom_name', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('custom_status', '=', $arr_search['status']);
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_custom, $str_by = 'custom_id', $num_notId) {
        $_arr_where[] = array($str_by, '=', $mix_custom);

        if ($num_notId > 0) {
            $_arr_where[] = array('cate_id', '<>', $num_notId);
        }

        return $_arr_where;
    }

    protected function rowProcess($arr_customRow = array()) {
        if (isset($arr_customRow['custom_opt'])) {
            $arr_customRow['custom_opt'] = Json::decode($arr_customRow['custom_opt']);
        } else {
            $arr_customRow['custom_opt'] = array();
        }

        return $arr_customRow;
    }
}
