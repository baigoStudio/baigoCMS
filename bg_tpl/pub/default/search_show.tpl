{* search_show.tpl 搜索显示 *}
{$cfg = [
	title      => $tplData.cateRow.cate_name,
	css        => "search_show",
	str_url    => "{$smarty.const.BG_URL_PUB}index.php?mod=search&{$tplData.query}"
]}
{include "include/pub_head.tpl" cfg=$cfg}

	<div class="search_nav">
		<a href="{$smarty.const.BG_URL_PUB}">首页</a>
		&raquo;
		搜索
		{if $tplData.search.key}
			&raquo;
			{$tplData.search.key}
		{/if}
	</div>

	<div class="search_form">
		<form name="search" action="{$smarty.const.BG_URL_PUB}index.php" method="get">
			<input type="hidden" name="mod" value="search" />
			<input type="hidden" name="act_get" value="show" />
			<input type="text" name="key" value="{$tplData.search.key}" />
			<button type="submit">搜索</button>
		</form>
	</div>

	<ul class="article_list">
		{foreach $tplData.articleRows as $value}
			<li>
				<ol>
					<li class="list_title"><a href="{$smarty.const.BG_URL_PUB}index.php?mod=article&act_get=show&article_id={$value.article_id}" target="_blank">{$value.article_title|replace:$tplData.search.key:"<span class='highlight'>{$tplData.search.key}</span>"}</a></li>
					<li class="list_time">
						{$value.article_time_pub|date_format:$smarty.const.BG_SITE_DATE}
					</li>
					<li class="list_tag">
						Tags:
						{foreach $value.tagRows as $tag_value}
							<a href="{$smarty.const.BG_URL_PUB}index.php?mod=tag&act_get=show&tag_name={$tag_value.tag_name}">{$tag_value.tag_name}</a>{if !$tag_value@last},{/if}
						{/foreach}
					</li>

				</ol>
			</li>
		{/foreach}
	</ul>

	{if $tplData.search.key}
		{include "include/page.tpl" cfg=$cfg}
	{/if}
	<div class="float_clear"></div>

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
