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
class Cate extends Validate {

    protected $rule     = array(
        'cate_id' => array(
            'require' => true,
        ),
        'cate_name' => array(
            'length'    => '1,300',
        ),
        'cate_alias' => array(
            'max'       => 300,
            'format'    => 'alpha_dash',
        ),
        'cate_perpage' => array(
            'format'    => 'int',
        ),
        'cate_prefix' => array(
            'max'       => 3000,
        ),
        'cate_link' => array(
            'max'       => 3000,
        ),
        'cate_parent_id' => array(
            'require'   => true,
        ),
        'cate_tpl' => array(
            'require'   => true,
        ),
        'cate_status' => array(
            'require'   => true,
        ),
        'cate_ftp_host' => array(
            'max'       => 3000,
        ),
        'cate_ftp_port' => array(
            'max'       => 5,
        ),
        'cate_ftp_user' => array(
            'max'       => 300,
        ),
        'cate_ftp_path' => array(
            'max'       => 3000,
        ),
        'cate_ids' => array(
            'require' => true,
        ),
        'act' => array(
            'require' => true,
        ),
        'cate_orders' => array(
            'require' => true,
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'cate_id',
            'cate_name',
            'cate_alias',
            'cate_perpage',
            'cate_prefix',
            'cate_link',
            'cate_parent_id',
            'cate_tpl',
            'cate_status',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_path',
            '__token__',
        ),
        'submit_db' => array(
            'cate_name',
            'cate_alias',
            'cate_perpage',
            'cate_prefix',
            'cate_link',
            'cate_parent_id',
            'cate_tpl',
            'cate_status',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_path',
        ),
        'duplicate' => array(
            'cate_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'delete' => array(
            'cate_ids',
            '__token__',
        ),
        'status' => array(
            'cate_ids',
            'act',
            '__token__',
        ),
        'order' => array(
            'cate_orders',
            '__token__',
        ),
        'common' => array(
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'cate_id'           => $this->obj_lang->get('ID'),
            'cate_name'         => $this->obj_lang->get('Name'),
            'cate_alias'        => $this->obj_lang->get('Alias'),
            'cate_perpage'      => $this->obj_lang->get('Count of per page'),
            'cate_prefix'       => $this->obj_lang->get('URL Prefix'),
            'cate_link'         => $this->obj_lang->get('Jump to'),
            'cate_parent_id'    => $this->obj_lang->get('Parent category'),
            'cate_tpl'          => $this->obj_lang->get('Template'),
            'cate_status'       => $this->obj_lang->get('Status'),
            'cate_ftp_host'     => $this->obj_lang->get('FTP Host'),
            'cate_ftp_port'     => $this->obj_lang->get('Host port'),
            'cate_ftp_user'     => $this->obj_lang->get('Username'),
            'cate_ftp_path'     => $this->obj_lang->get('Remote path'),
            'cate_ids'          => $this->obj_lang->get('Category'),
            'act'               => $this->obj_lang->get('Action'),
            'cate_orders'       => $this->obj_lang->get('Sort'),
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
            'int'          => $this->obj_lang->get('{:attr} must be integer'),
            'alpha_dash'   => $this->obj_lang->get('{:attr} must be alpha-numeric, dash, underscore'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
        $this->setFormatMsg($_arr_formatMsg);
    }
}
