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
class Cate_Belong extends Validate {

  protected $rule     = array(
    'max_id' => array(
      'require' => true,
      'format'  => 'int',
    ),
    '__token__' => array(
      'require' => true,
      'token'   => true,
    ),
  );

  protected function v_init() { //构造函数

    $_arr_typeMsg = array(
      'require'   => $this->obj_lang->get('{:attr} require'),
      'token'     => $this->obj_lang->get('Form token is incorrect'),
    );

    $_arr_formatMsg = array(
      'int' => $this->obj_lang->get('{:attr} must be integer'),
    );

    $this->setTypeMsg($_arr_typeMsg);
    $this->setFormatMsg($_arr_formatMsg);
  }
}
