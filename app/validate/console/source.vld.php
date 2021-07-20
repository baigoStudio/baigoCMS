<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\validate\console;

use ginkgo\Validate;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------管理员模型-------------*/
class Source extends Validate {

    protected $rule     = array(
        'source_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'source_name' => array(
            'length' => '1,300',
        ),
        'source_author' => array(
            'length' => '1,300',
        ),
        'source_url' => array(
            'max' => 900,
            'format' => 'url',
        ),
        'source_note' => array(
            'max' => 30,
        ),
        'source_ids' => array(
            'require' => true,
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'source_id',
            'source_name',
            'source_author',
            'source_url',
            'source_note',
            '__token__',
        ),
        'submit_db' => array(
            'source_name',
            'source_author',
            'source_url',
            'source_note',
        ),
        'delete' => array(
            'source_ids',
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'source_id'       => $this->obj_lang->get('ID'),
            'source_name'     => $this->obj_lang->get('Name'),
            'source_author'   => $this->obj_lang->get('Author'),
            'source_url'      => $this->obj_lang->get('URL'),
            'source_note'     => $this->obj_lang->get('Note'),
            'source_ids'      => $this->obj_lang->get('Source'),
            '__token__'       => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
            'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
            'max'       => $this->obj_lang->get('Max size of {:attr} must be {:rule}'),
            'token'     => $this->obj_lang->get('Form token is incorrect'),
        );

        $_arr_formatMsg = array(
            'int' => $this->obj_lang->get('{:attr} must be integer'),
            'url' => $this->obj_lang->get('{:attr} not a valid url'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
        $this->setFormatMsg($_arr_formatMsg);
    }
}
