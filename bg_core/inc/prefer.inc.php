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
    'editor' => array(
        'title' => 'WYSIWYG Editor',
        'list'  => array(
            'resize' => array(
                'label'      => 'Resize',
                'type'       => 'radio',
                'min'        => 1,
                'default'    => 'on',
                'option' => array(
                    'on'    => array(
                        'value'    => 'ON'
                    ),
                    'off'   => array(
                        'value'    => 'OFF'
                    ),
                ),
            ),
            'autosize' => array(
                'label'      => 'Auto Resize',
                'type'       => 'radio',
                'min'        => 1,
                'default'    => 'on',
                'option' => array(
                    'on'    => array(
                        'value'    => 'ON'
                    ),
                    'off'   => array(
                        'value'    => 'OFF'
                    ),
                ),
            ),
        ),
    ),
    'excerpt' => array(
        'title' => 'Article Excerpt',
        'list'  => array(
            'type' => array(
                'label'      => 'Default Mode',
                'type'       => 'select',
                'min'        => 1,
                'default'    => 100,
                'option'     => array(),
            ),
            'count' => array(
                'label'      => 'Excerpt Count',
                'type'       => 'str',
                'format'     => 'int',
                'min'        => 1,
                'default'    => 100,
            ),
        ),
    ),
    'sync' => array(
        'title' => 'Login Sync',
        'list'  => array(
            'sync' => array(
                'label'      => 'Login Sync',
                'type'       => 'radio',
                'min'        => 1,
                'default'    => 'off',
                'option' => array(
                    'on'    => array(
                        'value'    => 'ON'
                    ),
                    'off'   => array(
                        'value'    => 'OFF'
                    ),
                ),
            ),
        ),
    ),
);

