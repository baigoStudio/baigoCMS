{function page_process thisPage=""}{if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static"}{if $thisPage <= $smarty.const.BG_VISIT_PAGE}{$cfg.str_url}{$thisPage}{$cfg.page_ext}{else}{$cfg.str_urlMore}{$thisPage}{/if}{else}{$cfg.str_url}{$thisPage}{/if}{/function}

    <ul class="pagination pagination-sm">
        {if $tplData.pageRow.page > 1}
            <li>
                <a href="{$cfg.str_url}1{$cfg.page_ext}" title="{$lang.href.pageFirst}">{$lang.href.pageFirst}</a>
            </li>
        {/if}

        {if $tplData.pageRow.p * 10 > 0}
            <li>
                <a href="{page_process thisPage=$tplData.pageRow.p * 10}" title="{$lang.href.pagePrevList}">...</a>
            </li>
        {/if}

        <li class="{if $tplData.pageRow.page <= 1}disabled{/if}">
            {if $tplData.pageRow.page <= 1}
                <span title="{$lang.href.pagePrev}"><span class="glyphicon glyphicon-menu-left"></span></span>
            {else}
                <a href="{page_process thisPage=$tplData.pageRow.page - 1}" title="{$lang.href.pagePrev}"><span class="glyphicon glyphicon-menu-left"></span></a>
            {/if}
        </li>

        {for $iii = $tplData.pageRow.begin to $tplData.pageRow.end}
            <li class="{if $iii == $tplData.pageRow.page}active{/if}">
                {if $iii == $tplData.pageRow.page}
                    <span>{$iii}</span>
                {else}
                    <a href="{page_process thisPage=$iii}" title="{$iii}">{$iii}</a>
                {/if}
            </li>
        {/for}

        <li class="{if $tplData.pageRow.page >= $tplData.pageRow.total}disabled{/if}">
            {if $tplData.pageRow.page >= $tplData.pageRow.total}
                <span title="{$lang.href.pageNext}"><span class="glyphicon glyphicon-menu-right"></span></span>
            {else}
                <a href="{page_process thisPage=$tplData.pageRow.page + 1}" title="{$lang.href.pageNext}"><span class="glyphicon glyphicon-menu-right"></span></a>
            {/if}
        </li>

        {if $tplData.pageRow.end < $tplData.pageRow.total}
            <li>
                <a href="{page_process thisPage=$iii}" title="{$lang.href.pageNextList}">...</a>
            </li>
        {/if}

        {if $tplData.pageRow.page < $tplData.pageRow.total}
            <li>
                <a href="{page_process thisPage=$tplData.pageRow.total}" title="{$lang.href.pageLast}">{$lang.href.pageLast}</a>
            </li>
        {/if}

        {if isset($cfg.is_static)}
            <li>
                <a href="{$cfg.str_urlMore}{$tplData.pageRow.total + 1}" title="{$lang.href.more}">{$lang.href.more}</a>
            </li>
        {/if}
    </ul>
