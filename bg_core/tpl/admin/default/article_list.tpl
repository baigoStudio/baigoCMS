{function cate_list arr=""}
    {foreach $arr as $key=>$value}
        <option {if $tplData.search.cate_id == $value.cate_id}selected{/if} value="{$value.cate_id}">
            {if $value.cate_level > 1}
                {for $i=2 to $value.cate_level}
                    &nbsp;&nbsp;
                {/for}
            {/if}
            {$value.cate_name}
        </option>

        {if $value.cate_childs}
            {cate_list arr=$value.cate_childs}
        {/if}
    {/foreach}
{/function}

{$cfg = [
    title          => $adminMod.article.main.title,
    menu_active    => "article",
    sub_active     => "list",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    tooltip        => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li>{$adminMod.article.main.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            {$lang.href.add}
                        </a>
                    </li>
                    <li {if !$tplData.search.box}class="active"{/if}>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article">
                            {$lang.href.all}
                            <span class="badge">{$tplData.articleCount.all}</span>
                        </a>
                    </li>
                    <li {if $tplData.search.box == "draft"}class="active"{/if}>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&box=draft">
                            {$lang.href.draft}
                            <span class="badge">{$tplData.articleCount.draft}</span>
                        </a>
                    </li>
                    {if $tplData.articleCount.recycle > 0}
                        <li {if $tplData.search.box == "recycle"}class="active"{/if}>
                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&box=recycle">
                                {$lang.href.recycle}
                                <span class="badge">{$tplData.articleCount.recycle}</span>
                            </a>
                        </li>
                    {/if}
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=article" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="article_search" id="article_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="article">
                <input type="hidden" name="act_get" value="list">
                <input type="hidden" name="box" value="{$tplData.search.box}">
                <div class="form-group">
                    <select name="cate_id" class="form-control input-sm">
                        <option value="">{$lang.option.allCate}</option>
                        {cate_list arr=$tplData.cateRows}
                        <option {if $tplData.search.cate_id == -1}selected{/if} value="-1">{$lang.option.unknown}</option>
                    </select>
                </div>
                <div class="form-group">
                    <select name="year" class="form-control input-sm">
                        <option value="">{$lang.option.allYear}</option>
                        {foreach $tplData.articleYear as $key=>$value}
                            <option {if $tplData.search.year == $value.article_year}selected{/if} value="{$value.article_year}">{$value.article_year}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="form-group">
                    <select name="month" class="form-control input-sm">
                        <option value="">{$lang.option.allMonth}</option>
                        {for $i = 1 to 12}
                            {if $i<10}
                                {$str_month=0|cat:$i|truncate:2}
                            {else}
                                {$str_month=$i}
                            {/if}
                            <option {if $tplData.search.month == $str_month}selected{/if} value="{$str_month}">{$str_month}</option>
                        {/for}
                    </select>
                </div>
                <div class="form-group">
                    <select name="mark_id" class="form-control input-sm">
                        <option value="">{$lang.option.allMark}</option>
                        {foreach $tplData.markRows as $key=>$value}
                            <option {if $tplData.search.mark_id == $value.mark_id}selected{/if} value="{$value.mark_id}">{$value.mark_name}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="form-group">
                    <select name="status" class="form-control input-sm">
                        <option value="">{$lang.option.allStatus}</option>
                        {foreach $status.article as $key=>$value}
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

    {if $tplData.search.box == "recycle"}
        <form name="article_empty" id="article_empty">
            <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
            <input type="hidden" id="act_empty" name="act_post" value="empty">
            <div class="form-group">
                <button type="button" id="go_empty" class="btn btn-info btn-sm">{$lang.btn.emptyMy}</button>
            </div>
        </form>
    {/if}

    {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static" && !$tplData.search.box}
        <div class="form-group">
            <div class="btn-group btn-group-sm">
                <button data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=article&act_get=1by1" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gen_modal">
                    <span class="glyphicon glyphicon-refresh"></span>
                    {$lang.btn.articleGen1by1}
                </button>
                <button data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=article&act_get=1by1&enforce=true" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#gen_modal">
                    <span data-toggle="tooltip" data-placement="right" title="{$lang.label.enforce}">{$lang.btn.articleGenEnforce}</span>
                </button>
            </div>
        </div>
    {/if}

    <form name="article_list" id="article_list" class="form-inline">
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
                            <th>{$lang.label.articleTitle}</th>
                            <th class="text-nowrap td_lg">{$lang.label.cate} / {$lang.label.articleMark}</th>
                            <th class="text-nowrap td_md">{$lang.label.admin} / {$lang.label.hits}</th>
                            <th class="text-nowrap td_lg">{$lang.label.status} / {$lang.label.time}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $tplData.articleRows as $key=>$value}
                            {if $value.article_box == "normal"}
                                {if $value.article_time_pub > $smarty.now}
                                    {$css_status = "info"}
                                    {$str_status = "{$lang.label.timePub} {$value.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}"}
                                {else}
                                    {if $value.article_time_hide > 0 && $value.article_time_pub < $smarty.now}
                                        {$css_status = "default"}
                                        {$str_status = "{$lang.label.timeHide} {$value.article_time_hide|date_format:"{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}"}
                                    {else}
                                        {if $value.article_top == 1}
                                            {$css_status = "primary"}
                                            {$str_status = $lang.label.top}
                                        {else}
                                            {if $value.article_status == "pub"}
                                                {$css_status = "success"}
                                            {else if $value.article_status == "wait"}
                                                {$css_status = "warning"}
                                            {else}
                                                {$css_status = "default"}
                                            {/if}
                                            {$str_status = $status.article[$value.article_status]}
                                        {/if}
                                    {/if}
                                {/if}
                            {else}
                                {$css_status = "default"}
                                {$str_status = $lang.label[$value.article_box]}
                            {/if}
                            {if $value.article_is_gen == "yes"}
                                {$css_gen = "default"}
                            {else}
                                {$css_gen = "danger"}
                            {/if}

                            {$str_gen = $status.gen[$value.article_is_gen]}
                            <tr>
                                <td class="text-nowrap td_mn"><input type="checkbox" name="article_ids[]" value="{$value.article_id}" id="article_id_{$value.article_id}" data-validate="article_id" data-parent="chk_all"></td>
                                <td class="text-nowrap td_mn">{$value.article_id}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>
                                            {if $value.article_title}
                                                {$value.article_title}
                                            {else}
                                                {$lang.label.noname}
                                            {/if}
                                        </li>
                                        <li>
                                            <ul class="list_menu">
                                                <li>
                                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=show&article_id={$value.article_id}">{$lang.href.show}</a>
                                                </li>
                                                <li>
                                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=form&article_id={$value.article_id}">{$lang.href.edit}</a>
                                                </li>
                                                {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static" && $value.article_box == "normal" && $value.article_status == "pub" && $value.article_time_pub < $smarty.now && ($value.article_time_hide < 1 || $value.article_time_hide > $smarty.now)}
                                                    <li>
                                                        <button type="button" class="btn btn-xs btn-info" data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=article&act_get=single&article_id={$value.article_id}" data-toggle="modal" data-target="#gen_modal">
                                                            <span class="glyphicon glyphicon-refresh"></span>
                                                            {$lang.btn.articleGenSingle}
                                                        </button>
                                                    </li>
                                                {/if}
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap td_lg">
                                    <ul class="list-unstyled">
                                        <li>
                                            {$str_cateTrees = ""}
                                            {if isset($value.cateRow.cate_trees)}
                                                {foreach $value.cateRow.cate_trees as $key_tree=>$value_tree}
                                                    {$str_cateTrees = "{$str_cateTrees}{$value_tree.cate_name}"}
                                                    {if !$value_tree@last}
                                                        {$str_cateTrees = "{$str_cateTrees} &raquo; "}
                                                    {/if}
                                                {/foreach}
                                            {/if}

                                            {if isset($value.cateRow.cate_name)}
                                                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list&cate_id={$value_tree.cate_id}">
                                                    <abbr data-toggle="tooltip" data-placement="bottom" title="{$str_cateTrees}">
                                                        {$value.cateRow.cate_name}
                                                    </abbr>
                                                </a>
                                            {else}
                                                {$lang.label.unknown}
                                            {/if}
                                        </li>
                                        <li>
                                            {if isset($value.markRow.mark_name)}
                                                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&mark_id={$value.article_mark_id}">{$value.markRow.mark_name}</a>
                                            {else}
                                                {$lang.label.none}
                                            {/if}
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap td_md">
                                    <ul class="list-unstyled">
                                        <li>
                                            {if isset($value.adminRow.admin_name)}
                                                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&admin_id={$value.article_admin_id}&box={$tplData.search.box}">{$value.adminRow.admin_name}</a>
                                            {else}
                                                {$lang.label.unknown}
                                            {/if}
                                        </li>
                                        <li>
                                            <abbr data-toggle="tooltip" data-placement="bottom" title="{$lang.label.hitsDay} {$value.article_hits_day}<br>{$lang.label.hitsWeek} {$value.article_hits_week}<br>{$lang.label.hitsMonth} {$value.article_hits_month}<br>{$lang.label.hitsYear} {$value.article_hits_year}<br>{$lang.label.hitsAll} {$value.article_hits_all}">{$value.article_hits_all}</abbr>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap td_lg">
                                    <ul class="list-unstyled">
                                        <li class="label_baigo">
                                            <span class="label label-{$css_status}">{$str_status}</span>
                                            {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static"}
                                                <span class="label label-{$css_gen}">{$str_gen}</span>
                                            {/if}
                                        </li>
                                        <li>
                                            <abbr data-toggle="tooltip" data-placement="bottom" title="{$value.article_time|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}">{$value.article_time|date_format:"{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}</abbr>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <span id="msg_article_id"></span>
                            </td>
                            <td colspan="4">
                                <div class="form-group">
                                    <div id="group_act_post">
                                        <select name="act_post" id="act_post" data-validate class="form-control input-sm">
                                            <option value="">{$lang.option.batch}</option>
                                            {if $tplData.search.box == "recycle"}
                                                <option value="normal">{$lang.option.revert}</option>
                                                <option value="draft">{$lang.option.draft}</option>
                                                <option value="del">{$lang.option.del}</option>
                                            {else if $tplData.search.box == "draft"}
                                                <option value="normal">{$lang.option.revert}</option>
                                                <option value="recycle">{$lang.option.recycle}</option>
                                            {else}
                                                {foreach $status.article as $key=>$value}
                                                    <option value="{$key}">{$value}</option>
                                                {/foreach}
                                                <option value="top">{$lang.option.top}</option>
                                                <option value="untop">{$lang.option.untop}</option>
                                                <option value="normal">{$lang.option.revert}</option>
                                                <option value="draft">{$lang.option.draft}</option>
                                                <option value="recycle">{$lang.option.recycle}</option>
                                            {/if}
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
        article_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='article_id']", type: "checkbox" },
            msg: { selector: "#msg_article_id", too_few: "{$alert.x030202}" }
        },
        act_post: {
            len: { min: 1, "max": 0 },
            validate: { type: "select", group: "#group_act_post" },
            msg: { selector: "#msg_act_post", too_few: "{$alert.x030203}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=article",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    var opts_submit_empty = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=article",
        confirm_selector: "#act_empty",
        confirm_val: "empty",
        confirm_msg: "{$lang.confirm.empty}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        var obj_validate_list = $("#article_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#article_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });

        var obj_submit_empty = $("#article_empty").baigoSubmit(opts_submit_empty);
        $("#go_empty").click(function(){
            obj_submit_empty.formSubmit();
        });

        $("#article_list").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}