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
  'Access denied'                         => '拒绝访问',
  'Add'                                   => '添加', //添加
  'Back'                                  => '返回',
  'Edit'                                  => '编辑', //编辑
  'Show'                                  => '查看',
  'Reset'                                 => '清除',
  'Input error'                           => '输入错误，请检查！',
  'Group'                                 => '群组',
  'Missing ID'                            => '无法获取 ID',
  'Group not found'                       => '群组不存在',
  'Token'                                 => '表单令牌',
  'Keyword'                               => '关键词',
  'All'                                   => '全部',
  'Status'                                => '状态',
  'Target'                                => '类型',
  'Save'                                  => '保存',
  'Server side error'                     => '服务器错误',
  'Permission'                            => '权限',
  'Saving'                                => '正在保存 ...',
  'All status'                            => '所有状态',
  'All types'                             => '所有类型',
  'Name'                                  => '名称',
  'Note'                                  => '备注',
  'Action'                                => '操作', //生效
  'enable'                                => '启用', //生效
  'disabled'                              => '禁用', //禁用
  'admin'                                 => '管理组',
  'user'                                  => '用户组',
  'Add group successfully'                => '添加群组成功',
  'Add group failed'                      => '添加群组失败',
  'Update group successfully'             => '更新群组成功',
  'Successfully updated {:count} groups'  => '成功更新 {:count} 个群组',
  'Did not make any changes'              => '未做任何修改',
  'Delete'                                => '删除',
  'Successfully deleted {:count} groups'  => '成功删除 {:count} 个群组',
  'No group have been deleted'            => '未删除任何群组',
  'Apply'                                 => '提交',
  'Bulk actions'                          => '批量操作',
  'Form token is incorrect'               => '表单令牌错误',
  'Choose at least one item'              => '至少选择一项',
  'Choose at least one {:attr}'           => '至少选择一项 {:attr}',
  'Are you sure to delete?'               => '确认删除吗？此操作不可恢复',
  'You do not have permission'            => '您没有权限',
  '{:attr} require'                       => '{:attr} 是必需的',
  'Size of {:attr} must be {:rule}'       => '{:attr} 的长度必须在 {:rule} 之间',
  'Max size of {:attr} must be {:rule}'   => '{:attr} 最长 {:rule}',
  '{:attr} must be integer'               => '{:attr} 必须为整数',
);
