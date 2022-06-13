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
  'App Key'                           => 'App Key 通信密钥',
  'App Key is incorrect'              => 'App Key 通信密钥错误',
  'Size of App Secret must be 16'     => 'App Secret 长度必须为 16 位',
  'Timestamp'                         => '时间戳',
  'Signature'                         => '签名',
  'Signature is incorrect'            => '签名错误',
  'Encrypted code'                    => '加密码',
  'App not found'             => '应用不存在',
  'App is disabled'           => '应用被禁用',
  'Your IP address is not allowed'    => 'IP 地址不在允许范围内',
  'Your IP address is forbidden'      => 'IP 地址被禁止',
  '{:attr} require'                   => '{:attr} 是必需的',
  '{:attr} must be integer'           => '{:attr} 必须是整数',
);
