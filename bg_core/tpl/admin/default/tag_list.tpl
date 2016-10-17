{$cfg = [
    title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.tag.title}",
    menu_active    => "article",
    sub_active     => "tag",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=tag&act_get=list&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl"}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
    <li>{$adminMod.article.sub.tag.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=tag&act_get=form&view=iframe" data-toggle="modal" data-target="#tag_modal">
                            <span class="glyphicon glyphicon-plus"></span>
                            {$lang.href.add}
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=tag" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="tag_search" id="tag_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="tag">
                <input type="hidden" name="act_get" value="list">
                <div class="form-group">
                    <select name="status" class="form-control input-sm">
                        <option value="">{$lang.option.allStatus}</option>
                        {foreach $status.tag as $key=>$value}
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


    <form name="tag_list" id="tag_list" class="form-inline">
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
                            <th>{$lang.label.tagName}</th>
                            <th class="text-nowrap td_sm">{$lang.label.status} / {$lang.label.articleCount}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $tplData.tagRows as $key=>$value}
                            {if $value.tag_status == "show"}
                                {$css_status = "success"}
                            {else}
                                {$css_status = "default"}
                            {/if}
                            <tr>
                                <td class="text-nowrap td_mn"><input type="checkbox" name="tag_ids[]" value="{$value.tag_id}" id="tag_id_{$value.tag_id}" data-validate="tag_id" data-parent="chk_all"></td>
                                <td class="text-nowrap td_mn">{$value.tag_id}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>
                                            {if $value.tag_name}
                                                {$value.tag_name}
                                            {else}
                                                {$lang.label.noname}
                                            {/if}
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=tag&act_get=form&tag_id={$value.tag_id}&view=iframe" data-toggle="modal" data-target="#tag_modal">{$lang.href.edit}</a>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap td_sm">
                                    <ul class="list-unstyled">
                                        <li class="label_baigo">
                                            <span class="label label-{$css_status}">{$status.tag[$value.tag_status]}</span>
                                        </li>
                                        <li>{$value.tag_article_count}</li>
                                    </ul>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_tag_id"></span></td>
                            <td colspan="2">
                                <div class="form-group">
                                    <div id="group_act_post">
                                        <select name="act_post" id="act_post"  data-validate class="form-control input-sm">
                                            <option value="">{$lang.option.batch}</option>
                                            {foreach $status.tag as $key=>$value}
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

    <div class="modal fade" id="tag_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl"}

    <script type="text/javascript">
    var opts_validator_list = {
        tag_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='tag_id']", type: "checkbox" },
            msg: { selector: "#msg_tag_id", too_few: "{$alert.x030202}" }
        },
        act_post: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act_post" },
            msg: { selector: "#msg_act_post", too_few: "{$alert.x030203}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=tag",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        $("#tag_modal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
        var obj_validate_list = $("#tag_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#tag_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#tag_list").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}