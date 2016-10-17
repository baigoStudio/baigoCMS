{$cfg = [
    title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.spec.title}",
    menu_active    => "article",
    sub_active     => "spec",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=list&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl"}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
    <li>{$adminMod.article.sub.spec.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            {$lang.href.add}
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=spec" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="spec_search" id="spec_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="spec">
                <input type="hidden" name="act_get" value="list">
                <div class="form-group">
                    <select name="status" class="form-control input-sm">
                        <option value="">{$lang.option.allStatus}</option>
                        {foreach $status.spec as $key=>$value}
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
            <div class="btn-group btn-group-sm">
                <button data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=spec&act_get=1by1&overall=true" class="btn btn-primary" data-toggle="modal" data-target="#gen_modal">
                    <span class="glyphicon glyphicon-refresh"></span>
                    {$lang.btn.specGenOverall}
                </button>
                <button data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=spec&act_get=list" class="btn btn-primary" data-toggle="modal" data-target="#gen_modal">
                    {$lang.btn.specGenList}
                </button>
                <button data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=spec&act_get=1by1" class="btn btn-primary" data-toggle="modal" data-target="#gen_modal">
                    {$lang.btn.specGen1by1}
                </button>
            </div>
        </div>
    {/if}

    <form name="spec_list" id="spec_list" class="form-inline">
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
                            <th>{$lang.label.spec}</th>
                            <th class="text-nowrap td_sm">{$lang.label.status}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $tplData.specRows as $key=>$value}
                            {if $value.spec_status == "show"}
                                {$css_status = "success"}
                            {else}
                                {$css_status = "default"}
                            {/if}
                            <tr>
                                <td class="text-nowrap td_mn"><input type="checkbox" name="spec_ids[]" value="{$value.spec_id}" id="spec_id_{$value.spec_id}" data-validate="spec_id" data-parent="chk_all"></td>
                                <td class="text-nowrap td_mn">{$value.spec_id}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>
                                            {if $value.spec_name}
                                                {$value.spec_name}
                                            {else}
                                                {$lang.label.noname}
                                            {/if}
                                        </li>
                                        <li>
                                            <ul class="list_menu">
                                                <li>
                                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=form&spec_id={$value.spec_id}">{$lang.href.edit}</a>
                                                </li>
                                                <li>
                                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=select&spec_id={$value.spec_id}">{$lang.href.specSelect}</a>
                                                </li>
                                                {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static" && $value.spec_status == "show"}
                                                    <li>
                                                        <button type="button" class="btn btn-xs btn-info" data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=spec&act_get=single&spec_id={$value.spec_id}" data-toggle="modal" data-target="#gen_modal">
                                                            <span class="glyphicon glyphicon-refresh"></span>
                                                            {$lang.btn.specGenSingle}
                                                        </button>
                                                    </li>
                                                {/if}
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="td_sm label_baigo">
                                    <span class="label label-{$css_status}">{$status.spec[$value.spec_status]}</span>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_spec_id"></span></td>
                            <td colspan="2">
                                <div class="form-group">
                                    <div id="group_act_post">
                                        <select name="act_post" id="act_post" data-validate class="form-control input-sm">
                                            <option value="">{$lang.option.batch}</option>
                                            {foreach $status.spec as $key=>$value}
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

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl"}

    <script type="text/javascript">
    var opts_validator_list = {
        spec_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='spec_id']", type: "checkbox" },
            msg: { selector: "#msg_spec_id", too_few: "{$alert.x030202}" }
        },
        act_post: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act_post" },
            msg: { selector: "#msg_act_post", too_few: "{$alert.x030203}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        var obj_validate_list = $("#spec_list").baigoValidator(opts_validator_list);
        var obj_submit_list = $("#spec_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#spec_list").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}