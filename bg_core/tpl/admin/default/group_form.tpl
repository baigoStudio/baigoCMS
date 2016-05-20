{* admin_groupForm.tpl 管理组编辑界面 *}
{if $tplData.groupRow.group_id < 1}
    {$title_sub = $lang.page.add}
    {$sub_active = "form"}
{else}
    {$title_sub = $lang.page.edit}
    {$sub_active = "list"}
{/if}

{$cfg = [
    title          => "{$adminMod.group.main.title} - {$title_sub}",
    menu_active    => "group",
    sub_active     => $sub_active,
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=list">{$adminMod.group.main.title}</a></li>
    <li>{$title_sub}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=group#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="group_form" id="group_form">
        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
        <input type="hidden" name="act_post" value="submit">
        <input type="hidden" name="group_id" id="group_id" value="{$tplData.groupRow.group_id}">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_group_name">
                                <label class="control-label">{$lang.label.groupName}<span id="msg_group_name">*</span></label>
                                <input type="text" name="group_name" id="group_name" value="{$tplData.groupRow.group_name}" data-validate class="form-control">
                            </div>
                        </div>

                        <div id="groupAdmin" class="form-group">
                            <label class="control-label">{$lang.label.groupAllow}<span id="msg_group_allow">*</span></label>
                            <dl class="list_dl">
                                <dd>
                                    <div class="checkbox_baigo">
                                        <label for="chk_all">
                                            <input type="checkbox" id="chk_all" data-parent="first">
                                            {$lang.label.all}
                                        </label>
                                    </div>
                                </dd>

                                {foreach $adminMod as $key_m=>$value_m}
                                    <dt>{$value_m.main.title}</dt>
                                    <dd>
                                        <label for="allow_{$key_m}" class="checkbox-inline">
                                            <input type="checkbox" id="allow_{$key_m}" data-parent="chk_all">
                                            {$lang.label.all}
                                        </label>
                                        {foreach $value_m.allow as $key_s=>$value_s}
                                            <label for="allow_{$key_m}_{$key_s}" class="checkbox-inline">
                                                <input type="checkbox" name="group_allow[{$key_m}][{$key_s}]" value="1" id="allow_{$key_m}_{$key_s}" {if isset($tplData.groupRow.group_allow[$key_m][$key_s])}checked{/if} data-parent="allow_{$key_m}">
                                                {$value_s}
                                            </label>
                                        {/foreach}
                                    </dd>
                                {/foreach}

                                <dt>{$lang.label.opt}</dt>
                                <dd>
                                    <label for="allow_opt" class="checkbox-inline">
                                        <input type="checkbox" id="allow_opt" data-parent="chk_all">
                                        {$lang.label.all}
                                    </label>
                                    <label for="allow_opt_custom" class="checkbox-inline">
                                        <input type="checkbox" name="group_allow[opt][custom]" value="1" id="allow_opt_custom" data-parent="allow_opt" {if isset($tplData.groupRow.group_allow.opt.custom)}checked{/if}>
                                        {$lang.page.custom}
                                    </label>
                                    <label for="allow_opt_app" class="checkbox-inline">
                                        <input type="checkbox" name="group_allow[opt][app]" value="1" id="allow_opt_app" data-parent="allow_opt" {if isset($tplData.groupRow.group_allow.opt.app)}checked{/if}>
                                        {$lang.page.app}
                                    </label>
                                    <label for="allow_opt_dbconfig" class="checkbox-inline">
                                        <input type="checkbox" name="group_allow[opt][dbconfig]" value="1" id="allow_opt_dbconfig" data-parent="allow_opt" {if isset($tplData.groupRow.group_allow.opt.dbconfig)}checked{/if}>
                                        {$lang.page.installDbConfig}
                                    </label>
                                    {foreach $opt as $key_s=>$value_s}
                                        <label for="allow_opt_{$key_s}" class="checkbox-inline">
                                            <input type="checkbox" name="group_allow[opt][{$key_s}]" value="1" id="allow_opt_{$key_s}" data-parent="allow_opt" {if isset($tplData.groupRow.group_allow.opt[$key_s])}checked{/if}>
                                            {$value_s.title}
                                        </label>
                                    {/foreach}
                                </dd>
                            </dl>
                        </div>

                        <div id="groupUser" class="form-group">
                            <label class="control-label">{$lang.label.none}</label>
                        </div>

                        <div class="form-group">
                            <div id="group_group_note">
                                <label class="control-label">{$lang.label.groupNote}<span id="msg_group_note">*</span></label>
                                <input type="text" name="group_note" id="group_note" value="{$tplData.groupRow.group_note}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="go_submit btn btn-primary">{$lang.btn.submit}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    {if $tplData.groupRow.group_id > 0}
                        <div class="form-group">
                            <label class="control-label">{$lang.label.id}</label>
                            <p class="form-control-static">{$tplData.groupRow.group_id}</p>
                        </div>
                    {/if}

                    <div class="form-group">
                        <div id="group_group_type">
                            <label class="control-label">{$lang.label.groupType}<span id="msg_group_type">*</span></label>
                            {foreach $type.group as $key=>$value}
                                <div class="radio_baigo">
                                    <label for="group_type_{$key}">
                                        <input type="radio" name="group_type" id="group_type_{$key}" {if $tplData.groupRow.group_type == $key}checked{/if} value="{$key}" data-validate="group_type">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_group_status">
                            <label class="control-label">{$lang.label.status}<span id="msg_group_status">*</span></label>
                            {foreach $status.group as $key=>$value}
                                <div class="radio_baigo">
                                    <label for="group_status_{$key}">
                                        <input type="radio" name="group_status" id="group_status_{$key}" {if $tplData.groupRow.group_status == $key}checked{/if} value="{$key}" data-validate="group_status">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_form = {
        group_name: {
            len: { min: 1, max: 30 },
            validate: { type: "ajax", format: "text", group: "#group_group_name" },
            msg: { selector: "#msg_group_name", too_short: "{$alert.x040201}", too_long: "{$alert.x040202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
            ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=group&act_get=chkname", key: "group_name", type: "str", attach_selectors: ["#group_id"], attach_keys: ["group_id"] }
        },
        group_note: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_group_note" },
            msg: { selector: "#msg_group_note", too_long: "{$alert.x040204}" }
        },
        group_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='group_type']", type: "radio", group: "#group_group_type" },
            msg: { selector: "#msg_group_type", too_few: "{$alert.x040205}" }
        },
        group_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='group_status']", type: "radio", group: "#group_group_status" },
            msg: { selector: "#msg_group_status", too_few: "{$alert.x040207}" }
        }
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=group",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    function group_type(group_type) {
        switch (group_type) {
            case "admin":
                $("#groupAdmin").show();
                $("#groupUser").hide();
            break;

            default:
                $("#groupAdmin").hide();
                $("#groupUser").show();
            break;
        }
    }

    $(document).ready(function(){
        var obj_validate_form = $("#group_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#group_form").baigoSubmit(opts_submit_form);
        $(".go_submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        group_type("{$tplData.groupRow.group_type}");
        $("input[name='group_type']").click(function(){
            var _group_type = $("input[name='group_type']:checked").val();
            group_type(_group_type);
        });
        $("#group_form").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}

