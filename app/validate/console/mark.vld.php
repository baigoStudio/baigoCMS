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
class Mark extends Validate {

  protected $rule     = array(
    'mark_id' => array(
      'require' => true,
      'format'  => 'int',
    ),
    'mark_name' => array(
      'length' => '1,30',
    ),
    'mark_ids' => array(
      'require' => true,
    ),
    '__token__' => array(
      'require' => true,
      'token'   => true,
    ),
  );

  protected $scene    = array(
    'submit' => array(
      'mark_id',
      'mark_name',
      '__token__',
    ),
    'submit_db' => array(
      'mark_name',
    ),
    'delete' => array(
      'mark_ids',
      '__token__',
    ),
  );

  protected function v_init() { //构造函数

    $_arr_attrName = array(
      'mark_id'      => $this->obj_lang->get('ID'),
      'mark_name'    => $this->obj_lang->get('Name'),
      'mark_ids'     => $this->obj_lang->get('Mark'),
      '__token__'    => $this->obj_lang->get('Token'),
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
