<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

return array(
    'base' => array(
        'title' => '基本设置',
        'list' => array(
            'BG_SITE_NAME' => array(
                'label' => '网站名称',
            ),
            'BG_SITE_DOMAIN' => array(
                'label' => '网站域名',
            ),
            'BG_SITE_URL' => array(
                'label' => '首页 URL',
                'note'  => '末尾请勿加 <kbd>/</kbd>，仅需 http:// 和域名部分，如：http://' . $_SERVER['SERVER_NAME'],
            ),
            'BG_SITE_PERPAGE' => array(
                'label' => '每页显示数',
            ),
            'BG_SITE_ASSOCIATE' => array(
                'label' => '关联文章显示数',
            ),
            'BG_SITE_EXCERPT_TYPE' => array(
                'label'  => '文章摘要默认截取方式',
                'option' => array(
                    'auto'      => '自动',
                    'txt'       => '仅截取文本',
                    'none'      => '不要摘要',
                    'manual'    => '手工编辑',
                ),
            ),
            'BG_SITE_EXCERPT_COUNT' => array(
                'label' => '文章摘要默认截取字数',
            ),
            'BG_SITE_DATE' => array(
                'label' => '日期格式',
            ),
            'BG_SITE_DATESHORT' => array(
                'label' => '短日期格式',
            ),
            'BG_SITE_TIME' => array(
                'label' => '时间格式',
            ),
            'BG_SITE_TIMESHORT' => array(
                'label' => '短时间格式',
            ),
        ),
    ),
    'upload' => array(
        'title' => '上传设置',
        'list' => array(
            'BG_UPLOAD_SIZE' => array(
                'label' => '允许上传大小',
                'note'  => '单位请查看下一项',
            ),
            'BG_UPLOAD_UNIT' => array(
                'label' => '允许上传单位',
            ),
            'BG_UPLOAD_COUNT' => array(
                'label' => '允许同时上传数',
            ),
            'BG_UPLOAD_URL' => array(
                'label' => 'URL 前缀 ',
                'note'  => '末尾请勿加 <kbd>/</kbd>',
            ),
            'BG_UPLOAD_FTPHOST' => array(
                'label' => '分发 FTP 地址',
            ),
            'BG_UPLOAD_FTPPORT' => array(
                'label' => 'FTP 端口',
            ),
            'BG_UPLOAD_FTPUSER' => array(
                'label' => 'FTP 用户名',
            ),
            'BG_UPLOAD_FTPPASS' => array(
                'label' => 'FTP 密码',
            ),
            'BG_UPLOAD_FTPPATH' => array(
                'label' => 'FTP 远程路径',
                'note'  => '末尾请勿加 <kbd>/</kbd>',
            ),
            'BG_UPLOAD_FTPPASV' => array(
                'label' => 'FTP 被动模式',
                'option' => array(
                    'on' => array(
                        'value' => '开启'
                    ),
                    'off' => array(
                        'value' => '关闭'
                    ),
                ),
            ),
        ),
    ),
    'visit' => array(
        'title' => '访问方式',
        'list' => array(
            'BG_VISIT_TYPE' => array(
                'label' => '访问方式',
                'option' => array(
                    'default' => array(
                        'value' => '默认',
                        'note'  => '例：' . BG_SITE_URL . '/index.php?m=article&a=show&article_id=123',
                    ),
                    'pstatic' => array(
                        'value' => '伪静态',
                        'note'  => '例：' . BG_SITE_URL . '/article/123（需服务器支持）',
                    ),
                    'static' => array(
                        'value' => '纯静态',
                        'note'  => '例：' . BG_SITE_URL . '/article/' . date('Y') . '/' . date('m') . '/123.html',
                    ),
                ),
            ),
            'BG_VISIT_FILE' => array(
                'label' => '静态页面类型',
            ),
            'BG_VISIT_PAGE' => array(
                'label' => '静态页数',
                'note'  => '生成静态页面的页数，超过部分通过动态页面显示。',
            ),
        ),
    ),
    'spec' => array(
        'title' => '专题分发设置',
        'list' => array(
            'BG_SPEC_URL' => array(
                'label' => 'URL 前缀 ',
                'note'  => '末尾请勿加 <kbd>/</kbd>',
            ),
            'BG_SPEC_FTPHOST' => array(
                'label' => '分发 FTP 地址',
            ),
            'BG_SPEC_FTPPORT' => array(
                'label' => 'FTP 端口',
            ),
            'BG_SPEC_FTPUSER' => array(
                'label' => 'FTP 用户名',
            ),
            'BG_SPEC_FTPPASS' => array(
                'label' => 'FTP 密码',
            ),
            'BG_SPEC_FTPPATH' => array(
                'label' => 'FTP 远程路径',
                'note'  => '末尾请勿加 <kbd>/</kbd>',
            ),
            'BG_SPEC_FTPPASV' => array(
                'label' => 'FTP 被动模式',
                'option' => array(
                    'on' => array(
                        'value' => '开启'
                    ),
                    'off' => array(
                        'value' => '关闭'
                    ),
                ),
            ),
        ),
    ),
    'sso' => array(
        'title' => 'SSO 设置',
        'list' => array(
            'BG_SSO_URL' => array(
                'label' => 'API 接口 URL',
                'note'  => '必须以 http:// 开始',
            ),
            'BG_SSO_APPID' => array(
                'label' => 'APP ID',
            ),
            'BG_SSO_APPKEY' => array(
                'label' => 'APP KEY 通信密钥',
            ),
            'BG_SSO_APPSECRET' => array(
                'label' => 'APP SECRET 密文密钥',
            ),
            'BG_SSO_SYNC' => array(
                'label' => '同步登录',
                'option' => array(
                    'on' => array(
                        'value' => '开启'
                    ),
                    'off' => array(
                        'value' => '关闭'
                    ),
                ),
            ),
        ),
    ),
);

