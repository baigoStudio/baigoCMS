	<ul class="pagination pagination-sm">
		{if $tplData.pageRow.page > 1}
			<li>
				<a href="{$cfg.str_url}1{$cfg.page_ext}" title="{$lang.href.pageFirst}">{$lang.href.pageFirst}</a>
			</li>
		{/if}

		{if $tplData.pageRow.p * 10 > 0}
			<li>
				<a href="{$cfg.str_url}{$tplData.pageRow.p * 10}{$cfg.page_ext}" title="{$lang.href.pagePrevList}">{$lang.href.pagePrevList}</a>
			</li>
		{/if}

		<li class="{if $tplData.pageRow.page <= 1}disabled{/if}">
			{if $tplData.pageRow.page <= 1}
				<span title="{$lang.href.pagePrev}">&laquo;</span>
			{else}
				<a href="{$cfg.str_url}{$tplData.pageRow.page - 1}{$cfg.page_ext}" title="{$lang.href.pagePrev}">&laquo;</a>
			{/if}
		</li>

		{for $_iii = $tplData.pageRow.begin to $tplData.pageRow.end}
			<li class="{if $_iii == $tplData.pageRow.page}active{/if}">
				{if $_iii == $tplData.pageRow.page}
					<span>{$_iii}</span>
				{else}
					<a href="{$cfg.str_url}{$_iii}{$cfg.page_ext}" title="{$_iii}">{$_iii}</a>
				{/if}
			</li>
		{/for}

		<li class="{if $tplData.pageRow.page >= $tplData.pageRow.total}disabled{/if}">
			{if $tplData.pageRow.page >= $tplData.pageRow.total}
				<span title="{$lang.href.pageNext}">&raquo;</span>
			{else}
				<a href="{$cfg.str_url}{$tplData.pageRow.page + 1}{$cfg.page_ext}" title="{$lang.href.pageNext}">&raquo;</a>
			{/if}
		</li>

		{if $tplData.pageRow.end < $tplData.pageRow.total}
			<li>
				<a href="{$cfg.str_url}{$_iii}{$cfg.page_ext}" title="{$lang.href.pageNextList}">{$lang.href.pageNextList}</a>
			</li>
		{/if}

		{if $tplData.pageRow.page < $tplData.pageRow.total}
			<li>
				<a href="{$cfg.str_url}{$tplData.pageRow.total}{$cfg.page_ext}" title="{$lang.href.pageLast}">{$lang.href.pageLast}</a>
			</li>
		{/if}
	</ul>
