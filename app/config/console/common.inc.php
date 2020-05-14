<?php return array(
    'var_prefer' => array(
        'editor' => array(
            'default_height'    => 500,
            'resize'            => '',
            'autosize'          => '',
        ),
        'excerpt' => array(
            'type'  => 'auto',
            'count' => 100,
        ),
        'sync' => array(
            'sync' => '',
        ),
    ),
    'opt_extra' => array(
        'app' => array(
            'title' => 'API Permissions',
            'ctrl'   => 'app',
            'act'   => 'index',
        ),
    ),
    'session' => array(
        'expire'    => 20 * GK_MINUTE,
        'remember'  => 30 * GK_DAY,
    ),
    'excerpt'    => array(
        'auto'      => 'Auto (Text only)',
        'none'      => 'None',
        'manual'    => 'Manual',
    ),
    'token_reload' => 1 * GK_MINUTE * 1000, //分 * 秒 * 毫秒
    'count_option' => 3,  //自定义字段默认选项数量
    'count_gather' => 10, //单次入库数
    'count_gen'    => 10, //单次生成数
    'chk_attach'   => array(
        'article',
        'article_content',
        'article_custom',
        'cate',
        'spec',
        'album',
        'album_belong',
    ),
);
