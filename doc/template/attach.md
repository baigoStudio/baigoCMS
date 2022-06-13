## 附件

在发布文章时，插入到文章的第一张图片或附件会被系统记录，在需要时，可以调用相关信息，图片、附件信息一般命名为 $articleRow['attachRow']，在文章列表等处，也可能是多维数组的某一个键，如 $articleRows[0]['attachRow']，详细结构如下。

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
| rcode | string | 返回码 |

----------

### 缩略图

在上传图片时，系统会根据缩略图的设置自动生成缩略图，系统生成缩略图以后，需要在适当的地方给予显示，一般缩略图信息位于 `attachRow` 数组中。

以文章列表为例，第一篇文章有一个 `$articleRows[0]['attachRow']` 数组，此数组包含了第一篇文章的所有图片信息，包括原始图片、多个缩略图等，而缩略图位于 `$articleRows[0]['attachRow']['thumbRows']`。

attachRow 数组示例

``` php
array(
  'attach_id'     => 2662, //附件 ID
  'attach_name'   => '20080228_765bd81512e1d286d713fnYZzWPWCwbf.jpg', //原始文件名
  'attach_time'   => 1438308616,  //上传时间
  'attach_ext'    => 'jpg',  //扩展名
  'attach_mime'   => 'image/jpeg',  //MIME
  'attach_size'   => 42996, //大小
  'attach_type'   => 'image', //附件类型
  'attach_url'    => '/public/attach/2015/07/2662.jpg',  //附件 URL
  'rcode'         => 'y070102',
  'thumbRows'     => array(
    0 => array(
      'thumb_id'          => 0,
      'thumb_width'       => 100,
      'thumb_height'      => 100,
      'thumb_type'        => 'cut',
      'thumb_url_name'    => '2019/08/4016_100_100_cut.jpg',
      'thumb_url'         => 'http://dev.baigo.net/attach/2019/08/4016_100_100_cut.jpg',
    ),
    21 => array(
      'thumb_id'          => 21,
      'thumb_width'       => 200,
      'thumb_height'      => 200,
      'thumb_type'        => 'ratio',
      'thumb_url_name'    => '2019/08/4016_200_200_ratio.jpg',
      'thumb_url'         => 'http://dev.baigo.net/attach/2019/08/4016_200_200_ratio.jpg',
    ),
    20 => array(
      'thumb_id'          => 20,
      'thumb_width'       => 50,
      'thumb_height'      => 50,
      'thumb_type'        => 'ratio',
      'thumb_url_name'    => '2019/08/4016_50_50_ratio.jpg',
      'thumb_url'         => 'http://dev.baigo.net/attach/2019/08/4016_50_50_ratio.jpg',
    ),
  ),
);
```
