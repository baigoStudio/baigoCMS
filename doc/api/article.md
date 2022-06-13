## 文章接口

----------

### 读取文章

本接口用于读取指定的文章

##### URL

http://server/index.php/api/article/read

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| article_id | int | true | 文章 ID |

##### 返回结果

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| articleRow | array | 文章详细信息 | 详情请查看 [$articleRow](#articleRow) |
| tagRows | array | 当前文章关联的 TAG | 所有与此文章关联的 TAG。详情请查看 [TAG](tag.md)。 |
| cateRow | array | 当前文章所属栏目的详细信息 | 详情请查看 [栏目](cate.md)。 |
| rcode | string | 返回码 | |

返回结果示例

``` javascript
{
  "articleRow": {
    "article_id": "62", //文章 ID
    "article_cate_id": "2", //隶属栏目 ID
    "article_mark_id": "0", //标记 ID
    "article_title": "文章标题", //标题
    "article_excerpt": "<p><img id=\"baigo_2662\" class=\"img-fluid\" src=\"/public/attach/2015/07/2662.jpg\" alt=\"\" /></p>", //摘要
    "article_status": "pub", //状态
    "article_link": "", //链接
    "article_hits_day": "0", //日点
    "article_hits_week": "0", //周点
    "article_hits_month": "0", //月点
    "article_hits_year": "5", //年点
    "article_hits_all": "6", //总点
    "article_time": "1438309806", //创建时间
    "article_time_show": "1438308780", //显示时间
    "article_time_pub": "1438308780", //上线时间
    "article_time_hide": "1438308780", //下线时间
    "article_attach_id": "2662", //附件 ID
    "article_content": "<p><img id=\"baigo_2662\" class=\"img-fluid\" src=\"/public/attach/2015/07/2662.jpg\" alt=\"\" /></p><p> </p><p>[hr]</p>", //内容
    "rcode": "y120102",
    "article_customs": { //自定义字段
      "custom_4": "0",
      "custom_3": "0",
      "custom_5": "0",
      "custom_6": "0",
      "custom_8": "0",
      "custom_9": "",
      "custom_11": "",
      "custom_12": ""
    }
  },
  "cateRow": { //隶属栏目信息
    "rcode": "y250102",
    "cate_id": "2",
    "cate_name": "技术支持",
    "cate_alias": "support",
    "cate_parent_id": "0",
    "cate_type": "normal",
    "cate_tplDo": "default",
    "cate_content": "",
    "cate_url": {
      "url": "/public/cate/support/id/2/",
      "url_more": "/public/cate/support/id/2/",
      "param": "page-",
      "param_more": ".html"
    },
    "cate_breadcrumb": {
      [
        {
          "cate_id": "2",
          "cate_name": "技术支持",
          "cate_alias": "support",
          "cate_prefix": "",
          "cate_url": {
            "url": "/public/cate/support/id/2/",
            "url_more": "/public/cate/support/id/2/",
            "param": "page-",
            "param_more": ".html"
          }
        }
      ]
    }
  },
  "tagRows": { //TAG
  }
}
```

----------

<span id="lists"></span>

### 列出文章

本接口用于列出符合条件的文章

##### URL

http://server/index.php/api/article/lists

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| key | string | false | 搜索关键词 |
| year | string | false | 年份 |
| month | string | false | 月份 |
| cate_id | int | false | 栏目 ID |
| mark_ids | string | false | 标记 ID，多个 ID 请使用 <kbd>,</kbd> 分隔。 |
| tag_ids | string | false | 多个 ID 请使用 <kbd>,</kbd> 分隔。优先级为 tag_ids &gt; spec_ids &gt; custom_id，三选一。 |
| spec_ids | string | false | |
| custom_{\:id} | string | false | 假设系统中有自定字段，ID 为 25，即可设置参数 custom_25。 |
| perpage | int | false | 每页显示文章数 |

##### 返回结果

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| articleRows | array | 文章列表 | 详情请查看 [$articleRow](#articleRow) |
| pageRow | array | 分页参数 | 详情请查看 [分页](pagination.md) |

----------

<span id="hits"></span>

### 文章计数

由于纯静态页面无法计数，因此在此提供计数接口，建议只用于纯静态模式。本接口只能提供简单的文章点击数，如果需要详细的访问统计，请使用专业的网站统计系统。

##### URL

http://server/index.php/api/article/hits

##### HTTP 请求方式

GET

##### 请求参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| article_id | int | true | 文章 ID |

##### 返回结果

| 名称 | 类型 | 描述 |
| - | - | - |
| rcode | string | 返回码 |

----------

<span id="articleRow"></span>

### $articleRow 结构

| 名称 | 类型 | 描述 | 备注 |
| - | - | - | - |
| article_id | int | ID | |
| article_title | string | 文章标题 | |
| article_content | text | 文章内容 | |
| article_cate_id | int | 隶属栏目 ID | |
| article_mark_id | int | 隶属标记 ID | |
| article_excerpt | string | 文章摘要 | |
| article_link | string | 跳转至 | |
| article_hits_day | int | 一天点数 | |
| article_hits_week | int | 一周点数 | |
| article_hits_month | int | 一月点数 | |
| article_hits_year | int | 一年点数 | |
| article_hits_all | int | 总点数 | |
| article_is_time_pub | int | 是否定时上线 | 是否定时上线，值为 1 时文章定时上线。 |
| article_is_time_hide | int | 是否定时下线 | 是否定时上线，值为 1 时文章定时下线。 |
| article_time | int | 文章创建时间 | 指文章创建到数据库的时间。 |
| article_time_show | int | 文章显示时间 | 指显示在文章中的时间。 |
| article_time_show_format | array | 文章显示时间 | 日期时间格式 |
| article_time_pub | int | 文章上线时间 | 指文章上线时间。 |
| article_time_pub_format | array | 文章上线时间 | 日期时间格式 |
| article_time_hide | int | 文章下线时间 | 指文章下线时间。 |
| article_time_hide_format | string | 文章下线时间 | 日期时间格式 |
| article_status | string | 文章状态 | pub 为发布，wait 为待审，hide 为隐藏。 |
| article_customs | array | 自定义字段 | 自定义字段的内容。用 article_customs['custom_{\:id}'] 的方式便可获取自定义字段的内容。详情请查看 [自定义字段](custom.md)。 |
| article_source | string | 文章来源 | 常用于转载文章时，表明文章的出处，以示对原作者的尊重。 |
| article_source_url | string | 文章来源 URL | 常用于转载文章时，表明文章的出处，以示对原作者的尊重。 |
| article_author | string | 文章作者 | 常用于转载文章时，表明文章的出处，以示对原作者的尊重。 |
| article_attach_id | int | 封面图片 ID | |
