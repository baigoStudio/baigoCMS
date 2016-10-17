    <ul role="{$tplData.callRow.call_name}">
        {foreach $tplData.cateRows as $key=>$value}
            <li>
                <a href="{$value.urlRow.cate_url}">{$value.cate_name}</a>
            </li>
        {/foreach}
    </ul>