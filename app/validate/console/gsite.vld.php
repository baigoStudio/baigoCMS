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
class Gsite extends Validate {

    protected $rule     = array(
        'gsite_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'gsite_name' => array(
            'length'  => '1,300'
        ),
        'gsite_url' => array(
            'length'  => '1,900',
            'format'  => 'url'
        ),
        'gsite_charset' => array(
            'length'  => '1,100'
        ),
        'gsite_note' => array(
            'max'  => 30
        ),
        'gsite_status' => array(
            'require'  => true
        ),
        'gsite_cate_id' => array(
            '>'         => 0,
            'format'    => 'int',
        ),
        'gsite_ids' => array(
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
            'gsite_id',
            'gsite_name',
            'gsite_url',
            'gsite_charset',
            'gsite_note',
            'gsite_status',
            'gsite_cate_id',
            '__token__',
        ),
        'submit_db' => array(
            'gsite_name',
            'gsite_url',
            'gsite_charset',
            'gsite_note',
            'gsite_status',
            'gsite_cate_id',
        ),
        'duplicate' => array(
            'gsite_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'status' => array(
            'gsite_ids',
            'act',
            '__token__',
        ),
        'delete' => array(
            'gsite_ids',
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'gsite_id'      => $this->obj_lang->get('ID'),
            'gsite_name'    => $this->obj_lang->get('Name'),
            'gsite_url'     => $this->obj_lang->get('URL'),
            'gsite_charset' => $this->obj_lang->get('Charset'),
            'gsite_note'    => $this->obj_lang->get('Note'),
            'gsite_status'  => $this->obj_lang->get('Status'),
            'gsite_cate_id' => $this->obj_lang->get('Belong to category'),
            'gsite_ids'     => $this->obj_lang->get('Gathering site'),
            'act'           => $this->obj_lang->get('Action'),
            '__token__'     => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
            'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
            'token'     => $this->obj_lang->get('Form token is incorrect'),
            'max'       => $this->obj_lang->get('Max size of {:attr} must be {:rule}'),
            'gt'        => $this->obj_lang->get('{:attr} require'),
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
