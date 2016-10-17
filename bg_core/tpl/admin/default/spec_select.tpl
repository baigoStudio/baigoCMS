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
    title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.spec.title}",
    menu_active    => "article",
    sub_active     => "spec",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tinymce        => "true",
    upload         => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=select&spec_id={$tplData.specRow.spec_id}&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
    <li>{$adminMod.article.sub.spec.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=form&spec_id={$tplData.specRow.spec_id}">
                    <span class="glyphicon glyphicon-edit"></span>
                    {$lang.href.edit}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=spec#select" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
            <li>
                <button type="button" class="btn btn-warning btn-sm">{$lang.label.specName} <strong>{$tplData.specRow.spec_name}</strong></button>
            </li>
        </ul>
    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="well">
                <label class="control-label">{$lang.label.belongArticle}</label>
                <form name="belong_search" id="belong_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                    <input type="hidden" name="mod" value="spec">
                    <input type="hidden" name="act_get" value="select">
                    <input type="hidden" name="spec_id" value="{$tplData.specRow.spec_id}">
                    <div class="form-group">
                        <div class="input-group input-group-sm">
                            <input type="text" name="key_belong" class="form-control" value="{$tplData.searchBelong.key}" placeholder="{$lang.label.key}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>

            <form name="belong_form" id="belong_form">
                <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">

                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap td_mn">
                                        <label for="belong_all" class="checkbox-inline">
                                            <input type="checkbox" name="belong_all" id="belong_all" data-parent="first">
                                            {$lang.label.all}
                                        </label>
                                    </th>
                                    <th class="text-nowrap td_mn">{$lang.label.id}</th>
                                    <th>{$lang.label.articleTitle}</th>
                                    <th class="text-nowrap td_lg">{$lang.label.status}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $tplData.belongRows as $key=>$value}
                                    {if $value.article_box == "normal"}
                                        {if $value.article_time_pub > $smarty.now}
                                            {$css_status = "info"}
                                            {$str_status = "{$lang.label.timePub} {$value.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}"}
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
                                    <tr>
                                        <td class="text-nowrap td_mn"><input type="checkbox" name="article_ids[]" value="{$value.article_id}" id="belong_id_{$value.article_id}" data-validate="belong_id" data-parent="belong_all"></td>
                                        <td class="text-nowrap td_mn">{$value.article_id}</td>
                                        <td>
                                            {if $value.article_title}
                                                {$value.article_title}
                                            {else}
                                                {$lang.label.noname}
                                            {/if}
                                        </td>
                                        <td class="text-nowrap td_lg">
                                            <ul class="list-unstyled">
                                                <li class="label_baigo">
                                                    <span class="label label-{$css_status}">{$str_status}</span>
                                                </li>
                                                <li>{$value.article_time|date_format:"{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><span id="msg_belong_id"></span></td>
                                    <td colspan="2">
                                        <input type="hidden" name="act_post" value="belongDel">
                                        <button type="button" id="go_del" class="btn btn-primary btn-sm">{$lang.btn.belongDel}</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-6">

            <div class="well">
                <label class="control-label">{$lang.label.selectArticle}</label>
                <form name="select_search" id="select_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                    <input type="hidden" name="mod" value="spec">
                    <input type="hidden" name="act_get" value="select">
                    <input type="hidden" name="spec_id" value="{$tplData.specRow.spec_id}">
                    <div class="form-group">
                        <select name="cate_id" class="form-control input-sm">
                            <option value="">{$lang.option.allCate}</option>
                            {cate_list arr=$tplData.cateRows}
                            <option {if $tplData.search.cate_id == -1}selected{/if} value="-1">{$lang.option.unknown}</option>
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

            <form name="select_form" id="select_form">
                <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
                <input type="hidden" name="spec_id" value="{$tplData.specRow.spec_id}">

                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap td_mn">
                                        <label for="select_all" class="checkbox-inline">
                                            <input type="checkbox" name="select_all" id="select_all" data-parent="first">
                                            {$lang.label.all}
                                        </label>
                                    </th>
                                    <th class="text-nowrap td_mn">{$lang.label.id}</th>
                                    <th>{$lang.label.articleTitle} / {$lang.label.articleSpec}</th>
                                    <th class="text-nowrap td_lg">{$lang.label.status}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $tplData.articleRows as $key=>$value}
                                    {if $value.article_box == "normal"}
                                        {if $value.article_time_pub > $smarty.now}
                                            {$css_status = "info"}
                                            {$str_status = "{$lang.label.timePub} {$value.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}"}
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
                                    <tr>
                                        <td class="text-nowrap td_mn"><input type="checkbox" name="article_ids[]" value="{$value.article_id}" id="select_ids_{$value.article_id}" data-validate="select_ids" data-parent="select_all"></td>
                                        <td class="text-nowrap td_mn">{$value.article_id}</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=show&article_id={$value.article_id}">
                                                        {if $value.article_title}
                                                            {$value.article_title}
                                                        {else}
                                                            {$lang.label.noname}
                                                        {/if}
                                                    </a>
                                                </li>
                                                <li>
                                                    {if isset($value.specRow.spec_name)}
                                                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=select&spec_id={$value.specRow.spec_id}">{$value.specRow.spec_name}</a>
                                                    {/if}
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-nowrap td_lg">
                                            <ul class="list-unstyled">
                                                <li class="label_baigo">
                                                    <span class="label label-{$css_status}">{$str_status}</span>
                                                </li>
                                                <li>{$value.article_time|date_format:"{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><span id="msg_select_ids"></span></td>
                                    <td colspan="2">
                                        <input type="hidden" name="act_post" value="belongAdd">
                                        <button type="button" id="go_add" class="btn btn-primary btn-sm">{$lang.btn.belongAdd}</button>
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

        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}


    <script type="text/javascript">
    var opts_validator_select = {
        select_ids: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='select_ids']", type: "checkbox" },
            msg: { selector: "#msg_select_ids", too_few: "{$alert.x030202}" }
        }
    };

    var opts_validator_belong = {
        belong_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='belong_id']", type: "checkbox" },
            msg: { selector: "#msg_belong_id", too_few: "{$alert.x030202}" }
        }
    };

    var opts_submit_select = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    var opts_submit_belong = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        var obj_validate_select   = $("#select_form").baigoValidator(opts_validator_select);
        var obj_submit_select     = $("#select_form").baigoSubmit(opts_submit_select);
        $("#go_add").click(function(){
            if (obj_validate_select.verify()) {
                obj_submit_select.formSubmit();
            }
        });
        var obj_validate_belong   = $("#belong_form").baigoValidator(opts_validator_belong);
        var obj_submit_belong     = $("#belong_form").baigoSubmit(opts_submit_belong);
        $("#go_del").click(function(){
            if (obj_validate_belong.verify()) {
                obj_submit_belong.formSubmit();
            }
        });
        $("#belong_form").baigoCheckall();
        $("#select_form").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}

