## 专题接口

----------

### 读取专题

本接口用于读取指定的专题

##### URL

http://server/index.php/api/spec/read

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| spec_id | int | true | ID |

##### 返回结果

| 名称 | 类型 | 描述 |
| - | - | - |
| specRow | array | 专题详细信息 | 详情请查看 [$specRow](#specRow) |

返回结果示例

``` javascript
{
    "specRow": {
        "spec_id": "11", //专题 ID
        "spec_name": "专题名称", //专题名称
        "spec_status": "show", //状态
        "spec_content": "专题内容", //内容
        "spec_attach_id": "3517",
        "rcode": "y180102" //返回代码
    }
}
```

----------

<span id="lists"></span>

### 列出专题

本接口用于列出符合条件的专题

##### URL

http://server/index.php/api/spec/lists

##### HTTP 请求方式

GET

##### 请求参数

参数进行 JSON 编码，然后将 JSON 字符串进行加密。然后把加密的结果作为 `公共请求参数` 的 code 参数。

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| key | string | false | 搜索关键词 |
| perpage | int | false | 每页显示专题数 |

##### 返回结果

| 名称 | 类型 | 描述 |
| - | - | - |
| specRows | array | 专题列表 | 详情请查看 [$specRow](#specRow) |
| pageRow | array | 分页参数 | 详情请查看 [分页](pagination.md) |

----------

<span id="specRow"></span>

### $specRow 结构

| 名称 | 类型 | 描述 |
| - | - | - |
| spec_id | int | ID |
| spec_name | string | 专题名称 |
| spec_content | string | 内容 |
| spec_status | string | pub 为发布，hide 为隐藏 |
| spec_attach_id | int | 封面图片 ID | |
| rcode | string | 返回码 |

