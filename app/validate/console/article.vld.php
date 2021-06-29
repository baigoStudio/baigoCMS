<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\validate\console;

use ginkgo\Validate;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------管理员模型-------------*/
class Article extends Validate {

    protected $rule     = array(
        'article_id' => array(
            'require' => true,
        ),
        'article_title' => array(
            'length' => '1,300',
        ),
        'article_cate_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'article_excerpt' => array(
            'max' => 900,
        ),
        'article_status' => array(
            'require' => true,
        ),
        'article_box' => array(
            'require' => true,
        ),
        'article_mark_id' => array(
            'format' => 'int',
        ),
        'article_link' => array(
            'max'    => 900,
        ),
        'article_time_show_format' => array(
            'format' => 'date_time',
        ),
        'article_time_show' => array(
            'format' => 'int',
        ),
        'article_is_time_pub' => array(
            'format' => 'int',
        ),
        'article_time_pub_format' => array(
            'format' => 'date_time',
        ),
        'article_time_pub' => array(
            'format' => 'int',
        ),
        'article_is_time_hide' => array(
            'format' => 'int',
        ),
        'article_time_hide_format' => array(
            'format' => 'date_time',
        ),
        'article_time_hide' => array(
            'format' => 'int',
        ),
        'article_ids' => array(
            'require' => true,
        ),
        'act' => array(
            'require' => true,
        ),
        'cate_id' => array(
            '>' => 0,
        ),
        'attach_id' => array(
            '>' => 0,
        ),
        'max_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'article_id',
            'article_cate_id',
            'article_title',
            'article_excerpt',
            'article_status',
            'article_box',
            'article_mark_id',
            'article_link',
            'article_time_show_format',
            'article_is_time_pub',
            'article_time_pub_format',
            'article_is_time_hide',
            'article_time_hide_format',
            '__token__',
        ),
        'simple' => array(
            'article_id' => array(
                '>' => 0,
            ),
            'article_title',
            'article_cate_id',
            'article_status',
            'article_box',
            'article_mark_id',
            'article_time_show_format',
            'article_is_time_pub',
            'article_time_pub_format',
            'article_is_time_hide',
            'article_time_hide_format',
            'article_top',
            '__token__',
        ),
        'submit_db' => array(
            'article_title',
            'article_cate_id',
            'article_excerpt',
            'article_status',
            'article_box',
            'article_mark_id',
            'article_link',
            'article_time_show',
            'article_is_time_pub',
            'article_time_pub',
            'article_is_time_hide',
            'article_time_hide',
        ),
        'simple_db' => array(
            'article_title',
            'article_cate_id',
            'article_status',
            'article_box',
            'article_mark_id',
            'article_time_show',
            'article_is_time_pub',
            'article_time_pub',
            'article_is_time_hide',
            'article_time_hide',
            'article_top',
        ),
        'move' => array(
            'article_ids',
            'cate_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'cover' => array(
            'article_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'delete' => array(
            'article_ids',
            '__token__',
        ),
        'status' => array(
            'article_ids',
            'act',
            '__token__',
        ),
        'clear' => array(
            'max_id',
            '__token__',
        ),
        'common' => array(
            'article_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'article_id'            => $this->obj_lang->get('ID'),
            'article_cate_id'       => $this->obj_lang->get('Belong to category'),
            'article_excerpt'       => $this->obj_lang->get('Excerpt'),
            'article_status'        => $this->obj_lang->get('Status'),
            'article_box'           => $this->obj_lang->get('Position'),
            'article_mark_id'       => $this->obj_lang->get('Mark'),
            'article_link'          => $this->obj_lang->get('Jump to'),
            'article_time_show_format' => $this->obj_lang->get('Display time'),
            'article_is_time_pub'   => $this->obj_lang->get('Scheduled publish'),
            'article_time_pub_format'  => $this->obj_lang->get('Scheduled publish'),
            'article_is_time_hide'  => $this->obj_lang->get('Scheduled offline'),
            'article_time_hide_format' => $this->obj_lang->get('Scheduled offline'),
            'article_ids'           => $this->obj_lang->get('Article'),
            'act'                   => $this->obj_lang->get('Action'),
            'cate_id'               => $this->obj_lang->get('Category'),
            'attach_id'             => $this->obj_lang->get('Attachment'),
            '__token__'             => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
            'gt'        => $this->obj_lang->get('{:attr} require'),
            'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
            'max'       => $this->obj_lang->get('Max size of {:attr} must be {:rule}'),
            'token'     => $this->obj_lang->get('Form token is incorrect'),
        );

        $_arr_formatMsg = array(
            'url'         => $this->obj_lang->get('{:attr} not a valid url'),
            'int'         => $this->obj_lang->get('{:attr} must be integer'),
            'date_time'   => $this->obj_lang->get('{:attr} not a valid datetime'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
        $this->setFormatMsg($_arr_formatMsg);
    }
}
