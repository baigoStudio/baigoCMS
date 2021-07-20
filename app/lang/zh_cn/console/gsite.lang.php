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
    'Reset'                                 => '清除',
    'Cancel'                                => '取消',
    'Confirm'                               => '确定',
    'Input error'                           => '输入错误，请检查！',
    'Gathering site'                        => '采集点',
    'Missing ID'                            => '无法获取 ID',
    'Gathering site not found'              => '采集点不存在',
    'Time'                                  => '时间',
    'Source code'                           => '源代码',
    'Preview'                               => '预览',
    'Token'                                 => '表单令牌',
    'Keyword'                               => '关键词',
    'All'                                   => '全部',
    'Close'                                 => '关闭',
    'OK'                                    => '确定',
    'Show'                                  => '查看',
    'Save'                                  => '保存',
    'Status'                                => '状态',
    'All status'                            => '所有状态',
    'Note'                                  => '备注',
    'Action'                                => '操作',
    'Please select'                         => '请选择',
    'Charset'                               => '字符集',
    'Common charset'                        => '常用字符集',
    'Server side error'                     => '服务器错误',
    'Submitting'                            => '正在提交 ...',
    'Saving'                                => '正在保存 ...',
    'enable'                                => '启用',
    'disabled'                              => '禁用',
    'Name'                                  => '名称',
    'Duplicate'                             => '克隆',
    'Bulk actions'                          => '批量操作',
    'List settings'                         => '列表设置',
    'Content settings'                      => '内容设置',
    'Paging list settings'                  => '分页列表设置',
    'Paging content settings'               => '分页内容设置',
    'Belong to category'                    => '隶属于栏目',
    'Add site successfully'                 => '添加采集点成功',
    'Add site failed'                       => '添加采集点失败',
    'Update site successfully'              => '更新采集点成功',
    'Successfully updated {:count} sites'   => '成功更新 {:count} 个采集点',
    'Did not make any changes'              => '未做任何修改',
    'Delete'                                => '删除',
    'Successfully deleted {:count} sites'   => '成功删除 {:count} 个采集点',
    'No site have been deleted'             => '未删除任何采集点',
    'Apply'                                 => '提交',
    'Form token is incorrect'               => '表单令牌错误',
    'Choose at least one item'              => '至少选择一项',
    'Choose at least one {:attr}'           => '至少选择一项 {:attr}',
    'Are you sure to delete?'               => '确认删除吗？此操作不可恢复',
    'You do not have permission'            => '您没有权限',
    'Gathering site already exists'         => '采集点已存在',
    'Duplicate site successfully'           => '克隆采集点成功',
    'Duplicate site failed'                 => '克隆采集点失败',
    '{:attr} require'                       => '{:attr} 是必需的',
    'Size of {:attr} must be {:rule}'       => '{:attr} 的长度必须在 {:rule} 之间',
    'Max size of {:attr} must be {:rule}'   => '{:attr} 最长 {:rule}',
    '{:attr} must be integer'               => '{:attr} 必须为整数',
    '{:attr} not a valid url'               => '{:attr} 格式不合法',
    'Start with <code>http://</code> or <code>https://</code>' => '以 <code>http://</code> 或者 <code>https://</code> 开头',
);
