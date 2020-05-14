## 调用

----------

##### 纯静态模式

纯静态模式下，调用将会生成静态文件，然后在需要显示调用的地方，用“服务器端嵌入 Server Side Include（SSI）”的方式来调用，如：`<!--#include file="./call/9.html" -->`。

调用方式可以在 `后台管理 -> 查看调用` 中查询，推荐生成 html 文件。

调用模板位于 `./app/tpl/call` 目录下。模板文件名必须使用 英文 与 数字，不能使用中文、符号等，如：`./app/tpl/call/call_cate.php`。

模板中的变量会根据不同的调用类型有所不同。

* 文章列表、日排行、周排行、月排行、年排行、总排行

    | 变量名 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | articleRows | array | 详情请查看 [文章列表](article.md) |


* 栏目列表

    | 变量名 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | cateRow | array | 详情请查看 [父栏目](cate.md) |
    | cateRows | array | 详情请查看 [栏目列表](cate.md) |

* 专题列表

    | 变量名 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | specRows | array | 详情请查看 [专题列表](spec.md) |

* TAG 列表、TAG 排行

    | 变量名 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | tagRows | array | 详情请查看 [TAG 列表](tag.md) |

* 友情链接

    | 变量名 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | linkRows | array | 详情请查看 [友情链接](#linkRow) |

----------

##### 其他模式

其他模式下，可以用调用对象 `$call` 的 `get` 方法来调用，执行此方法后，会返回一个多维数组，可以通过遍历数组的方式来显示调用结果，返回数组会根据不同的调用类型有所不同，数组结构请查看纯静态模式下的模板。关于调用以及调用 ID 请查看 `管理后台 -> 调用管理`。以下是一个示例：

``` php
$_arr_callRow = $call->get(1);

print_r($_arr_callRow);
```

----------

<span id="callRow"></span>

##### 调用详情

| 键名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| call_id | int | 调用 ID |   |
| call_name | string | 调用变量名 | 调用的名称。 |
| call_type | string | 调用类型 | article 文章列表、hits_day 日排行、hits_week 周排行、hits_month 月排行、hits_year 年排行、hits_all 总排行、spec 专题列表、cate 栏目列表、tag_list TAG 列表、tag_rank TAG 排行 |
| call_cate_ids | array | 栏目 ID |   |
| call_cate_excepts | array | 排除栏目 ID |   |
| call_cate_id | int | 栏目 ID |   |
| call_spec_ids | array | 专题 ID |  | 
| call_mark_ids | array | 标记 ID |   |
| call_file | string | 生成文件类型 |  
| call_amount | array | 显示数量 | top 键为显示数量、except 键为排除数量 |
| call_attach | string | 附件选项 | all 全部、attach 仅显示带附件文章、none 仅显示无附件文章 |
| call_status | string | 调用状态 | enable 为启用，disable 为禁用。 |
| call_tpl | string | 模板 |   |
| rcode | string | 返回代码 | 显示当前调用的状态，详情请查看 返回代码。 |


----------

<span id="linkRow"></span>

##### 友情链接

友情链接只能通过调用来显示，调用后返回的数组结构如下。

| 键名 | 类型 | 描述 |
| - | - | - |
| link_id | int | 链接 ID |
| link_name | string | 链接名称 |
| link_url | string | 链接地址 |
| link_blank | bool | 是否打开新窗口 |
