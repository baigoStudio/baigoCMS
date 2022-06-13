## API 接口钩子

| 名称 | 类型 | 描述 | 位置 |
| - | - | - | - |
| action_api_init | action | API 初始化时触发 | 控制器 |
| [filter_api_article_read](#filter_api_article_read) | filter | 读取文章时过滤 | 控制器 |
| [filter_api_article_lists](#filter_api_article_lists) | filter | 列出文章时过滤 | 控制器 |
| [filter_api_cate_read](#filter_api_cate_read) | filter | 读取栏目时过滤 | 控制器 |
| [filter_api_cate_tree](#filter_api_cate_tree) | filter | 列出栏目树时过滤 | 控制器 |
| [filter_api_spec_read](#filter_api_spec_read) | filter | 读取专题时过滤 | 控制器 |
| [filter_api_spec_lists](#filter_api_spec_lists) | filter | 列出专题时过滤 | 控制器 |
| [filter_api_tag_read](#filter_api_tag_read) | filter | 读取 TAG 时过滤 | 控制器 |
| [filter_api_call_article](#filter_api_call_article) | filter | 调用文章列表时触发 | 控制器 |
| [filter_api_call_cate](#filter_api_call_article) | filter | 调用栏目列表时触发 | 控制器 |
| [filter_api_call_spec](#filter_api_call_article) | filter | 调用专题列表时触发 | 控制器 |
| [filter_api_call_link](#filter_api_call_article) | filter | 调用友情链接列表时触发 | 控制器 |
| [filter_api_call_tag](#filter_api_call_article) | filter | 调用 TAG 列表、排行时触发 | 控制器 |

----------

<span id="filter_api_article_read"></span>

##### filter_api_article_read

* 返回、回传参数

  详情请参考 [API 接口 -> 文章](../api/article.md)

----------

<span id="filter_api_article_lists"></span>

##### filter_api_article_lists

* 返回、回传参数

  详情请参考 [API 接口 -> 文章](../api/article.md#lists)

----------

<span id="filter_api_cate_read"></span>

##### filter_api_cate_read

* 返回、回传参数

  详情请参考 [API 接口 -> 栏目](../api/cate.md)

----------

<span id="filter_api_cate_tree"></span>

##### filter_api_cate_tree

* 返回、回传参数

  详情请参考 [API 接口 -> 栏目](../api/cate.md)

----------

<span id="filter_api_spec_read"></span>

##### filter_api_spec_read

* 返回、回传参数

  详情请参考 [API 接口 -> 专题](../api/spec.md)

----------

<span id="filter_api_spec_lists"></span>

##### filter_api_spec_lists

* 返回、回传参数

  详情请参考 [API 接口 -> 专题](../api/spec.md#lists)

----------

<span id="filter_api_tag_read"></span>

##### filter_api_tag_read

* 返回、回传参数

  详情请参考 [API 接口 -> TAG](../api/tag.md)

----------

<span id="filter_api_call_article"></span>

##### filter_api_call_article / filter_api_call_cate / filter_api_call_spec / filter_api_call_link / filter_api_call_tag

* 返回、回传参数

  详情请参考 [API 接口 -> 调用](../api/call.md)
