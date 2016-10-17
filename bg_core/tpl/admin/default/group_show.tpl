{$cfg = [
    title          => "{$adminMod.group.main.title} - {$lang.page.show}",
    menu_active    => "group",
    sub_active     => "list"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=list">{$adminMod.group.main.title}</a></li>
    <li>{$lang.page.show}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.groupName}</label>
                        <p class="form-control-static input-lg">{$tplData.groupRow.group_name}</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.groupAllow}</label>
                        <dl class="list_dl">
                            {foreach $adminMod as $key_m=>$value_m}
                                <dt>{$value_m.main.title}</dt>
                                <dd>
                                    <ul class="list-inline">
                                        {foreach $value_m.allow as $key_s=>$value_s}
                                            <li>
                                                <span class="glyphicon glyphicon-{if isset($tplData.groupRow.group_allow[$key_m][$key_s])}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
                                                {$value_s}
                                            </li>
                                        {/foreach}
                                    </ul>
                                </dd>
                            {/foreach}

                            <dt>{$lang.label.opt}</dt>
                            <dd>
                                <ul class="list-inline">
                                    <li>
                                        <span class="glyphicon glyphicon-{if isset($tplData.groupRow.group_allow.opt.custom)}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
                                        {$lang.page.custom}
                                    </li>
                                    <li>
                                        <span class="glyphicon glyphicon-{if isset($tplData.groupRow.group_allow.opt.app)}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
                                        {$lang.page.app}
                                    </li>
                                    <li>
                                        <span class="glyphicon glyphicon-{if isset($tplData.groupRow.group_allow.opt.chkver)}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
                                        {$lang.page.chkver}
                                    </li>
                                    <li>
                                        <span class="glyphicon glyphicon-{if isset($tplData.groupRow.group_allow.opt.dbconfig)}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
                                        {$lang.page.installDbConfig}
                                    </li>
                                    {foreach $opt as $key_s=>$value_s}
                                        <li>
                                            <span class="glyphicon glyphicon-{if isset($tplData.groupRow.group_allow.opt[$key_s])}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
                                            {$value_s.title}
                                        </li>
                                    {/foreach}
                                </ul>
                            </dd>
                        </dl>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.groupNote}</label>
                        <p class="form-control-static input-lg">{$tplData.groupRow.group_note}</p>
                    </div>

                    <div class="form-group">
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=form&group_id={$tplData.groupRow.group_id}">
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
                    <p class="form-control-static">{$tplData.groupRow.group_id}</p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.groupType}</label>
                    <p class="form-control-static">{$type.group[$tplData.groupRow.group_type]}</p>
                </div>

                <div class="form-group">
                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=form&group_id={$tplData.groupRow.group_id}">
                        <span class="glyphicon glyphicon-edit"></span>
                        {$lang.href.edit}
                    </a>
                </div>
            </div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}
{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}