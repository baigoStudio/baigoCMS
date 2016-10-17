{$cfg = [
    title  => $lang.page.gening
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_head.tpl" cfg=$cfg}
    {if $tplData.status == "complete"}
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok-circle"></span>
            {$alert.y120403}
        </div>
    {else}
        <div class="alert alert-info">
            <h4>{$lang.label.article} {$tplData.articleRow.article_title}</h4>
            <hr>
            <div>{$lang.label.id} {$tplData.articleRow.article_id}</div>
        </div>
    {/if}
{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
