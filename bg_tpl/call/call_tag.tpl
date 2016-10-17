    <ul role="{$tplData.callRow.call_name}">
        {foreach $tplData.tagRows as $key=>$value}
            <li>
                <a href="{$value.urlRow.tag_url}">{$value.tag_name}</a>
            </li>
        {/foreach}
    </ul>