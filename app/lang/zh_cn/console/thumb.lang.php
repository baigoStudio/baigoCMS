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
  'Add'                                       => '添加', //添加
  'Back'                                      => '返回',
  'Edit'                                      => '编辑', //编辑
  'Show'                                      => '查看',
  'Reset'                                     => '清除',
  'Input error'                               => '输入错误，请检查！',
  'Thumbnail'                                 => '缩略图',
  'Missing ID'                                => '无法获取 ID',
  'Thumbnail not found'                       => '缩略图不存在',
  'Thumbnail already exists'                  => '缩略图已存在',
  'Token'                                     => '表单令牌',
  'Keyword'                                   => '关键词',
  'All'                                       => '全部',
  'Refresh cache'                             => '更新缓存',
  'Default'                                   => '默认',
  'Status'                                    => '状态',
  'Type'                                      => '类型',
  'Save'                                      => '保存',
  'ratio'                                     => '比例',
  'cut'                                       => '裁切',
  'To'                                        => '至',
  'Quality'                                   => '图片质量',
  '0 - 100, only valid for JPG and PNG'       => '0 - 100，仅对 JPG、PNG 有效',
  '<kbd>0</kbd> is unlimited'                 => '<kbd>0</kbd> 为无限制',
  'Attachment ID range'                       => '附件 ID 范围',
  'Server side error'                         => '服务器错误',
  'Saving'                                    => '正在保存 ...',
  'Maximum width'                             => '最大宽度',
  'Maximum height'                            => '最大高度',
  'Set as default'                            => '设为默认',
  'Add thumbnail successfully'                => '添加缩略图成功',
  'Add thumbnail failed'                      => '添加缩略图失败',
  'Update thumbnail successfully'             => '更新缩略图成功',
  'Did not make any changes'                  => '未做任何修改',
  'Delete'                                    => '删除',
  'Successfully deleted {:count} thumbnails'  => '成功删除 {:count} 个缩略图',
  'No thumbnail have been deleted'            => '未删除任何缩略图',
  'Form token is incorrect'                   => '表单令牌错误',
  'Choose at least one item'                  => '至少选择一项',
  'Choose at least one {:attr}'               => '至少选择一项 {:attr}',
  'Are you sure to delete?'                   => '确认删除吗？此操作不可恢复',
  'You do not have permission'                => '您没有权限',
  '{:attr} require'                           => '{:attr} 是必需的',
  '{:attr} must be integer'                   => '{:attr} 必须为整数',
  '{:attr} must between {:rule}'              => '{:attr} 必须在 {:rule} 之间',
  'Regenerate thumbnails'                     => '重新生成缩略图',
  'Refresh cache successfully'                => '更新缓存成功',
  'Refresh cache failed'                      => '更新缓存失败',
  'Set successfully'                          => '设置成功',
  'Set failed'                                => '设置失败',
  'Warning! This operation will take a long time!' => '警告！此操作将耗费较长时间！',
);
