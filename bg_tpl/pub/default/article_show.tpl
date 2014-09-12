{* article_show.tpl 文章显示 *}
{$cfg = [
	title  => $tplData.articleRow.article_title,
	css    => "article_show"
]}

{include "include/pub_head.tpl" cfg=$cfg}

	<ol class="breadcrumb">
		<li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
		{foreach $tplData.cateRow.cate_trees as $value}
			<li><a href="{$value.urlRow.cate_url}">{$value.cate_name}</a></li>
		{/foreach}
	</ol>


	<div class="article_title">{$tplData.articleRow.article_title}</div>
	<div class="article_time">
		{$tplData.articleRow.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}
	</div>

	<div class="article_content">{$tplData.articleRow.article_content}</div>

	<div class="article_tag">
		Tags:
		{foreach $tplData.tagRows as $tag_value}
			<a href="{$tag_value.urlRow.tag_url}">{$tag_value.tag_name}</a>
		{/foreach}
	</div>


{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
