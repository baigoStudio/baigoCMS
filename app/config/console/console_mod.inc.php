<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*----------后台管理模块----------*/
return array(
    'article' => array(
        'main' => array(
            'title'  => 'Article management',
            'ctrl'   => 'article',
            'icon'   => 'newspaper',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Article list',
                'ctrl'  => 'article',
                'act'   => 'index',
            ),
            'form' => array(
                'title' => 'New article',
                'ctrl'  => 'article',
                'act'   => 'form',
            ),
            'tag' => array(
                'title' => 'Tag',
                'ctrl'  => 'tag',
                'act'   => 'index',
            ),
            'mark' => array(
                'title' => 'Mark',
                'ctrl'  => 'mark',
                'act'   => 'index',
            ),
            'custom' =>  array(
                'title' => 'Custom fields',
                'ctrl'  => 'custom',
                'act'   => 'index',
            ),
            'source' =>  array(
                'title' => 'Article source',
                'ctrl'  => 'source',
                'act'   => 'index',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'add'       => 'Add',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
            'tag'       => 'Tag',
            'mark'      => 'Mark',
            'custom'    => 'Custom fields',
            'source'    => 'Article source',
        ),
    ),
    'spec' => array(
        'main' => array(
            'title'  => 'Special topic',
            'ctrl'   => 'spec',
            'icon'   => 'clipboard-list',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Topic list',
                'ctrl'  => 'spec',
                'act'   => 'index',
            ),
            'form' => array(
                'title' => 'Add topic',
                'ctrl'  => 'spec',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'add'       => 'Add',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
        ),
    ),
    'gather' => array(
        'main' => array(
            'title' => 'Gathering',
            'ctrl'  => 'gather',
            'icon'  => 'database',
        ),
        'lists' => array(
            'gather' => array(
                'title' => 'Gather data',
                'ctrl'  => 'grab',
                'act'   => 'index',
            ),
            'approve' => array(
                'title' => 'Approve',
                'ctrl'  => 'gather',
                'act'   => 'index',
            ),
            'gsite' => array(
                'title' => 'Gathering site',
                'ctrl'  => 'gsite',
                'act'   => 'index',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'gather'    => 'Gather data',
            'approve'   => 'Approve',
            'gsite'     => 'Gathering site',
        ),
    ),
    'attach' => array(
        'main' => array(
            'title'  => 'Attachment',
            'ctrl'   => 'attach',
            'icon'   => 'paperclip',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Attachment list',
                'ctrl'  => 'attach',
                'act'   => 'index',
            ),
            'form' => array(
                'title' => 'Upload',
                'ctrl'  => 'attach',
                'act'   => 'form',
            ),
            'album' => array(
                'title' => 'Albums',
                'ctrl'  => 'album',
                'act'   => 'index',
            ),
            'mime' => array(
                'title' => 'MIME',
                'ctrl'  => 'mime',
                'act'   => 'index',
            ),
            'thumb' => array(
                'title' => 'Thumbnails',
                'ctrl'  => 'thumb',
                'act'   => 'index',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'add'       => 'Upload',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
            'mime'      => 'MIME',
            'thumb'     => 'Thumbnails',
            'album'     => 'Albums',
        ),
    ),
    'cate' => array(
        'main' => array(
            'title'  => 'Category',
            'ctrl'   => 'cate',
            'icon'   => 'layer-group',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Category list',
                'ctrl'  => 'cate',
                'act'   => 'index',
            ),
            'form' => array(
                'title' => 'Add category',
                'ctrl'  => 'cate',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'add'       => 'Add',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
            'approve'   => 'Approve',
            'cate'      => 'Category infomation',
        ),
    ),
    'call' => array(
        'main' => array(
            'title'  => 'Call',
            'ctrl'   => 'call',
            'icon'   => 'tasks',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Call list',
                'ctrl'  => 'call',
                'act'   => 'index',
            ),
            'form' => array(
                'title' => 'Add call',
                'ctrl'  => 'call',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Add',
            'edit'   => 'Edit',
            'delete' => 'Delete',
        ),
    ),
    'admin' => array(
        'main' => array(
            'title'  => 'Administrator',
            'ctrl'   => 'admin',
            'icon'   => 'user-lock',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Administrator list',
                'ctrl'  => 'admin',
                'act'   => 'index',
            ),
            'form' => array(
                'title' => 'Add administrator',
                'ctrl'  => 'admin',
                'act'   => 'form',
            ),
            'auth' => array(
                'title' => 'Authorization',
                'ctrl'  => 'auth',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'add'       => 'Add',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
            'addon'     => 'Add on group',
        ),
    ),
    'group' => array(
        'main' => array(
            'title'  => 'Group',
            'ctrl'   => 'group',
            'icon'   => 'users',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Group list',
                'ctrl'  => 'group',
                'act'   => 'index',
            ),
            'form' => array(
                'title' => 'Add group',
                'ctrl'  => 'group',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'add'       => 'Add',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
        ),
    ),
    'link' => array(
        'main' => array(
            'title'  => 'Link',
            'ctrl'   => 'link',
            'icon'   => 'link',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Link management',
                'ctrl'  => 'link',
                'act'   => 'index',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'add'       => 'Add',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
        ),
    ),
    'plugin' => array(
        'main' => array(
            'title' => 'Plugin',
            'ctrl'  => 'plugin',
            'icon'  => 'puzzle-piece',
        ),
        'lists' => array(
            'index' => array(
                'title' => 'Plugin management',
                'ctrl'  => 'plugin',
                'act'   => 'index',
            ),
        ),
        'allow' => array(
            'browse'    => 'Browse',
            'install'   => 'Install',
            'edit'      => 'Edit',
            'option'    => 'Option',
            'uninstall' => 'Uninstall',
        ),
    ),
);
