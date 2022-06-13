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

/*-------------相册归属模型-------------*/
class Album_View extends Model {

  protected $create = array(
    array('album.album_id'),
    array('album.album_name'),
    array('album.album_status'),
    array('album.album_tpl'),
    array('album.album_time'),
    array('album.album_attach_id'),
    array('album_belong.belong_attach_id'),
  );


  public function createView() {
    $_arr_join = array(
      'album_belong',
      array('album.album_id', '=', 'album_belong.belong_album_id'),
      'LEFT',
    );

    $_num_count  = $this->viewFrom('album')->viewJoin($_arr_join)->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y290108'; //更新成功
      $_str_msg   = 'Create view successfully';
    } else {
      $_str_rcode = 'x290108'; //更新成功
      $_str_msg   = 'Create view failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }
}
