    <ul role="{$tplData.callRow.call_name}">
        {foreach $tplData.articleRows as $key=>$value}
            <li>
                <a href="{$value.urlRow.article_url}">{$value.article_title}</a>
            </li>
        {/foreach}
    </ul>