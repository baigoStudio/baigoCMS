<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

return array(
  'route' => array(
    'cate'      => 'cate',
    'search'    => 'search',
    'article'   => 'article',
    'tag'       => 'tag',
    'spec'      => 'spec',
    'call'      => 'call',
    'album'     => 'album',
  ),
);
