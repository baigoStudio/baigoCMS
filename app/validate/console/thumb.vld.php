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
class Thumb extends Validate {

    protected $rule     = array(
        'thumb_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'thumb_width' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'thumb_height' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'thumb_type' => array(
            'require' => true,
        ),
        'thumb_quality' => array(
            'between' => '1,100',
            'format'  => 'int',
        ),
        'thumb_ids' => array(
            'require' => true,
        ),
        'act' => array(
            'require' => true,
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'thumb_id',
            'thumb_width',
            'thumb_height',
            'thumb_type',
            'thumb_quality',
            '__token__',
        ),
        'submit_db' => array(
            'thumb_width',
            'thumb_height',
            'thumb_type',
            'thumb_quality',
        ),
        'delete' => array(
            'thumb_ids',
            '__token__',
        ),
        'default' => array(
            'thumb_id',
            '__token__',
        ),
        'common' => array(
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'thumb_id'      => $this->obj_lang->get('ID'),
            'thumb_width'   => $this->obj_lang->get('Width'),
            'thumb_height'  => $this->obj_lang->get('Height'),
            'thumb_type'    => $this->obj_lang->get('Type'),
            'thumb_quality' => $this->obj_lang->get('Quality'),
            'thumb_ids'     => $this->obj_lang->get('Thumbnail'),
            '__token__'     => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
            'between'   => $this->obj_lang->get('{:attr} must between {:rule}'),
            'token'     => $this->obj_lang->get('Form token is incorrect'),
        );

        $_arr_formatMsg = array(
            'int' => $this->obj_lang->get('{:attr} must be integer'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
        $this->setFormatMsg($_arr_formatMsg);
    }
}
