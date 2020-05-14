<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Html;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------来源模型-------------*/
class Source extends Model {

    function check($mix_source, $str_by = 'source_id', $num_notId = 0) {
        $_arr_select = array(
            'source_id',
        );

        $_arr_sourceRow = $this->read($mix_source, $str_by, $num_notId, $_arr_select);

        return $_arr_sourceRow;
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $mix_source
     * @param string $str_by (default: 'source_id')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function read($mix_source, $str_by = 'source_id', $num_notId = 0, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'source_id',
                'source_name',
                'source_author',
                'source_url',
                'source_note',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_source, $str_by, $num_notId);

        $_arr_sourceRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_sourceRow) {
            return array(
                'msg'   => 'Source not found',
                'rcode' => 'x260102', //不存在记录
            );
        }

        $_arr_sourceRow['rcode'] = 'y260102';
        $_arr_sourceRow['ms']    = '';

        return $this->rowProcess($_arr_sourceRow);
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_status (default: '')
     * @param string $str_type (default: '')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function lists($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_sourceSelect = array(
            'source_id',
            'source_name',
            'source_author',
            'source_url',
            'source_note',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_sourceRows = $this->where($_arr_where)->order('source_id', 'DESC')->limit($num_except, $num_no)->select($_arr_sourceSelect);

        foreach ($_arr_sourceRows as $_key=>$_value) {
            $_arr_sourceRows[$_key]  = $this->rowProcess($_value);
        }

        return $_arr_sourceRows;
    }


    function count($arr_search = array()) {

        $_arr_where = $this->queryProcess($arr_search);

        $_num_sourceCount = $this->where($_arr_where)->count();

        return $_num_sourceCount;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('source_name|source_author|source_note', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_source, $str_by = 'source_id', $num_notId = 0) {
        $_arr_where[] = array($str_by, '=', $mix_source);

        if ($num_notId > 0) {
            $_arr_where[] = array('source_id', '<>', $num_notId);
        }

        return $_arr_where;
    }


    protected function rowProcess($arr_sourceRow = array()) {
        if (isset($arr_sourceRow['source_url'])) {
            $arr_sourceRow['source_url']  = Html::decode($arr_sourceRow['source_url'], 'url');
        } else {
            $arr_sourceRow['source_url']  = '';
        }

        return $arr_sourceRow;
    }
}
