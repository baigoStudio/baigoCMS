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
    'Back'                                  => '返回',
    'Show'                                  => '查看',
    'Cancel'                                => '取消',
    'Confirm'                               => '确定',
    'Input error'                           => '输入错误，请检查！',
    'Album'                                 => '相册',
    'Missing ID'                            => '无法获取 ID',
    'Album not found'                       => '相册不存在',
    'Reset'                                 => '清除',
    'Cover'                                 => '封面',
    'Upload'                                => '上传',
    'Remove'                                => '剔除',
    'Choose'                                => '选择',
    'Choose image'                          => '选择图片',
    'Token'                                 => '表单令牌',
    'Keyword'                              => '关键词',
    'All'                                   => '全部',
    'Close'                                 => '关闭',
    'OK'                                    => '确定',
    'Set as cover'                          => '设为封面',
    'Status'                                => '状态',
    'Server side error'                     => '服务器错误',
    'Submitting'                            => '正在提交 ...',
    'Complete'                              => '完成',
    'Saving'                                => '正在保存 ...',
    'All status'                            => '所有状态',
    'All types'                             => '所有类型',
    'normal'                                => '正常',
    'recycle'                               => '回收站',
    'reserve'                               => '保留数据',
    'Name'                                  => '名称',
    'Intro'                                 => '说明',
    'Action'                                => '操作', //生效
    'enable'                                => '启用', //生效
    'disabled'                              => '禁用', //禁用
    'Attachment'                            => '附件',
    'Images in album'                       => '相册内图片',
    'Pending images'                        => '待选图片',
    'Delete'                                => '删除',
    'Successfully processed {:count} datas' => '成功处理 {:count} 条数据',
    'Successfully remove {:count} datas'    => '成功剔除 {:count} 条数据',
    'Did not make any changes'              => '未做任何修改',
    'No data have been removed'             => '未剔除任何数据',
    'Apply'                                 => '提交',
    'Bulk actions'                          => '批量操作',
    'Form token is incorrect'               => '表单令牌错误',
    'Choose at least one item'              => '至少选择一项',
    'Choose at least one {:attr}'           => '至少选择一项 {:attr}',
    'Are you sure to choose?'               => '确认选择吗？',
    'Are you sure to remove?'               => '确认剔除吗？',
    'You do not have permission'            => '您没有权限',
    '{:attr} require'                       => '{:attr} 是必需的',
    'Size of {:attr} must be {:rule}'       => '{:attr} 的长度必须在 {:rule} 之间',
    'Max size of {:attr} must be {:rule}'   => '{:attr} 最长 {:rule}',
    '{:attr} must be integer'               => '{:attr} 必须为整数',
);
