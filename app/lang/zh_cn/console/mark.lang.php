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
    'Mark'                                  => '标记',
    'Missing ID'                            => '无法获取 ID',
    'Mark not found'                        => '标记不存在',
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
    'Add mark successfully'                 => '添加标记成功',
    'Add mark failed'                       => '添加标记失败',
    'Update mark successfully'              => '更新标记成功',
    'Successfully updated {:count} marks'   => '成功更新 {:count} 个标记',
    'Did not make any changes'              => '未做任何修改',
    'Delete'                                => '删除',
    'Successfully deleted {:count} marks'   => '成功删除 {:count} 个标记',
    'No mark have been deleted'             => '未删除任何标记',
    'Apply'                                 => '提交',
    'Form token is incorrect'               => '表单令牌错误',
    'Choose at least one item'              => '至少选择一项',
    'Choose at least one {:attr}'           => '至少选择一项 {:attr}',
    'Are you sure to delete?'               => '确认删除吗？此操作不可恢复',
    'You do not have permission'            => '您没有权限',
    'Mark already exists'                   => '标记已存在',
    '{:attr} require'                       => '{:attr} 是必需的',
    'Size of {:attr} must be {:rule}'       => '{:attr} 的长度必须在 {:rule} 之间',
    'Max size of {:attr} must be {:rule}'   => '{:attr} 最长 {:rule}',
    '{:attr} must be integer'               => '{:attr} 必须为整数',
);
