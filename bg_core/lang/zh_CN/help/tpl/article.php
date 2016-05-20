<?php
return "<h3>文章显示</h3>
    <p>文件名：<span class=\"text-primary\">article_show.tpl</span></p>
    <p>
        用于显示当前文章的详细信息。
    </p>
    <div class=\"panel panel-default\">
        <div class=\"table-responsive\">
            <table class=\"table\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">键名</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">说明</th>
                        <th>备注</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">tplData.articleRow</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">当前文章的详细信息</td>
                        <td>查看 <a href=\"#articleRow\">tplData.articleRow</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">tplData.associateRows</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">关联文章的列表</td>
                        <td>系统将一个或以上 TAG 相同的文章列出。此数组为多维数组，详细信息查看 <a href=\"#articleRow\">tplData.articleRow</a>。</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <a name=\"articleRow\"></a>
    <h4><code>{\$tplData.articleRow}</code> 数组</h4>

    <p>当前文章的详细信息</p>

    <div class=\"panel panel-default\">
        <div class=\"table-responsive\">
            <table class=\"table\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">键名</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">说明</th>
                        <th>备注</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">article_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">文章 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_title</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">文章标题</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_content</td>
                        <td class=\"text-nowrap\">text</td>
                        <td class=\"text-nowrap\">文章内容</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_cate_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">隶属栏目 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_mark_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">隶属标记 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_spec_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">文章隶属专题 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_excerpt</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">文章摘要</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_link</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">跳转至</td>
                        <td>如填写了跳转地址，该文章将直接跳转至相应的地址，不会显示文章内容。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_hits_day</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">一天点击数</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_hits_week</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">一周点击数</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_hits_month</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">一月点击数</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_hits_year</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">一年点击数</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_hits_all</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">总点击数</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_time</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">文章添加时间</td>
                        <td>指文章添加到数据库的时间。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_time_pub</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">文章发布时间</td>
                        <td>指文章发布时间。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_url</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">当前文章 URL</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">tagRows</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">当前文章关联的 TAG</td>
                        <td>所有与此文章关联的 TAG。详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=tag#tagRow\" target=\"_blank\">TAG</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">cateRow</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">当前文章所属栏目的详细信息</td>
                        <td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate#cateRow\" target=\"_blank\">栏目</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">attachRow</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">当前文章附件的详细信息</td>
                        <td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=attach\" target=\"_blank\">图片 / 缩略图</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_status</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">文章状态</td>
                        <td>pub 为发布，wait 为待审，hide 为隐藏。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_customs</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">自定义字段值</td>
                        <td>自定义字段的内容。用 <code>{\$tplData.articleRow.article_customs[\"custom_自定义字段 ID\"}</code> 的方法便可显示自定义字段的内容。详情请查看通用资源 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=common#custom\" target=\"_blank\">自定义字段</a>，或后台管理 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=custom\" target=\"_blank\">自定义字段</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">alert</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">返回代码</td>
                        <td>显示当前文章的状态，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\" target=\"_blank\">返回代码</a>。</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <h4>文章数据示例</h4>
    <code>{\$tplData.articleRow|@print_r}</code>
    <p>
<pre><code class=\"language-php\">Array (
    [article_id] =&gt; 62 //文章 ID
    [article_cate_id] =&gt; 2 //隶属栏目 ID
    [article_mark_id] =&gt; 0 //标记 ID
    [article_title] =&gt; 文章标题 //标题
    [article_excerpt] =&gt; &lt;p&gt;&lt;img id=&quot;baigo_2662&quot; class=&quot;img-responsive&quot; src=&quot;/cms/bg_attach/2015/07/2662.jpg&quot; alt=&quot;&quot; /&gt;&lt;/p&gt; //摘要
    [article_status] =&gt; pub //状态
    [article_link] =&gt; //链接
    [article_hits_day] =&gt; 0 //日点击
    [article_hits_week] =&gt; 0 //周点击
    [article_hits_month] =&gt; 0 //月点击
    [article_hits_year] =&gt; 5 //年点击
    [article_hits_all] =&gt; 6 //总点击
    [article_time] =&gt; 1438309806 //添加时间
    [article_time_pub] =&gt; 1438308780 //发布时间
    [article_spec_id] =&gt; 11 //隶属专题 ID
    [article_attach_id] =&gt; 2662 //附件 ID
    [article_content] =&gt; &lt;p&gt;&lt;img id=&quot;baigo_2662&quot; class=&quot;img-responsive&quot; src=&quot;/cms/bg_attach/2015/07/2662.jpg&quot; alt=&quot;&quot; /&gt;&lt;/p&gt;&lt;p&gt;&nbsp;&lt;/p&gt;&lt;p&gt;[hr]&lt;/p&gt; //内容
    [article_customs] =&gt; Array ( //自定义字段
        [custom_4] =&gt; 0
        [custom_3] =&gt; 0
        [custom_5] =&gt; 0
        [custom_6] =&gt; 0
        [custom_8] =&gt; 0
        [custom_9] =&gt;
        [custom_11] =&gt;
        [custom_12] =&gt;
    )
    [article_url] =&gt; /cms/article/id-62 //URL
    [cateRow] =&gt; Array ( //隶属栏目信息
        [alert] =&gt; y110102
        [cate_id] =&gt; 2
        [cate_name] =&gt; 技术支持
        [cate_alias] =&gt; support
        [cate_parent_id] =&gt; 0
        [cate_type] =&gt; normal
        [cate_tplDo] =&gt; default
        [cate_content] =&gt;
        [urlRow] =&gt; Array (
            [cate_url] =&gt; /cms/cate/support/id-2/
            [page_attach] =&gt; page-
        )
        [cate_trees] =&gt; Array (
            [0] =&gt; Array (
                [cate_id] =&gt; 2
                [cate_name] =&gt; 技术支持
                [cate_alias] =&gt; support
                [cate_domain] =&gt;
                [urlRow] =&gt; Array (
                    [cate_url] =&gt; /cms/cate/support/id-2/
                    [page_attach] =&gt; page-
                )
            )
        )
    )
    [tagRows] =&gt; Array ( //TAG
    )
    [attachRow] =&gt; Array ( //附件信息
        [attach_id] =&gt; 2662
        [attach_name] =&gt; 20080228_765bd81512e1d286d713fnYZzWPWCwbf.jpg
        [attach_time] =&gt; 1438308616
        [attach_ext] =&gt; jpg
        [attach_mime] =&gt; image/jpeg
        [attach_size] =&gt; 42996
        [attach_type] =&gt; image
        [attach_url] =&gt; /cms/bg_attach/2015/07/2662.jpg
        [thumb_100_100_cut] =&gt; /cms/bg_attach/2015/07/2662_100_100_cut.jpg
        [thumb_150_2000_ratio] =&gt; /cms/bg_attach/2015/07/2662_150_2000_ratio.jpg
        [thumb_200_200_ratio] =&gt; /cms/bg_attach/2015/07/2662_200_200_ratio.jpg
        [thumb_500_500_cut] =&gt; /cms/bg_attach/2015/07/2662_500_500_cut.jpg
        [alert] =&gt; y070102
    )
    [alert] =&gt; y120102
)</code></pre>
    </p>";