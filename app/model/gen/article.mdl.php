<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\gen;

use app\model\index\Article as Article_Index;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------前台文章模型-------------*/
class Article extends Article_Index {

    function pathProcess($arr_articleRow = array()) {
        $_str_articlePathName = $this->nameProcess($arr_articleRow, DS);

        $arr_articleRow['article_path_name'] = $_str_articlePathName;
        $arr_articleRow['article_path']      = GK_PATH_PUBLIC . $this->configRoute['article'] . DS . $_str_articlePathName;

        return $arr_articleRow;
    }


    function isGen($arr_articleId, $str_isGen = 'yes') {
        $_arr_update = array(
            'article_is_gen' => $str_isGen,
        );

        $_num_articleCount    = $this->where('article_id', 'IN', $arr_articleId)->update($_arr_update);

        return $_num_articleCount;
    }

    function inputSubmit() {
        $_arr_inputParam = array(
            'article_id'    => array('int', 0),
            'enforce'       => array('str', ''),
            '__token__'     => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit);

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x120201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputSubmit['rcode'] = 'y120201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where[] = array('article_status', '=', 'pub');
        $_arr_where[] = array('article_box', '=', 'normal');

        if (isset($arr_search['is_gen']) && !Func::isEmpty($arr_search['is_gen'])) {
            $_arr_where[] = array('article_is_gen', '=', $arr_search['is_gen']);
        }

        if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
            $_arr_where[] = array('article_id', '<', $arr_search['max_id'], 'max_id');
        }

        if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
            $_arr_where[] = array('article_id', '>', $arr_search['min_id'], 'min_id');
        }

        if (isset($arr_search['range_id'][0]) && $arr_search['range_id'][0] > 0 && isset($arr_search['range_id'][1]) && $arr_search['range_id'][1] > 0) {
            $_arr_where[] = array('article_id', 'BETWEEN', $arr_search['range_id'], 'range_id');
        }

        return $_arr_where;
    }
}
