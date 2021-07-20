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
class Spec extends Validate {

    protected $rule     = array(
        'spec_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'spec_name' => array(
            'length' => '1,300',
        ),
        'spec_status' => array(
            'require' => true,
        ),
        'spec_content' => array(
            'max' => 3000,
        ),
        'spec_time_update_format' => array(
            'format'  => 'date_time',
        ),
        'spec_time_update' => array(
            'format'  => 'int',
        ),
        'spec_ids' => array(
            'require' => true,
        ),
        'act' => array(
            'require' => true,
        ),
        'attach_id' => array(
            '>' => 0,
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'spec_id',
            'spec_name',
            'spec_status',
            'spec_content',
            'spec_time_update_format',
            '__token__',
        ),
        'submit_db' => array(
            'spec_name',
            'spec_status',
            'spec_content',
            'spec_time_update',
        ),
        'cover' => array(
            'spec_id' => array(
                '>' => 0,
            ),
            'attach_id',
            '__token__',
        ),
        'delete' => array(
            'spec_ids',
            '__token__',
        ),
        'status' => array(
            'spec_ids',
            'act',
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'spec_id'               => $this->obj_lang->get('ID'),
            'spec_name'             => $this->obj_lang->get('Name'),
            'spec_status'           => $this->obj_lang->get('Status'),
            'spec_content'          => $this->obj_lang->get('Content'),
            'spec_time_update_format'  => $this->obj_lang->get('Updated time'),
            'spec_ids'              => $this->obj_lang->get('Topic'),
            'act'                   => $this->obj_lang->get('Action'),
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
            'date_time'    => $this->obj_lang->get('{:attr} not a valid datetime'),
            'int'          => $this->obj_lang->get('{:attr} must be integer'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
        $this->setFormatMsg($_arr_formatMsg);
    }
}
