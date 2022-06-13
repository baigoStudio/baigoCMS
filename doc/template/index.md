## 模板概述

baigo CMS 使用 PHP 作为模板。

前台模板位于 ./app/tpl/index 目录下，一套模板单独一个目录，如默认模板 ./app/tpl/index/default，以下文档全部以此为基础。注：模板目录必须使用 英文 与 数字，不能使用中文、符号等。

模板目录结构说明

```
+-- default
|   +-- index
|   |   +-- index.tpl.php         首页
|   |
|   +-- cate
|   |   +-- index.tpl.php         显示栏目
|   |
|   +-- article
|   |   +-- index.tpl.php         显示文章
|   |
|   +-- tag
|   |   +-- index.tpl.php         显示 TAG
|   |
|   +-- search
|   |   +-- index.tpl.php         显示搜索结果
|   |
|   +-- spec
|   |   +-- index.tpl.php         专题列表
|   |   +-- show.tpl.php          显示专题
|   |
|   +-- common                    通用
|   |   +-- error.tpl.php         出错信息
|   |
|   +-- include                   include
|      +-- html_head.tpl.php      HTML 头部
|      +-- html_foot.tpl.php      HTML 底部
|      +-- index_head.tpl.php     头部
|      +-- index_foot.tpl.php     底部
|
+--  ...
```

----------

##### 单独指定模板

`3.0-beta-2` 起，支持为单个 TAG、单个专题、单个相册、单篇文章指定模板。

这些模板都位于 ./app/tpl/single 目录下，模板目录结构说明：

```
+-- tag                           TAG 模板
|   +-- default.tpl.php           默认
|   +-- ...
+-- spec                          专题模板
|   +-- default.tpl.php           默认
|   +-- ...
+-- album                         相册模板
|   +-- default.tpl.php           默认
|   +-- ...
+-- article                       文章模板
|   +-- default.tpl.php           默认
|   +-- ...
|
+--  ...
```

> 注意：每个目录下只能建立文件，无法建立文件夹，系统会忽略文件夹

----------

##### 变量输出

在模板中主要以输出变量的方式来显示内容，比如：

``` php
Hello, <?php echo $name; ?>！
```

运行的时候会显示： Hello, baigo！

输出根据变量类型有所区别，刚才输出的是字符串，下面是一个数组的例子：

``` php
Name：<?php echo $data['name']; ?>
Email：<?php echo $data['email']; ?>
```

> 具体变量和类型请查看具体文档

----------

##### 输出替换

在模板中以 `{:变量名}` 形式的字符将会被替换。

以下为默认的输出替换

| 名称 | 描述 |
| - | - | - | - |
| {\:URL_BASE} | 当前 URL 地址，不含 QUERY_STRING，包含域名。 |
| {\:URL_ROOT} | 当前 URL 根目录，包含域名。 |
| {\:DIR_STATIC} | 静态文件目录 |
| {\:ROUTE_ROOT} | 根路径 |
| {\:ROUTE_PAGE} | 分页用的基本路径 |

----------

##### 常量输出

还可以输出常量

``` php
<?php echo PHP_VERSION; ?>
<?php echo GK_PATH_APP; ?>
```

----------

##### 包含

在任何模板内，均可以用 `include("模板路径")` 的方式来包含并执行文件，您可以在模板目录下，建立一个目录，如 inc，用来统一存放被包含的模板，如：`include("inc/head.tpl.php")`。
