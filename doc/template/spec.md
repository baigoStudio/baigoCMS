## 专题

----------

##### 专题显示

用于显示所有隶属于此专题的文章

位置：./spec/show.tpl.php

| 变量名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| $specRow | array | 当前 TAG 详细信息 | 详情请查看 [$specRow](#specRow) |
| $articleRows | array | 验证信息信息 | 详情请查看 [文章](article.md) |
| $pageRow | array | 分页参数 | 详情请查看 [分页](pagination.md) |
| $urlRow | array | 专题 URL | |

----------

##### 专题列表

用于显示所有专题

位置：./spec/index.tpl.php

| 变量名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| $specRows | array | 验证信息信息 | 详情请查看 [$specRow](#specRow) |
| $pageRow | array | 分页参数 | 详情请查看 [分页](pagination.md) |
| $urlRow | array | 专题 URL | |

----------

<span id="specRow"></a>

##### $specRow 结构

| 名称 | 类型 | 描述 |
| - | - | - |
| spec_id | int | ID |
| spec_name | string | 名称 |
| spec_content | string | 专题内容 |
| spec_status | string | 状态 pub 为发布，hide 为隐藏 |
| rcode | string | 返回码 |

数据示例

``` php
array(
  'spec_id'       => 62,
  'spec_name'     => '专题名称',
  'spec_content'  => '专题内容',
  'spec_status'   => 'pub',
  'rcode'         => 'y120102'
);
```
