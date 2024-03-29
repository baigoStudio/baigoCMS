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
class Tag extends Validate {

  protected $rule     = array(
    'tag_id' => array(
      'require' => true,
      'format'  => 'int',
    ),
    'tag_name' => array(
      'length' => '1,30',
    ),
    'tag_status' => array(
      'require' => true,
    ),
    'tag_ids' => array(
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
      'tag_id',
      'tag_name',
      'tag_status',
      '__token__',
    ),
    'submit_db' => array(
      'tag_name',
      'tag_status',
    ),
    'delete' => array(
      'tag_ids',
      '__token__',
    ),
    'status' => array(
      'tag_ids',
      'act',
      '__token__',
    ),
  );

  protected function v_init() { //构造函数
    $_arr_attrName = array(
      'tag_id'        => $this->obj_lang->get('ID'),
      'tag_name'      => $this->obj_lang->get('Name'),
      'tag_status'    => $this->obj_lang->get('Status'),
      'tag_ids'       => $this->obj_lang->get('Tag'),
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
