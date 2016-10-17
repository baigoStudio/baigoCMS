{$cfg = [
    title          => $adminMod.call.main.title,
    menu_active    => "call",
    sub_active     => "list",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=list&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li>{$adminMod.call.main.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            {$lang.href.add}
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=call" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="call_search" id="call_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="call">
                <input type="hidden" name="act_get" value="list">
                <div class="form-group">
                    <select name="type" class="form-control input-sm">
                        <option value="">{$lang.option.allType}</option>
                        {foreach $type.call as $key=>$value}
                            <option {if $tplData.search.type == $key}selected{/if} value="{$key}">{$value}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="form-group">
                    <select name="status" class="form-control input-sm">
                        <option value="">{$lang.option.allStatus}</option>
                        {foreach $status.call as $key=>$value}
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

    {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static"}
        <div class="form-group">
            <button data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=call&act_get=1by1" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gen_modal">
                <span class="glyphicon glyphicon-refresh"></span>
                {$lang.btn.callGen1by1}
            </button>
        </div>
    {/if}

    <form name="call_list" id="call_list" class="form-inline">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">

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
                            <th>{$lang.label.callName}</th>
                            <th class="text-nowrap td_sm">{$lang.label.status} / {$lang.label.type}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $tplData.callRows as $key=>$value}
                            {if $value.call_status == "enable"}
                                {$css_status = "success"}
                            {else}
                                {$css_status = "default"}
                            {/if}
                            <tr>
                                <td class="text-nowrap td_mn"><input type="checkbox" name="call_ids[]" value="{$value.call_id}" id="call_id_{$value.call_id}" data-parent="chk_all" data-validate="call_id"></td>
                                <td class="text-nowrap td_mn">{$value.call_id}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>{$value.call_name}</li>
                                        <li>
                                            <ul class="list_menu">
                                                <li>
                                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=show&call_id={$value.call_id}">{$lang.href.show}</a>
                                                </li>
                                                <li>
                                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=form&call_id={$value.call_id}">{$lang.href.edit}</a>
                                                </li>
                                                {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static" && $value.call_status == "enable"}
                                                    <li>
                                                        <button type="button" class="btn btn-xs btn-info" data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=call&act_get=single&call_id={$value.call_id}" data-toggle="modal" data-target="#gen_modal">
                                                            <span class="glyphicon glyphicon-refresh"></span>
                                                            {$lang.btn.callGenSingle}
                                                        </button>
                                                    </li>
                                                {/if}
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap td_sm">
                                    <ul class="list-unstyled">
                                        <li class="label_baigo">
                                            <span class="label label-{$css_status}">{$status.call[$value.call_status]}</span>
                                        </li>
                                        <li>{$type.call[$value.call_type]}</li>
                                    </ul>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_call_id"></span></td>
                            <td colspan="2">
                                <div class="form-group">
                                    <div id="group_act_post">
                                        <select name="act_post" id="act_post" data-validate class="form-control input-sm">
                                            <option value="">{$lang.option.batch}</option>
                                            {foreach $status.call as $key=>$value}
                                                <option value="{$key}">{$value}</option>
                                            {/foreach}
                                            <option value="del">{$lang.option.del}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.submit}</button>
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

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_list = {
        call_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='call_id']", type: "checkbox" },
            msg: { selector: "#msg_call_id", too_few: "{$alert.x030202}" }
        },
        act_post: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act_post" },
            msg: { selector: "#msg_act_post", too_few: "{$alert.x030203}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=call",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        var obj_validate_list = $("#call_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#call_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#call_list").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}