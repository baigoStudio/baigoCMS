{* admin_list.tpl 管理员列表 *}
{$cfg = [
    title          => $adminMod.admin.main.title,
    menu_active    => "admin",
    sub_active     => "list",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=list&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li>{$adminMod.admin.main.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            {$lang.href.add}
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=auth">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            {$lang.href.auth}
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=admin" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pull-right">
            <form name="admin_search" id="admin_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="admin">
                <input type="hidden" name="act_get" value="list">
                <div class="form-group">
                    <select name="status" class="form-control input-sm">
                        <option value="">{$lang.option.allStatus}</option>
                        {foreach $status.admin as $key=>$value}
                            <option {if $tplData.search.status == $key}selected{/if} value="{$key}">{$value}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <input type="text" name="key" class="form-control" value="{$tplData.search.key}" placeholder="{$lang.label.key}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>

    <form name="admin_list" id="admin_list" class="form-inline">
        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap td_mn">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    {$lang.label.all}
                                </label>
                            </th>
                            <th class="text-nowrap td_mn">{$lang.label.id}</th>
                            <th>{$lang.label.admin}</th>
                            <th class="text-nowrap td_md">{$lang.label.adminGroup} / {$lang.label.note}</th>
                            <th class="text-nowrap td_sm">{$lang.label.status}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $tplData.adminRows as $key=>$value}
                            {if $value.admin_status == "enable"}
                                {$css_status = "success"}
                            {else}
                                {$css_status = "default"}
                            {/if}
                            <tr>
                                <td class="text-nowrap td_mn"><input type="checkbox" name="admin_ids[]" value="{$value.admin_id}" id="admin_id_{$value.admin_id}" data-parent="chk_all" data-validate="admin_id"></td>
                                <td class="text-nowrap td_mn">{$value.admin_id}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>
                                            {if $value.admin_name}
                                                {$value.admin_name}
                                                {if $value.admin_nick}
                                                    [ {$value.admin_nick} ]
                                                {/if}
                                            {else}
                                                {$lang.label.adminUnknow}
                                            {/if}
                                        </li>
                                        <li>
                                            <ul class="list_menu">
                                                {if $value.admin_name}
                                                    <li>
                                                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=show&admin_id={$value.admin_id}">{$lang.href.show}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=form&admin_id={$value.admin_id}">{$lang.href.edit}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=toGroup&admin_id={$value.admin_id}&view=iframe" data-toggle="modal" data-target="#group_modal">{$lang.href.toGroup}</a>
                                                    </li>
                                                {else}
                                                    <li>
                                                        {$lang.href.show}
                                                    </li>
                                                    <li>
                                                        {$lang.href.edit}
                                                    </li>
                                                    <li>
                                                        {$lang.href.toGroup}
                                                    </li>
                                                {/if}
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap td_md">
                                    <ul class="list-unstyled">
                                        <li>
                                            {if isset($value.groupRow.group_name)}
                                                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=list&group_id={$value.admin_group_id}">{$value.groupRow.group_name}</a>
                                            {else}
                                                {$lang.label.none}
                                            {/if}
                                        </li>
                                        <li>{$value.admin_note}</li>
                                    </ul>
                                </td>
                                <td class="td_sm label_baigo">
                                    <span class="label label-{$css_status}">{$status.admin[$value.admin_status]}</span>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_admin_id"></span></td>
                            <td colspan="3">
                                <div class="form-group">
                                    <div id="group_act_post">
                                        <select name="act_post" id="act_post" data-validate class="form-control input-sm">
                                            <option value="">{$lang.option.batch}</option>
                                            {foreach $status.admin as $key=>$value}
                                                <option value="{$key}">{$value}</option>
                                            {/foreach}
                                            <option value="del">{$lang.option.del}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="go_submit" class="btn btn-default btn-sm">{$lang.btn.submit}</button>
                                </div>
                                <div class="form-group">
                                    <span id="msg_act_post"></span>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </form>

    <div class="text-right">
        {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/page.tpl" cfg=$cfg}
    </div>

    <div class="modal fade" id="group_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_list = {
        admin_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='admin_id']", type: "checkbox" },
            msg: { selector: "#msg_admin_id", too_few: "{$alert.x030202}" }
        },
        act_post: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act_post" },
            msg: { selector: "#msg_act_post", too_few: "{$alert.x030203}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        $("#group_modal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
        var obj_validate_list = $("#admin_list").baigoValidator(opts_validator_list);
        var obj_submit_list = $("#admin_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#admin_list").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
