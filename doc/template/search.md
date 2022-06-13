## 搜索

用于显示搜索结果。

位置：./search/index.tpl.php

| 变量名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| $articleRows | array | 验证信息信息 | 详情请查看 [文章](article.md) |
| $search | array | 搜索参数 | |
| $pageRow | array | 分页参数 | 详情请查看 [分页](pagination.md) |
| $urlRow | array | 栏目 URL | |

----------

##### 搜索请求

以 GET 形式发起搜索请求

搜索参数

| 名称 | 类型 | 必需 | 描述 |
| - | - | - | - |
| key | string | false | 搜索关键词 |
| year | string | false | 年份 |
| month | string | false | 月份 |
| cate | int | false | 栏目 ID |
| custom_{\:id} | string | false | 假设系统中有自定字段，ID 为 25，即可设置参数 custom_25。 |

----------

##### 搜索 URL 示例：

`./index.php/search/key/关键词/custom_25/35/cate/4`

用常见的 URL 来解释即：

`./search.php?key=关键词&custom_25=35&cate=4`

----------

##### HTML 示例代码

系统自带了一个名为 `baigoQuery` 的 jQuery 插件，该插件会自动将搜索表单的 action 转换为符合 baigo CMS 要求的 URL，开发者可以直接使用。

该插件位于 `./public/static/lib/baigoQuery/`

[点击查看 baigoQuery 文档](//doc.baigo.net/ginkgo/jquery/query/)。

``` php
<html>
<head>
  <meta charset="utf-8">
  <title>搜索<title>
  <script src="./public/static/lib/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
  <script src="./public/static/lib/baigoQuery/1.0.0/baigoQuery.min.js" type="text/javascript"></script>
</head>
<body>

  <form name="search_form" id="search_form" action="<?php echo $url_search; ?>">
    <div class="form-group">
      <label>关键词</label>
      <input type="text" name="key" id="key" value="<?php echo $search['key']; ?>" class="form-control" placeholder="关键词">
    </div>
    <div class="form-group">
      <label>电压</label>
      <input type="text" name="custom_25" value="<?php echo $search['custom_25']; ?>" class="form-control" placeholder="电压">
    </div>
    <div class="form-group">
      <label>序列号</label>
      <input type="text" name="custom_5" value="<?php echo $search['custom_5']; ?>" class="form-control" placeholder="序列号">
    </div>
    <button type="submit" id="search" class="btn btn-primary">搜索</button>
  </form>

  <script type="text/javascript">
  $(document).ready(function(){
    var obj_query = $('#search_form').baigoQuery(); // 初始化插件

    $('#search_form').submit(function(){
      obj_query.formSubmit(); // 提交
    });
  });
  </script>

</body>
</html>
```
