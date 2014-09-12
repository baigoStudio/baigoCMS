{* index.tpl 首页 *}
{$cfg = [
	baigoSlider    => "true",
	css            => "index"
]}

{include "include/pub_head.tpl" cfg=$cfg}

	{call_display call_id=2}

	<ul class="body_products" id="baigoSlider">
		{for $_iii = 1 to 2}
			<li id="slider_{$_iii}"><a href="#"><img src="{$smarty.const.BG_URL_STATIC_PUB}default/image/products_cms_{$_iii}.jpg"></a></li>
		{/for}
	</ul>

{include "include/pub_foot.tpl" cfg=$cfg}

<script type="text/javascript">
$(document).ready(function(){
	$("#baigoSlider").baigoSlider({ width: 700, height: 700 });
});
</script>

{include "include/html_foot.tpl"}
