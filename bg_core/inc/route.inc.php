<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

return array(
    'pub' => array(
        'ui' => array(
            'index',
            'cate',
            'article',
            'search',
            'tag',
            'spec',
        ),
    ),
    'console' => array(
        'ui' => array(
            'article',
            'article_gen',
            'tag',
            'mark',
            'source',
            'spec',
            'spec_gen',
            'cate',
            'cate_gen',
            'gsite',
            'gsite_source',
            'gsite_preview',
            'gather',
            'attach',
            'mime',
            'thumb',
            'call',
            'call_gen',
            'user',
            'admin',
            'group',
            'opt',
            'app',
            'custom',
            'link',
            'profile',
            'pm',
            'login',
            'forgot',
            'captcha'
        ),
        'request' => array(
            'article',
            'article_gen',
            'tag',
            'mark',
            'source',
            'spec',
            'spec_gen',
            'cate',
            'cate_gen',
            'gsite',
            'gather',
            'attach',
            'mime',
            'thumb',
            'call',
            'call_gen',
            'user',
            'admin',
            'group',
            'opt',
            'app',
            'custom',
            'link',
            'profile',
            'pm',
            'login',
            'forgot',
            'captcha',
            'token',
        ),
    ),
    'api' => array(
        'api' => array(
            'article',
            'tag',
            'mark',
            'spec',
            'cate',
            'attach',
            'call',
            'custom',
        ),
        'sso' => array(
            'notify',
            'sync',
        ),
    ),
    'install' => array(
        'ui' => array(
            'setup',
            'upgrade',
        ),
        'request' => array(
            'setup',
            'upgrade',
        ),
    ),
    'help' => array(
        'ui' => array(
            'help',
        ),
    ),
);
