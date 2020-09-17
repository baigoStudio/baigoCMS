<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\validate\console;

use ginkgo\Validate;
use ginkgo\Config;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------管理员模型-------------*/
class Call extends Validate {

    protected $rule     = array(
        'call_id' => array(
            'require' => true,
        ),
        'call_name' => array(
            'length' => '1,300',
        ),
        'call_type' => array(
            'require' => true,
        ),
        'call_status' => array(
            'require' => true,
        ),
        'call_file' => array(
            'require' => true,
        ),
        'call_tpl' => array(
            'require' => true,
        ),
        'call_ids' => array(
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
            'call_id',
            'call_name',
            'call_type',
            'call_status',
            '__token__',
        ),
        'submit_db' => array(
            'call_name',
            'call_type',
            'call_status',
        ),
        'duplicate' => array(
            'call_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'delete' => array(
            'call_ids',
            '__token__',
        ),
        'status' => array(
            'call_ids',
            'act',
            '__token__',
        ),
        'common' => array(
            '__token__',
        ),
    );


    function v_init() { //构造函数

        $_arr_attrName = array(
            'call_id'               => $this->obj_lang->get('ID'),
            'call_name'             => $this->obj_lang->get('Name'),
            'call_type'             => $this->obj_lang->get('Type'),
            'call_status'           => $this->obj_lang->get('Status'),
            'call_file'             => $this->obj_lang->get('Type of generate file'),
            'call_tpl'              => $this->obj_lang->get('Template'),
            'call_amount'           => $this->obj_lang->get('Amount of display'),
            'call_ids'              => $this->obj_lang->get('Call'),
            'act'                   => $this->obj_lang->get('Action'),
            '__token__'             => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
            'gt'        => $this->obj_lang->get('{:attr} require'),
            'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
            'token'     => $this->obj_lang->get('Form token is incorrect'),
        );

        $_arr_formatMsg = array(
            'int' => $this->obj_lang->get('{:attr} must be integer'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
        $this->setFormatMsg($_arr_formatMsg);

        $_arr_configVisit    = Config::get('visit', 'var_extra');

        if ($_arr_configVisit['visit_type'] == 'static') {
            $this->scene['submit'][] = 'call_file';
            $this->scene['submit'][] = 'call_tpl';
            $this->scene['submit_db'][] = 'call_file';
            $this->scene['submit_db'][] = 'call_tpl';
        }
    }
}
