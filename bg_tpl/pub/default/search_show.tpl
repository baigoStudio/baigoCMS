{* search_show.tpl 搜索显示 *}
{$cfg = [
	title      => $lang.page.search,
	str_url    => "{$tplData.search.urlRow.search_url}{$tplData.search.urlRow.page_attach}",
	page_ext   => $tplData.search.page_ext
]}
{include "include/pub_head.tpl" cfg=$cfg}

	<ol class="breadcrumb">
		<li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
		{if $tplData.search.key}
			<li><a href="{$tplData.search.urlRow.search_url}">搜索</a></li>
			<li>{$tplData.search.key}</li>
		{else}
			<li>搜索</li>
		{/if}
	</ol>

	<form name="search" action="{$smarty.const.BG_URL_ROOT}index.php" method="get" class="form-inline">
		<input type="hidden" name="mod" value="search">
		<input type="hidden" name="act_get" value="show">
		<input type="text" name="key" value="{$tplData.search.key}" class="form-control">
		<button type="submit" class="btn btn-primary">搜索</button>
	</form>

	{foreach $tplData.articleRows as $value}
		<h3><a href="{$value.article_url}" target="_blank">{$value.article_title|replace:$tplData.search.key:"<span class='highlight'>{$tplData.search.key}</span>"}</a></h3>
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

	{if $tplData.search.key}
		{include "include/page.tpl" cfg=$cfg}
	{/if}

{include "include/pub_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl"}
