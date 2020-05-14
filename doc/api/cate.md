## 栏目接口

----------

### 读取栏目

本接口用于读取指定的栏目

##### URL

http://server/index.php/api/cate/read

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| cate_id | int | true | 栏目 ID |

##### 返回结果

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| cateRow | array | 当前栏目的详细信息 | 详情请查看 [$cateRow](#cateRow) |

解密结果示例

``` javascript
{
    "cateRow": {
        "cate_id": "7",
        "cate_name": "Tech",
        "cate_alias": "tech",
        "cate_tpl": "-1",
        "cate_content": "",
        "cate_link": "",
        "cate_parent_id": "2",
        "cate_attach_id": "3517",
        "cate_prefix": "",
        "cate_status": "show",
        "cate_perpage": "30",
        "rcode": "y250102",
        "cate_breadcrumb": {
            0: {
                "cate_id": "1",
                "cate_name": "baigo CMS",
                "cate_alias": "baigocms",
                "cate_tpl": "-1",
                "cate_content": "<p>aaaaaaaaaaaasdfdsf</p>",
                "cate_link": "",
                "cate_parent_id": "0",
                "cate_prefix": "",
                "cate_status": "show",
                "cate_perpage": "30",
                "rcode": "y250102"
            },
            1: {
                "cate_id": "2",
                "cate_name": "Support",
                "cate_alias": "support",
                "cate_tpl": "-1",
                "cate_content": "<p>aaaaaaaaaaaasdfdsf</p>",
                "cate_link": "",
                "cate_parent_id": "1",
                "cate_prefix": "",
                "cate_status": "show",
                "cate_perpage": "30",
                "rcode": "y250102"
            },
            3: {
                "cate_id": "7",
                "cate_name": "Tech",
                "cate_alias": "tech",
                "cate_tpl": "-1",
                "cate_content": "<p>aaaaaaaaaaaasdfdsf</p>",
                "cate_link": "",
                "cate_parent_id": "2",
                "cate_prefix": "",
                "cate_status": "show",
                "cate_perpage": "30",
                "rcode": "y250102"
            }
        },
        "ids": {
            0: "30",
            1: "14",
            2: "13",
            3: "17",
            4: "7"
        },
    }
}
```

----------

### 列出栏目树

本接口用于列出栏目的树形目录

##### URL

http://server/index.php/api/cate/tree

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| parent_id | int | false | 父栏目 ID，如果指定该参数，只返回隶属于该栏目的树形目录。 |

##### 返回结果

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| cate_tree | array | 栏目树信息 | 详情请查看 [$cateRow](#cateRow) |

返回结果示例

``` javascript
{
    "cate_tree": {
        "1": {
            "cate_id": "1", // ID
            "cate_name": "baigo", // 名称
            "cate_alias": "baigo",
            "cate_content": "nickname",
            "cate_status": "wait",
            "cate_link": "",
            "cate_parent_id": "0",
            "cate_level": 1, // 栏目层级
            "cate_childs": { // 子栏目
                31: {
                    "cate_id": "31",
                    "cate_name": "gh",
                    "cate_link": "",
                    "cate_alias": "",
                    "cate_status": "show",
                    "cate_parent_id": "1",
                    "cate_prefix": "",
                    "cate_perpage": "50",
                    "cate_level": 2,
                    "cate_childs":  {}
                },
                27: {
                    "cate_id": "27",
                    "cate_name": "gh",
                    "cate_link": "",
                    "cate_alias": "hhhhhhhh",
                    "cate_status": "show",
                    "cate_parent_id": "1",
                    "cate_prefix": "",
                    "cate_perpage": "50",
                    "cate_level": 2,
                    "cate_childs": {
                        26: {
                            "cate_id": "26",
                            "cate_name": "gh",
                            "cate_link": "",
                            "cate_alias": "hhhhhhhh",
                            "cate_status": "show",
                            "cate_parent_id": "27",
                            "cate_prefix": "",
                            "cate_perpage": "50",
                            "cate_level": 3,
                            "cate_childs": {}
                        }
                    }
                }
            }
        },
        "2": {
            "cate_id": "2", // ID
            "cate_name": "baigo", // 名称
            "cate_alias": "baigo",
            "cate_content": "nickname",
            "cate_status": "wait",
            "cate_link": "",
            "cate_parent_id": "0",
            "cate_level": 1, // 栏目层级
            "cate_childs": { // 子栏目
                30: {
                    "cate_id": "30",
                    "cate_name": "gh",
                    "cate_link": "",
                    "cate_alias": "",
                    "cate_status": "show",
                    "cate_parent_id": "1",
                    "cate_prefix": "",
                    "cate_perpage": "50",
                    "cate_level": 2,
                    "cate_childs":  {}
                }
            }
        }
    }
}
```

----------

<span id="cateRow"></span>

### $cateRow 结构

| 名称 | 类型 | 描述 |
| - | - | - |
| cate_id | int | ID |
| cate_name | string | 栏目名称 |
| cate_alias | string | 别名 |
| cate_content | string | 内容 |
| cate_status | string | 状态 |
| cate_link | string | 跳转至 |
| cate_parent_id | int | 隶属于栏目 |
| cate_attach_id | int | 封面图片 ID |
| cate_breadcrumb | array | 面包屑路径，关于面包屑路径请查看 [互动百科](http://www.baike.com/wiki/面包屑路径) |
| cate_prefix | string | URL 前缀 |
| rcode | string | 返回码 |
