## 栏目

用于显示所有隶属于此栏目的文章，以及栏目介绍等信息。

位置：./cate/index.tpl.php

| 变量名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| $cateRow | array | 当前栏目详细信息 | 详情请查看 [$cateRow](#cateRow) |
| $articleRows | array | 文章列表 | 隶属于当前栏目的所有文章。详情请查看 [文章](article.md)。 |
| $pageRow | array | 分页参数 | 详情请查看 [分页](pagination.md) |
| $urlRow | array | 栏目 URL | |
 
----------

<span id="cateRow"></a>

##### $cateRow 结构

| 键名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| cate_id | int | 栏目 ID |
| cate_name | string | 栏目名称 | 栏目的名称。
| cate_alias | string | 别名 | 栏目的英文别名。 |
| cate_tpl_do | string | 模板 | 栏目所使用的模板。 |
| cate_content | text | 栏目介绍 | 栏目的具体介绍。 |
| cate_parent_id | int | 隶属栏目 ID | 栏目所属的上一级栏目，0 为“一级栏目”，无隶属关系。 |
| cate_status | string | 栏目状态 | show 为显示，hide 为隐藏。 |
| rcode | string | 返回代码 | 显示当前栏目的状态，详情请查看 返回代码。 |
| cate_breadcrumb | array | 面包屑路径 | 关于面包屑路径请查看 [互动百科](http://www.baike.com/wiki/面包屑路径) |
| cate_url | array | 栏目 URL | |
 
数据示例

``` php
array(
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
);
```
