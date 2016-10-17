{$cfg = [
    title          => $lang.page.prefer,
    menu_active    => "profile",
    sub_active     => "prefer",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=profile&act_get=prefer"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=profile">{$lang.page.profile}</a></li>
    <li>{$lang.page.prefer}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <form name="profile_form" id="profile_form">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="prefer">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">{$lang.label.username}</label>
                            <input type="text" name="admin_name" id="admin_name" class="form-control" readonly value="{$tplData.ssoRow.user_name}">
                        </div>

                        {foreach $tplData.prefer as $key=>$value}
                            <h3>{$value.title}</h3>
                            {foreach $value.list as $key_s=>$value_s}
                                <div class="form-group">
                                    <div id="group_prefer_{$key}_{$key_s}">
                                        <label class="control-label">{$value_s.label}<span id="msg_prefer_{$key}_{$key_s}"></span></label>
                                        {if $value_s.type == "select"}
                                            <select name="prefer[{$key}][{$key_s}]" id="prefer_{$key}_{$key_s}" data-validate="prefer_{$key}_{$key_s}" class="form-control">
                                                {foreach $value_s.option as $key_opt=>$value_opt}
                                                    <option {if $value_s.default == $key_opt}selected{/if} value="{$key_opt}">{$value_opt}</option>
                                                {/foreach}
                                            </select>
                                        {else if $value_s.type == "radio"}
                                            <div>
                                                {foreach $value_s.option as $key_opt=>$value_opt}
                                                    <div class="radio-inline">
                                                        <label for="prefer_{$key}_{$key_s}_{$key_opt}">
                                                            <input type="radio" {if $value_s.default == $key_opt}checked{/if} value="{$key_opt}" data-validate="prefer_{$key}_{$key_s}" name="prefer[{$key}][{$key_s}]" id="prefer_{$key}_{$key_s}_{$key_opt}">
                                                            {$value_opt.value}
                                                        </label>
                                                    </div>
                                                    {if isset($value_opt.note)}<p class="help-block">{$value_opt.note}</p>{/if}
                                                {/foreach}
                                            </div>
                                        {else if $value_s.type == "textarea"}
                                            <textarea name="prefer[{$key}][{$key_s}]" id="prefer_{$key}_{$key_s}" data-validate="prefer_{$key}_{$key_s}" class="form-control text_md">{$value_s.default}</textarea>
                                        {else}
                                            <input type="text" value="{$value_s.default}" name="prefer[{$key}][{$key_s}]" id="prefer_{$key}_{$key_s}" data-validate="prefer_{$key}_{$key_s}" class="form-control">
                                        {/if}

                                        {if isset($value_s.note)}<p class="help-block">{$value_s.note}</p>{/if}
                                    </div>
                                </div>
                            {/foreach}
                        {/foreach}

                        <div class="form-group">
                            <button type="button" id="go_submit" class="btn btn-primary">{$lang.btn.save}</button>
                        </div>
                    </div>
                </div>
            </div>

            {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/profile_left.tpl" cfg=$cfg}
        </div>

    </form>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_form = {
        {foreach $tplData.prefer as $key=>$value}
            {foreach $value.list as $key_s=>$value_s}
                {if $value_s.type == "str" || $value_s.type == "textarea"}
                    {$str_msg_min = "too_short"}
                    {$str_msg_max = "too_long"}
                {else}
                    {$str_msg_min = "too_few"}
                    {$str_msg_max = "too_many"}
                {/if}
                "prefer_{$key}_{$key_s}": {
                    len: { min: {$value_s.min}, max: 900 },
                    validate: { selector: "[data-validate='prefer_{$key}_{$key_s}']", type: "{$value_s.type}", {if isset($value_s.format)}format: "{$value_s.format}", {/if}group: "#group_prefer_{$key}_{$key_s}" },
                    msg: { selector: "#msg_prefer_{$key}_{$key_s}", {$str_msg_min}: "{$alert.x060201}{$value_s.label}", {$str_msg_max}: "{$value_s.label}{$alert.x060202}", format_err: "{$value_s.label}{$alert.x060203}" }
                }{if !$value@last || !$value_s@last},{/if}
            {/foreach}
        {/foreach}
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=profile",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        var obj_validate_form = $("#profile_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#profile_form").baigoSubmit(opts_submit_form);
        $("#go_submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}