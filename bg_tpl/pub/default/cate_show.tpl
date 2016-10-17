{$str_url = $tplData.cateRow.urlRow.cate_url}

{if $smarty.const.BG_MODULE_GEN < 1}
    {$str_url = "{$str_url}key-{$tplData.search.key}/customs-{$tplData.search.customs}/"}
{/if}

{$cfg = [
    title       => $tplData.cateRow.cate_name,
    str_url     => "{$str_url}{$tplData.cateRow.urlRow.page_attach}",
    str_urlMore => "{$tplData.cateRow.urlRow.cate_urlMore}{$tplData.cateRow.urlRow.page_attach}",
    page_ext    => $tplData.cateRow.urlRow.page_ext
]}

{if isset($tplData.cateRow.is_static)}
    {$cfg.is_static = "true"}
{/if}

{include "include/pub_head.tpl" cfg=$cfg}

    <ol class="breadcrumb">
        <li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
        {foreach $tplData.cateRow.cate_trees as $key=>$value}
            <li><a href="{$value.urlRow.cate_url}">{$value.cate_name}</a></li>
        {/foreach}
    </ol>

    <!--#include virtual="/cms/call/9.html" -->

    {foreach $tplData.articleRows as $value}
        <h3><a href="{$value.urlRow.article_url}" target="_blank">{$value.article_title}</a></h3>
        <p>{$value.article_time_pub|date_format:$smarty.const.BG_SITE_DATE}</p>

        <p>{$value.article_excerpt}</p>
        <p><a href="{$value.urlRow.article_url}">阅读全文...</a></p>
        <hr>
        <ul class="list-inline">
            <li>
                <span class="glyphicon glyphicon-tags"></span>
                Tags:
            </li>
            {if isset($value.tagRows)}
                {foreach $value.tagRows as $tag_value}
                    <li><a href="{$tag_value.urlRow.tag_url}">{$tag_value.tag_name}</a></li>
                {/foreach}
            {/if}
        </ul>
    {/foreach}

    {include "include/page.tpl" cfg=$cfg}

{include "include/pub_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl"}