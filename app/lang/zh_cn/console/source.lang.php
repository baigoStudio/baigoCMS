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
    'Cancel'                                => '取消',
    'Confirm'                               => '确定',
    'Input error'                           => '输入错误，请检查！',
    'Source'                                => '来源',
    'Missing ID'                            => '无法获取 ID',
    'Source not found'                      => '来源不存在',
    'Token'                                 => '表单令牌',
    'Keyword'                              => '关键词',
    'All'                                   => '全部',
    'Close'                                 => '关闭',
    'OK'                                    => '确定',
    'Save'                                  => '保存',
    'Server side error'                     => '服务器错误',
    'Submitting'                            => '正在提交 ...',
    'Saving'                                => '正在保存 ...',
    'Name'                                  => '名称',
    'Note'                                  => '备注',
    'Author'                                => '作者',
    'Action'                                => '操作',
    'Add source successfully'               => '添加来源成功',
    'Add source failed'                     => '添加来源失败',
    'Update source successfully'            => '更新来源成功',
    'Refresh cache successfully'            => '更新缓存成功',
    'Refresh cache failed'                  => '更新缓存失败',
    'Successfully updated {:count} sources' => '成功更新 {:count} 个来源',
    'Did not make any changes'              => '未做任何修改',
    'Delete'                                => '删除',
    'Successfully deleted {:count} sources' => '成功删除 {:count} 个来源',
    'No source have been deleted'           => '未删除任何来源',
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
    'Start with <code>http://</code> or <code>https://</code>' => '以 <code>http://</code> 或者 <code>https://</code> 开头',
);
