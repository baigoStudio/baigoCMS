{$cfg = [
    title  => $lang.page.gening
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_head.tpl" cfg=$cfg}
    {if $tplData.status == "complete"}
        {if $tplData.overall == "true"}
            <meta http-equiv="refresh" content="0; url={$smarty.const.BG_URL_ADMIN}gen.php?mod=spec&act_get=list">
        {else}
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok-circle"></span>
                {$alert.y180403}
            </div>
        {/if}
    {else if $tplData.status == "without"}
        <div class="alert alert-warning">
            <h4>{$lang.label.spec} {$tplData.specRow.spec_name}</h4>
            <hr>
            <div>{$lang.label.id} {$tplData.specRow.spec_id}</div>
            <span class="glyphicon glyphicon-warning-sign"></span>
            {$alert.x180404}
        </div>
    {else}
        <div class="alert alert-info">
            <h4>{$lang.label.spec} {$tplData.specRow.spec_name}</h4>
            <hr>
            <div>{$lang.label.id} {$tplData.specRow.spec_id}</div>
            <div>{$lang.label.pageCount} {$tplData.pageRow.page} {$lang.label.pagePage}</div>
        </div>
    {/if}

    {if $tplData.status == "loading"}
        {$num_page = $tplData.pageRow.page + 1}
    {else}
        {$num_page = 1}
    {/if}
    {if $tplData.status != "complete"}
        <meta http-equiv="refresh" content="0; url={$smarty.const.BG_URL_ADMIN}gen.php?mod=spec&act_get=1by1&max_id={$tplData.max_id}&page={$num_page}&overall={$tplData.overall}&overall={$tplData.overall}">
    {/if}
{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
