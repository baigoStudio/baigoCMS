<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------采集点模型-------------*/
class Gsite extends Model {

    public $obj_db;
    public $arr_status = array('enable', 'disabled');
    public $keepTag    = array( //保留标签
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'p', 'div',
        'mark', 'del', 's', 'ins', 'u', 'em', 'i', 'small', 'strong', 'b',
        'abbr', 'address', 'span',
        'blockquote', 'br',
        'ul', 'ol', 'li',
        'dl', 'dt', 'dd',
        'code', 'var', 'samp',
        'img',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td',
    );

    public $keepAttr = array(
        'img' => array(
            'src'
        ),
        'a' => array(
            'href',
            'target',
        ),
    );


    function check($mix_gsite, $str_by = 'gsite_id') {
        $_arr_select = array(
            'gsite_id',
        );

        return $this->readProcess($mix_gsite, $str_by, $_arr_select);
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $mix_gsite
     * @param string $str_by (default: 'gsite_id')
     * @param int $num_notId (default: 0)
     * @return void
     */
    function read($mix_gsite, $str_by = 'gsite_id', $arr_select = array()) {
        $_arr_gsiteRow = $this->readProcess($mix_gsite, $str_by, $arr_select);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        return $this->rowProcess($_arr_gsiteRow);
    }


    function readProcess($mix_gsite, $str_by = 'gsite_id', $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'gsite_id',
                'gsite_name',
                'gsite_url',
                'gsite_status',
                'gsite_keep_tag',
                'gsite_note',
                'gsite_cate_id',
                'gsite_charset',
                'gsite_list_selector',
                'gsite_title_selector',
                'gsite_title_attr',
                'gsite_title_filter',
                'gsite_title_replace',
                'gsite_content_selector',
                'gsite_content_attr',
                'gsite_content_filter',
                'gsite_content_replace',
                'gsite_time_selector',
                'gsite_time_attr',
                'gsite_time_filter',
                'gsite_time_replace',
                'gsite_source_selector',
                'gsite_source_attr',
                'gsite_source_filter',
                'gsite_source_replace',
                'gsite_author_selector',
                'gsite_author_attr',
                'gsite_author_filter',
                'gsite_author_replace',
                'gsite_page_list_selector',
                'gsite_page_content_selector',
                'gsite_page_content_attr',
                'gsite_page_content_filter',
                'gsite_page_content_replace',
                'gsite_img_filter',
                'gsite_img_src',
                'gsite_attr_allow',
                'gsite_ignore_tag',
                'gsite_attr_except',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_gsite, $str_by);

        $_arr_gsiteRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_gsiteRow) {
            return array(
                'msg'   => 'Gathering site not found',
                'rcode' => 'x270102', //不存在记录
            );
        }

        $_arr_gsiteRow['rcode'] = 'y270102';
        $_arr_gsiteRow['msg']   = '';

