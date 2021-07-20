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
class Group extends Validate {

    protected $rule     = array(
        'group_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'group_name' => array(
            'length' => '1,30',
        ),
        'group_status' => array(
            'require' => true,
        ),
        'group_note' => array(
            'max' => 30,
        ),
        'group_allow' => array(
            'max' => 1000,
        ),
        'group_ids' => array(
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
            'group_id',
            'group_name',
            'group_status',
            'group_note',
            'group_allow',
            '__token__',
        ),
        'submit_db' => array(
            'group_name',
            'group_status',
            'group_note',
            'group_allow',
        ),
        'status' => array(
            'group_ids',
            'act',
            '__token__',
        ),
        'delete' => array(
            'group_ids',
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'group_id'      => $this->obj_lang->get('ID'),
            'group_name'    => $this->obj_lang->get('Name'),
            'group_status'  => $this->obj_lang->get('Status'),
            'group_note'    => $this->obj_lang->get('Note'),
            'group_allow'   => $this->obj_lang->get('Permission'),
            'group_ids'     => $this->obj_lang->get('Group'),
            'act'           => $this->obj_lang->get('Action'),
            '__token__'     => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
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
