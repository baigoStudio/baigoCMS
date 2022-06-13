<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

return array(
  'title'  => array(
    'title'     => 'Title',
    'require'   => true,
    'show'      => true,
    'base'      => true,
  ),
  'content'  => array(
    'title'     => 'Content',
    'require'   => true,
    'base'      => true,
  ),
  'time'  => array(
    'title'     => 'Time',
    'show'      => true,
    'more'      => true,
  ),
  'source'  => array(
    'title'     => 'Source',
    'more'      => true,
  ),
  'author'  => array(
    'title'     => 'Author',
    'more'      => true,
  ),
);
