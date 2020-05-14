## 调用接口

----------

### 读取调用

本接口用于读取指定的调用

##### URL

http://server/index.php/api/call/read

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| call_id | int | true | ID |

##### 返回结果

返回结果会根据不同的调用类型有所不同

* 文章列表、日排行、周排行、月排行、年排行、总排行

    | 名称 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | articleRows | array | 详情请查看 [文章列表](article.md) |


* 栏目列表

    | 名称 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | cateRow | array | 详情请查看 [父栏目](cate.md) |
    | cateRows | array | 详情请查看 [栏目列表](cate.md) |

* 专题列表

    | 名称 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | specRows | array | 详情请查看 [专题列表](spec.md) |

* TAG 列表、TAG 排行

    | 名称 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | tagRows | array | 详情请查看 [TAG 列表](tag.md) |

* 友情链接

    | 名称 | 类型 | 描述 |
    | - | - | - |
    | callRow | array | 详情请查看 [调用详情](#callRow) |
    | linkRows | array | 详情请查看 [友情链接](#linkRow) |

----------

<span id="callRow"></span>

##### 调用详情

| 键名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| call_id | int | 调用 ID |   |
| call_name | string | 调用名称 | 调用的名称。 |
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
