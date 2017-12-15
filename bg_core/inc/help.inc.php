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
    'nav' => array(
        'intro' => array(
            'title' => 'Introduction',
        ),
        'install' => array(
            'title' => 'Setup / Upgrade',
            'sub'   => array(
                'setup'     => 'Setup',
                'upgrade'   => 'Upgrade',
                'manual'    => 'Manual Setup / Upgrade',
                'deploy'    => 'Advanced deployment',
            ),
        ),
        'console' => array(
            'title' => 'The Console',
        ),
        'doc' => array(
            'title' => 'Documentation',
            'sub'   => array(
                'tpl'   => 'Template Documentation',
                'api'   => 'API Documentation',
            ),
        ),
    ),

    'mod' => array(
        'intro' => array(
            'active'    => 'intro',
            'menu'      => array(
                'outline'   => 'Introduction',
                'faq'       => 'FAQ',
            ),
        ),
        'setup' => array(
            'active'    => 'install',
            'menu'      => array(
                'outline'   => 'Setup Outline',
                'phplib'    => 'PHP Extension Check',
                'dbconfig'  => 'Database Settings',
                'dbtable'   => 'Create Database',
                'base'      => 'Base Settings',
                'visit'     => 'Visiting Settings',
                'spec'      => 'Special Topic Distribution Settings',
                'upload'    => 'Uploading Settings',
                'sso'       => 'SSO Settings',
                'admin'     => 'Create Administrator',
                'over'      => 'Complete Setup',
            ),
        ),
        'upgrade' => array(
            'active'    => 'install',
            'menu'      => array(
                'outline'   => 'Upgrade Outline',
                'phplib'    => 'PHP Extension Check',
                'dbconfig'  => 'Database Settings',
                'dbtable'   => 'Upgrade Database',
                'base'      => 'Base Settings',
                'visit'     => 'Visiting Settings',
                'spec'      => 'Special Topic Distribution Settings',
                'upload'    => 'Uploading Settings',
                'sso'       => 'SSO Settings',
                'admin'     => 'Create Administrator',
                'over'      => 'Complete Upgrade',
            ),
        ),
        'manual' => array(
            'active'    => 'install',
            'menu'      => array(
                'outline'   => 'Manual Outline',
                'dbconfig'  => 'Database Settings',
                'base'      => 'Base Settings',
                'visit'     => 'Visiting Settings',
                'spec'      => 'Special Topic Distribution Settings',
                'upload'    => 'Uploading Settings',
                'sso'       => 'SSO Settings',
            ),
        ),
        'deploy' => array(
            'active'    => 'install',
            'menu'      => array(
                'outline'   => 'Advanced Deployment',
            ),
        ),
        'console' => array(
            'active'    => 'console',
            'menu'      => array(
                'outline'   => 'The Console Outline',
                'common'    => 'Common Resources',
                'article'   => 'Article Management',
                'tag'       => 'TAG / Mark',
                'source'    => 'Article Source',
                'spec'      => 'Special Topic',
                'cate'      => 'Category Management',
                'attach'    => 'Attachment Management',
                'call'      => 'Call Management',
                'admin'     => 'Administrator',
                'group'     => 'Group Management',
                'link'      => 'Link',
                'opt'       => 'Settings',
                'custom'    => 'Custom Fields',
                'app'       => 'API Settings',
            ),
        ),
        'tpl' => array(
            'active'    => 'doc',
            'menu'      => array(
                'outline'       => 'Template Outline',
                'common'        => 'Common Resources',
                'index_error'   => 'Homepage / Alert Message',
                'page'          => 'Paging Parameters',
                'cate'          => 'Category',
                'article'       => 'Article',
                'tag'           => 'TAG',
                'spec'          => 'Special Topic',
                'attach'        => 'Attachments / Thumbnails',
                'call'          => 'Call',
                'search'        => 'Search',
            ),
        ),
        'api' => array(
            'active'    => 'doc',
            'menu'      => array(
                'outline'   => 'API Outline',
                'page'      => 'Paging Parameters',
                'cate'      => 'Category',
                'article'   => 'Article',
                'custom'    => 'Custom Fields',
                'tag'       => 'TAG',
                'mark'      => 'Mark',
                'spec'      => 'Special Topic',
                'call'      => 'Call',
                'attach'    => 'Attachments / Thumbnails',
                'rcode'     => 'Return Code',
            ),
        ),
    ),
);
