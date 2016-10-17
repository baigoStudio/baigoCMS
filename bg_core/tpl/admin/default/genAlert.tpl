{$cfg = [
    title  => $lang.page.alert
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_head.tpl" cfg=$cfg}

    <div class="alert alert-{if $tplData.status == "y"}success{else}danger{/if}">
        <span class="glyphicon glyphicon-{if $tplData.status == "y"}ok-circle{else}remove-circle{/if}"></span>
        {if $tplData.alert && isset($alert[$tplData.alert])}
            {$alert[$tplData.alert]}
        {/if}
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
