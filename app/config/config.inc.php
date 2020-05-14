<?php return array(
    'var_default' => array(
        'site_name' => 'baigo CMS',
    ),
    'module' => array(
        'ftp'       => true,
        'gen'       => true,
        'gather'    => true,
    ),
    'tpl' => array(
        'path'    => 'default',
    ),
    'session' => array(
        'autostart'     => true,
        'name'          => 'baigoCMSssinID',
        'prefix'        => 'baigo.cms',
    ),
    'cookie' => array(
        'prefix'    => 'baigo_cms_', // cookie 名称前缀
    ),
    'cache' => array( //缓存
        'life_time'     => 864000, // cache 生存时间 0 为永久保存
    ),
    'route' => array(
        'route_rule'    => array(
            'search/typeahead'                  => 'index/search/typeahead',
            'search'                            => 'index/search/index',
            'console/opt/base'                  => 'console/opt/form',
            'console/opt/visit'                 => 'console/opt/form',
            'console/opt/sso'                   => 'console/opt/form',
            'console/gsite_step/lists'          => 'console/gsite_step/form',
            'console/gsite_step/content'        => 'console/gsite_step/form',
            'console/gsite_step/page-lists'     => 'console/gsite_step/form',
            'console/gsite_step/page-content'   => 'console/gsite_step/form',
            'console/gsite_source/lists'        => 'console/gsite_source/form',
            'console/gsite_source/page-lists'   => 'console/gsite_source/form',
            array('/^album\/id\/(\d+)(\/page\/(\d+))?.*$/ui', 'index/album/show', array('id', '', 'page')),
            array('article/:year/:month/:id', 'index/article/index'), //动态例子 array(规则, 地址)
            array('/^spec\/\d+\/\d+\/(\d+)(\/page\/(\d+))?.*$/ui', 'index/spec/show', array('id', '', 'page')),
            array('/^tag\/[\x{4e00}-\x{9fa5}a-zA-Z0-9\_\-\s+]+\/id\/(\d+)(\/page\/(\d+))?.*$/ui', 'index/tag/index', array('id', '', 'page')),
            array('/^cate[\/\x{4e00}-\x{9fa5}a-zA-Z0-9\_\-\s+]+\/id\/(\d+)(\/page\/(\d+))?.*$/ui', 'index/cate/index', array('id', '', 'page')), //正则例子 array(规则, 地址, 参数)
            'album'                             => 'index/album/index',
            'spec'                              => 'index/spec/index',
        ),
    ),
    'config_extra' => array(
        'base'  => true,
        'visit' => true,
        'sso'   => true,
    ),
    'var_extra' => array(
        'base' => array( //设置默认值
            'site_name'             => 'baigo CMS',
            'site_date'             => 'Y-m-d',
            'site_date_short'       => 'm-d',
            'site_time'             => 'H:i:s',
            'site_time_short'       => 'H:i',
            'site_timezone'         => 'Asia/Shanghai',
            'site_tpl'              => 'default',
            'site_thumb_default'    => 0,
        ),
        'visit' => array(
            'visit_type'        => 'default',
            'visit_file'        => 'html',
            'visit_pagecount'   => 10,
            'perpage_spec'      => 30,
            'perpage_album'     => 30,
            'perpage_in_spec'   => 30,
            'perpage_in_cate'   => 30,
            'perpage_in_tag'    => 30,
            'perpage_in_search' => 30,
            'perpage_in_ajax'   => 10,
            'perpage_in_api'    => 30,
            'perpage_in_album'  => 30,
            'count_associate'   => 10,
            'count_tag'         => 5,
        ),
        'sso' => array(
            'app_id'        => 1,
            'app_key'       => '',
            'app_secret'    => '',
            'base_url'      => 'http://' . $_SERVER['SERVER_NAME'],
        ),
        'upload' => array(
            'ftp_host' => '',
            'ftp_port' => 21,
            'ftp_user' => '',
            'ftp_pass' => '',
            'ftp_path' => '',
            'ftp_pasv' => 'off',
        ),
    ),
    'ui_ctrl' => array(
        'copyright'             => 'on',
        'update_check'          => 'on',
        'logo_install'          => '',
        'logo_console_login'    => '',
        'logo_console_head'     => '',
        'logo_console_foot'     => '',
    ),
);
