## 相册接口

----------

### 读取相册

本接口用于读取指定的相册

##### URL

http://server/index.php/api/album/read

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| album_id | int | true | ID |

##### 返回结果

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| albumRow | array | 相册详细信息 | 详情请查看 [$albumRow](#albumRow) |

返回结果示例

``` javascript
{
  "albumRow": {
    "album_id": "11", //相册 ID
    "album_name": "相册名称", //相册名称
    "album_status": "show", //状态
    "album_content": "相册内容", //内容
    "album_attach_id": "3517",
    "rcode": "y180102" //返回代码
  }
}
```

----------

<span id="albumRow"></span>

### $albumRow 结构

| 名称 | 类型 | 描述 |
| - | - | - |
| album_id | int | ID |
| album_name | string | 相册名称 |
| album_content | string | 内容 |
| album_status | string | pub 为发布，hide 为隐藏 |
| album_attach_id | int | 封面图片 ID |
| rcode | string | 返回码 |
