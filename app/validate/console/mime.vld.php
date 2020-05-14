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
class Mime extends Validate {

    protected $rule     = array(
        'mime_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'mime_note' => array(
            'max' => 300,
        ),
        'mime_ext' => array(
            'length' => '1,30',
        ),
        'mime_content' => array(
            'require' => true,
        ),
        'mime_ids' => array(
            'require' => true,
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'mime_id',
            'mime_note',
            'mime_ext',
            'mime_content',
            '__token__',
        ),
        'submit_db' => array(
            'mime_note',
            'mime_ext',
            'mime_content',
        ),
        'delete' => array(
            'mime_ids',
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'mime_id'       => $this->obj_lang->get('ID'),
            'mime_note'     => $this->obj_lang->get('Note'),
            'mime_ext'      => $this->obj_lang->get('Extension name'),
            'mime_content'  => $this->obj_lang->get('MIME content'),
            'mime_ids'      => $this->obj_lang->get('MIME'),
            '__token__'     => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
            'max'       => $this->obj_lang->get('Max size of {:attr} must be {:rule}'),
            'require'   => $this->obj_lang->get('{:attr} require'),
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
