{$cfg = [
    title  => "提示信息"
]}

{include "include/pub_head.tpl" cfg=$cfg}

    <div class="page-header">
        <h1>
            {$lang.page.rcode}
        </h1>
    </div>

    <div class="alert alert-{if $tplData.status == "y"}success{else}danger{/if}">
        <h3>
            <span class="glyphicon glyphicon-{if $tplData.status == "y"}ok-sign{else}remove-sign{/if}"></span>
            {$rcode[$tplData.rcode]}
        </h3>

        <p>
            <a href="javascript:history.go(-1);">
                <span class="glyphicon glyphicon-chevron-left"></span>
                返回
            </a>
        </p>
        <hr>
        <p>
            提示信息 : {$tplData.alert}
        </p>
    </div>
</div>

{include "include/pub_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl"}