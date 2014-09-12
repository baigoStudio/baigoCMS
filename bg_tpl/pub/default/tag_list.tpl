{* tag_list.tpl TAG 列表 *}
{$cfg = [
	title      => $tplData.cateRow.cate_name,
	css        => "tag_list",
	str_url    => "{$tplData.search.urlRow.tag_url}{$tplData.search.urlRow.page_attach}",
	page_ext   => $tplData.search.page_ext
]}
{include "include/pub_head.tpl" cfg=$cfg}

	<div class="tag_nav">
		<a href="{$smarty.const.BG_URL_ROOT}">首页</a>
		&raquo;
		TAG
	</div>

	<ul class="tag_list">
		{foreach $tplData.tagRows as $value}
			{if $value.tag_article_count > 5}
				{$_str_class = "tag_size_5"}
			{else}
				{$_str_class = "tag_size_common"}
			{/if}
			<li class="tag_name">
				<a href="{$value.urlRow.tag_url}" target="_blank" class="{$_str_class}">
					{$value.tag_name}
					({$value.tag_article_count})
				</a>
			</li>
		{/foreach}
		<li class="float_clear"></li>
	</ul>

	{include "include/page.tpl" cfg=$cfg}
	<div class="float_clear"></div>

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
