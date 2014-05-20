{* page.tpl 分页菜单 *}
	<ul id="page_global" class="page_global">

		<li id="page_first" class="page_first">

		{if $tplData.pageRow.page > 1}
			<a href="{$cfg.str_url}1{$cfg.page_ext}" title="首页">首页</a>
		{else}
			<strong>首页</strong>
		{/if}

		</li>

		<li id="page_pre_ten" class="page_pre_ten">

		{if $tplData.pageRow.p * 10 > 0}
			<a href="{$cfg.str_url}{$tplData.pageRow.p * 10}{$cfg.page_ext}" title="上十页">上十页</a>
		{else}
			<strong>上十页</strong>
		{/if}

		</li>

		<li id="page_pre" class="page_pre">

		{if $tplData.pageRow.page > 1}
			<a href="{$cfg.str_url}{$tplData.pageRow.page - 1}{$cfg.page_ext}" title="上一页">上一页</a>
		{else}
			<strong>上一页</strong>
		{/if}

		</li>

		{for $_iii = $tplData.pageRow.begin to $tplData.pageRow.end}
			<li id="page_list_{$_iii}" class="page_list">

			{if $_iii == $tplData.pageRow.page}
				<strong>{$_iii}</strong>
			{else}
				<a href="{$cfg.str_url}{$_iii}{$cfg.page_ext}" title="{$_iii}">{$_iii}</a>
			{/if}

			</li>
		{/for}

		<li id="page_next" class="page_next">

		{if $tplData.pageRow.page >= $tplData.pageRow.total}
			<strong>下一页</strong>
		{else}
			<a href="{$cfg.str_url}{$tplData.pageRow.page + 1}{$cfg.page_ext}" title="下一页">下一页</a>
		{/if}

		</li>

		<li id="page_next_ten" class="page_next_ten">

		{if $_iii < $tplData.pageRow.total}
			<a href="{$cfg.str_url}{$_iii}{$cfg.page_ext}" title="下十页">下十页</a>
		{else}
			<strong>下十页</strong>
		{/if}

		</li>

		<li id="page_last" class="page_last">

		{if $tplData.pageRow.page >= $tplData.pageRow.total}
			<strong>末页</strong>
		{else}
			<a href="{$cfg.str_url}{$tplData.pageRow.total}{$cfg.page_ext}" title="末页">末页</a>
		{/if}

		</li>
		<li class="page_clear"></li>
	</ul>
