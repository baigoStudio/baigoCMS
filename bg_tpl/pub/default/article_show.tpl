{function custom_list arr=""}
    {foreach $arr as $key=>$value}
        {if isset($value.custom_childs)}
            <label class="control-label">{$value.custom_name}</label>
        {else}
            <div class="form-group">
                <label class="control-label">{$value.custom_name}</label>
                <p class="form-control-static">
                    {if isset($tplData.articleRow.article_customs["custom_{$value.custom_id}"])}
                        {$tplData.articleRow.article_customs["custom_{$value.custom_id}"]}
                    {/if}
                </p>
            </div>
        {/if}

        {if isset($value.custom_childs)}
            {custom_list arr=$value.custom_childs}
        {/if}
    {/foreach}
{/function}

{$cfg = [
    title  => $tplData.articleRow.article_title
]}

{include "include/pub_head.tpl" cfg=$cfg}

    <ol class="breadcrumb">
        <li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
        {foreach $tplData.articleRow.cateRow.cate_trees as $key=>$value}
            <li><a href="{$value.urlRow.cate_url}">{$value.cate_name}</a></li>
        {/foreach}
    </ol>

    <h3>{$tplData.articleRow.article_title}</h3>
    <p>{$tplData.articleRow.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</p>

    <p>{$tplData.articleRow.article_content|ubb}</p>

    {custom_list arr=$tplData.customRows}

    {call_attach attach_id=2600}

    {$attachRows|@debug_print_var}

    <hr>

    <ul class="list-inline">
        <li>
            <span class="glyphicon glyphicon-tags"></span>
            Tags:
        </li>

        {foreach $tplData.articleRow.tagRows as $tag_key=>$tag_value}
            <li><a href="{$tag_value.urlRow.tag_url}">{$tag_value.tag_name}</a></li>
        {/foreach}
    </ul>

    <ul class="list-unstyled">
        {foreach $tplData.associateRows as $key=>$value}
            <li><a href="{$value.urlRow.article_url}">{$value.article_title}</a></li>
        {/foreach}
    </ul>

{include "include/pub_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl"}