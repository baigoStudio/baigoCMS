{* pub_foot.tpl 前台底部 *}

</div>

<div class="page_foot">
	<ul>
		<li>&copy; {$smarty.now|date_format:"%Y"} Copyright baigo Studio / <a href="http://www.baigo.net" target="_blank">www.baigo.net</a></li>
	</ul>
</div>

<ul class="global_foot">
	<li class="foot_copy">
		{$smarty.const.PRD_CMS_POWERED}
		<a href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.PRD_CMS_NAME}</a>
		{$smarty.const.PRD_CMS_VER}
	</li>
</ul>

