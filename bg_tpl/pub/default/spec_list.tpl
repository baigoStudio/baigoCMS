{* spec_list.tpl TAG 列表 *}
{$cfg = [
	title      => $lang.page.spec,
	str_url    => "{$tplData.search.urlRow.spec_url}{$tplData.search.urlRow.page_attach}",
	page_ext   => $tplData.search.page_ext
]}
{include "include/pub_head.tpl" cfg=$cfg}

	<ol class="breadcrumb">
		<li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
		<li>专题</li>
	</ol>

	{foreach $tplData.specRows as $value}
		<h4><a href="{$value.urlRow.spec_url}" target="_blank" class="{$_str_class}">{$value.spec_name}</a></h4>
		<hr>
	{/foreach}

	{include "include/page.tpl" cfg=$cfg}

{include "include/pub_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl"}
