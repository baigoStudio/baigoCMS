<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Cate_Belong as Cate_Belong_Base;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------栏目归属模型-------------*/
class Cate_Belong extends Cate_Belong_Base {

    function move($arr_articleIds, $num_cateId, $arr_cateIds) {
        $_arr_belongUpdate = array(
            'belong_cate_id' => $num_cateId,
        );

        $_arr_where = array();

        if (!Func::isEmpty($arr_articleIds)) {
            $arr_articleIds     = Func::arrayFilter($arr_articleIds);
            $_arr_where[] = array('belong_article_id', 'IN', $arr_articleIds, 'article_ids');
        }

        if (!Func::isEmpty($arr_cateIds)) {
            $arr_cateIds        = Func::arrayFilter($arr_cateIds);
            $_arr_where[] = array('belong_cate_id', 'IN', $arr_cateIds, 'cate_ids');
        }

        $_num_count     = $this->where($_arr_where)->update($_arr_belongUpdate); //更新数

        if ($_num_count > 0) {
            $_str_rcode = 'y150103';
        } else {
            $_str_rcode = 'x150103';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
        );
    }

    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_belongId
     * @param mixed $num_cateId
     * @param mixed $num_belongId
     * @return void
     */
    function submit($num_articleId, $num_cateId) {
        $_str_rcode = 'x150101';

        if ($num_articleId > 0 && $num_cateId > 0) { //插入
            $_arr_belongRow = $this->read($num_cateId, $num_articleId);

            if ($_arr_belongRow['rcode'] == 'x150102') { //插入
                $_arr_belongData = array(
                    'belong_article_id'  => $num_articleId,
                    'belong_cate_id'     => $num_cateId,
                );

                $_arr_belongRowSub = $this->read(0, $num_articleId);

                if ($_arr_belongRowSub['rcode'] == 'y150102') {
                    $_num_count     = $this->where('belong_id', '=', $_arr_belongRowSub['belong_id'])->update($_arr_belongData); //更新数

                    if ($_num_count > 0) {
                        $_str_rcode = 'y150103';
                    } else {
                        $_str_rcode = 'x150103';
                    }
                } else {
                    $_num_belongId   = $this->insert($_arr_belongData);

                    if ($_num_belongId > 0) { //数据库插入是否成功
                        $_str_rcode = 'y150101';
                    } else {
                        $_str_rcode = 'x150101';
                    }
                }
            }
        }

        return array(
            'rcode'  => $_str_rcode,
        );
    }


    function clear($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_belongSelect = array(
            'belong_id',
            'belong_cate_id',
            'belong_article_id',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_belongRows = $this->where($_arr_where)->order('belong_id', 'DESC')->limit($num_except, $num_no)->select($_arr_belongSelect);

        $_mdl_article = Loader::model('article');
        $_mdl_cate    = Loader::model('cate');

        foreach ($_arr_belongRows as $_key=>$_value) {
            $_arr_articleRow = $_mdl_article->check($_value['belong_article_id']);

            if ($_arr_articleRow['rcode'] != 'y120102') {
                $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
            }

            $_arr_cateRow = $_mdl_cate->check($_value['belong_cate_id']);

            if ($_arr_cateRow['rcode'] != 'y250102') {
                $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
            }
        }

        return $_arr_belongRows;
    }


    /**
     * delete function.
     *
     * @access public
     * @param int $num_cateId (default: 0)
     * @param int $num_articleId (default: 0)
     * @return void
     */
    function delete($num_cateId = 0, $num_articleId = 0, $arr_cateIds = false, $arr_articleIds = false, $arr_notCateIds = false, $arr_notArticleIds = false, $num_belongId = 0) {

        $_arr_where = array();

        if ($num_cateId > 0) {
            $_arr_where[] = array('belong_cate_id', '=', $num_cateId);
        }

        if ($num_articleId > 0) {
            $_arr_where[] = array('belong_article_id', '=', $num_articleId);
        }

        if (!Func::isEmpty($arr_cateIds)) {
            $arr_cateIds = Func::arrayFilter($arr_cateIds);

            $_arr_where[] = array('belong_cate_id', 'IN', $arr_cateIds, 'cate_ids');
        }

        if (!Func::isEmpty($arr_articleIds)) {
            $arr_articleIds = Func::arrayFilter($arr_articleIds);

            $_arr_where[] = array('belong_article_id', 'IN', $arr_articleIds, 'article_ids');
        }

        if (!Func::isEmpty($arr_notCateIds)) {
            $arr_notCateIds = Func::arrayFilter($arr_notCateIds);

            $_arr_where[] = array('belong_cate_id', 'NOT IN', $arr_notCateIds, 'not_cate_ids');
        }

        if (!Func::isEmpty($arr_notArticleIds)) {
            $arr_notArticleIds = Func::arrayFilter($arr_notArticleIds);

            $_arr_where[] = array('belong_article_id', 'NOT IN', $arr_notArticleIds, 'not_article_ids');
        }

        if ($num_belongId > 0) {
            $_arr_where[] = array('belong_id', '=', $num_belongId);
        }

        $_arr_belongData = array(
            //'belong_article_id' => 0,
            'belong_cate_id'    => 0,
        );

        $_num_count     = $this->where($_arr_where)->update($_arr_belongData); //更新数

        return $_num_count; //成功
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