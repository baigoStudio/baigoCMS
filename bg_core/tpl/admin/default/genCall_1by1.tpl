{$cfg = [
    title  => $lang.page.gening
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_head.tpl" cfg=$cfg}
    {if $tplData.status == "complete"}
        {if $tplData.overall == "true"}
            <meta http-equiv="refresh" content="0; url={$smarty.const.BG_URL_ADMIN}gen.php?mod=spec&act_get=1by1&overall=true">
        {else}
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok-circle"></span>
                {$alert.y170403}
            </div>
        {/if}
    {else if $tplData.status == "without"}
        <div class="alert alert-warning">
            <h4>{$lang.label.call} {$tplData.callRow.call_name}</h4>
            <hr>
            <div>{$lang.label.id} {$tplData.callRow.call_id}</div>
            <span class="glyphicon glyphicon-warning-sign"></span>
            {$alert.x170404}
        </div>
    {else}
        <div class="alert alert-info">
            <h4>{$lang.label.call} {$tplData.callRow.call_name}</h4>
            <hr>
            <div>{$lang.label.id} {$tplData.callRow.call_id}</div>
        </div>
    {/if}

    {if $tplData.status != "complete"}
        <meta http-equiv="refresh" content="0; url={$smarty.const.BG_URL_ADMIN}gen.php?mod=call&act_get=1by1&min_id={$tplData.min_id}&overall={$tplData.overall}">
    {/if}
{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
