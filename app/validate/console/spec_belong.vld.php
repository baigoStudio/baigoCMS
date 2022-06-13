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
class Spec_Belong extends Validate {

  protected $rule     = array(
    'spec_id' => array(
      'require' => true,
      'format'  => 'int',
    ),
    'max_id' => array(
      'require' => true,
      'format'  => 'int',
    ),
    'article_ids' => array(
      'require' => true,
    ),
    'article_ids_belong' => array(
      'require' => true,
    ),
    '__token__' => array(
      'require' => true,
      'token'   => true,
    ),
  );

  protected $scene    = array(
    'submit' => array(
      'spec_id' => array(
        '>' => 0,
      ),
      'article_ids',
      '__token__',
    ),
    'clear' => array(
      'max_id',
      '__token__',
    ),
    'remove' => array(
      'spec_id' => array(
        '>' => 0,
      ),
      'article_ids_belong',
      '__token__',
    ),
  );

  protected function v_init() { //构造函数

    $_arr_attrName = array(
      'spec_id'               => $this->obj_lang->get('Topic ID'),
      'article_ids'           => $this->obj_lang->get('Article'),
      'article_ids_belong'    => $this->obj_lang->get('Article'),
      '__token__'             => $this->obj_lang->get('Token'),
    );

    $_arr_typeMsg = array(
      'require'   => $this->obj_lang->get('{:attr} require'),
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
