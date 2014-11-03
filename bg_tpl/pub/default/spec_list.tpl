{* spec_list.tpl TAG 列表 *}
{$cfg = [
	title      => $tplData.cateRow.cate_name,
	str_url    => "{$tplData.search.urlRow.spec_url}{$tplData.search.urlRow.page_attach}",
	page_ext   => $tplData.search.page_ext
]}
{include "include/pub_head.tpl" cfg=$cfg}

	<div class="spec_nav">
		<a href="{$smarty.const.BG_URL_ROOT}">首页</a>
		&raquo;
		专题
	</div>

	<ul class="spec_list">
		{foreach $tplData.specRows as $value}
			<li class="spec_name">
				<a href="{$value.urlRow.spec_url}" target="_blank" class="{$_str_class}">{$value.spec_name}</a>
			</li>
		{/foreach}
	</ul>

	{include "include/page.tpl" cfg=$cfg}

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
