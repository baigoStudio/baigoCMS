<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

return array(
  'sso_url' => '',
  'index' => array(
    'index'     => array(
      'title' => 'PHP Extensions',
    ),
    'type'      => array(
      'title' => 'Installation type',
    ),
    'dbconfig'  => array(
      'title' => 'Database settings',
    ),
    'data'      => array(
      'title' => 'Create data',
    ),
    'admin'     => array(
      'title' => 'Add administrator',
    ),
    'over'      => array(
      'title' => 'Complete installation',
    ),
  ),
  'upgrade' => array(
    'index'     => array(
      'title' => 'PHP Extensions',
    ),
    'data'      => array(
      'title' => 'Update data',
    ),
    'admin'     => array(
      'title' => 'Add administrator',
    ),
    'over'      => array(
      'title' => 'Complete upgrade',
    ),
  ),
  'data' => array(
    'index' => array(
      'table' => array(
        'title' => 'Create table',
        'lists' => array(
          'Admin',
          'Album',
          'Album_Belong',
          'App',
          'Article',
          'Article_Content',
          'Article_Custom',
          'Attach',
          'Call',
          'Cate',
          'Cate_Belong',
          'Custom',
          'Gather',
          'Group',
          'Gsite',
          'Link',
          'Mark',
          'Mime',
          'Source',
          'Spec',
          'Spec_Belong',
          'Tag',
          'Tag_Belong',
          'Thumb',
        ),
      ),
      'index' => array(
        'title' => 'Create index',
        'lists' => array(
          'Album_Belong',
          'Article',
          'Cate',
          'Cate_Belong',
          'Link',
          'Spec_Belong',
          'Tag',
          'Tag_Belong',
        ),
      ),
      'view' => array(
        'title' => 'Create view',
        'lists' => array(
          'Album_View',
          'Spec_View',
          'Tag_View',
          'Article_Cate_View',
          'Article_Spec_View',
          'Article_Tag_View',
          'Article_Custom_View',
          'Attach_Album_View',
        ),
      ),
    ),
    'upgrade' => array(
      'table' => array(
        'title' => 'Create table',
        'lists' => array(
          'Album',
          'Album_Belong',
          'Article_Content',
          'Article_Custom',
          'App',
          'Custom',
          'Link',
          'Gather',
          'Gsite',
          'Spec',
          'Spec_Belong',
          'Source',
        ),
      ),
      'rename' => array(
        'title' => 'Rename table',
        'lists' => array(
          'Attach',
        ),
      ),
      'alter' => array(
        'title' => 'Update table',
        'lists' => array(
          'Admin',
          'Album',
          'App',
          'Article',
          'Article_Content',
          'Article_Custom',
          'Attach',
          'Call',
          'Cate',
          'Cate_Belong',
          'Custom',
          'Gather',
          'Group',
          'Gsite',
          'Link',
          'Mark',
          'Mime',
          'Source',
          'Spec',
          'Tag',
          'Thumb',
        ),
      ),
      'index' => array(
        'title' => 'Create index',
        'lists' => array(
          'Album_Belong',
          'Article',
          'Cate',
          'Cate_Belong',
          'Link',
          'Spec_Belong',
          'Tag',
          'Tag_Belong',
        ),
      ),
      'view' => array(
        'title' => 'Create view',
        'lists' => array(
          'Album_View',
          'Spec_View',
          'Tag_View',
          'Article_Cate_View',
          'Article_Spec_View',
          'Article_Tag_View',
          'Article_Custom_View',
          'Attach_Album_View',
        ),
      ),
      'copy' => array(
        'title' => 'Copy table',
        'lists' => array(
          'Article',
        ),
      ),
    ),
  ),
);
