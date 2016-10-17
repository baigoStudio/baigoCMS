    <ul role="{$tplData.callRow.call_name}">
        {foreach $tplData.specRows as $key=>$value}
            <li>
                <a href="{$value.urlRow.spec_url}">{$value.spec_name}</a>
            </li>
        {/foreach}
    </ul>