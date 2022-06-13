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
  'Edit'                      => '编辑', //编辑
  'Show'                      => '查看',
  'Reset'                     => '清除',
  'Input error'               => '输入错误，请检查！',
  'Call'                      => '调用',
  'Missing ID'                => '无法获取 ID',
  'Call not found'            => '调用不存在',
  'Path'                      => '路径',
  'Date condition'            => '日期条件',
  'Within days'               => '几天内',
  '<kbd>0</kbd> is unlimited' => '<kbd>0</kbd> 为无限制',
  'Suggested calling code'    => '建议调用代码',
  'Token'                     => '表单令牌',
  'Keyword'                   => '关键词',
  'All'                       => '全部',
  'Save'                      => '保存',
  'Server side error'         => '服务器错误',
  'Bulk actions'              => '批量操作',
  'Saving'                    => '正在保存 ...',
  'Type'                      => '类型',
  'Status'                    => '状态',
  'All status'                => '所有状态',
  'Filter'                    => '过滤',
  'Category'                  => '栏目',
  'All categories'            => '所有栏目',
  'Special topic'             => '专题',
  'With pictures'             => '是否含图片',
  'Mark'                      => '标记',
  'enable'                    => '启用', //生效
  'disabled'                  => '禁用', //禁用
  'all'                       => '全部',
  'attach'                    => '带附件',
  'none'                      => '无附件',
  'article'                   => '文章列表', //普通
  'hits_day'                  => '日排行',
  'hits_week'                 => '周排行',
  'hits_month'                => '月排行',
  'hits_year'                 => '年排行',
  'hits_all'                  => '总排行',
  'spec'                      => '专题列表',
  'cate'                      => '栏目列表',
  'tag_list'                  => 'TAG 列表',
  'tag_rank'                  => 'TAG 排行',
  'link'                      => '友情链接',
  'Amount of display'         => '显示数量',
  'Top'                       => '显示前',
  'Except top'                => '排除前',
  'Except'                    => '排除',
  'Generate'                  => '生成',
  'Duplicate'                 => '克隆',
  'Refresh cache'             => '更新缓存',
  'Name'                                  => '名称',
  'Note'                                  => '备注',
  'Action'                                => '操作',
  'Template'                              => '模板',
  'Type of generate file'                 => '生成文件类型',
  'Add call successfully'                 => '添加调用成功',
  'Add call failed'                       => '添加调用失败',
  'Update call successfully'              => '更新调用成功',
  'Refresh cache successfully'            => '更新缓存成功',
  'Refresh cache failed'                  => '更新缓存失败',
  'Successfully updated {:count} calls'   => '成功更新 {:count} 个调用',
  'Did not make any changes'              => '未做任何修改',
  'Delete'                                => '删除',
  'Successfully deleted {:count} calls'   => '成功删除 {:count} 个调用',
  'No call have been deleted'             => '未删除任何调用',
  'Duplicate call successfully'           => '克隆调用成功',
  'Duplicate call failed'                 => '克隆调用失败',
  'Please select'                         => '请选择',
  'Apply'                                 => '提交',
  'Form token is incorrect'                      => '表单令牌错误',
  'Choose at least one item'              => '至少选择一项',
  'Choose at least one {:attr}'           => '至少选择一项 {:attr}',
  'Are you sure to delete?'               => '确认删除吗？此操作不可恢复',
  'You do not have permission'            => '您没有权限',
  '{:attr} require'                       => '{:attr} 是必需的',
  'Size of {:attr} must be {:rule}'       => '{:attr} 的长度必须在 {:rule} 之间',
  'Max size of {:attr} must be {:rule}'   => '{:attr} 最长 {:rule}',
  '{:attr} must be integer'               => '{:attr} 必须为整数',
  '{:attr} not a valid url'               => '{:attr} 格式不合法',
);
