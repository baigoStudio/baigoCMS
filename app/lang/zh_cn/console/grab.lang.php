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
  'Access denied'             => '拒绝访问',
  'Add'                       => '添加', //添加
  'Back'                      => '返回',
  'Edit and store'            => '编辑并入库',
  'Reset'                     => '清除',
  'Input error'               => '输入错误，请检查！',
  'Grabbing'                  => '正在抓取',
  'Gathering'                 => '采集',
  'Site'                      => '采集点',
  'Gathering site'            => '采集点',
  'Missing ID'                => '无法获取 ID',
  'Missing title'             => '标题不能为空',
  'Already stored'            => '已入库',
  'Gathering site not found'  => '采集点不存在',
  'Data not found'            => '数据不存在',
  'Time'                      => '时间',
  'Token'                     => '表单令牌',
  'Title'                     => '标题',
  'Keyword'                   => '关键词',
  'All'                       => '全部',
  'All sites'                 => '所有采集点',
  'All categories'            => '所有栏目',
  'Show'                      => '查看',
  'Save'                      => '保存',
  'Gather'                    => '采集',
  'Gather all'                => '全部采集',
  'Status'                    => '状态',
  'Please select'             => '请选择',
  'Server side error'         => '服务器错误',
  'Saving'                    => '正在保存 ...',
  'Store'                     => '入库',
  'Store enforce'             => '强制入库',
  'Store all'                 => '全部入库',
  'Note'                      => '备注',
  'All status'                => '所有状态',
  'enable'                    => '启用',
  'disabled'                  => '禁用',
  'Name'                      => '名称',
  'Bulk actions'              => '批量操作',
  'Being stored'              => '正在入库',
  'Category'                              => '栏目',
  'Belong to category'                    => '隶属于栏目',
  'Display time'                          => '显示时间',
  'Gather successfully'                   => '采集成功',
  'Gather failed'                         => '采集失败',
  'Apply'                                 => '提交',
  'Form token is incorrect'               => '表单令牌错误',
  'Choose at least one item'              => '至少选择一项',
  'Choose at least one {:attr}'           => '至少选择一项 {:attr}',
  'Are you sure to delete?'               => '确认删除吗？此操作不可恢复',
  'You do not have permission'            => '您没有权限',
  'Data already exists'                   => '数据已存在',
  '{:attr} require'                       => '{:attr} 是必需的',
  'Size of {:attr} must be {:rule}'       => '{:attr} 的长度必须在 {:rule} 之间',
  'Max size of {:attr} must be {:rule}'   => '{:attr} 最长 {:rule}',
  '{:attr} must be integer'               => '{:attr} 必须为整数',
  '{:attr} not a valid url'               => '{:attr} 格式不合法',
  'Completed gather' => '采集完毕',
);
