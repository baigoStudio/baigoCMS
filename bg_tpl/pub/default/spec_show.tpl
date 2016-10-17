{$cfg = [
    title       => $tplData.specRow.spec_name,
    str_url     => "{$tplData.specRow.urlRow.spec_url}{$tplData.specRow.urlRow.page_attach}",
    str_urlMore => "{$tplData.specRow.urlRow.spec_urlMore}{$tplData.specRow.urlRow.page_attach}",
    page_ext    => $tplData.specRow.urlRow.page_ext
]}

{if isset($tplData.specRow.is_static)}
    {$cfg.is_static = "true"}
{/if}

{include "include/pub_head.tpl" cfg=$cfg}

    <ol class="breadcrumb">
        <li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
        <li><a href="{$tplData.urlRow.spec_url}">专题</a></li>
        <li>{$tplData.specRow.spec_name}</li>
    </ol>

    {foreach $tplData.articleRows as $key=>$value}
        <h3><a href="{$value.urlRow.article_url}" target="_blank">{$value.article_title}</a></h3>
        <p>{$value.article_time_pub|date_format:$smarty.const.BG_SITE_DATE}</p>
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