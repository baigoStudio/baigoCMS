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
class Custom extends Validate {

    protected $rule     = array(
        'custom_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'custom_name' => array(
            'length' => '1,90',
        ),
        'custom_type' => array(
            'require' => true,
        ),
        'custom_opt' => array(
            'max' => 1000,
        ),
        'custom_status' => array(
            'require' => true,
        ),
        'custom_parent_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'custom_cate_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'custom_format' => array(
            'require' => true,
        ),
        'custom_size' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'custom_ids' => array(
            'require' => true,
        ),
        'act' => array(
            'require' => true,
        ),
        'custom_orders' => array(
            'require' => true,
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'custom_id',
            'custom_name',
            'custom_type',
            'custom_opt',
            'custom_status',
            'custom_parent_id',
            'custom_cate_id',
            'custom_format',
            'custom_size',
            '__token__',
        ),
        'submit_db' => array(
            'custom_name',
            'custom_type',
            'custom_opt',
            'custom_status',
            'custom_parent_id',
            'custom_cate_id',
            'custom_format',
            'custom_size',
        ),
        'duplicate' => array(
            'custom_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'delete' => array(
            'custom_ids',
            '__token__',
        ),
        'status' => array(
            'custom_ids',
            'act',
            '__token__',
        ),
        'custom_orders' => array(
            'custom_ids',
            '__token__',
        ),
        'common' => array(
            '__token__',
        ),
    );


    function v_init() { //构造函数

        $_arr_attrName = array(
            'custom_id'         => $this->obj_lang->get('ID'),
            'custom_name'       => $this->obj_lang->get('Name'),
            'custom_type'       => $this->obj_lang->get('Type'),
            'custom_opt'        => $this->obj_lang->get('Option'),
            'custom_status'     => $this->obj_lang->get('Status'),
            'custom_parent_id'  => $this->obj_lang->get('Parent field'),
            'custom_cate_id'    => $this->obj_lang->get('Category'),
            'custom_format'     => $this->obj_lang->get('Format'),
            'custom_size'       => $this->obj_lang->get('Size'),
            'custom_ids'        => $this->obj_lang->get('Field'),
            'act'               => $this->obj_lang->get('Action'),
            'custom_orders'     => $this->obj_lang->get('Sort'),
            '__token__'         => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
            'gt'        => $this->obj_lang->get('{:attr} require'),
            'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
            'max'       => $this->obj_lang->get('Max size of {:attr} must be {:rule}'),
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
