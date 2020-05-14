<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use ginkgo\Model;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------TAG 模型-------------*/
class Album_View extends Model {

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
        $_arr_albumSelect = array(
            'album_id',
            'album_name',
            'album_status',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_group = array('album_id');

        $_arr_albumRows = $this->where($_arr_where)->order('album_id', 'DESC')->group($_arr_group)->limit($num_except, $num_no)->select($_arr_albumSelect);

        return $_arr_albumRows;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['attach_id']) && $arr_search['attach_id'] > 0) {
            $_arr_where[] = array('belong_attach_id', '=', $arr_search['attach_id']);
        }

        return $_arr_where;
    }
}
