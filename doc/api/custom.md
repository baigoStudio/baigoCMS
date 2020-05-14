## 自定义字段接口

----------

### 列出自定义字段

用于列出系统内所有有效自定义字段

##### URL

http://server/index.php/api/custom/lists

##### HTTP 请求方式

GET

##### 请求参数

仅公共请求参数

##### 返回结果

| 名称 | 类型 | 描述 |
| - | - | - |
| customRows | array | 自定义字段列表 | 详情请查看 [$customRow](#customRow) |

返回结果示例

``` javascript
{
    "customRows": [
        {
            "custom_id": "4", //字段 ID
            "custom_name": "尺寸", //名称
            "custom_parent_id": "0", //隶属字段 ID
            "custom_cate_id": "0", //隶属栏目 ID
        },
        {
            "custom_id": "5",
            "custom_name": "长",
            "custom_parent_id": "4",
            "custom_cate_id": "2"
        }
    ]
}
```

----------

### 列出自定义字段树

本接口用于列出自定义字段的树形目录

##### URL

http://server/index.php/api/custom/tree

##### HTTP 请求方式

GET

##### 请求参数

仅公共请求参数

##### 返回结果

| 名称 | 类型 | 描述 |
| - | - | - |
| custom_tree | array | 自定义字段树 | 详情请查看 [$customRow](#customRow) |

返回结果示例

``` javascript
{
    "custom_tree": [
        {
            "custom_id": "4", //字段 ID
            "custom_name": "尺寸", //名称
            "custom_parent_id": "0", //隶属字段 ID
            "custom_cate_id": "0", //隶属栏目 ID
            "custom_childs": [ //子字段
                {
                    "custom_id": "5",
                    "custom_name": "长",
                    "custom_parent_id": "4",
                    "custom_cate_id": "2"
                }
            ]
        }
    ]
}
```

----------

<span id="customRow"></span>

### $customRow 结构

| 名称 | 类型 | 描述 |
| - | - | - |
| custom_id | int | ID |
| custom_name | string | 字段名 |
| custom_parent_id | int | 隶属于字段 |
| custom_cate_id | int | 隶属于栏目 |
