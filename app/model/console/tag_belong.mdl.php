<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Tag_Belong as Tag_Belong_Base;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------TAG 归属模型-------------*/
class Tag_Belong extends Tag_Belong_Base {

    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_belongId
     * @param mixed $num_tagId
     * @param mixed $num_belongId
     * @return void
     */
    function submit($num_articleId, $num_tagId) {
        $_str_rcode = 'x160101';

        if ($num_articleId > 0 && $num_tagId > 0) { //插入
            $_arr_belongRow = $this->read($num_tagId, $num_articleId);

            if ($_arr_belongRow['rcode'] == 'x160102') { //插入
                $_arr_belongData = array(
                    'belong_article_id'  => $num_articleId,
                    'belong_tag_id'     => $num_tagId,
                );

                $_arr_belongRowSub = $this->read(0, $num_articleId);

                if ($_arr_belongRow['rcode'] == 'y160102') {
                    $_num_count     = $this->where('belong_id', '=', $_arr_belongRowSub['belong_id'])->update($_arr_belongData); //更新数

                    if ($_num_count > 0) {
                        $_str_rcode = 'y160103';
                    } else {
                        $_str_rcode = 'x160103';
                    }
                } else {
                    $_num_belongId   = $this->insert($_arr_belongData);

                    if ($_num_belongId > 0) { //数据库插入是否成功
                        $_str_rcode = 'y160101';
                    } else {
                        $_str_rcode = 'x160101';
                    }
                }
            }
        }

        return array(
            'rcode'  => $_str_rcode,
        );
    }


    function clear($pagination = 0, $arr_search = array()) {
        $_arr_belongSelect = array(
            'belong_id',
            'belong_tag_id',
            'belong_article_id',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('belong_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_belongSelect);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_clearData = $_arr_getData['dataRows'];
        } else {
            $_arr_clearData = $_arr_getData;
        }

        if (!Func::isEmpty($_arr_clearData)) {
            $_mdl_article = Loader::model('article');
            $_mdl_tag     = Loader::model('tag');

            foreach ($_arr_clearData as $_key=>$_value) {
                $_arr_articleRow = $_mdl_article->check($_value['belong_article_id']);

                if ($_arr_articleRow['rcode'] != 'y120102') {
                    $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
                }

                $_arr_tagRow = $_mdl_tag->check($_value['belong_tag_id']);

                if ($_arr_tagRow['rcode'] != 'y130102') {
                    $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
                }
            }
        }

        return $_arr_getData;
    }


    /**
     * delete function.
     *
     * @access public
     * @param int $num_tagId (default: 0)
     * @param int $num_articleId (default: 0)
     * @return void
     */
    function delete($num_tagId = 0, $num_articleId = 0, $arr_tagIds = false, $arr_articleIds = false, $arr_notTagIds = false, $arr_notArticleIds = false, $num_belongId = 0) {

        $_arr_where = array();

        if ($num_tagId > 0) {
            $_arr_where[] = array('belong_tag_id', '=', $num_tagId);
        }

        if ($num_articleId > 0) {
            $_arr_where[] = array('belong_article_id', '=', $num_articleId);
        }

        if (!Func::isEmpty($arr_tagIds)) {
            $arr_tagIds = Func::arrayFilter($arr_tagIds);

            $_arr_where[] = array('belong_tag_id', 'IN', $arr_tagIds, 'tag_ids');
        }

        if (!Func::isEmpty($arr_articleIds)) {
            $arr_articleIds = Func::arrayFilter($arr_articleIds);

            $_arr_where[] = array('belong_article_id', 'IN', $arr_articleIds, 'article_ids');
        }

        if (!Func::isEmpty($arr_notTagIds)) {
            $arr_notTagIds = Func::arrayFilter($arr_notTagIds);

            $_arr_where[] = array('belong_tag_id', 'NOT IN', $arr_notTagIds, 'not_tag_ids');
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
            'belong_tag_id'  => 0,
        );

        $_num_count = $this->where($_arr_where)->update($_arr_belongData);

        return $_num_count; //成功
    }


    function inputClear() {
        $_arr_inputParam = array(
            'max_id'    => array('int', 0),
            '__token__' => array('str', ''),
        );

        $_arr_inputClear = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputClear, '', 'clear');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x160201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputClear['rcode'] = 'y160201';

        $this->inputClear = $_arr_inputClear;

        return $_arr_inputClear;
    }
}
