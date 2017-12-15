<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*----------后台管理模块----------*/
return array(
    'article' => array(
        'main' => array(
            'title'  => 'Article',
            'mod'    => 'article',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Article List',
                'mod'   => 'article',
                'act'   => 'list',
            ),
            'form' => array(
                'title' => 'Write',
                'mod'   => 'article',
                'act'   => 'form',
            ),
            'tag' => array(
                'title' => 'TAG',
                'mod'   => 'tag',
                'act'   => 'list',
            ),
            'mark' =>  array(
                'title' => 'Mark',
                'mod'   => 'mark',
                'act'   => 'list',
            ),
            'custom' =>  array(
                'title' => 'Custom Fields',
                'mod'   => 'custom',
                'act'   => 'list',
            ),
            'source' =>  array(
                'title' => 'Article Source',
                'mod'   => 'source',
                'act'   => 'list',
            ),
        ),
        'allow' => array(
            'browse'     => 'Browse',
            'add'        => 'Create',
            'edit'       => 'Edit',
            'del'        => 'Delete',
            'approve'    => 'Approve',
            'tag'        => 'TAG',
            'mark'       => 'Mark',
            'custom'     => 'Custom Fields',
            'source'     => 'Article Source',
        ),
    ),
    'spec' => array(
        'main' => array(
            'title' => 'Special Topic',
            'mod'   => 'spec',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Topic List',
                'mod'   => 'spec',
                'act'   => 'list',
            ),
            'form' => array(
                'title' => 'Create',
                'mod'   => 'spec',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Create',
            'edit'   => 'Edit',
            'del'    => 'Delete',
        ),
    ),
    'gather' => array(
        'main' => array(
            'title' => 'Gathering',
            'mod'   => 'gather',
        ),
        'sub' => array(
            'gather' => array(
                'title' => 'Gathering Data',
                'mod'   => 'gather',
                'act'   => 'gather',
            ),
            'approve' => array(
                'title' => 'Approve',
                'mod'   => 'gather',
                'act'   => 'list',
            ),
            'gsite' => array(
                'title' => 'Gathering Site',
                'mod'   => 'gsite',
                'act'   => 'list',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'gather'    => 'Gathering Data',
            'approve'   => 'Approve',
            'gsite'     => 'Gathering Site',
        ),
    ),
    'attach' => array(
        'main' => array(
            'title'  => 'Attachment',
            'mod'    => 'attach',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Attachment List',
                'mod'   => 'attach',
                'act'   => 'list',
            ),
            'mime' => array(
                'title' => 'MINE',
                'mod'   => 'mime',
                'act'   => 'list',
            ),
            'thumb' => array(
                'title' => 'Thumbnails',
                'mod'   => 'thumb',
                'act'   => 'list',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'del'    => 'Delete',
            'upload' => 'Upload',
            'mime'   => 'MIME',
            'thumb'  => 'Thumbnails',
        ),
    ),
    'cate' => array(
        'main' => array(
            'title'  => 'Category',
            'mod'    => 'cate',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Category List',
                'mod'   => 'cate',
                'act'   => 'list',
            ),
            'form' => array(
                'title' => 'Create',
                'mod'   => 'cate',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Create',
            'edit'   => 'Edit',
            'del'    => 'Delete',
        ),
    ),
    'call' => array(
        'main' => array(
            'title'  => 'Call',
            'mod'    => 'call',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Call List',
                'mod'   => 'call',
                'act'   => 'list',
            ),
            'form' => array(
                'title' => 'Create',
                'mod'   => 'call',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Create',
            'edit'   => 'Edit',
            'del'    => 'Delete',
        ),
    ),
    'admin' => array(
        'main' => array(
            'title'  => 'Administrator',
            'mod'    => 'admin',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Administrator List',
                'mod'   => 'admin',
                'act'   => 'list',
            ),
            'form' => array(
                'title' => 'Create',
                'mod'   => 'admin',
                'act'   => 'form',
            ),
            'auth' => array(
                'title' => 'Authorization',
                'mod'   => 'admin',
                'act'   => 'auth',
            ),
        ),
        'allow' => array(
            'browse'     => 'Browse',
            'add'        => 'Create',
            'edit'       => 'Edit',
            'del'        => 'Delete',
            'toGroup'    => 'Join Group',
        ),
    ),
    'group' => array(
        'main' => array(
            'title'  => 'Group',
            'mod'    => 'group',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Group List',
                'mod'   => 'group',
                'act'   => 'list',
            ),
            'form' => array(
                'title' => 'Create',
                'mod'   => 'group',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Create',
            'edit'   => 'Edit',
            'del'    => 'Delete',
        ),
    ),
    'link' => array(
        'main' => array(
            'title'  => 'Link',
            'mod'    => 'link',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Link Management',
                'mod'   => 'link',
                'act'   => 'list',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Create',
            'edit'   => 'Edit',
            'del'    => 'Delete',
        ),
    ),
);
