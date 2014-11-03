{* article_show.tpl 文章显示 *}
{$cfg = [
	title  => $tplData.articleRow.article_title
]}

{include "include/pub_head.tpl" cfg=$cfg}

	<ol class="breadcrumb">
		<li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
		{foreach $tplData.cateRow.cate_trees as $value}
			<li><a href="{$value.urlRow.cate_url}">{$value.cate_name}</a></li>
		{/foreach}
	</ol>


	<h3>{$tplData.articleRow.article_title}</h3>
	<p>{$tplData.articleRow.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</p>

	<p>{$tplData.articleRow.article_content}</p>

	<hr>

	<ul class="list-inline">
		<li>
			<span class="glyphicon glyphicon-tags"></span>
			Tags:
		</li>

		{foreach $tplData.tagRows as $tag_value}
			<li><a href="{$tag_value.urlRow.tag_url}">{$tag_value.tag_name}</a></li>
		{/foreach}
	</ul>

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
