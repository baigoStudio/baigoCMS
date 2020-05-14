## 文章

用于显示当前文章的详细信息。

位置：./article/index.tpl.php

| 变量名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| $articleRow | array | 文章详细信息 | 详情请查看 [$articleRow](#articleRow) |
| $cateRow | array | 文章所属栏目详细信息 | 详情请查看 [栏目](cate.md) |
| $attachRow | array | 附件详细信息 | 详情请查看 [附件](attach.md) |
| $tagRows | array | TAG 列表 | 详情请查看 [TAG](tag.md) |
| $associateRows | array | 关联文章列表 | 详情请查看 [$articleRow](#articleRow) |

----------

<span id="articleRow"></a>

##### $articleRow 结构

| 键名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| article_id | int | ID | |
| article_title | string | 文章标题 | |
| article_content | text | 文章内容 | |
| article_cate_id | int | 隶属栏目 ID | |
| article_mark_id | int | 隶属标记 ID | |
| article_excerpt | string | 文章摘要 | |
| article_link | string | 跳转至 | |
| article_hits_day | int | 一天点数 | |
| article_hits_week | int | 一周点数 | |
| article_hits_month | int | 一月点数 | |
| article_hits_year | int | 一年点数 | |
| article_hits_all | int | 总点数 | |
| article_is_time_pub | int | 是否定时上线 | 是否定时上线，值为 1 时文章定时上线。 |
| article_is_time_hide | int | 是否定时下线 | 是否定时上线，值为 1 时文章定时下线。 |
| article_time | int | 文章创建时间 | 指文章创建到数据库的时间。 |
| article_time_show | int | 文章显示时间 | 指显示在文章中的时间。 |
| article_time_show_format | array | 文章显示时间 | 日期时间格式 |
| article_time_pub | int | 文章上线时间 | 指文章上线时间。 |
| article_time_pub_format | array | 文章上线时间 | 日期时间格式 |
| article_time_hide | int | 文章下线时间 | 指文章下线时间。 |
| article_time_hide_format | array | 文章下线时间 | 日期时间格式 |
| article_status | string | 文章状态 | pub 为发布，wait 为待审，hide 为隐藏。 |
| article_customs | array | 自定义字段 | 自定义字段的内容。用 article_customs['custom_{\:id}'] 的方式便可获取自定义字段的内容。详情请查看 [概况](overview.md#common)。 |
| article_source | string | 文章来源 | 常用于转载文章时，表明文章的出处，以示对原作者的尊重。 |
| article_source_url | string | 文章来源 URL | 常用于转载文章时，表明文章的出处，以示对原作者的尊重。 |
| article_author | string | 文章作者 | 常用于转载文章时，表明文章的出处，以示对原作者的尊重。 |
| article_url | string | 文章 URL | |
 
数据示例

``` php
array(
    'article_id'            => 62, //文章 ID
    'article_cate_id'       => 2, //隶属栏目 ID
    'article_mark_id'       => 0, //标记 ID
    'article_title'         => '文章标题', //标题
    'article_excerpt'       => '摘要', //摘要
    'article_status'        => 'pub', //状态
    'article_link'          => '', //链接
    'article_hits_day'      => 0, //日点
    'article_hits_week'     => 0, //周点
    'article_hits_month'    => 0, //月点
    'article_hits_year'     => 5, //年点
    'article_hits_all'      => 6, //总点
    'article_time'          => 1438309806 //创建时间
    'article_time_show'     => 1438308780 //显示时间
    'article_time_pub'      => 1438308780 //上线时间
    'article_time_hide'     => 1438308780 //下线时间
    'article_attach_id'     => 2662 //附件 ID
    'article_content'       => '内容', //内容
    'article_customs'       => array( //自定义字段
        'custom_4'  => 0,
        'custom_3'  => 0,
        'custom_5'  => 0,
        'custom_6'  => 0,
        'custom_8'  => 0,
        'custom_9'  => '',
        'custom_11' => '',
        'custom_12' => '',
    )
    'article_url' => '/public/index.php/article/2019/08/62', //URL
    'cateRow' => array(
        'cate_id'           => '1',
        'cate_name'         => '关于 baigo',
        'cate_alias'        => 'about',
        'cate_tpl_do'       => 'default',
        'cate_content'      => 'baigo Studio 是一个公益性的团体',
        'cate_link'         => '',
        'cate_parent_id'    => '0',
        'cate_prefix'       => '',
        'cate_status'       => 'show',
        'cate_perpage'      => '10',
        'rcode'             => 'y250102',
        'cate_breadcrumb'   => array(
            0 => array(
                'cate_id'           => '1',
                'cate_name'         => '关于 baigo',
                'cate_alias'        => 'about',
                'cate_tpl_do'       => 'default',
                'cate_content'      => 'baigo Studio 是一个公益性的团体',
                'cate_link'         => '',
                'cate_parent_id'    => '0',
                'cate_prefix'       => '',
                'cate_status'       => 'show',
                'cate_perpage'      => '10',
                'rcode'             => 'y250102',
                'cate_url'          => array(
                    'url'           => '/public/index.php/cate/about/id/1/',
                    'url_more'      => '',
                    'param'         => 'page/',
                    'param_more'    => 'page/',
                    'suffix'        => '',
                ),
            ),
        ),
        'cate_url'          => array(
            'url'           => '/public/index.php/cate/about/id/1/',
            'url_more'      => '',
            'param'         => 'page/',
            'param_more'    => 'page/',
            'suffix'        => '',
        ),
    ),
    'tagRows' => array( //TAG
    ),
    'attachRow' => array( //附件信息
        'attach_id'             => 2662,
        'attach_name'           => '20080228_765bd81512e1d286d713fnYZzWPWCwbf.jpg',
        'attach_time'           => 1438308616,
        'attach_ext'            => 'jpg',
        'attach_mime'           => 'image/jpeg',
        'attach_size'           => 42996,
        'attach_type'           => 'image',
        'attach_url'            => '/public/attach/2015/07/2662.jpg',
        'thumb_100_100_cut'     => '/public/attach/2015/07/2662_100_100_cut.jpg',
        'thumb_150_2000_ratio'  => '/public/attach/2015/07/2662_150_2000_ratio.jpg',
        'thumb_200_200_ratio'   => '/public/attach/2015/07/2662_200_200_ratio.jpg',
        'thumb_500_500_cut'     => '/public/attach/2015/07/2662_500_500_cut.jpg',
        'rcode'                 => 'y070102',
    ),
    'rcode' => 'y120102',
);
```
