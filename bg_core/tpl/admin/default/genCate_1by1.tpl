{$cfg = [
    title  => $lang.page.gening
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_head.tpl" cfg=$cfg}
    {if $tplData.status == "complete"}
        {if $tplData.overall == "true"}
            <meta http-equiv="refresh" content="0; url={$smarty.const.BG_URL_ADMIN}gen.php?mod=call&act_get=1by1&overall=true">
        {else}
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok-circle"></span>
                {$alert.y110403}
            </div>
        {/if}
    {else if $tplData.status == "without"}
        <div class="alert alert-warning">
            <h4>{$lang.label.cate} {$tplData.cateRow.cate_name}</h4>
            <hr>
            <div>{$lang.label.id} {$tplData.cateRow.cate_id}</div>
            <span class="glyphicon glyphicon-warning-sign"></span>
            {$alert.x110404}
        </div>
    {else}
        <div class="alert alert-info">
            <h4>{$lang.label.cate} {$tplData.cateRow.cate_name}</h4>
            <hr>
            <div>{$lang.label.id} {$tplData.cateRow.cate_id}</div>
            <div>{$lang.label.pageCount} {$tplData.pageRow.page} {$lang.label.pagePage}</div>
        </div>
    {/if}

    {if $tplData.status == "loading"}
        {$num_page = $tplData.pageRow.page + 1}
    {else}
        {$num_page = 1}
    {/if}
    {if $tplData.status != "complete"}
        <meta http-equiv="refresh" content="0; url={$smarty.const.BG_URL_ADMIN}gen.php?mod=cate&act_get=1by1&min_id={$tplData.min_id}&page={$num_page}&overall={$tplData.overall}">
    {/if}
{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
