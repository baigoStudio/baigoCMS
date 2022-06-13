## TAG 接口

----------

### 读取 TAG

本接口用于读取指定的 TAG

##### URL

http://server/index.php/api/tag/read

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| tag_id | int | true | ID |

##### 返回结果

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| tagRow | array | TAG 详细信息 | 详情请查看 [$albumRow](#albumRow) |

返回结果示例

``` javascript
{
  "tagRow": {
    "tag_id": "62",
    "tag_name": "2",
    "tag_article_count": "0",
    "tag_status": "pub",
    "rcode": "y120102"
  }
}
```

----------

<span id="tagRow"></span>

### $tagRow 结构

| 名称 | 类型 | 描述 |
| - | - | - |
| tag_id | int | ID |
| tag_name | string | 名称 |
| tag_article_count | int | 与当前 TAG 关联的文章数 |
| tag_status | string | 状态  pub 为发布，hide 为隐藏 |
| rcode | string | 返回码 |
