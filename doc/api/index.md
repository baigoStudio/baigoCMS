## API 概述

baigo CMS 的 API 接口主要用于提供信息源，您可以在各类应用程序中使用该接口，方便进行整合。

通过发起 HTTP 请求方式调用 baigo CMS 服务，返回 JSON 数据。

----------

##### API 调用示例

本文档的所有的示例都是在 ginkgo 框架基础之上建立的，关于 ginkgo 框架的详情请查看 [ginkgo 框架文档](//doc.baigo.net/ginkgo/)。以下为完整的调用文章列表接口的示例：

``` php
use ginkgo/Http;

$_time_deviation    = 300; //超时范围 (秒)
$_app_id            = 1; //APP ID
$_app_key           = 'e10adc3949ba59abbe56e057f20f883e'; //App Key
$_app_secret        = 'e10adc3949ba59ab'; //App Secret

$_arr_data = array(
  'app_id'    => $_app_id,
  'app_key'   => $_app_key,
  'cate_id'   => 1,
  'key'       => 'test',
);

$_arr_get = Http::instance()->request('http://server/index.php/api/article/lists/', $_arr_data, 'get'); //请求

$_arr_return = Json::decode(_arr_get); //解码

print_r($_arr_return);
```

----------

##### 返回结果

API 接口返回 JSON 对象，内容需要解码，详情请查看具体接口。

返回结果示例

``` javascript
{
  "articleRows": [
    {
      "article_id": "62", //文章 ID
      "article_cate_id": "2", //隶属栏目 ID
      "article_mark_id": "0", //标记 ID
      "article_title": "文章标题", //标题
      "article_excerpt": "<p><img id=\"baigo_2662\" class=\"img-fluid\" src=\"/public/attach/2015/07/2662.jpg\" alt=\"\" /></p>", //摘要
      "article_content": "<p><img id=\"baigo_2662\" class=\"img-fluid\" src=\"/public/attach/2015/07/2662.jpg\" alt=\"\" /></p><p> </p><p>[hr]</p>", //内容
      "cateRow": { //隶属栏目信息
        "rcode": "y250102",
        "cate_id": "2",
        "cate_name": "技术支持",
        "cate_alias": "support",
        "cate_parent_id": "0",
        "cate_type": "normal",
        "cate_tplDo": "default",
        "cate_content": ""
      },
      "tagRows": { //TAG
      },
      "attachRow": { //附件信息
        "attach_id": "2662",
        "attach_name": "20080228_765bd81512e1d286d713fnYZzWPWCwbf.jpg",
        "attach_time": "1438308616",
        "attach_ext": "jpg",
        "attach_mime": "image/jpeg",
        "attach_size": "42996",
        "attach_type": "image",
        "attach_url": "/public/attach/2015/07/2662.jpg",
        "thumb_100_100_cut": "/public/attach/2015/07/2662_100_100_cut.jpg",
        "thumb_150_2000_ratio": "/public/attach/2015/07/2662_150_2000_ratio.jpg",
        "thumb_200_200_ratio": "/public/attach/2015/07/2662_200_200_ratio.jpg",
        "thumb_500_500_cut": "/public/attach/2015/07/2662_500_500_cut.jpg",
        "rcode": "y070102"
      }
    },
    {
      "article_id": "61", //文章 ID
      "article_cate_id": "2", //隶属栏目 ID
      "article_mark_id": "0", //标记 ID
      "article_title": "文章标题", //标题
      "article_excerpt": "<p><img id=\"baigo_2662\" class=\"img-fluid\" src=\"/public/attach/2015/07/2662.jpg\" alt=\"\" /></p>", //摘要
      "article_content": "<p><img id=\"baigo_2662\" class=\"img-fluid\" src=\"/public/attach/2015/07/2662.jpg\" alt=\"\" /></p><p> </p><p>[hr]</p>", //内容
      "cateRow": { //隶属栏目信息
        "rcode": "y250102",
        "cate_id": "2",
        "cate_name": "技术支持",
        "cate_alias": "support",
        "cate_parent_id": "0",
        "cate_type": "normal",
        "cate_tplDo": "default",
        "cate_content": ""
      },
      "tagRows": { //TAG
      },
      "attachRow": { //附件信息
        "attach_id": "2662",
        "attach_name": "20080228_765bd81512e1d286d713fnYZzWPWCwbf.jpg",
        "attach_time": "1438308616",
        "attach_ext": "jpg",
        "attach_mime": "image/jpeg",
        "attach_size": "42996",
        "attach_type": "image",
        "attach_url": "/public/attach/2015/07/2662.jpg",
        "thumb_100_100_cut": "/public/attach/2015/07/2662_100_100_cut.jpg",
        "thumb_150_2000_ratio": "/public/attach/2015/07/2662_150_2000_ratio.jpg",
        "thumb_200_200_ratio": "/public/attach/2015/07/2662_200_200_ratio.jpg",
        "thumb_500_500_cut": "/public/attach/2015/07/2662_500_500_cut.jpg",
        "rcode": "y070102"
      }
    }
  ],
  "pageRow": {
    "page": "1",
    "total": "35",
    "first": "1",
    "final": "35",
    "prev": false,
    "next": "2",
    "group_begin": "1",
    "group_end": "10",
    "group_prev": false,
    "group_next": "11"
  }
}
```
