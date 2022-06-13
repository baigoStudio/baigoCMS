<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\common;

use app\model\Tag as Tag_Base;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------TAG 模型-------------*/
class Tag extends Tag_Base {

  /**
   * mdl_updateCount function.
   *
   * @access public
   * @param mixed $num_tagId
   * @param int $num_articleCount (default: 0)
   * @return void
   */
  public function updateCount($num_tagId, $num_articleCount = 0) {
    $_arr_tagData = array(
      'tag_article_count' => $num_articleCount,
    );

    $_num_count     = $this->where('tag_id', '=', $num_tagId)->update($_arr_tagData); //更新数

    if ($_num_count > 0) {
      $_str_rcode = 'y130103';
    } else {
      return array(
        'rcode' => 'x130103',
      );
    }

    return array(
      'rcode'  => $_str_rcode,
    );
  }

}
