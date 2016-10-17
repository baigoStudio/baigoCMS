{function cate_checkbox arr="" level=""}
    <ul class="list-unstyled{if $level > 0} list_padding{/if}">
        {foreach $arr as $key=>$value}
            <li>
                <span {if $value.cate_id|in_array:$tplData.callRow.call_cate_ids}class="text-primary"{/if}>
                    {if $value.cate_id|in_array:$tplData.callRow.call_cate_ids}
                        <span class="glyphicon glyphicon-ok-circle"></span>
                    {/if}
                    {$value.cate_name}
                </span>

                {if $value.cate_childs}
                    {cate_checkbox arr=$value.cate_childs level=$value.cate_level}
                {/if}
            </li>
        {/foreach}
    </ul>
{/function}

{function cate_radio arr="" level=""}
    <ul class="list-unstyled{if $level > 0} list_padding{/if}">
        {foreach $arr as $key=>$value}
            <li>
                <span {if $tplData.callRow.call_cate_id == $value.cate_id}class="text-primary"{/if}>
                    {if $tplData.callRow.call_cate_id == $value.cate_id}
                        <span class="glyphicon glyphicon-ok-circle"></span>
                    {/if}
                    {$value.cate_name}
                </span>

                {if $value.cate_id|in_array:$tplData.callRow.call_cate_excepts}
                    <span class="text-danger">
                        <span class="glyphicon glyphicon-remove-circle"></span>
                        {$lang.label.except}
                    </span>
                {/if}

                {if $value.cate_childs}
                    {cate_radio arr=$value.cate_childs level=$value.cate_level}
                {/if}
            </li>
        {/foreach}
    </ul>
{/function}

{$cfg = [
    title          => "{$adminMod.call.main.title} - {$lang.page.show}",
    menu_active    => "call",
    sub_active     => "list",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=list">{$adminMod.call.main.title}</a></li>
    <li>{$lang.page.show}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=call#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.callFunc}</label>
                        <p class="form-control-static input-lg">
                            <code>
                                {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static"}
                                    {if $tplData.callRow.call_file == "html"}
                                        &lt;!--#include virtual=&quot;{$tplData.callRow.urlRow.call_url}&quot; --&gt;
                                    {else}
                                        &lt;script src=&quot;{$tplData.callRow.urlRow.call_url}&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
                                    {/if}
                                {else}
                                    {ldelim}call_display call_id={$tplData.callRow.call_id}{rdelim}
                                {/if}
                            </code>
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.callName}</label>
                        <p class="form-control-static input-lg">{$tplData.callRow.call_name}</p>
                    </div>

                    {if $tplData.callRow.call_type == "cate"}
                        <div class="alert alert-success">{$lang.label.callFilter}</div>

                        <div class="form-group">
                            <label class="control-label static_label">{$lang.label.callCate}</label>
                            <p class="form-control-static">
                                <div {if $tplData.callRow.call_cate_id < 1}class="text-primary"{/if}>
                                    {if $tplData.callRow.call_cate_id < 1}
                                        <span class="glyphicon glyphicon-ok-circle"></span>
                                    {else}
                                        <span class="glyphicon glyphicon-remove-circle"></span>
                                    {/if}
                                    {$lang.label.cateAll}
                                </div>
                                {cate_radio arr=$tplData.cateRows}
                            </p>
                        </div>
                    {else if $tplData.callRow.call_type != "spec" && $tplData.callRow.call_type != "tag_list" && $tplData.callRow.call_type != "tag_rank"}
                        <div class="alert alert-success">{$lang.label.callFilter}</div>

                        <div class="form-group">
                            <label class="control-label static_label">{$lang.label.callCate}</label>
                            <p class="form-control-static">
                                {cate_checkbox arr=$tplData.cateRows}
                            </p>
                        </div>

                        <div class="form-group">
                            <label class="control-label static_label">{$lang.label.articleSpec}</label>
                            <p class="form-control-static">
                                {foreach $tplData.specRows as $key=>$value}
                                    <div class="text-primary">
                                        <span class="glyphicon glyphicon-ok-circle"></span>
                                        {$value.spec_name}
                                    </div>
                                {/foreach}
                            </p>
                        </div>

                        <div class="form-group">
                            <label class="control-label static_label">{$lang.label.callAttach}</label>
                            <p class="form-control-static input-lg">{$type.callAttach[$tplData.callRow.call_attach]}</p>
                        </div>

                        <div class="form-group">
                            <label class="control-label static_label">{$lang.label.callMark}</label>
                            <p class="form-control-static">
                                {foreach $tplData.markRows as $key=>$value}
                                    <div {if $value.mark_id|in_array:$tplData.callRow.call_mark_ids}class="text-primary"{/if}>
                                        {if $value.mark_id|in_array:$tplData.callRow.call_mark_ids}
                                            <span class="glyphicon glyphicon-ok-circle"></span>
                                        {/if}

                                        {$value.mark_name}
                                    </div>
                                {/foreach}
                            </p>
                        </div>
                    {/if}

                    <div class="form-group">
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=form&call_id={$tplData.callRow.call_id}">
                            <span class="glyphicon glyphicon-edit"></span>
                            {$lang.href.edit}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.id}</label>
                    <p class="form-control-static">{$tplData.callRow.call_id}</p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.callType}</label>
                    <p class="form-control-static">{$type.call[$tplData.callRow.call_type]}</p>
                </div>

                {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static"}
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.callFile}</label>
                        <p class="form-control-static">{$type.callFile[$tplData.callRow.call_file]}</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.callTpl}</label>
                        <p class="form-control-static">{$tplData.callRow.call_tpl}</p>
                    </div>
                {/if}

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.status}</label>
                    <p class="form-control-static">{$status.call[$tplData.callRow.call_status]}</p>
                </div>

                <div class="alert alert-success">{$lang.label.callAmount}</div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.callAmoutTop}</label>
                    <p class="form-control-static static_label">{$tplData.callRow.call_amount.top}</p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.callAmoutExcept}</label>
                    <p class="form-control-static">{$tplData.callRow.call_amount.except}</p>
                </div>

                <div class="form-group">
                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=form&call_id={$tplData.callRow.call_id}">
                        <span class="glyphicon glyphicon-edit"></span>
                        {$lang.href.edit}
                    </a>
                </div>
            </div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}
{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}