        return $_arr_gsiteRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @return void
     */
    function lists($pagination = 0, $arr_search = array()) {

        $_arr_gsiteSelect = array(
            'gsite_id',
            'gsite_name',
            'gsite_note',
            'gsite_status',
            'gsite_cate_id',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('gsite_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_gsiteSelect);

        return $_arr_getData;

    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_status (default: '')
     * @return void
     */
    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        $_num_gsiteCount = $this->where($_arr_where)->count();

        return $_num_gsiteCount;
    }


    function selectorProcess($arr_gsiteRow) {
        $arr_gsiteRow['gsite_url']      = Html::decode($arr_gsiteRow['gsite_url'], 'url');
        $arr_gsiteRow['gsite_charset']  = strtoupper(Html::decode($arr_gsiteRow['gsite_charset'], 'url'));

        if (!Func::isEmpty($arr_gsiteRow['gsite_list_selector'])) {
            $arr_gsiteRow['gsite_list_selector']            = Html::decode($arr_gsiteRow['gsite_list_selector'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_title_selector'])) {
            $arr_gsiteRow['gsite_title_selector']           = Html::decode($arr_gsiteRow['gsite_title_selector'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_title_filter'])) {
            $arr_gsiteRow['gsite_title_filter']             = Html::decode($arr_gsiteRow['gsite_title_filter'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_content_selector'])) {
            $arr_gsiteRow['gsite_content_selector']         = Html::decode($arr_gsiteRow['gsite_content_selector'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_content_filter'])) {
            $arr_gsiteRow['gsite_content_filter']           = Html::decode($arr_gsiteRow['gsite_content_filter'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_time_selector'])) {
            $arr_gsiteRow['gsite_time_selector']            = Html::decode($arr_gsiteRow['gsite_time_selector'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_time_filter'])) {
            $arr_gsiteRow['gsite_time_filter']              = Html::decode($arr_gsiteRow['gsite_time_filter'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_source_selector'])) {
            $arr_gsiteRow['gsite_source_selector']          = Html::decode($arr_gsiteRow['gsite_source_selector'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_source_filter'])) {
            $arr_gsiteRow['gsite_source_filter']            = Html::decode($arr_gsiteRow['gsite_source_filter'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_author_selector'])) {
            $arr_gsiteRow['gsite_author_selector']          = Html::decode($arr_gsiteRow['gsite_author_selector'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_author_filter'])) {
            $arr_gsiteRow['gsite_author_filter']            = Html::decode($arr_gsiteRow['gsite_author_filter'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_page_list_selector'])) {
            $arr_gsiteRow['gsite_page_list_selector']       = Html::decode($arr_gsiteRow['gsite_page_list_selector'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_page_content_selector'])) {
            $arr_gsiteRow['gsite_page_content_selector']    = Html::decode($arr_gsiteRow['gsite_page_content_selector'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_page_content_filter'])) {
            $arr_gsiteRow['gsite_page_content_filter']      = Html::decode($arr_gsiteRow['gsite_page_content_filter'], 'selector');
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_img_filter'])) {
            $arr_gsiteRow['gsite_img_filter']               = Html::decode($arr_gsiteRow['gsite_img_filter']);
            $arr_gsiteRow['gsite_img_filter']               = explode(',', $arr_gsiteRow['gsite_img_filter']);
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_keep_tag'])) {
            $arr_gsiteRow['gsite_keep_tag']                 = Html::decode($arr_gsiteRow['gsite_keep_tag']);
            $arr_gsiteRow['gsite_keep_tag']                 = explode(',', $arr_gsiteRow['gsite_keep_tag']);
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_attr_allow'])) {
            $arr_gsiteRow['gsite_attr_allow']               = Html::decode($arr_gsiteRow['gsite_attr_allow']);
            $arr_gsiteRow['gsite_attr_allow']               = explode(',', $arr_gsiteRow['gsite_attr_allow']);
        }
        if (!Func::isEmpty($arr_gsiteRow['gsite_ignore_tag'])) {
            $arr_gsiteRow['gsite_ignore_tag']               = Html::decode($arr_gsiteRow['gsite_ignore_tag']);
            $arr_gsiteRow['gsite_ignore_tag']               = explode(',', $arr_gsiteRow['gsite_ignore_tag']);
        }

        if (Func::isEmpty($arr_gsiteRow['gsite_title_attr'])) {
            $arr_gsiteRow['gsite_title_attr']               = 'text';
        } else {
            $arr_gsiteRow['gsite_title_attr']               = Html::decode($arr_gsiteRow['gsite_title_attr'], 'selector');
        }

        if (Func::isEmpty($arr_gsiteRow['gsite_content_attr'])) {
            $arr_gsiteRow['gsite_content_attr']             = 'html';
        } else {
            $arr_gsiteRow['gsite_content_attr']             = Html::decode($arr_gsiteRow['gsite_content_attr'], 'selector');
        }

        if (Func::isEmpty($arr_gsiteRow['gsite_time_attr'])) {
            $arr_gsiteRow['gsite_time_attr']                = 'text';
        } else {
            $arr_gsiteRow['gsite_time_attr']                = Html::decode($arr_gsiteRow['gsite_time_attr'], 'selector');
        }

        if (Func::isEmpty($arr_gsiteRow['gsite_author_attr'])) {
            $arr_gsiteRow['gsite_author_attr']              = 'text';
        } else {
            $arr_gsiteRow['gsite_author_attr']              = Html::decode($arr_gsiteRow['gsite_author_attr'], 'selector');
        }

        if (Func::isEmpty($arr_gsiteRow['gsite_source_attr'])) {
            $arr_gsiteRow['gsite_source_attr']              = 'text';
        } else {
            $arr_gsiteRow['gsite_source_attr']              = Html::decode($arr_gsiteRow['gsite_source_attr'], 'selector');
        }

        if (Func::isEmpty($arr_gsiteRow['gsite_page_content_attr'])) {
            $arr_gsiteRow['gsite_page_content_attr']        = 'html';
        } else {
            $arr_gsiteRow['gsite_page_content_attr']        = Html::decode($arr_gsiteRow['gsite_page_content_attr'], 'selector');
        }

        if (!Func::isEmpty($arr_gsiteRow['gsite_attr_except'])) {
            foreach ($arr_gsiteRow['gsite_attr_except'] as $_key=>$_value) {
                $_str_attrExcept = Html::decode($_value['attr']);

                $_arr_attrExcept = explode(',', $_str_attrExcept);

                $this->keepAttr[$_value['tag']] = array_replace_recursive($this->keepAttr[$_value['tag']], $_arr_attrExcept);
            }
        }

        if ($arr_gsiteRow['gsite_img_src'] != 'src') {
            array_push($this->keepAttr['img'], $arr_gsiteRow['gsite_img_src']);
        }
        $arr_gsiteRow['gsite_attr_except'] = $this->keepAttr;

        return $arr_gsiteRow;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('gsite_name|gsite_note', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('gsite_status', '=', $arr_search['status']);
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_gsite, $str_by = 'gsite_id') {
        $_arr_where = array($str_by, '=', $mix_gsite);

        return $_arr_where;
    }


    protected function rowProcess($arr_gsiteRow = array()) {
        if (isset($arr_gsiteRow['gsite_title_attr'])) {
            $arr_gsiteRow['gsite_title_attr']              = strtolower($arr_gsiteRow['gsite_title_attr']);
        }
        if (isset($arr_gsiteRow['gsite_content_attr'])) {
            $arr_gsiteRow['gsite_content_attr']            = strtolower($arr_gsiteRow['gsite_content_attr']);
        }
        if (isset($arr_gsiteRow['gsite_time_attr'])) {
            $arr_gsiteRow['gsite_time_attr']               = strtolower($arr_gsiteRow['gsite_time_attr']);
        }
        if (isset($arr_gsiteRow['gsite_source_attr'])) {
            $arr_gsiteRow['gsite_source_attr']             = strtolower($arr_gsiteRow['gsite_source_attr']);
        }
        if (isset($arr_gsiteRow['gsite_author_attr'])) {
            $arr_gsiteRow['gsite_author_attr']             = strtolower($arr_gsiteRow['gsite_author_attr']);
        }
        if (isset($arr_gsiteRow['gsite_page_content_attr'])) {
            $arr_gsiteRow['gsite_page_content_attr']       = strtolower($arr_gsiteRow['gsite_page_content_attr']);
        }
        if (isset($arr_gsiteRow['gsite_img_filter'])) {
            $arr_gsiteRow['gsite_img_filter']              = strtolower($arr_gsiteRow['gsite_img_filter']);
        }
        if (!isset($arr_gsiteRow['gsite_img_src']) || Func::isEmpty($arr_gsiteRow['gsite_img_src'])) {
            $arr_gsiteRow['gsite_img_src']                 = 'src';
        } else {
            $arr_gsiteRow['gsite_img_src']                 = strtolower($arr_gsiteRow['gsite_img_src']);
        }
        if (isset($arr_gsiteRow['gsite_attr_allow'])) {
            $arr_gsiteRow['gsite_attr_allow']              = strtolower($arr_gsiteRow['gsite_attr_allow']);
        }
        if (isset($arr_gsiteRow['gsite_charset'])) {
            $arr_gsiteRow['gsite_charset']                 = strtoupper($arr_gsiteRow['gsite_charset']);
        }
        if (isset($arr_gsiteRow['gsite_attr_except'])) {
            $arr_gsiteRow['gsite_attr_except']             = Arrays::fromJson($arr_gsiteRow['gsite_attr_except']);
        }
        if (isset($arr_gsiteRow['gsite_title_replace'])) {
            $arr_gsiteRow['gsite_title_replace']           = Arrays::fromJson($arr_gsiteRow['gsite_title_replace']);
        }
        if (isset($arr_gsiteRow['gsite_content_replace'])) {
            $arr_gsiteRow['gsite_content_replace']         = Arrays::fromJson($arr_gsiteRow['gsite_content_replace']);
        }
        if (isset($arr_gsiteRow['gsite_time_replace'])) {
            $arr_gsiteRow['gsite_time_replace']            = Arrays::fromJson($arr_gsiteRow['gsite_time_replace']);
        }
        if (isset($arr_gsiteRow['gsite_source_replace'])) {
            $arr_gsiteRow['gsite_source_replace']          = Arrays::fromJson($arr_gsiteRow['gsite_source_replace']);
        }
        if (isset($arr_gsiteRow['gsite_author_replace'])) {
            $arr_gsiteRow['gsite_author_replace']          = Arrays::fromJson($arr_gsiteRow['gsite_author_replace']);
        }
        if (isset($arr_gsiteRow['gsite_page_content_replace'])) {
            $arr_gsiteRow['gsite_page_content_replace']    = Arrays::fromJson($arr_gsiteRow['gsite_page_content_replace']);
        }

        return $arr_gsiteRow;
    }
}
