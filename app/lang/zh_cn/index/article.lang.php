<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------------------通用-------------------------*/
return array(
  'Access denied'         => '拒绝访问',
  'Category not found'    => '栏目不存在',
  'Category is invalid'   => '栏目无效',
  'Article not found'     => '文章不存在',
  'Article is invalid'    => '文章无效',
  'Missing ID'            => '无法获取 ID',
  'Missing category ID'   => '无法获取栏目 ID',
);
