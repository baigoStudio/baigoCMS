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
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------文章模型-------------*/
class Article_Content extends Model {


    function check($num_articleId) {
        $_arr_select = array(
            'article_id',
        );

        return $this->read($num_articleId, $_arr_select);
    }


    /** 读出内容
     * readContent function.
     *
     * @access public
     * @param mixed $num_articleId
     * @return void
     */
    function read($num_articleId, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'article_content',
                'article_source',
                'article_source_url',
                'article_author',
            );
        }

        $_arr_contentRow = $this->where('article_id', '=', $num_articleId)->find($arr_select);

        if ($_arr_contentRow) {
            if (isset($_arr_contentRow['article_source_url']) && !Func::isEmpty($_arr_contentRow['article_source_url'])) {
                $_arr_contentRow['article_source_url']  = Html::decode($_arr_contentRow['article_source_url'], 'url');
            }

            $_arr_contentRow['rcode'] = 'y150102';
        } else {
            $_arr_contentRow = array(
                'article_content'       => '',
                'article_source'        => '',
                'article_source_url'    => '',
                'article_author'        => '',
                'rcode'                 => 'x150102',
            );
        }

        return $_arr_contentRow;
    }


    function submit($arr_inputSubmit) {
        $_str_rcode = 'x150101';

        if (isset($arr_inputSubmit['article_id']) && $arr_inputSubmit['article_id'] > 0) {
            $_arr_contentData['article_id'] = $arr_inputSubmit['article_id'];

            if (isset($arr_inputSubmit['article_content'])) {
                $_arr_contentData['article_content'] = $arr_inputSubmit['article_content'];
            }

            if (isset($arr_inputSubmit['article_source'])) {
                $_arr_contentData['article_source'] = $arr_inputSubmit['article_source'];
            }

            if (isset($arr_inputSubmit['article_source_url'])) {
                $_arr_contentData['article_source_url'] = $arr_inputSubmit['article_source_url'];
            }

            if (isset($arr_inputSubmit['article_author'])) {
                $_arr_contentData['article_author'] = $arr_inputSubmit['article_author'];
            }

            $_arr_contentRow = $this->check($arr_inputSubmit['article_id']);

            if ($_arr_contentRow['rcode'] == 'x150102') {
                $_num_articleId     = $this->insert($_arr_contentData); //更新数据

                //print_r($_num_articleId);

                if ($_num_articleId > 0) {
                    $_str_rcode      = 'y150101';
                } else {
                    $_str_rcode      = 'x150101';
                }
            } else {
                //print_r($arr_inputSubmit);

                $_num_count     = $this->where('article_id', '=', $arr_inputSubmit['article_id'])->update($_arr_contentData); //更新数据

                if ($_num_count > 0) {
                    $_str_rcode      = 'y150103';
                } else {
                    $_str_rcode      = 'x150103';
                }
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }
}
