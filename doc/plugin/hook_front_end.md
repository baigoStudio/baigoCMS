## 网站前台钩子

| 名称 | 类型 | 描述 | 位置 |
| - | - | - | - |
| action_pub_init | action | 用户模块初始化时触发 | 控制器 |
| [filter_pub_article_show](#filter_pub_article_show) | filter | 读取文章时过滤 | 控制器 |
| [filter_pub_cate_show](#filter_pub_cate_show) | filter | 读取栏目时过滤 | 控制器 |
| [filter_pub_spec_show](#filter_pub_spec_show) | filter | 读取专题时过滤 | 控制器 |
| [filter_pub_spec_lists](#filter_pub_spec_lists) | filter | 列出专题时过滤 | 控制器 |
| [filter_pub_tag_show](#filter_pub_tag_show) | filter | 读取 TAG 时过滤 | 控制器 |
| [filter_pub_call_article](#filter_pub_call_article) | filter | 调用文章列表时触发 | 控制器 |
| [filter_pub_call_cate](#filter_pub_call_article) | filter | 调用栏目列表时触发 | 控制器 |
| [filter_pub_call_spec](#filter_pub_call_article) | filter | 调用专题列表时触发 | 控制器 |
| [filter_pub_call_link](#filter_pub_call_article) | filter | 调用友情链接列表时触发 | 控制器 |
| [filter_pub_call_tag](#filter_pub_call_article) | filter | 调用 TAG 列表、排行时触发 | 控制器 |
| action_pub_head_before | action | 用户模块界面头部之前 | 模板 |
| action_pub_head_after | action | 用户模块界面头部之后 | 模板 |
| action_pub_foot_before | action | 用户模块界面底部之前 | 模板 |
| action_pub_foot_after | action | 用户模块界面底部之后 | 模板 |

----------

<span id="filter_pub_article_show"></span>

##### filter_pub_article_show

* 返回、回传参数

    详情请参考 [模板 -> 文章](../template/article.md)

----------

<span id="filter_pub_cate_show"></span>

##### filter_pub_cate_show

* 返回、回传参数

    详情请参考 [模板 -> 栏目](../template/cate.md)

----------

<span id="filter_pub_spec_show"></span>

##### filter_pub_spec_show

* 返回、回传参数

    详情请参考 [模板 -> 专题](../template/spec.md)

----------

<span id="filter_pub_spec_lists"></span>

##### filter_pub_spec_lists

* 返回、回传参数

    详情请参考 [模板 -> 专题](../template/spec.md#lists)

----------

<span id="filter_pub_tag_show"></span>

##### filter_pub_tag_show

* 返回、回传参数

    详情请参考 [模板 -> TAG](../template/tag.md)

----------

<span id="filter_pub_call_article"></span>

##### filter_pub_call_article / filter_pub_call_cate / filter_pub_call_spec / filter_pub_call_link / filter_pub_call_tag

* 返回、回传参数

    详情请参考 [模板 -> 调用](../template/call.md)
