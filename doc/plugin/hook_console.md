## 后台钩子

| 名称 | 类型 | 描述 | 位置 |
| - | - | - | - |
| action_console_init | action | 后台初始化时触发 | 控制器 |
| [filter_console_article_add](#filter_console_article_add) | filter | 添加文章时触发 | 模型 |
| [filter_console_article_edit](#filter_console_article_add) | filter | 编辑文章时触发 | 模型 |
| [action_console_article_box](#action_console_article_box) | action | 更改文章保存位置时触发 | 控制器 |
| [action_console_article_status](#action_console_article_status) | action | 更改文章状态时触发 | 控制器 |
| [action_console_article_delete](#action_console_article_delete) | action | 删除文章时触发 | 控制器 |
| [filter_console_cate_add](#filter_console_cate_add) | filter | 添加栏目时触发 | 模型 |
| [filter_console_cate_edit](#filter_console_cate_add) | filter | 编辑栏目时触发 | 模型 |
| [action_console_cate_status](#action_console_cate_status) | action | 更改栏目状态时触发 | 控制器 |
| [action_console_cate_delete](#action_console_cate_delete) | action | 删除栏目时触发 | 控制器 |
| [filter_console_spec_add](#filter_console_spec_add) | filter | 添加专题时触发 | 模型 |
| [filter_console_spec_edit](#filter_console_spec_add) | filter | 编辑专题时触发 | 模型 |
| [action_console_spec_status](#action_console_spec_status) | action | 更改专题状态时触发 | 控制器 |
| [action_console_spec_delete](#action_console_spec_delete) | action | 删除专题时触发 | 控制器 |
| [filter_console_link_add](#filter_console_link_add) | filter | 添加链接时触发 | 模型 |
| [filter_console_link_edit](#filter_console_link_add) | filter | 编辑链接时触发 | 模型 |
| [action_console_link_status](#action_console_link_status) | action | 更改链接状态时触发 | 控制器 |
| [action_console_link_delete](#action_console_link_delete) | action | 删除链接时触发 | 控制器 |
| action_console_head_before | action | 后台界面头部之前 | 模板 |
| action_console_head_after | action | 后台界面头部之后  | 模板 |
| action_console_navbar_before | action | 后台界面导航条之前 | 模板 |
| action_console_navbar_after | action | 后台界面导航条之后 | 模板 |
| action_console_menu_before | action | 后台界面菜单之前 | 模板 |
| action_console_menu_plugin | action | 后台界面插件菜单中 | 模板 |
| action_console_menu_end | action | 后台界面菜单末尾 | 模板 |
| action_console_menu_after | action | 后台界面菜单之后 | 模板 |
| action_console_foot_before | action | 后台界面底部之前 | 模板 |
| action_console_foot_after | action | 后台界面底部之后 | 模板 |

----------

<span id="filter_console_article_add"></span>

##### filter_console_article_add / filter_console_article_edit

* 返回、回传参数

  详情请参考 [模板 -> 文章](../template/article.md)

----------

<span id="action_console_article_box"></span>

##### action_console_article_box

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | article_ids | array | 被更改的文章 ID |
  | article_box | array | 保存位置 |

----------

<span id="action_console_article_status"></span>

##### action_console_article_status

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | article_ids | array | 被更改的文章 ID |
  | article_status | array | 状态 |

----------

<span id="action_console_article_delete"></span>

##### action_console_article_delete

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | article_ids | array | 被删除的文章 ID |

----------

<span id="filter_console_cate_add"></span>

##### filter_console_cate_add / filter_console_cate_edit

* 返回、回传参数

  详情请参考 [模板 -> 栏目](../template/cate.md)

----------

<span id="action_console_cate_status"></span>

##### action_console_cate_status

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | cate_ids | array | 被更改的栏目 ID |
  | cate_status | array | 状态 |

----------

<span id="action_console_cate_delete"></span>

##### action_console_cate_delete

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | cate_ids | array | 被删除的栏目 ID |

----------

<span id="filter_console_spec_add"></span>

##### filter_console_spec_add / filter_console_spec_edit

* 返回、回传参数

  详情请参考 [模板 -> 专题](../template/spec.md)

----------

<span id="action_console_spec_status"></span>

##### action_console_spec_status

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | spec_ids | array | 被更改的专题 ID |
  | spec_status | array | 状态 |

----------

<span id="action_console_spec_delete"></span>

##### action_console_spec_delete

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | spec_ids | array | 被删除的专题 ID |

----------

<span id="filter_console_link_add"></span>

##### filter_console_link_add

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | link_name | string | 链接名称 |
  | link_url | string | 链接地址 |
  | link_status | string | 状态 |
  | link_blank | bool | 是否新窗口打开 |

----------

<span id="action_console_link_edit"></span>

##### action_console_link_edit

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | link_id | int | 链接 ID |
  | link_name | string | 链接名称 |
  | link_url | string | 链接地址 |
  | link_status | string | 状态 |
  | link_blank | bool | 是否新窗口打开 |

----------

<span id="action_console_link_status"></span>

##### action_console_link_status

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | link_ids | array | 被更改的链接 ID |
  | link_status | array | 状态 |

----------

<span id="action_console_link_delete"></span>

##### action_console_link_delete

* 返回

  | 参数 | 类型 | 描述 |
  | - | - | - |
  | link_ids | array | 被删除的链接 ID |
