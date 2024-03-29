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
  'Add'               => '添加', //添加
  'Back'              => '返回',
  'Edit'              => '编辑', //编辑
  'Show'              => '查看',
  'Reset'             => '清除',
  'Input error'       => '输入错误，请检查！',
  'Special topic'     => '专题',
  'Missing ID'        => '无法获取 ID',
  'Topic'             => '专题',
  'Topic not found'   => '专题不存在',
  'Choose article'    => '选择文章',
  'Token'             => '表单令牌',
  'Keyword'           => '关键词',
  'All'               => '全部',
  'More'              => '更多',
  'Size'              => '大小',
  'Detail'            => '详情',
  'ratio'             => '比例',
  'cut'               => '裁切',
  'normal'            => '正常',
  'recycle'           => '回收站',
  'reserve'           => '保留数据',
  'Template'          => '模板',
  'Inherit'           => '继承',
  'Select'            => '选择',
  'Attachment'                            => '附件',
  'Attachment not found'                  => '附件不存在',
  'Cover'                                 => '封面',
  'Set cover'                             => '设置封面',
  'Set as cover'                          => '设为封面',
  'Cover management'                      => '封面管理',
  'Set cover successfully'                => '设置封面成功',
  'Generate'                              => '生成',
  'Time'                                  => '时间',
  'Updated time'                          => '更新时间',
  'Status'                                => '状态',
  'Save'                                  => '保存',
  'Server side error'                     => '服务器错误',
  'Saving'                                => '正在保存 ...',
  'All status'                            => '所有状态',
  'All types'                             => '所有类型',
  'Name'                                  => '名称',
  'Content'                               => '内容',
  'Action'                                => '操作',
  'show'                                  => '显示',
  'hide'                                  => '隐藏',
  'Add media'                             => '添加媒体',
  'Add album'                             => '添加相册',
  'Add topic successfully'                => '添加专题成功',
  'Add topic failed'                      => '添加专题失败',
  'Update topic successfully'             => '更新专题成功',
  'Successfully updated {:count} topics'  => '成功更新 {:count} 个专题',
  'Did not make any changes'              => '未做任何修改',
  'Delete'                                => '删除',
  'Successfully deleted {:count} topics'  => '成功删除 {:count} 个专题',
  'No topic have been deleted'            => '未删除任何专题',
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
  '{:attr} not a valid datetime'          => '{:attr} 格式不合法',
);
