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
  'count_lists' => array(
    'article' => array(
      'title'  => 'Article',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
    'tag'     => array(
      'title'  => 'Tag',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
    'spec'    => array(
      'title'  => 'Special topic',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
    'attach'  => array(
      'title'  => 'Attachment',
      'lists'  => array(
        'total'  => array('box', 'normal'),
      ),
    ),
    'cate'    => array(
      'title'  => 'Category',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
    'admin'   => array(
      'title'  => 'Administrator',
      'lists'  => array(
        'total'  => true,
        'status' => true,
        'type'   => true,
      ),
    ),
    'group'   => array(
      'title'  => 'Group',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
    'link'    => array(
      'title'  => 'Link',
      'lists'  => array(
        'total'  => true,
        'status' => true,
        'type'   => true,
      ),
    ),
    'app'     => array(
      'title'  => 'App',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
  ),
);
