{function cate_list arr="" level=""}
    <ul class="list-unstyled{if $level > 0} list_padding{/if}">
        {foreach $arr as $key=>$value}
            <li>
                <dl class="dl_baigo">
                    <dt>{$value.cate_name}</dt>
                    <dd>
                        <ul class="list-inline">
                            {foreach $lang.allow as $key_s=>$value_s}
                                <li>
                                    <span class="glyphicon glyphicon-{if isset($tplData.adminLogged.admin_allow_cate[$value.cate_id][$key_s]) || isset($tplData.adminLogged.groupRow.group_allow.article[$key_s])}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
                                    {$value_s}
                                </li>
                            {/foreach}
                        </ul>
                        {if $value.cate_childs}
                            {cate_list arr=$value.cate_childs level=$value.cate_level}
                        {/if}
                    </dd>
                </dl>
            </li>
        {/foreach}
    </ul>
{/function}

{$cfg = [
    title          => $lang.page.profile,
    menu_active    => "profile",
    sub_active     => "info",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=profile"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li>{$lang.page.profile}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <form name="profile_form" id="profile_form">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="info">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">{$lang.label.username}</label>
                            <input type="text" name="admin_name" id="admin_name" class="form-control" readonly value="{$tplData.ssoRow.user_name}">
                        </div>

                        <div class="form-group">
                            <div id="group_admin_mail">
                                <label class="control-label">{$lang.label.mail}<span id="msg_admin_mail"></span></label>
                                <input type="text" name="admin_mail" id="admin_mail" value="{$tplData.ssoRow.user_mail}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_admin_nick">
                                <label class="control-label">{$lang.label.nick}<span id="msg_admin_nick"></span></label>
                                <input type="text" name="admin_nick" id="admin_nick" value="{if $tplData.adminLogged.admin_nick}{$tplData.adminLogged.admin_nick}{else}{$tplData.ssoRow.user_nick}{/if}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" id="go_submit" class="btn btn-primary">{$lang.btn.save}</button>
                        </div>

                        <div class="form-group">
                            <label class="control-label">{$lang.label.cateAllow}</label>
                            {cate_list arr=$tplData.cateRows}
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
        admin_mail: {
            len: { min: 0, max: 0 },
            validate: { type: "ajax", format: "email", group: "#group_admin_mail" },
            msg: { selector: "#msg_admin_mail", too_short: "{$alert.x020207}", too_long: "{$alert.x020208}", format_err: "{$alert.x020209}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
            ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin&act_get=chkmail", key: "admin_mail", type: "str", attach_selectors: ["#admin_id"], attach_keys: ["admin_id"] }
        },
        admin_nick: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_admin_nick" },
            msg: { selector: "#msg_admin_nick", too_long: "{$alert.x020216}" }
        }
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