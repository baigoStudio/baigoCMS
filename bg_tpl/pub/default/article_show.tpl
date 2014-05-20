{* article_show.tpl 文章显示 *}
{$cfg = [
	title  => $tplData.articleRow.article_title,
	css    => "article_show"
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

	<div class="article_title">{$tplData.articleRow.article_title}</div>
	<div class="article_time">
		{$tplData.articleRow.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}
	</div>

	<div class="article_content">{$tplData.articleRow.article_content}</div>

	<div class="article_tag">
		Tags:
		{foreach $tplData.tagRows as $tag_value}
			<a href="{$tag_value.tag_url}">{$tag_value.tag_name}</a>{if !$tag_value@last},{/if}
		{/foreach}
	</div>


{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
