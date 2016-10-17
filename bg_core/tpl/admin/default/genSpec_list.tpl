{$cfg = [
    title  => $lang.page.gening
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_head.tpl" cfg=$cfg}
    {if $tplData.status == "complete"}
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok-circle"></span>
            {$alert.y180403}
        </div>
    {else}
        <div class="alert alert-info">
            <h4>{$lang.label.spec}</h4>
            <hr>
            <div>{$lang.label.pageCount} {$tplData.pageRow.page} {$lang.label.pagePage}</div>
        </div>
    {/if}

    {if $tplData.status == "loading"}
        <meta http-equiv="refresh" content="1; url={$smarty.const.BG_URL_ADMIN}gen.php?mod=spec&act_get=list&page={$tplData.pageRow.page + 1}">
    {/if}
{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
