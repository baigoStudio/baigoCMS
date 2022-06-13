<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
namespace app\model\index;

use app\model\Article_Custom as Article_Custom_Base;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------应用归属-------------*/
class Article_Custom extends Article_Custom_Base {

}
