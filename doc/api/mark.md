## 标记接口

----------

### 列出标记

本接口用于列出系统内的标记

##### URL

http://server/index.php/api/mark/lists

##### HTTP 请求方式

GET

##### 请求参数

仅公共请求参数

##### 返回结果

| 名称 | 类型 | 描述 |
| - | - | - |
| markRows | array | 标记列表 | 详情请查看 [$markRow](#markRow) |

返回结果示例

``` javascript
{
  "markRows": [
    {
      "mark_id": "3", //标记 ID
      "mark_name": "推荐" //名称
    },
    {
      "mark_id": "4", //标记 ID
      "mark_name": "推荐到首页" //名称
    }
  ]
}
```

----------

<span id="markRow"></span>

### $markRow 结构

| 名称 | 类型 | 描述 |
| - | - | - |
| mark_id | int | ID |
| mark_name | string | 名称 |
| rcode | string | 返回码 |
