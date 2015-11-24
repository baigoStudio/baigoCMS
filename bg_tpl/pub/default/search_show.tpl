{* search_show.tpl 搜索显示 *}
{function custom_list arr=""}
	{foreach $arr as $key=>$value}
		{if isset($value.custom_childs)}
			<h4>
				<span class="label label-default">{$value.custom_name}</span>
			</h4>
		{else}
			<div class="form-group">
				<label class="control-label">{$value.custom_name}</label>
				<input type="text" name="custom_{$value.custom_id}" value="{if isset($tplData.customs["custom_{$value.custom_id}"])}{$tplData.customs["custom_{$value.custom_id}"]}{/if}" class="customs form-control" placeholder="{$value.custom_name}">
			</div>
		{/if}

		{if isset($value.custom_childs)}
			{custom_list arr=$value.custom_childs}
		{/if}
	{/foreach}
{/function}

{$cfg = [
	title      => $lang.page.search,
	str_url    => "{$tplData.search.urlRow.search_url}key-{$tplData.search.key}/customs-{$tplData.search.customs}/cate-{$tplData.search.cate_id}/{$tplData.search.urlRow.page_attach}",
	page_ext   => ""
]}
{include "include/pub_head.tpl" cfg=$cfg}

	<ol class="breadcrumb">
		<li><a href="{$smarty.const.BG_URL_ROOT}">首页</a></li>
		<li><a href="{$tplData.search.urlRow.search_url}">搜索</a></li>
	</ol>

	<form name="search" id="search">
		<div class="form-group">
			<label class="control-label">{$lang.label.key}</label>
			<input type="text" name="key" id="key" value="{$tplData.search.key}" class="form-control" placeholder="{$lang.label.key}">
		</div>

		{custom_list arr=$tplData.customRows}

		<button type="button" id="search_go" class="btn btn-primary">搜索</button>
	</form>

	{foreach $tplData.articleRows as $value}
		<h3><a href="{$value.article_url}" target="_blank">{$value.article_title}</a></h3>
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

	{if $tplData.search.key || $tplData.search.customs}
		{include "include/page.tpl" cfg=$cfg}
	{/if}

{include "include/pub_foot.tpl" cfg=$cfg}
	<script type="text/javascript">
   	$(document).ready(function(){
		$("#search_go").click(function(){
			var _str_customs     = "";
			var _key             = $("#key").val();
			var _customs         = $(".customs").serialize();
			window.location.href = "{$tplData.search.urlRow.search_url}key-" + encodeURIComponent(_key) + "/customs-" + encodeURIComponent(Base64.encode(_customs));
		});
	})
	</script>
{include "include/html_foot.tpl"}
