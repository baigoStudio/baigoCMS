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
  'attr_often' => array(
    'html'  => 'HTML Source code',
    'text'  => 'Text',
    'href'  => 'Link',
    'src'   => 'Source URL',
    'class' => 'Class',
    'id'    => 'ID',
    'title' => 'Title',
  ),
);
