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
class Gather extends Validate {

    protected $rule     = array(
        'gather_id' => array(
            '>' => 0,
        ),
        'gather_title' => array(
            'require' => true,
        ),
        'url' => array(
            'require' => true,
        ),
        'gather_ids' => array(
            'require' => true,
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'gather_title',
        ),
        'grab' => array(
            'gather_id',
            'url',
            '__token__',
        ),
        'store' => array(
            'gather_id',
            '__token__',
        ),
        'delete' => array(
            'gather_ids',
            '__token__',
        ),
    );


    function v_init() { //构造函数

        $_arr_attrName = array(
            'gather_id'  => $this->obj_lang->get('ID'),
            'gather_ids' => $this->obj_lang->get('Gathering site'),
            '__token__'  => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
            'gt'        => $this->obj_lang->get('{:attr} require'),
            'token'     => $this->obj_lang->get('Form token is incorrect'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
    }
}
