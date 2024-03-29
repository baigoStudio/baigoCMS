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
  'Access denied'                             => '拒绝访问',
  'Token'                                     => '表单令牌',
  'Send'                                      => '发送',
  'Sending'                                   => '正在发送 ...',
  'Keyword'                                   => '关键词',
  'Bulk'                                      => '群发',
  'To'                                        => '至',
  'Reset'                                     => '清除',
  'Back'                                      => '返回',
  'Show'                                      => '查看',
  'Input error'                               => '输入错误，请检查！',
  'Missing ID'                                => '无法获取 ID',
  'Enter username'                            => '输入用户名',
  'Message'                                   => '短信',
  'Private message'                           => '站内短信',
  'read'                                      => '已读',
  'wait'                                      => '未读',
  'revoke'                                    => '撤回',
  'out'                                       => '已发送',
  'in'                                        => '收件箱',
  'Status'                                    => '状态',
  'Type'                                      => '类型',
  'Time'                                      => '时间',
  'Title'                                     => '标题',
  'Content'                                   => '内容',
  'Sender'                                    => '发件人',
  'Recipient'                                 => '收件人',
  'Recipient not found'                       => '收件人不存在',
  'Unknown'                                   => '未知',
  'Apply'                                     => '提交',
  'Delete'                                    => '删除',
  'Action'                                    => '操作',
  'Bulk actions'                              => '批量操作',
  'System'                                    => '系统',
  'System message'                            => '系统消息',
  'Form token is incorrect'                   => '表单令牌错误',
  'All status'                                => '所有状态',
  'All type'                                  => '所有类型',
  'Choose at least one item'                  => '至少选择一项',
  'Choose at least one {:attr}'               => '至少选择一项 {:attr}',
  'Reply'                                     => '回复',
  'Revoke'                                    => '撤回',
  'Are you sure to delete?'                   => '确认删除吗？此操作不可恢复',
  'Are you sure to revoke?'                   => '确认撤回吗？',
  'Send message successfully'                 => '发送短信成功',
  'Send message failed'                       => '发送短信失败',
  'Successfully updated {:count} messages'    => '成功更新 {:count} 条短信',
  'Did not make any changes'                  => '未做任何修改',
  'You do not have permission'                => '您没有权限',
  'Successfully revoked {:count} messages'    => '成功撤回 {:count} 条短信',
  'Successfully deleted {:count} messages'    => '成功删除 {:count} 条短信',
  'No message have been revoked'              => '未撤回任何短信',
  'No message have been deleted'              => '未删除任何短信',
  '{:attr} require'                           => '{:attr} 是必需的',
  'Size of {:attr} must be {:rule}'           => '{:attr} 的长度必须在 {:rule} 之间',
  'For multiple recipients, please use <kbd>,</kbd> to separate'  => '多个收件人请使用 <kbd>,</kbd> 分隔',
);
