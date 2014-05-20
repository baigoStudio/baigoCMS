{* html_foot.tpl HTML 底部通用 *}
	<ul id="page_global" class="page_global">

		<li id="page_first" class="page_first">

		{if $tplData.pageRow.page > 1}
			<a href="{$cfg.str_url}&page=1" title="{$lang.href.pageFirst}">{$lang.href.pageFirst}</a>
		{else}
			<strong>{$lang.href.pageFirst}</strong>
		{/if}

		</li>

		<li id="page_pre_ten" class="page_pre_ten">

		{if $tplData.pageRow.p * 10 > 0}
			<a href="{$cfg.str_url}&page={$tplData.pageRow.p * 10}" title="{$lang.href.pagePreList}">{$lang.href.pagePreList}</a>
		{else}
			<strong>{$lang.href.pagePreList}</strong>
		{/if}

		</li>

		<li id="page_pre" class="page_pre">

		{if $tplData.pageRow.page > 1}
			<a href="{$cfg.str_url}&page={$tplData.pageRow.page - 1}" title="{$lang.href.pagePre}">{$lang.href.pagePre}</a>
		{else}
			<strong>{$lang.href.pagePre}</strong>
		{/if}

		</li>

		{for $_iii = $tplData.pageRow.begin to $tplData.pageRow.end}
			<li id="page_list_{$_iii}" class="page_list">

			{if $_iii == $tplData.pageRow.page}
				<strong>{$_iii}</strong>
			{else}
				<a href="{$cfg.str_url}&page={$_iii}" title="{$_iii}">{$_iii}</a>
			{/if}

			</li>
		{/for}

		<li id="page_next" class="page_next">

		{if $tplData.pageRow.page >= $tplData.pageRow.total}
			<strong>{$lang.href.pageNext}</strong>
		{else}
			<a href="{$cfg.str_url}&page={$tplData.pageRow.page + 1}" title="{$lang.href.pageNext}">{$lang.href.pageNext}</a>
		{/if}

		</li>

		<li id="page_next_ten" class="page_next_ten">

		{if $_iii < $tplData.pageRow.total}
			<a href="{$cfg.str_url}&page={$_iii}" title="{$lang.href.pageNextList}">{$lang.href.pageNextList}</a>
		{else}
			<strong>{$lang.href.pageNextList}</strong>
		{/if}

		</li>

		<li id="page_last" class="page_last">

		{if $tplData.pageRow.page >= $tplData.pageRow.total}
			<strong>{$lang.href.pageLast}</strong>
		{else}
			<a href="{$cfg.str_url}&page={$tplData.pageRow.total}" title="{$lang.href.pageLast}">{$lang.href.pageLast}</a>
		{/if}

		</li>
		<li class="page_clear"></li>

	</ul>
