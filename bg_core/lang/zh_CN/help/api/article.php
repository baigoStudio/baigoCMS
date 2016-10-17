<?php
return "<h3>文章列表</h3>
    <p class=\"text-info\">接口说明</p>
    <p>用于显示文章列表。</p>

    <p class=\"text-info\">URL</p>
    <p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=article</span></p>

    <p class=\"text-info\">HTTP 请求方式</p>
    <p>GET</p>

    <p class=\"text-info\">返回格式</p>
    <p>JSON</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">请求参数</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">名称</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">必须</th>
                        <th>具体描述</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">act_get</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>接口调用动作，值只能为 list。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">app_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>应用的 APP ID，后台创建应用时生成的 ID。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">app_key</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>应用的 APP KEY，后台创建应用时生成的 KEY。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">key</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">false</td>
                        <td>搜索关键词</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">year</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">false</td>
                        <td>年份</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">month</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">false</td>
                        <td>月份</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">cate_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">false</td>
                        <td>栏目 ID</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">mark_ids</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">false</td>
                        <td>标记 ID，多个 ID 请使用 <kbd>|</kbd> 分隔。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">tag_ids</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">false</td>
                        <td rowspan=\"3\">
                            <div>多个 ID 请使用 <kbd>|</kbd> 分隔。此三个参数为三选一，优先级依次为 tag_ids &gt; spec_ids &gt; customs。</div>
                            <div>关于 customs 详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=search#customs\" target=\"_blank\">搜索</a></div>
                        </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">spec_ids</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">false</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">customs</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">false</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">per_page</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">false</td>
                        <td>每页显示文章数</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">返回结果</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
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
                        <td class=\"text-nowrap\">articleRows</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">文章列表</td>
                        <td>符合搜索条件的所有文章。详情请查看 <a href=\"#result\">文章显示返回结果</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">pageRow</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">分页参数</td>
                        <td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=page\" target=\"_blank\">分页参数</a>。</td>
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

    <a name=\"get\"></a>
    <h3>文章显示</h3>
    <p class=\"text-info\">接口说明</p>
    <p>用于显示当前文章的详细信息。</p>

    <p class=\"text-info\">URL</p>
    <p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=article</span></p>

    <p class=\"text-info\">HTTP 请求方式</p>
    <p>GET</p>

    <p class=\"text-info\">返回格式</p>
    <p>JSON</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">请求参数</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">名称</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">必须</th>
                        <th>具体描述</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">act_get</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>接口调用动作，值只能为 list。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">app_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>应用的 APP ID，后台创建应用时生成的 ID。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">app_key</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>应用的 APP KEY，后台创建应用时生成的 KEY。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>文章 ID</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <a name=\"result\"></a>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">返回结果</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">名称</th>
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
                        <td class=\"text-nowrap\">文章上线时间</td>
                        <td>指文章上线时间。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_time_hide</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">文章下线时间</td>
                        <td>指文章下线时间。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">tagRows</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">当前文章关联的 TAG</td>
                        <td>所有与此文章关联的 TAG。详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=tag#tagRow\" target=\"_blank\">TAG</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">cateRow</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">当前文章所属栏目的详细信息</td>
                        <td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=cate#cateRow\" target=\"_blank\">栏目</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">attachRow</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">当前文章附件的详细信息</td>
                        <td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=attach\" target=\"_blank\">附件</a>。</td>
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
                        <td class=\"text-nowrap\">自定义字段</td>
                        <td>自定义字段的内容。用 <code>article_customs[\"custom_自定义字段 ID\"]</code> 的方式便可获取自定义字段的内容。详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=custom\" target=\"_blank\">自定义字段</a>。</td>
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

    <h4>返回结果示例</h4>
    <p>
<pre><code class=\"language-javascript\">{
    &quot;article_id&quot;: &quot;62&quot;, //文章 ID
    &quot;article_cate_id&quot;: &quot;2&quot;, //隶属栏目 ID
    &quot;article_mark_id&quot;: &quot;0&quot;, //标记 ID
    &quot;article_title&quot;: &quot;文章标题&quot;, //标题
    &quot;article_excerpt&quot;: &quot;&lt;p&gt;&lt;img id=\&quot;baigo_2662\&quot; class=\&quot;img-responsive\&quot; src=\&quot;/cms/bg_attach/2015/07/2662.jpg\&quot; alt=\&quot;\&quot; /&gt;&lt;/p&gt;&quot;, //摘要
    &quot;article_status&quot;: &quot;pub&quot;, //状态
    &quot;article_link&quot;: &quot;&quot;, //链接
    &quot;article_hits_day&quot;: &quot;0&quot;, //日点击
    &quot;article_hits_week&quot;: &quot;0&quot;, //周点击
    &quot;article_hits_month&quot;: &quot;0&quot;, //月点击
    &quot;article_hits_year&quot;: &quot;5&quot;, //年点击
    &quot;article_hits_all&quot;: &quot;6&quot;, //总点击
    &quot;article_time&quot;: &quot;1438309806&quot;, //添加时间
    &quot;article_time_pub&quot;: &quot;1438308780&quot;, //上线时间
    &quot;article_time_hide&quot;: &quot;1438308780&quot;, //下线时间
    &quot;article_attach_id&quot;: &quot;2662&quot;, //附件 ID
    &quot;article_content&quot;: &quot;&lt;p&gt;&lt;img id=\&quot;baigo_2662\&quot; class=\&quot;img-responsive\&quot; src=\&quot;/cms/bg_attach/2015/07/2662.jpg\&quot; alt=\&quot;\&quot; /&gt;&lt;/p&gt;&lt;p&gt;&nbsp;&lt;/p&gt;&lt;p&gt;[hr]&lt;/p&gt;&quot;, //内容
    &quot;article_customs&quot;: { //自定义字段
        &quot;custom_4&quot;: &quot;0&quot;,
        &quot;custom_3&quot;: &quot;0&quot;,
        &quot;custom_5&quot;: &quot;0&quot;,
        &quot;custom_6&quot;: &quot;0&quot;,
        &quot;custom_8&quot;: &quot;0&quot;,
        &quot;custom_9&quot;: &quot;&quot;,
        &quot;custom_11&quot;: &quot;&quot;,
        &quot;custom_12&quot;: &quot;&quot;
    },
    &quot;urlRow&quot;: {
        &quot;article_url&quot;: &quot;/cms/article/id-62&quot;, //URL
        &quot;page_ext&quot;: &quot;.html&quot;
    },
    &quot;cateRow&quot;: { //隶属栏目信息
        &quot;alert&quot;: &quot;y110102&quot;,
        &quot;cate_id&quot;: &quot;2&quot;,
        &quot;cate_name&quot;: &quot;技术支持&quot;,
        &quot;cate_alias&quot;: &quot;support&quot;,
        &quot;cate_parent_id&quot;: &quot;0&quot;,
        &quot;cate_type&quot;: &quot;normal&quot;,
        &quot;cate_tplDo&quot;: &quot;default&quot;,
        &quot;cate_content&quot;: &quot;&quot;
        &quot;urlRow&quot;: {
            &quot;cate_url&quot;: &quot;/cms/cate/support/id-2/&quot;,
            &quot;cate_urlMore&quot;: &quot;/cms/cate/support/id-2/&quot;,
            &quot;page_attach&quot;: &quot;page-&quot;,
            &quot;page_ext&quot;: &quot;.html&quot;
        },
        &quot;cate_trees&quot;: {
            [
                &quot;0&quot;: {
                    &quot;cate_id&quot;: &quot;2&quot;,
                    &quot;cate_name&quot;: &quot;技术支持&quot;,
                    &quot;cate_alias&quot;: &quot;support&quot;,
                    &quot;cate_domain&quot;: &quot;&quot;,
                    &quot;urlRow&quot;: {
                        &quot;cate_url&quot;: &quot;/cms/cate/support/id-2/&quot;,
                        &quot;cate_urlMore&quot;: &quot;/cms/cate/support/id-2/&quot;,
                        &quot;page_attach&quot;: &quot;page-&quot;,
                        &quot;page_ext&quot;: &quot;.html&quot;
                    }
                }
            ]
        }
    },
    &quot;tagRows&quot;: { //TAG
    },
    &quot;attachRow&quot;: { //附件信息
        &quot;attach_id&quot;: &quot;2662&quot;,
        &quot;attach_name&quot;: &quot;20080228_765bd81512e1d286d713fnYZzWPWCwbf.jpg&quot;,
        &quot;attach_time&quot;: &quot;1438308616&quot;,
        &quot;attach_ext&quot;: &quot;jpg&quot;,
        &quot;attach_mime&quot;: &quot;image/jpeg&quot;,
        &quot;attach_size&quot;: &quot;42996&quot;,
        &quot;attach_type&quot;: &quot;image&quot;,
        &quot;attach_url&quot;: &quot;/cms/bg_attach/2015/07/2662.jpg&quot;,
        &quot;thumb_100_100_cut&quot;: &quot;/cms/bg_attach/2015/07/2662_100_100_cut.jpg&quot;,
        &quot;thumb_150_2000_ratio&quot;: &quot;/cms/bg_attach/2015/07/2662_150_2000_ratio.jpg&quot;,
        &quot;thumb_200_200_ratio&quot;: &quot;/cms/bg_attach/2015/07/2662_200_200_ratio.jpg&quot;,
        &quot;thumb_500_500_cut&quot;: &quot;/cms/bg_attach/2015/07/2662_500_500_cut.jpg&quot;,
        &quot;alert&quot;: &quot;y070102&quot;
    },
    &quot;alert&quot;: &quot;y120102&quot;
}</code></pre>
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

    <a name=\"hits\"></a>
    <h3>文章计数</h3>

    <p class=\"text-info\">接口说明</p>
    <p>由于纯静态页面无法计数，因此在此提供计数接口，建议只用于纯静态模式。本接口只能提供简单的文章点击数，如果需要详细的访问统计，请使用专业的网站统计系统。</p>

    <p class=\"text-info\">URL</p>
    <p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=article</span></p>

    <p class=\"text-info\">HTTP 请求方式</p>
    <p>GET</p>

    <p class=\"text-info\">返回格式</p>
    <p>JSON</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">请求参数</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">名称</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">必须</th>
                        <th>具体描述</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">act_get</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>接口调用动作，值只能为 hits。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">article_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>文章 ID</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">返回结果</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
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
                        <td class=\"text-nowrap\">alert</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">返回代码</td>
                        <td>显示技术结果，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\" target=\"_blank\">返回代码</a>。</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>";