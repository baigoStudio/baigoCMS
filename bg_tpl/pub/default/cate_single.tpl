{* cate_single.tpl 单页栏目 *}
{$cfg = [
	title      => $tplData.cateRow.cate_name,
	css        => "cate_show",
	str_url    => "{$tplData.cateRow.cate_url}{$tplData.cateRow.page_attach}",
	page_ext   => $tplData.cateRow.page_ext
]}

{include "include/pub_head.tpl" cfg=$cfg}

	<div class="cate_nav">
		<a href="{$smarty.const.BG_URL_PUB}">首页</a>
		&raquo;
		{foreach $tplData.cateTrees as $value}
			<a href="{$value.cate_url}">{$value.cate_name}</a>
			{if !$value@last}&raquo;{/if}
		{/foreach}
	</div>

	<div class="cate_content">
		{$tplData.cateRow.cate_content}
	</div>

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
