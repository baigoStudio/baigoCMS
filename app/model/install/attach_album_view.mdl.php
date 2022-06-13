<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\install;

use app\classes\install\Model;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------附件模型-------------*/
class Attach_Album_View extends Model {

  protected $create = array(
    array('attach.attach_id'),
    array('attach.attach_ext'),
    array('attach.attach_name'),
    array('attach.attach_note'),
    array('attach.attach_time'),
    array('attach.attach_box'),
  );

  public function createView() {
    $this->create[] = 'IFNULL(' . $this->obj_builder->table('album_belong') . '.`belong_album_id`, 0) AS `belong_album_id`';

    $_arr_join = array(
      'album_belong',
      array('attach.attach_id', '=', 'album_belong.belong_attach_id'),
      'LEFT',
    );

    $_num_count  = $this->viewFrom('attach')->viewJoin($_arr_join)->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y070108'; //更新成功
      $_str_msg   = 'Create view successfully';
    } else {
      $_str_rcode = 'x070108'; //更新成功
      $_str_msg   = 'Create view failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }
}
