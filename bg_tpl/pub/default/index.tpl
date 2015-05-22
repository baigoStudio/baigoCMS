{* index.tpl 首页 *}
{$cfg = [
	title => "首页"
]}

{include "include/pub_head.tpl" cfg=$cfg}

	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="{$smarty.const.BG_URL_STATIC_PUB}{$smarty.const.BG_SITE_TPL}/image/index_slide_1.jpg">
			</div>
			<div class="item">
				<img src="{$smarty.const.BG_URL_STATIC_PUB}{$smarty.const.BG_SITE_TPL}/image/index_slide_2.jpg">
			</div>
		</div>

		<!-- Controls -->
		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	{call_display call_id=7}

	{foreach $callRows.7 as $_key=>$_value}
		<p>{$_key}</p>
	{/foreach}

{include "include/pub_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl"}
