## 通用

----------

##### 通用变量

以下变量为所有模板中都可输出

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| $path_tpl | string | 当前模板所在的目录 | |
| $dir_root | string | 根目录 | |
| $dir_static | string | 静态文件目录 | |
| $route_root | string | 根路径 | |
| $route_index | string | 前台模块路径 | |
| $url_search | string | 搜索模块 URL | |
| $cate_tree | array | 栏目树 | 详情请查看 [$cate_tree](#cate_tree) |
| $custom_tree | array | 自定义字段树 | 详情请查看 [$custom_tree](#custom_tree) |
| $customRows | array | 自定义字段列表 | 详情请查看 [$custom_tree](#customRows) |
| $call | object | 调用对象 | 详情请查看 [调用](call.md) |
| $lang | object | 语言对象 | 详情请查看 [$lang](#lang) |
| $request | object | 请求对象 | 详情请查看 [$request](#request) |
| $config | array | 配置数组 | 详情请查看 [$config](#config) |

----------

<span id='lang'></span>

##### 语言变量

语言变量的输出使用 `Lang` 对象，模板中已内置，可以直接使用 `$lang`，例如：

``` php
<?php echo $lang->get('page_error'); ?>
<?php echo $lang->get('var_error'; ?>
```

----------

<span id='request'></span>

##### 系统变量

系统变量的输出使用 `Request` 对象，模板中已内置，可以直接使用 `$request`，例如：

``` php
<?php echo $request->server('script_name'); ?> // 输出 $_SERVER['SCRIPT_NAME'] 变量
<?php echo $request->session('article_id'); ?> // 输出 $_SESSION['article_id'] 变量
<?php echo $request->get('page'); ?> // 输出 $_GET['page'] 变量
<?php echo $request->cookie('name'); ?>  // 输出 $_COOKIE['name'] 变量
```

支持输出 `$_SERVER`、`$_POST`、`$_GET`、`$_REQUEST`、`$_SESSION` 和 `$_COOKIE` 变量，详情请查看 ginkgo 文档的 [请求 -> 输入变量](//doc.baigo.net/ginkgo/quick/request/input)

----------

<span id='config'></span>

##### 配置输出

输出配置参数使用：

``` php
<?php echo $config['route']['default_mod']; ?>
<?php echo $config['route']['default_ctrl']; ?>
```

----------

<span id='cate_tree'></span>

##### 栏目树示例

``` php
array(
    1 => array(
        'cate_id'           => 1, // ID
        'cate_name'         => 'baigo', // 名称
        'cate_alias'        => 'baigo',
        'cate_content'      => 'nickname',
        'cate_status'       => 'wait',
        'cate_link'         => '',
        'cate_parent_id'    => 0,
        'cate_level'        => 1, // 栏目层级
        'cate_childs'       => array( // 子栏目
            31 => array(
                'cate_id'           => 31,
                'cate_name'         => 'gh',
                'cate_link'         => '',
                'cate_alias'        => '',
                'cate_status'       => 'show',
                'cate_parent_id'    => 1,
                'cate_prefix'       => '',
                'cate_perpage'      => 50,
                'cate_level'        => 2,
                'cate_childs'       => array(),
            ),
            27 => array(
                'cate_id'           => 27,
                'cate_name'         => 'gh',
                'cate_link'         => '',
                'cate_alias'        => 'hhhhhhhh',
                'cate_status'       => 'show',
                'cate_parent_id'    => 1,
                'cate_prefix'       => '',
                'cate_perpage'      => 50,
                'cate_level'        => 2,
                'cate_childs'       => array(
                    26 => array(
                        'cate_id'           => 26,
                        'cate_name'         => 'gh',
                        'cate_link'         => '',
                        'cate_alias'        => 'hhhhhhhh',
                        'cate_status'       => 'show',
                        'cate_parent_id'    => 27,
                        'cate_prefix'       => '',
                        'cate_perpage'      => 50',
                        'cate_level'        => 3,
                        'cate_childs'       => array()
                    )
                )
            )
        )
    ),
    2 => array(
        'cate_id'           => 2, // ID
        'cate_name'         => 'baigo', // 名称
        'cate_alias'        => 'baigo',
        'cate_content'      => 'nickname',
        'cate_status'       => 'wait',
        'cate_link'         => '',
        'cate_parent_id'    => 0,
        'cate_level'        => 1, // 栏目层级
        'cate_childs'       => array( // 子栏目
            30 => array(
                'cate_id'           => 30,
                'cate_name'         => 'gh',
                'cate_link'         => '',
                'cate_alias'        => '',
                'cate_status'       => 'show',
                'cate_parent_id'    => 1,
                'cate_prefix'       => '',
                'cate_perpage'      => 50,
                'cate_level'        => 2,
                'cate_childs'       => array(),
            )
        )
    )
)
```

----------

<span id='custom_tree'></span>

##### 自定义字段树示例

``` php
array(
    array(
        'custom_id' => '4', //字段 ID
        'custom_name' => '尺寸', //名称
        'custom_parent_id' => '0', //隶属字段 ID
        'custom_cate_id' => '0', //隶属栏目 ID
        'custom_childs' => array( //子字段
            array(
                'custom_id' => '5',
                'custom_name' => '长',
                'custom_parent_id' => '4',
                'custom_cate_id' => '2'
            )
        )
    )
)

```