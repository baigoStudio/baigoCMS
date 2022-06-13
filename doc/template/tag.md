## TAG

用于显示所有与此 TAG 关联的文章

位置：./tag/index.tpl.php

| 变量名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| $tagRow | array | 当前 TAG 详细信息 | 详情请查看 [$tagRow](#tagRow) |
| $articleRows | array | 验证信息信息 | 详情请查看 [文章](article.md) |
| $pageRow | array | 分页参数 | 详情请查看 [分页](pagination.md) |
| $urlRow | array | 栏目 URL | |

----------

<span id="tagRow"></a>

##### $tagRow 结构

| 名称 | 类型 | 描述 |
| - | - | - |
| tag_id | int | ID |
| tag_name | string | 名称 |
| tag_article_count | int | 与当前 TAG 关联的文章数 |
| tag_status | string | 状态  pub 为发布，hide 为隐藏 |
| rcode | string | 返回码 |

数据示例

``` php
array(
  'tag_id'            => 62,
  'tag_name'          => 'TAG',
  'tag_article_count' => 5,
  'tag_status'        => 'pub',
  'rcode'             => 'y120102'
);
```
