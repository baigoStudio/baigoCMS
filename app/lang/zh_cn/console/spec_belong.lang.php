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
    'Back'              => '返回',
    'Show'              => '查看',
    'Cancel'            => '取消',
    'Confirm'           => '确定',
    'Input error'       => '输入错误，请检查！',
    'Special topic'     => '专题',
    'Missing ID'        => '无法获取 ID',
    'Topic'             => '专题',
    'Topic not found'   => '专题不存在',
    'Reset'             => '清除',
    'Upload'            => '上传',
    'Remove'            => '剔除',
    'Choose'            => '选择',
    'Choose article'    => '选择文章',
    'Token'             => '表单令牌',
    'Keyword'          => '关键词',
    'All'               => '全部',
    'Close'             => '关闭',
    'OK'                => '确定',
    'Status'            => '状态',
    'Server side error' => '服务器错误',
    'Submitting'        => '正在提交 ...',
    'Saving'            => '正在保存 ...',
    'Complete'          => '完成',
    'All status'        => '所有状态',
    'All types'         => '所有类型',
    'pub'               => '发布',
    'wait'              => '待审',
    'hide'              => '隐藏',
    'normal'            => '正常',
    'draft'             => '草稿',
    'recycle'           => '回收站',
    'Sticky'            => '置顶',
    'Scheduled publish' => '定时发布',
    'Scheduled offline' => '定时下线',
    'Action'            => '操作', //生效
    'enable'            => '启用', //生效
    'disabled'          => '禁用', //禁用
    'Article'           => '文章',
    'Articles in topic' => '专题内文章',
    'Pending articles'  => '待选文章',
    'Successfully processed {:count} datas' => '成功处理 {:count} 条数据',
    'Did not make any changes'              => '未做任何修改',
    'Delete'                                => '删除',
    'Successfully remove {:count} datas'    => '成功剔除 {:count} 条数据',
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
