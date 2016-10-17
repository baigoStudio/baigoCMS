<?php
return "<h3>TAG 显示</h3>
    <p class=\"text-info\">接口说明</p>
    <p>用于显示当前 TAG 的详细信息。</p>

    <p class=\"text-info\">URL</p>
    <p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=tag</span></p>

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
                        <td>接口调用动作，值只能为 read。</td>
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
                        <td class=\"text-nowrap\">tag_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">true</td>
                        <td>TAG ID</td>
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
                        <td class=\"text-nowrap\">tag_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">TAG ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">tag_name</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">TAG 名称</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">tag_article_count</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">文章计数</td>
                        <td>与当前 TAG 关联的文章计数。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">tag_status</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">TAG 状态</td>
                        <td>pub 为发布，hide 为隐藏。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">alert</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">返回代码</td>
                        <td>显示当前 TAG 的状态，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\" target=\"_blank\">返回代码</a>。</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <h4>返回结果示例</h4>
    <p>
<pre><code class=\"language-javascript\">{
    &quot;tag_id&quot;: &quot;94&quot;, //TAG ID
    &quot;tag_name&quot;: &quot;asp&quot;, //TAG 名称
    &quot;tag_status&quot;: &quot;show&quot;, //状态
    &quot;tag_article_count&quot;: &quot;0&quot;, //关联文章数
    &quot;urlRow&quot;: {
        &quot;tag_url&quot;: &quot;/cms/tag/tag-asp/&quot;, //URL
        &quot;page_attach&quot;: &quot;page-&quot;, //分页附加
        &quot;page_ext&quot;: &quot;.html&quot;
    }
    &quot;alert&quot;: &quot;y130102&quot;
}</code></pre>
    </p>";