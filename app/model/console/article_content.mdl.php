<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Article_Content as Article_Content_Base;
use ginkgo\Loader;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------文章模型-------------*/
class Article_Content extends Article_Content_Base {

    function chkAttach($arr_attachRow) {
        return $this->where('article_content', 'LIKE', '%' . $arr_attachRow['attach_url_name'] . '%')->find('article_id');
    }


    function clear($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
            $_arr_where[] = array('article_id', '<', $arr_search['max_id'], 'max_id');
        }

        $_arr_articleRows = $this->where($_arr_where)->order('article_id', 'DESC')->limit($num_except, $num_no)->select('article_id');

        $_mdl_article = Loader::model('article');

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleRow = $_mdl_article->check($_value['article_id']);

            if (!$_arr_articleRow) {
                $this->where('article_id', '=', $_value['article_id'])->delete();
            }
        }

        return $_arr_articleRows;
    }


    function inputClear() {
        $_arr_inputParam = array(
            'max_id'    => array('int', 0),
            '__token__' => array('str', ''),
        );

        $_arr_inputClear = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputClear);

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x150201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputClear['rcode'] = 'y150201';

        $this->inputClear = $_arr_inputClear;

        return $_arr_inputClear;
    }
}
