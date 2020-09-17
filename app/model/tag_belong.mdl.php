<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------TAG 归属模型-------------*/
class Tag_Belong extends Model {

    function ids($arr_search) {
        $_arr_belongSelect = array(
            'belong_tag_id',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_belongRows = $this->where($_arr_where)->select($_arr_belongSelect);

        $_arr_tagIds = array();

        foreach ($_arr_belongRows as $_key=>$_value) {
            $_arr_tagIds[]   = $_value['belong_tag_id'];
        }

        return Func::arrayFilter($_arr_tagIds);
    }


    function read($num_tagId = 0, $num_articleId = 0) {
        $_arr_belongSelect = array(
            'belong_id',
            'belong_article_id',
            'belong_tag_id',
        );

        $_arr_where = $this->readQueryProcess($num_tagId, $num_articleId);

        $_arr_belongRow = $this->where($_arr_where)->find($_arr_belongSelect);

        if (!$_arr_belongRow) {
            return array(
                'rcode' => 'x160102', //不存在记录
            );
        }

        $_arr_belongRow['rcode'] = 'y160102';

        return $_arr_belongRow;
    }


    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        $_num_belongCount = $this->where($_arr_where)->count();

        return $_num_belongCount;
    }

    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['tag_id']) && $arr_search['tag_id'] > 0) {
            $_arr_where[] = array('belong_tag_id', '=', $arr_search['tag_id']);
        }

        if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
            $_arr_where[] = array('belong_id', '>', $arr_search['min_id'], 'min_id');
        }

        if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
            $_arr_where[] = array('belong_id', '<', $arr_search['max_id'], 'max_id');
        }

        return $_arr_where;
    }


    function readQueryProcess($num_tagId = 0, $num_articleId = 0) {
        $_arr_where[] = array('belong_tag_id', '=', $num_tagId);

        if ($num_articleId > 0) {
            $_arr_where[] = array('belong_article_id', '=', $num_articleId);
        }

        return $_arr_where;
    }
}
