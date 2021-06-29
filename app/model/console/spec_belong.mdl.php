<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Spec_Belong as Spec_Belong_Base;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Arrays;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------专题归属模型-------------*/
class Spec_Belong extends Spec_Belong_Base {

    function choose() {
        $_num_count = 0;

        foreach ($this->inputChoose['article_ids'] as $_key=>$_value) {
            if ($_value > 0 && $this->inputChoose['spec_id'] > 0) { //插入
                $_arr_submitResult = $this->submit($_value, $this->inputChoose['spec_id']);
                if ($_arr_submitResult['rcode'] == 'y230101' || $_arr_submitResult['rcode'] == 'y230103') {
                    ++$_num_count;
                }
            }
        }

        if ($_num_count > 0) {
            $_str_rcode = 'y230103';
            $_str_msg   = 'Successfully processed {:count} datas';
        } else {
            $_str_rcode = 'x230103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'msg'    => $_str_msg,
            'count'  => $_num_count,
            'rcode'  => $_str_rcode,
        );
    }


    function remove() {
        $_num_count         = 0;
        $_num_countGlobal   = 0;

        foreach ($this->inputRemove['article_ids_belong'] as $_key=>$_value) {
            if ($_value > 0 && $this->inputRemove['spec_id'] > 0) { //插入
                $_arr_belongRow = $this->read($this->inputRemove['spec_id'], $_value); //是否存在

                /*print_r($_arr_belongRow);
                print_r(PHP_EOL);*/

                if ($_arr_belongRow['rcode'] == 'y230102') { //存在
                    $_arr_belongData = array(
                        'belong_spec_id'  => 0,
                    );

                    $_num_count = $this->delete(0, 0, false, false, false, false, $_arr_belongRow['belong_id']); //作为闲置数据

                    if ($_num_count > 0) {
                        $_num_countGlobal = $_num_countGlobal + $_num_count;
                    }
                }
            }
        }

        if ($_num_countGlobal > 0) {
            $_str_rcode = 'y230104';
            $_str_msg   = 'Successfully remove {:count} datas';
        } else {
            $_str_rcode = 'x230104';
            $_str_msg   = 'No data have been removed';
        }

        return array(
            'msg'    => $_str_msg,
            'count'  => $_num_countGlobal,
            'rcode'  => $_str_rcode,
        );
    }



    function clear($pagination = 0, $arr_search = array()) {
        $_arr_belongSelect = array(
            'belong_id',
            'belong_spec_id',
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
            $_mdl_article = Loader::model('Article');
            $_mdl_spec    = Loader::model('Spec');

            foreach ($_arr_clearData as $_key=>$_value) {
                $_arr_articleRow = $_mdl_article->check($_value['belong_article_id']);

                if ($_arr_articleRow['rcode'] != 'y120102') {
                    $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
                }

                $_arr_specRow = $_mdl_spec->check($_value['belong_spec_id']);

                if ($_arr_specRow['rcode'] != 'y180102') {
                    $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
                }
            }
        }

        return $_arr_getData;
    }



    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_belongId
     * @param mixed $num_specId
     * @param mixed $num_belongId
     * @return void
     */
    function submit($num_articleId, $num_specId) {
        $_str_rcode = 'x230101';

        if ($num_articleId > 0 && $num_specId > 0) { //插入
            $_arr_belongRow = $this->read($num_specId, $num_articleId);

            if ($_arr_belongRow['rcode'] == 'x230102') { //插入
                $_arr_belongData = array(
                    'belong_article_id'  => $num_articleId,
                    'belong_spec_id'     => $num_specId,
                );

                $_arr_belongRowSub = $this->read(0, $num_articleId);

                if ($_arr_belongRowSub['rcode'] == 'y230102') {
                    $_num_count     = $this->where('belong_id', '=', $_arr_belongRowSub['belong_id'])->update($_arr_belongData); //更新数

                    if ($_num_count > 0) {
                        $_str_rcode = 'y230103';
                    } else {
                        $_str_rcode = 'x230103';
                    }
                } else {
                    $_num_belongId   = $this->insert($_arr_belongData);

                    if ($_num_belongId > 0) { //数据库插入是否成功
                        $_str_rcode = 'y230101';
                    } else {
                        $_str_rcode = 'x230101';
                    }
                }
            }
        }

        return array(
            'rcode'  => $_str_rcode,
        );
    }


    /**
     * delete function.
     *
     * @access public
     * @param int $num_specId (default: 0)
     * @param int $num_articleId (default: 0)
     * @return void
     */
    function delete($num_specId = 0, $num_articleId = 0, $arr_specIds = false, $arr_articleIds = false, $arr_notSpecIds = false, $arr_notArticleIds = false, $num_belongId = 0) {

        $_arr_where = array();

        if ($num_specId > 0) {
            $_arr_where[] = array('belong_spec_id', '=', $num_specId);
        }

        if ($num_articleId > 0) {
            $_arr_where[] = array('belong_article_id', '=', $num_articleId);
        }

        if (!Func::isEmpty($arr_specIds)) {
            $arr_specIds = Arrays::filter($arr_specIds);
            $_arr_where[] = array('belong_spec_id', 'IN', $arr_specIds, 'spec_ids');
        }

        if (!Func::isEmpty($arr_articleIds)) {
            $arr_articleIds = Arrays::filter($arr_articleIds);
            $_arr_where[] = array('belong_article_id', 'IN', $arr_articleIds, 'article_ids');
        }

        if (!Func::isEmpty($arr_notSpecIds)) {
            $arr_notSpecIds = Arrays::filter($arr_notSpecIds);
            $_arr_where[] = array('belong_spec_id', 'NOT IN', $arr_notSpecIds, 'not_spec_ids');
        }

        if (!Func::isEmpty($arr_notArticleIds)) {
            $arr_notArticleIds = Arrays::filter($arr_notArticleIds);
            $_arr_where[] = array('belong_article_id', 'NOT IN', $arr_notArticleIds, 'not_article_ids');
        }

        if ($num_belongId > 0) {
            $_arr_where[] = array('belong_id', '=', $num_belongId);
        }

        $_arr_belongData = array(
            //'belong_article_id' => 0,
            'belong_spec_id'  => 0,
        );

        $_num_count     = $this->where($_arr_where)->update($_arr_belongData); //更新数

        return $_num_count; //成功
    }


    function inputChoose() {
        $_arr_inputParam = array(
            'spec_id'       => array('int', 0),
            'article_ids'   => array('arr', array()),
            '__token__'     => array('str', ''),
        );

        $_arr_inputChoose = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputChoose, '', 'choose');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x230201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputChoose['rcode'] = 'y230201';

        $this->inputChoose = $_arr_inputChoose;

        return $_arr_inputChoose;
    }


    function inputRemove() {
        $_arr_inputParam = array(
            'spec_id'               => array('int', 0),
            'article_ids_belong'    => array('arr', array()),
            '__token__'             => array('str', ''),
        );

        $_arr_inputRemove = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputRemove, '', 'remove');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x230201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputRemove['rcode'] = 'y230201';

        $this->inputRemove = $_arr_inputRemove;

        return $_arr_inputRemove;
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
                'rcode' => 'x230201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputClear['rcode'] = 'y230201';

        $this->inputClear = $_arr_inputClear;

        return $_arr_inputClear;
    }
}
