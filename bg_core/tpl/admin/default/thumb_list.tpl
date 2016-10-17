{$cfg = [
    title          => "{$adminMod.attach.main.title} - {$adminMod.attach.sub.thumb.title}",
    menu_active    => "attach",
    sub_active     => "thumb",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    baigoClear     => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=list"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=list">{$adminMod.attach.main.title}</a></li>
    <li>{$adminMod.attach.sub.thumb.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=form&view=iframe" data-toggle="modal" data-target="#thumb_modal">
                    <span class="glyphicon glyphicon-plus"></span>
                    {$lang.href.add}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=attach#thumb" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="thumb_list" id="thumb_list" class="form-inline">
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
                            <th>{$lang.label.thumbWidth} X {$lang.label.thumbHeight}</th>
                            <th class="text-nowrap td_bg">{$lang.label.thumbCall}</th>
                            <th class="text-nowrap td_sm">{$lang.label.thumbType}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $tplData.thumbRows as $key=>$value}
                            <tr>
                                <td class="text-nowrap td_mn"><input type="checkbox" name="thumb_ids[]" value="{$value.thumb_id}" id="thumb_id_{$value.thumb_id}" data-validate="thumb_id" data-parent="chk_all"></td>
                                <td class="text-nowrap td_mn">{$value.thumb_id}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>{$value.thumb_width} X {$value.thumb_height}</li>
                                        <li>
                                            <ul class="list_menu">
                                                {if $value.thumb_id > 0}
                                                    <li>
                                                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=show&thumb_id={$value.thumb_id}">{$lang.href.show}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=form&thumb_id={$value.thumb_id}&view=iframe" data-toggle="modal" data-target="#thumb_modal">{$lang.href.edit}</a>
                                                    </li>
                                                {else}
                                                    <li>
                                                        {$lang.href.show}
                                                    </li>
                                                    <li>
                                                        {$lang.href.edit}
                                                    </li>
                                                {/if}
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap td_bg">thumb_{$value.thumb_width}_{$value.thumb_height}_{$value.thumb_type}</td>
                                <td class="text-nowrap td_sm">{$type.thumb[$value.thumb_type]}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_thumb_id"></span></td>
                            <td colspan="3">
                                <div class="form-group">
                                    <div id="group_act_post">
                                        <select name="act_post" id="act_post" data-validate class="form-control input-sm">
                                            <option value="">{$lang.option.batch}</option>
                                            <option value="cache">{$lang.option.cache}</option>
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

    <div class="modal fade" id="thumb_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_list = {
        thumb_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='thumb_id']", type: "checkbox" },
            msg: { selector: "#msg_thumb_id", too_few: "{$alert.x030202}" }
        },
        act_post: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act_post" },
            msg: { selector: "#msg_act_post", too_few: "{$alert.x030203}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=thumb",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        $("#thumb_modal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
        var obj_validate_list = $("#thumb_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#thumb_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#thumb_list").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}