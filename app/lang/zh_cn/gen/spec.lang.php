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
    'Access denied'                     => '拒绝访问',
    'Special topic'                     => '专题',
    'Missing ID'                        => '无法获取 ID',
    'Topic not found'                   => '专题不存在',
    'Topic is invalid'                  => '专题无效',
    'Token'                             => '表单令牌',
    'Status'                            => '状态',
    'Server side error'                 => '服务器错误',
    'Form token is incorrect'           => '表单令牌错误',
    'Pagination'                        => '分页',
    'Generate'                          => '生成',
    'Generating'                        => '正在生成',
    'Generate enforce'                  => '强制生成',
    'Complete generation'               => '生成完毕',
    'Generate topic failed'             => '生成专题失败',
    'Generate topic successfully'       => '生成专题成功',
    '{:attr} require'                   => '{:attr} 是必需的',
    '{:attr} must be integer'           => '{:attr} 必须是整数',
    'Template not found'                => '模板不存在',
);
