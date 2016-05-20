{* mime_list.php 允许上传类型列表 *}
{$cfg = [
    title          => "{$adminMod.attach.main.title} - {$adminMod.attach.sub.mime.title}",
    menu_active    => "attach",
    sub_active     => "mime",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mime&act_get=list"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=list">{$adminMod.attach.main.title}</a></li>
    <li>{$adminMod.attach.sub.mime.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mime&act_get=form&view=iframe" data-toggle="modal" data-target="#mime_modal">
                    <span class="glyphicon glyphicon-plus"></span>
                    {$lang.href.add}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=attach#mime" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="mime_list" id="mime_list">
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
                            <th>{$lang.label.mimeName}</th>
                            <th class="text-nowrap td_md">{$lang.label.ext} / {$lang.label.note}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $tplData.mimeRows as $key=>$value}
                            <tr>
                                <td class="text-nowrap td_mn"><input type="checkbox" name="mime_ids[]" value="{$value.mime_id}" id="mime_id_{$value.mime_id}" data-parent="chk_all" data-validate="mime_id"></td>
                                <td class="text-nowrap td_mn">{$value.mime_id}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>{$value.mime_name}</li>
                                        <li>
                                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mime&act_get=form&mime_id={$value.mime_id}&view=iframe" data-toggle="modal" data-target="#mime_modal">{$lang.href.edit}</a>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap td_md">
                                    <ul class="list-unstyled">
                                        <li>{$value.mime_ext}</li>
                                        <li>{$value.mime_note}</li>
                                    </ul>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_mime_id"></span></td>
                            <td colspan="2">
                                <input type="hidden" name="act_post" id="act_post" value="del">
                                <button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.del}</button>
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

    <div class="modal fade" id="mime_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_list = {
        mime_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='mime_id']", type: "checkbox" },
            msg: { selector: "#msg_mime_id", too_few: "{$alert.x030202}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        $("#mime_modal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
        var obj_validate_list   = $("#mime_list").baigoValidator(opts_validator_list);
        var obj_submit_list     = $("#mime_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#mime_list").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}

