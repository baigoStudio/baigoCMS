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
  'Access denied'                 => '拒绝访问',
  'Token'                         => '表单令牌',
  'Call'                          => '调用',
  'Input error'                   => '输入错误，请检查！',
  'Missing ID'                    => '无法获取 ID',
  'Status'                        => '状态',
  'Form token is incorrect'       => '表单令牌错误',
  'None'                          => '无',
  'Call not found'                => '调用不存在',
  'Call is invalid'               => '调用无效',
  'Unable to generate'            => '无法生成',
  'Template not found'            => '模板不存在',
  'Generate'                      => '生成',
  'Generating'                    => '正在生成',
  'Complete generation'           => '生成完毕',
  'Generate call failed'          => '生成调用失败',
  'Generate call successfully'    => '生成调用成功',
  '<kbd>0</kbd> is unlimited'     => '<kbd>0</kbd> 为无限制',
  '{:attr} require'               => '{:attr} 是必需的',
  '{:attr} must be integer'       => '{:attr} 必须是整数',
);
