## 附件接口

----------

### 读取附件

本接口用于读取指定的附件

##### URL

http://server/index.php/api/attach/read

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| attach_id | int | true | 附件 ID |

##### 返回结果

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| attachRow | array | 附件详细信息 | 详情请查看 [$attachRow](#attachRow) |

返回结果示例

``` javascript
{
  "attachRow": {
    "attach_id": "2662", //附件 ID
    "attach_name": "20080228_765bd81512e1d286d713fnYZzWPWCwbf.jpg", //原始文件名
    "attach_time": "1438308616",  //上传时间
    "attach_ext": "jpg",  //扩展名
    "attach_mime": "image/jpeg",  //MIME
    "attach_size": "42996", //大小
    "attach_type": "image", //附件类型
    "attach_url": "/public/attach/2015/07/2662.jpg",  //附件 URL
    "thumbRows": {
      "0": {
        "thumb_id": "0",
        "thumb_width": "100",
        "thumb_height": "100",
        "thumb_type": "cut",
        "thumb_url_name": "2019/08/4016_100_100_cut.jpg",
        "thumb_url": "http://dev.baigo.net/attach/2019/08/4016_100_100_cut.jpg"
      },
      "21": {
        "thumb_id": "21",
        "thumb_width": "200",
        "thumb_height": "200",
        "thumb_type": "ratio",
        "thumb_url_name": "2019/08/4016_200_200_ratio.jpg",
        "thumb_url": "http://dev.baigo.net/attach/2019/08/4016_200_200_ratio.jpg"
      },
      "20": {
        "thumb_id": "20",
        "thumb_width": "50",
        "thumb_height": "50",
        "thumb_type": "ratio",
        "thumb_url_name": "2019/08/4016_50_50_ratio.jpg",
        "thumb_url": "http://dev.baigo.net/attach/2019/08/4016_50_50_ratio.jpg"
      }
    },
    "rcode": "y070102"
  }
}
```

----------

<span id="lists"></span>

### 列出附件

本接口用于列出符合条件的附件

##### URL

http://server/index.php/api/attach/lists

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| key | string | false | 搜索关键词 |
| year | string | false | 年份 |
| month | string | false | 月份 |
| album_id | int | false | 相册 ID |
| perpage | int | false | 每页显示附件数 |

##### 返回结果

| 名称 | 类型 | 描述 |
| - | - | - |
| attachRows | array | 附件列表 | 详情请查看 [读取附件](#read) |
| pageRow | array | 分页参数 | 详情请查看 [分页](pagination.md) |

----------

### 缩略图

在上传图片时，系统会根据缩略图的设置自动生成缩略图，系统生成缩略图以后，需要在适当的地方给予显示，一般缩略图信息位于 `attachRow` 对象中。

以文章列表为例，第一篇文章有一个 `articleRows[0].attachRow` 对象，此对象包含了第一篇文章的所有图片信息，包括原始图片、多个缩略图等，而缩略图位于 `articleRows[0].attachRow.thumbRows`。

----------

<span id="attachRow"></span>

### $attachRow 结构

| 名称 | 类型 | 描述 |
| - | - | - | - |
| attach_id | int | ID |
| attach_name | string | 原始文件名 |
| attach_time | int | 上传时间戳 |
| attach_time_format | array | 日期时间格式 |
| attach_ext | string | 扩展名 |
| attach_size | int | 大小 |
| attach_size_format | string | 大小 |
| attach_url | string | 附件 URL |
| thumbRows | array | 缩略图列表 |
| rcode | string | 返回码 |
