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
class Album extends Validate {

  protected $rule     = array(
    'album_id' => array(
      'require' => true,
      'format'  => 'int',
    ),
    'album_name' => array(
      'length' => '1,300',
    ),
    'album_status' => array(
      'require' => true,
    ),
    'album_content' => array(
      'max' => 3000,
    ),
    'album_ids' => array(
      'require' => true,
    ),
    'act' => array(
      'require' => true,
    ),
    'attach_id' => array(
      'require' => true,
    ),
    '__token__' => array(
      'require' => true,
      'token'   => true,
    ),
  );

  protected $scene    = array(
    'submit' => array(
      'album_id',
      'album_name',
      'album_status',
      'album_content',
      '__token__',
    ),
    'submit_db' => array(
      'album_name',
      'album_status',
      'album_content',
    ),
    'cover' => array(
      'album_id' => array(
        '>' => 0,
      ),
      'attach_id' => array(
        '>' => 0,
      ),
      '__token__',
    ),
    'delete' => array(
      'admin_ids',
      '__token__',
    ),
    'status' => array(
      'admin_ids',
      'act',
      '__token__',
    ),
  );


  protected function v_init() { //构造函数
    $_arr_attrName = array(
      'album_id'      => $this->obj_lang->get('ID'),
      'album_name'    => $this->obj_lang->get('Name'),
      'album_status'  => $this->obj_lang->get('Status'),
      'album_content' => $this->obj_lang->get('Intro'),
      '__token__'     => $this->obj_lang->get('Token'),
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
