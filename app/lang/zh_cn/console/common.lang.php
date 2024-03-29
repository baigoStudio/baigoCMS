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
  'Console'                       => '管理后台',
  'Back'                          => '返回',
  'Logout'                        => '退出',
  'Send a message'                => '新消息',
  'out'                           => '已发送',
  'in'                            => '收件箱',
  'OK'                            => '确定',
  'Cancel'                        => '取消',
  'Confirm'                       => '确定',
  'Close'                         => '关闭',
  'Submitting'                    => '正在提交 ...',
  'Complete'                      => '完成',
  'Need to execute the installer' => '需要执行安装程序',
  'Need to execute the upgrader'  => '需要执行升级程序',
  'System already installed'      => '系统已安装',
  'Help'                          => '帮助',
  'Article'                       => '文章',
  'Article management'            => '文章管理',
  'Article list'                  => '所有文章',
  'New article'                   => '写文章',
  'Mark'                          => '标记',
  'Tag'                           => 'TAG 标签',
  'Custom fields'                 => '自定义字段',
  'Article source'                => '文章来源',
  'Browse'                        => '浏览',
  'Add'                           => '添加',
  'Error'                         => '错误',
  'Edit'                          => '编辑',
  'Delete'                        => '删除',
  'Add on group'                  => '加入组',
  'Login successful'              => '登录成功',
  'You have not logged in'        => '您尚未登录',
  'Private message'               => '站内短信',
  'Special topic'                 => '专题',
  'Topic list'                    => '所有专题',
  'Add topic'                     => '添加专题',
  'Gathering'                     => '内容采集',
  'Gather data'                   => '数据采集',
  'Data approve'                  => '采集审核',
  'Approve'                       => '审核',
  'Gathering site'                => '采集点',
  'Attachment'                    => '附件',
  'Attachment list'               => '所有附件',
  'Albums'                        => '相册',
  'Thumbnails'                    => '缩略图',
  'Install'                       => '安装',
  'Uninstall'                     => '卸载',
  'Category'                      => '栏目',
  'Add category'                  => '添加栏目',
  'Category list'                 => '所有栏目',
  'Category infomation'           => '栏目信息',
  'Call'                          => '调用',
  'Call list'                     => '所有调用',
  'Add call'                      => '添加调用',
  'App'                           => '应用',
  'App list'                      => '所有应用',
  'Add App'                       => '添加应用',
  'Administrator'                 => '管理员',
  'Administrator list'            => '所有管理员',
  'Add administrator'             => '添加管理员',
  'Authorization'                 => '授权为管理员',
  'The login timeout, please login again!' => '登录超时，请重新登录！',
  'Group'                         => '群组',
  'Group list'                    => '所有群组',
  'Add group'                     => '添加群组',
  'Link'                          => '链接',
  'Link management'               => '链接管理',
  'Plugin'                        => '插件',
  'Plugin management'             => '插件管理',
  'Option'                        => '选项',
  'System settings'               => '系统设置',
  'Base settings'                 => '基本设置',
  'Visit settings'                => '访问设置',
  'Upload'                        => '上传',
  'Upload settings'               => '上传设置',
  'SSO Settings'                  => 'SSO 设置',
  'Database settings'             => '数据库设置',
  'API Permissions'               => 'API 权限',
  'Check for updates'             => '检查更新',
  'Profile'                       => '个人设置',
  'Profile info'                  => '个人信息',
  'Preferences'                   => '偏好设置',
  'Password'                      => '密码',
  'Security question'             => '密保问题',
  'Mailbox'                       => '邮箱',
  'Shortcut'                      => '快捷方式',
  'Generating'                    => '正在生成',
  'Generate static pages'         => '生成静态页面',
  'Generate all'                  => '全部生成',
  'Generate one by one'           => '逐个生成',
  'Generate enforce'              => '强制生成（耗时）',
  'Generate list'                 => '生成列表',
  'First page'                    => '首页',
  'Previous ten pages'            => '上十页',
  'Previous page'                 => '上页',
  'Next page'                     => '下页',
  'Next ten pages'                => '下十页',
  'End page'                      => '末页',
  'Jan'                           => '一月',
  'Feb'                           => '二月',
  'Mar'                           => '三月',
  'Apr'                           => '四月',
  'May'                           => '五月',
  'Jun'                           => '六月',
  'Jul'                           => '七月',
  'Aug'                           => '八月',
  'Sep'                           => '九月',
  'Oct'                           => '十月',
  'Nov'                           => '十一月',
  'Dec'                           => '十二月',
  'Sun'                           => '日',
  'Mon'                           => '一',
  'Tue'                           => '二',
  'Wed'                           => '三',
  'Thu'                           => '四',
  'Fri'                           => '五',
  'Sat'                           => '六',
  'Insert iframe'                 => '插入 iframe',
  'Fill in iframe link'           => '输入 iframe 地址',
  'Choose a ratio'                => '选择比例',

  'App ID is incorrect'               => 'App ID 错误',
  'App Key'                           => 'App Key 通信密钥',
  'App Key is incorrect'              => 'App Key 通信密钥错误',
  'Size of App Secret must be 16'     => 'App Secret 长度必须为 16 位',
  'Timestamp'                         => '时间戳',
  'Signature'                         => '签名',
  'Signature is incorrect'            => '签名错误',
  'Encrypted code'                    => '加密码',
  'Your IP address is not allowed'    => 'IP 地址不在允许范围内',
  'Your IP address is forbidden'      => 'IP 地址被禁止',
  '{:attr} require'                   => '{:attr} 是必需的',
  '{:attr} must be integer'           => '{:attr} 必须是整数',
  'Timestamp out of range'            => '时间戳超出允许范围',

  'x250401'   => '尚未创建栏目，<a href="{:route_console}cate/form/" target="_top">点击立刻设置</a>',
  'x070405'   => '尚未设置允许上传的文件类型，<a href="{:route_console}mime/form/" target="_top">点击立刻设置</a>',
);
