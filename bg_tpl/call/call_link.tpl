    <ul role="{$tplData.callRow.call_name}">
        {foreach $tplData.linkRows as $key=>$value}
            <li>
                <a href="{$value.link_url}"{if $value.link_blank > 0} target="_blank"{/if}>{$value.link_name}</a>
            </li>
        {/foreach}
    </ul>