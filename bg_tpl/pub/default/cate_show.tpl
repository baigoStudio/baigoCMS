{* cate_show.tpl 栏目显示 *}
{$cfg = [
	title      => $tplData.cateRow.cate_name,
	css        => "cate_show",
	str_url    => "{$tplData.cateRow.urlRow.cate_url}{$tplData.cateRow.urlRow.page_attach}",
	page_ext   => $tplData.search.page_ext
]}

{include "include/pub_head.tpl" cfg=$cfg}

	<ol class="breadcrumb">
		<li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
		{foreach $tplData.cateRow.cate_trees as $value}
			<li><a href="{$value.urlRow.cate_url}">{$value.cate_name}</a></li>
		{/foreach}
	</ol>

	<ul class="article_list">
		{foreach $tplData.articleRows as $value}
			<li>
				<ol>
					<li class="list_title"><a href="{$value.article_url}" target="_blank">{$value.article_title}</a></li>
					<li class="list_time">
						{$value.article_time_pub|date_format:$smarty.const.BG_SITE_DATE}
					</li>

					<li class="list_excerpt">{$value.article_excerpt}</li>
					<li class="list_read"><a href="{$value.article_url}">阅读全文...</a></li>
					<li class="list_tag">
						Tags:
						{foreach $value.tagRows as $tag_value}
							<a href="{$tag_value.urlRow.tag_url}">{$tag_value.tag_name}</a>
						{/foreach}
					</li>
				</ol>
			</li>
		{/foreach}
	</ul>

	{include "include/page.tpl" cfg=$cfg}
	<div class="float_clear"></div>

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
