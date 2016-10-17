<?php
return "<h3>栏目树</h3>
    <p>
        在任何模板内，均可以用遍历 <code>{\$tplData.cateRows}</code> 的方式来显示网站所有栏目的树形结构，详细字段请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate#cateRow\">栏目</a>。
    </p>

    <p>&nbsp;</p>

    <h4>栏目树数据示例</h4>
    <code>{\$tplData.cateRows|@print_r}</code>
    <p>
<pre><code class=\"language-php\">Array (
    [7] =&gt; Array (
        [cate_id] =&gt; 7 //栏目 ID
        [cate_name] =&gt; baigo CMS //名称
        [cate_alias] =&gt; baigocms //别名
        [cate_parent_id] =&gt; 0 //隶属栏目 ID
        [urlRow] =&gt; Array (
            [cate_url] =&gt; /cate/baigocms/id-7/ //URL
            [cate_urlMore] =&gt; /cate/baigocms/id-7/ //更多分页 URL
            [page_attach] =&gt; page- //分页附加
            [page_ext] =&gt; .html
        )
        [cate_childs] =&gt; Array ( //子栏目
            [13] =&gt; Array (
                [cate_id] =&gt; 13
                [cate_name] =&gt; test
                [cate_alias] =&gt; test
                [cate_parent_id] =&gt; 7
                [urlRow] =&gt; Array (
                    [cate_url] =&gt; /cate/baigocms/test/id-13/
                    [cate_urlMore] =&gt; /cate/baigocms/id-7/ //更多分页 URL
                    [page_attach] =&gt; page-
                    [page_ext] =&gt; .html
                )
            )
        )
    )
)</code></pre>
    </p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"include\"></a>
    <h3>包含</h3>
    <p>
        在任何模板内，均可以用 <code>{include \"包含模板路径\"}</code> 的方式来包含并执行文件，您可以在模板目录下，建立一个目录，如 <mark>inc</mark>，用来统一存放被包含的模板，如：<code>{include \"inc/head.tpl\"}</code>，关于包含，请查看 Smarty 官方网站 <a href=\"http://www.smarty.net\" target=\"_blank\">http://www.smarty.net</a></a>。
    </p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"ubb\"></a>
    <h3>部分 UBB 代码支持</h3>
    <p>
        在任何模板内，均可以用 Smarty 修饰符 <code>{\$string|ubb}</code> 的方式来实现部分 UBB 代码，被支持的 UBB 代码请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=common#ubb\">管理后台</a>。
    </p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"const\"></a>
    <h3>常量</h3>
    <p>
        在任何模板内，均可以用 <code>{\$smarty.const.常量名}</code> 的方式来调用系统内置常量，如果您想得到所有的常量名，请查看 <mark>./bg_config</mark> 目录下的文件。
    </p>
    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">常用常量</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">常量名</th>
                        <th>说明</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_ROOT</td>
                        <td>网站根目录</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_HELP</td>
                        <td>帮助信息路径</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_ARTICLE</td>
                        <td>文章路径</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_ATTACH</td>
                        <td>附件路径</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_SSO</td>
                        <td>baigo SSO 路径</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_PUB</td>
                        <td>前台路径</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_ADMIN</td>
                        <td>管理后台路径</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_INSTALL</td>
                        <td>安装程序路径</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_URL_STATIC</td>
                        <td>静态文件路径</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_NAME</td>
                        <td>网站名称</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_DOMAIN</td>
                        <td>网站域名</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_URL</td>
                        <td>网站首页 URL</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_PERPAGE</td>
                        <td>每页显示数</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_TIMEZONE</td>
                        <td>所处时区</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_DATE</td>
                        <td>日期格式</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_DATESHORT</td>
                        <td>短日期格式</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_TIME</td>
                        <td>时间格式</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_SITE_TIMESHORT</td>
                        <td>短时间格式</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">BG_VISIT_PAGE</td>
                        <td>静态页数</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"lang\"></a>
    <h3>语言资源</h3>
    <p>
        在任何模板内，均可以用 <code>{\$数组名.键名}</code> 的方式来调用系统内置语言资源，如果您想得到所有的语言资源的键名，可以使用 <code>{\$数组名|@debug_print_var}</code> 或者 <code>{\$数组名|@print_r}</code> 来显示数组结构。
    </p>
    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">常用语言资源</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">数组名</th>
                        <th>说明</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">lang</td>
                        <td>通用信息，包含系统中常用的语言内容。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">alert</td>
                        <td>提示信息</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"custom\"></a>
    <h3>自定义字段</h3>
    <p>
        在任何模板内，均可以用遍历 <code>{\$tplData.customRows}</code> 的方式来显示所有有效自定义字段的列表。
    </p>
    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">常用语言资源</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">键名</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th>说明</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">custom_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td>自定义字段 ID</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">custom_name</td>
                        <td class=\"text-nowrap\">string</td>
                        <td>自定义字段名称</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">custom_childs</td>
                        <td class=\"text-nowrap\">array</td>
                        <td>子字段数组</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <h4>自定义字段数据示例</h4>
    <code>{\$tplData.customRows|@print_r}</code>
    <p>
<pre><code class=\"language-php\">Array (
    [0] =&gt; Array (
        [custom_id] =&gt; 4 //字段 ID
        [custom_name] =&gt; 尺寸 //名称
        [custom_parent_id] =&gt; 0 //隶属字段 ID
        [custom_cate_id] =&gt; 0 //隶属栏目 ID
        [custom_childs] =&gt; Array ( //子字段
            [0] =&gt; Array (
                [custom_id] =&gt; 5
                [custom_name] =&gt; 长
                [custom_parent_id] =&gt; 4
                [custom_cate_id] =&gt; 2
            )
        )
    )
)</code></pre>
    </p>";