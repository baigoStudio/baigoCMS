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
class App extends Validate {

    protected $rule     = array(
        'app_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'app_name' => array(
            'length' => '1,30'
        ),
        'app_ip_allow' => array(
            'max' => 3000
        ),
        'app_ip_bad' => array(
            'max' => 3000
        ),
        'app_note' => array(
            'max' => 30
        ),
        'app_status' => array(
            'require' => true
        ),
        'app_allow' => array(
            'max' => 3000
        ),
        'app_param' => array(
            'max' => 1000
        ),
        'app_ids' => array(
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
            'app_id',
            'app_name',
            'app_ip_allow',
            'app_ip_bad',
            'app_note',
            'app_status',
            'app_allow',
            'app_param',
            '__token__',
        ),
        'submit_db' => array(
            'app_name',
            'app_ip_allow',
            'app_ip_bad',
            'app_note',
            'app_status',
            'app_allow',
            'app_param',
        ),
        'delete' => array(
            'app_ids',
            '__token__',
        ),
        'status' => array(
            'app_ids',
            'act',
            '__token__',
        ),
        'common' => array(
            'app_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
    );


    function v_init() { //构造函数

        $_arr_attrName = array(
            'app_id'            => $this->obj_lang->get('ID'),
            'app_name'          => $this->obj_lang->get('App name'),
            'app_ip_allow'      => $this->obj_lang->get('Allowed IPs'),
            'app_ip_bad'        => $this->obj_lang->get('Banned IPs'),
            'app_note'          => $this->obj_lang->get('Note'),
            'app_status'        => $this->obj_lang->get('Status'),
            'app_allow'         => $this->obj_lang->get('License'),
            'app_param'         => $this->obj_lang->get('Parameter'),
            'app_ids'           => $this->obj_lang->get('App'),
            'act'               => $this->obj_lang->get('Action'),
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
