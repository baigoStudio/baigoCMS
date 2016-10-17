<?php
return "<h3>调用</h3>
    <p>&nbsp;</p>
    <h4>纯静态模式下</h4>
    <p>
        纯静态模式下，调用将会生成静态文件，调用方式可以在后台管理的查看调用中查询，推荐生成 html 文件，然后在需要显示调用的地方，用“服务器端嵌入 Server Side Include（SSI）”的方式来调用，如：<code>&lt;!--#include file=&quot;./call/9.html&quot; --&gt;</code>。
    </p>
    <p>
        调用模板位于 <mark>./bg_tpl/call</mark> 目录下，如默认模板 <mark>./bg_tpl/call/call_cate.tpl</mark>。注：模板文件名必须使用 <mark>英文</mark> 与 <mark>数字</mark>，不能使用中文、符号等。
    </p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">默认模板结构说明</div>
        <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <thead>
                    <tr>
                        <th>调用类型</th>
                        <th class=\"text-nowrap\">默认模板</th>
                        <th>传递数据</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>文章列表、日排行、周排行、月排行、年排行、总排行</td>
                        <td class=\"text-nowrap\">call_article.tpl</td>
                        <td>
                            <ul class=\"list-unstyled\">
                                <li>
                                    <code>{\$tplData.callRow}</code> 调用 <a href=\"#callRow\">查看详情</a>
                                </li>
                                <li>
                                    <code>{\$tplData.articleRows}</code> 文章列表
                                    <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=article#articleRow\">查看详情</a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>栏目列表</td>
                        <td class=\"text-nowrap\">call_cate.tpl</td>
                        <td>
                            <ul class=\"list-unstyled\">
                                <li>
                                    <code>{\$tplData.callRow}</code> 调用 <a href=\"#callRow\">查看详情</a>
                                </li>
                                <li>
                                    <code>{\$tplData.cateRows}</code> 栏目列表
                                    <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate#cateRow\">查看详情</a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>专题列表</td>
                        <td class=\"text-nowrap\">call_spec.tpl</td>
                        <td>
                            <ul class=\"list-unstyled\">
                                <li>
                                    <code>{\$tplData.callRow}</code> 调用 <a href=\"#callRow\">查看详情</a>
                                </li>
                                <li>
                                    <code>{\$tplData.specRows}</code> 专题列表
                                    <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=spec#specRow\">查看详情</a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>TAG 列表、TAG 排行</td>
                        <td class=\"text-nowrap\">call_tag.tpl</td>
                        <td>
                            <ul class=\"list-unstyled\">
                                <li>
                                    <code>{\$tplData.callRow}</code> 调用 <a href=\"#callRow\">查看详情</a>
                                </li>
                                <li>
                                    <code>{\$tplData.tagRows}</code> TAG 列表
                                    <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=tag#tagRow\">查看详情</a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <p>&nbsp;</p>

    <a name=\"callRow\"></a>
    <h4><code>{\$tplData.callRow}</code> 数组</h4>

    <p>当前栏目详细信息</p>

    <div class=\"panel panel-default\">
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
                        <td class=\"text-nowrap\">call_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">调用 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_name</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">调用名称</td>
                        <td>调用的名称。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_type</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">调用类型</td>
                        <td>article 文章列表、hits_day 日排行、hits_week 周排行、hits_month 月排行、hits_year 年排行、hits_all 总排行、spec 专题列表、cate 栏目列表、tag_list TAG 列表、tag_rank TAG 排行</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_cate_ids</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">栏目 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_cate_excepts</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">排除栏目 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_cate_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">栏目 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_spec_ids</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">专题 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_mark_ids</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">标记 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_file</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">生成文件类型</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_amount</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">显示数量</td>
                        <td><code>{\$tplData.callRow.call_amount.top}</code> 为显示数量、<code>{\$tplData.callRow.call_amount.except}</code> 为排除数量</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_attach</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">附件选项</td>
                        <td>all 全部、attach 仅显示带附件文章、none 仅显示无附件文章</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_status</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">调用状态</td>
                        <td>enable 为启用，disable 为禁用。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">call_tpl</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">模板</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">alert</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">返回代码</td>
                        <td>显示当前调用的状态，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\" target=\"_blank\">返回代码</a>。</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <h4>其他模式下</h4>
    <p>
        在任何模板内，均可以用函数 <code>{call_display call_id=调用 ID}</code> 的方式来显示调用，执行此函数后，模板会生成一个 <code>{\$callRows}</code> 数组，可以通过遍历 <code>{\$callRows.调用 ID}</code> 的方式来显示调用结果，<code>{\$callRows}</code> 数组会根据不同的调用类型有所不同，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=article#articleRow\">文章</a>、<a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate#cateRow\">栏目</a>、<a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=tag#tagRow\">TAG</a>、<a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=spec#specRow\">专题</a> 等有关信息。关于调用以及调用 ID 请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=call\">调用管理</a>。
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

    <a name=\"callAttach\"></a>
    <h3>调用附件</h3>
    <p>
        在任何模板内，均可以用函数 <code>{call_attach attach_id=附件 ID}</code> 的方式来显示调用，执行此函数后，模板会生成一个 <code>{\$attachRows}</code> 数组，可以通过遍历 <code>{\$attachRows.附件 ID}</code> 的方式来显示调用结果，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=attach\">附件 / 缩略图</a>。
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

    <a name=\"callCate\"></a>
    <h3>调用栏目</h3>
    <p>
        在任何模板内，均可以用函数 <code>{call_cate cate_id=栏目 ID}</code> 的方式来显示调用，执行此函数后，模板会生成一个 <code>{\$cateRows}</code> 数组，可以通过遍历 <code>{\$cateRows.栏目 ID}</code> 的方式来显示调用结果，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate\">栏目</a>。
    </p>";