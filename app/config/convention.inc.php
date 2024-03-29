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
  ),
);
