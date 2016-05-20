{* cate_single.tpl 单页栏目 *}
{$cfg = [
    title      => $tplData.cateRow.cate_name
]}

{include "include/pub_head.tpl" cfg=$cfg}

    <ol class="breadcrumb">
        <li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
        {foreach $tplData.cateRow.cate_trees as $key=>$value}
            <li><a href="{$value.urlRow.cate_url}">{$value.cate_name}</a></li>
        {/foreach}
    </ol>

    <h3>{$tplData.cateRow.cate_name}</h3>

    <p>
        {$tplData.cateRow.cate_content}
    </p>

{include "include/pub_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl"}
