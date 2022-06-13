<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\gen;

use app\model\index\Spec as Spec_Index;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------栏目模型-------------*/
class Spec extends Spec_Index {

  public $inputLists  = array();

  public function pathLists($num_page = 1) {
    $_str_listsPathRoot     = GK_PATH_PUBLIC . $this->routeSpec . DS;
    $_str_listsPathFile     = 'page-' . $num_page . '.' . $this->configVisit['visit_file'];
    $_str_listsPathIndex    = 'index.' . $this->configVisit['visit_file'];

    $_arr_listsPath['lists_path_name'] = $_str_listsPathFile;
    $_arr_listsPath['lists_path']      = $_str_listsPathRoot . $_str_listsPathFile;

    if ($num_page == 1) {
      $_arr_listsPath['lists_path_index'] = $_str_listsPathRoot . $_str_listsPathIndex;
    }

    return $_arr_listsPath;
  }


  public function inputLists() {
    $_arr_inputParam = array(
      'page'      => array('int', 0),
      '__token__' => array('str', ''),
    );

    $_arr_inputLists = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputLists);

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x180201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputLists['rcode'] = 'y180201';

    $this->inputLists = $_arr_inputLists;

    return $_arr_inputLists;
  }
}
