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
  'Access denied'     => '拒绝访问',
  'Input error'       => '输入错误，请检查！',
  'Missing ID'        => '无法获取 ID',
  'Status'            => '状态',
  'Server side error' => '服务器错误',
  'Saving'            => '正在保存 ...',
  'Form token is incorrect'               => '表单令牌错误',
  'You do not have permission'            => '您没有权限',
  '{:attr} require'                       => '{:attr} 是必需的',
  'Size of {:attr} must be {:rule}'       => '{:attr} 的长度必须在 {:rule} 之间',
  'Max size of {:attr} must be {:rule}'   => '{:attr} 最长 {:rule}',
  '{:attr} must be integer'               => '{:attr} 必须为整数',
);
