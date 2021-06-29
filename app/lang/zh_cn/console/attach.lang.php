<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------------------通用-------------------------*/
return array(
    'Access denied'         => '拒绝访问',
    'Add'                   => '添加', //添加
    'Back'                  => '返回',
    'Edit'                  => '编辑', //编辑
    'Show'                  => '查看',
    'OK'                    => '确定',
    'Reset'                 => '清除',
    'Cancel'                => '取消',
    'Confirm'               => '确定',
    'Time'                  => '时间',
    'Size'                  => '大小',
    'Browse'                => '选择文件',
    'Upload'                => '上传',
    'Uploading'             => '正在上传',
    'Insert'                => '插入',
    'Insert original image' => '插入原图',
    'View original image'   => '查看原图',
    'Input error'           => '输入错误，请检查！',
    'Administrator'         => '管理员',
    'Choose image'          => '选择图片',
    'Advanced mode'         => '高级上传模式',
    'exists'                => '存在',
    'notfound'              => '不存在',
    'enable'                => '启用', //生效
    'disabled'              => '禁用', //禁用
    'Path'                  => '路径',
    'Attachment'            => '附件',
    'Thumbnail'             => '缩略图',
    'Detail'                => '详情',
    'None'                  => '无',
    'Unknown'               => '未知',
    'Images in album'       => '相册内图片',
    'ratio'                 => '比例',
    'cut'                   => '裁切',
    'Waiting'               => '等待',
    'Missing ID'            => '无法获取 ID',
    'Attachment not found'  => '附件不存在',
    'File not found'        => '文件不存在',
    'Album not found'       => '相册不存在',
    'Thumbnail not found'   => '缩略图不存在',
    'Original name'         => '原始名称',
    'Status'                => '状态',
    'normal'                => '正常',
    'recycle'               => '回收站',
    'reserve'               => '保留数据',
    'Extension'             => '扩展名',
    'Year'                  => '年度',
    'Month'                 => '月份',
    'All extensions'        => '所有扩展名',
    'All years'             => '所有年度',
    'All months'            => '所有月份',
    'Token'                 => '表单令牌',
    'Keyword'               => '关键词',
    'All'                   => '全部',
    'Restore'               => '恢复',
    'Recycle'               => '回收站',
    'Reserve data'          => '保留数据',
    'Fix it'                => '修复',
    'Move to recycle'       => '移到回收站',
    'Clean up attachments'  => '清理附件',
    'Close'                 => '关闭',
    'OK'                    => '确定',
    'Save'                  => '保存',
    'Server side error'     => '服务器错误',
    'Member of group'       => '隶属于群组',
    'Submitting'            => '正在提交 ...',
    'Saving'                => '正在保存 ...',
    'Complete'              => '完成',
    'Nickname'              => '昵称',
    'Note'                  => '备注',
    'Action'                => '操作', //生效
    'Please select'         => '请选择',
    'Select'                => '选择',
    'Empty'                 => '清空',
    'Add on album'          => '加入相册',

    'Album'                 => '相册',
    'Attachments in this article'                       => '本文附件',
    'Use when the image cannot be displayed'            => '图片无法显示时使用',
    'Upload attachment successfully'                    => '上传附件成功',
    'Add attachment successfully'                       => '添加附件成功',
    'Add attachment failed'                             => '添加附件失败',
    'Attachment fixed successful'                       => '修复附件成功',
    'Successfully updated {:count} attachments'         => '成功更新 {:count} 个附件',
    'Update attachment successfully'                    => '更新附件成功',
    'Did not make any changes'                          => '未做任何修改',
    'Delete'                                            => '删除',
    'Successfully deleted {:count} attachments'         => '成功删除 {:count} 个附件',
    'No attachment have been deleted'                   => '未删除任何附件',
    'Apply'                                             => '提交',
    'Bulk actions'                                      => '批量操作',
    'Form token is incorrect'                           => '表单令牌错误',
    'Choose at least one item'                          => '至少选择一项',
    'Choose at least one {:attr}'                       => '至少选择一项 {:attr}',
    'Are you sure to delete?'                           => '确认删除吗？此操作不可恢复',
    'Are you sure move to recycle?'                     => '确认放入回收站吗？',
    'You do not have permission'                        => '您没有权限',
    'File size exceeds {:size}'                         => '文件大小超过了 {:size}',
    'File count exceeds {:count}'                       => '文件数量超过了 {:count}',
    'Type denied'                                       => '不允许上传的类型',

    'MIME has not been set'                             => '尚未设置 MIME',
    'MIME check failed'                                 => 'MIME 校验失败',
    'No files uploaded'                                 => '没有上传任何文件',
    'MIME not allowed'                                  => '不允许的 MIME',
    'Upload file size exceeds the settings'             => '文件尺寸超过设置',
    'Failed to create directory'                        => '添加目录失败',
    'Failed to move uploaded file'                      => '移动上传文件失败',

    'Upload file size exceeds the php.ini settings'     => '文件尺寸超过 php.ini 的设置',
    'Upload file size exceeds the form settings'        => '文件尺寸超过表单的设置',
    'Only the portion of file is uploaded'              => '只有部分文件被上传',
    'Upload temp dir not found'                         => '上传临时目录不存在',
    'File write error'                                  => '文件写入失败',
    'Unknown upload error'                              => '未知的上传错误',
    'Failed to generate thumbnail'                      => '生成缩略图失败',

    'FTP Error: Cannot conect to {:ftp_host}'           => 'FTP 错误：无法连接至 {:ftp_host}',
    'FTP Error: Cannot login to  {:ftp_host}'           => 'FTP 错误：无法登录至 {:ftp_host}',
    'FTP Error: Turn on passive mode failed'            => 'FTP 错误：无法开启被动模式',
    'FTP Error: Failed to create remote directory'      => 'FTP 错误：无法创建远程目录',
    'FTP Error: Local file not found'                   => 'FTP 错误：本地文件不存在',
    'FTP Error: Upload to remote directory failed'      => 'FTP 错误：上传至远程目录失败',
    'Upload thumbnail to remote directory failed'       => '上传缩略图至远程目录失败',

    '{:attr} require'                                   => '{:attr} 是必需的',
    'Size of {:attr} must be {:rule}'                   => '{:attr} 的长度必须在 {:rule} 之间',
    '{:attr} must be alpha-numeric, dash, underscore'   => '{:attr} 必须为字母、数字、连接符和下划线',
    'Max size of {:attr} must be {:rule}'               => '{:attr} 最长 {:rule}',
    '{:attr} must be integer'                           => '{:attr} 必须为整数',
    'Warning! This operation is not recoverable!'       => '警告！此操作不可恢复！',
    'Warning! This operation will take a long time!'    => '警告！此操作将耗费较长时间！',

    'If the path or thumbnail is not found, you can try to fix it.' => '如果路径或者缩略图不存在，您可以尝试修复。',
    'Uploading requires HTML5 support, please upgrade your browser' => '上传需要 HTML5 支持，请升级您的浏览器',
);
