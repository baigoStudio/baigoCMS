{* tag_show.tpl TAG 显示 *}
{$cfg = [
	title      => $tplData.tagRow.tag_name,
	str_url    => "{$tplData.specRow.urlRow.spec_url}{$tplData.specRow.urlRow.page_attach}",
	page_ext   => $tplData.search.page_ext
]}
{include "include/pub_head.tpl" cfg=$cfg}

	<div class="spec_nav">
		<a href="{$smarty.const.BG_URL_ROOT}">首页</a>
		&raquo;
		<a href="{$tplData.search.urlRow.spec_url}">专题</a>
		&raquo;
		{$tplData.specRow.spec_name}
	</div>

	<ul class="article_list">
		{foreach $tplData.articleRows as $value}
			<li>
				<ol>
					<li class="list_title"><a href="{$value.article_url}" target="_blank">{$value.article_title}</a></li>
					<li class="list_time">
						{$value.article_time_pub|date_format:$smarty.const.BG_SITE_DATE}
					</li>
					<li class="list_spec">
						Tags:
						{foreach $value.tagRows as $tag_value}
							{if $tag_value.tag_name == $tplData.tagRow.tag_name}
								{$_str_class = "highlight"}
							{else}
								{$_str_class = "normal"}
							{/if}
							<a href="{$tag_value.urlRow.tag_url}" class="{$_str_class}">{$tag_value.tag_name}</a>
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
