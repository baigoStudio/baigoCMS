{*attach_list.php 上传管理*}
{$cfg = [
    title          => "{$adminMod.article.main.title} - {$lang.page.attachArticle}",
    menu_active    => "article",
    sub_active     => "list",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    tooltip        => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=article&article_id={$tplData.articleRow.article_id}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=form&article_id={$tplData.articleRow.article_id}">{$tplData.articleRow.article_title}</a></li>
    <li>{$lang.page.attachArticle}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=form&article_id={$tplData.articleRow.article_id}">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            {$lang.href.back}
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=attach" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&ids={$tplData.ids}" class="btn btn-info btn-sm">{$lang.href.attachList}</a>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="well">
                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.id}</label>
                    <p class="form-control-static">{$tplData.articleRow.article_id}</p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.articleTitle}</label>
                    <p class="form-control-static input-lg">
                        {$tplData.articleRow.article_title}
                    </p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.articleCate}</label>
                    <p class="form-control-static">{$tplData.cateRow.cate_name}</p>
                </div>

                {if $tplData.articleRow.article_box == "normal"}
                    {if $tplData.articleRow.article_time_pub > $smarty.now}
                        {$css_status = "info"}
                        {$str_status = "{$lang.label.deadline} {$tplData.articleRow.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}"}
                    {else}
                        {if $tplData.articleRow.article_top == 1}
                            {$css_status = "primary"}
                            {$str_status = $lang.label.top}
                        {else}
                            {if $tplData.articleRow.article_status == "pub"}
                                {$css_status = "success"}
                            {else if $tplData.articleRow.article_status == "wait"}
                                {$css_status = "warning"}
                            {else}
                                {$css_status = "default"}
                            {/if}
                            {$str_status = $status.article[$tplData.articleRow.article_status]}
                        {/if}
                    {/if}
                {else}
                    {$css_status = "default"}
                    {$str_status = $lang.label[$tplData.articleRow.article_box]}
                {/if}

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.status}</label>
                    <p class="form-control-static label_baigo">
                        <span class="label label-{$css_status}">{$str_status}</span>
                    </p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.time}</label>
                    <p class="form-control-static">
                        {$tplData.articleRow.article_time|date_format:"%Y-%m-%d %H:%M"}
                    </p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.articleMark}</label>
                    <p class="form-control-static">
                        {if isset($tplData.markRow.mark_name)}
                            {$tplData.markRow.mark_name}
                        {else}
                            {$lang.label.none}
                        {/if}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <form name="attach_list" id="attach_list">
                <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
                <input type="hidden" name="article_id" value="{$tplData.articleRow.article_id}">
                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap td_mn">

                                    </th>
                                    <th class="text-nowrap td_mn">{$lang.label.id}</th>
                                    <th class="text-nowrap td_sm">{$lang.label.attachThumb}</th>
                                    <th>{$lang.label.attachInfo}</th>
                                    <th class="text-nowrap td_md">{$lang.label.status} / {$lang.label.admin}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $tplData.attachRows as $key=>$value}
                                    {if $value.attach_box == "normal"}
                                        {$css_status = "success"}
                                    {else}
                                        {$css_status = "default"}
                                    {/if}
                                    <tr>
                                        <td class="text-nowrap td_mn">
                                            <input type="radio" name="attach_id" value="{$value.attach_id}" {if $value.attach_id == $tplData.articleRow.article_attach_id}checked{/if} id="attach_id_{$value.attach_id}" data-validate="attach_id">
                                        </td>
                                        <td class="text-nowrap td_mn">{$value.attach_id}</td>
                                        <td class="text-nowrap td_sm">
                                            {if $value.attach_type == "image"}
                                                <a href="{$value.attach_url}" target="_blank"><img src="{$value.attach_thumb.0.thumb_url}" alt="{$value.attach_name}" width="100"></a>
                                            {else}
                                                <a href="{$value.attach_url}" target="_blank"><img src="{$smarty.const.BG_URL_STATIC}image/file_{$value.attach_ext}.png" alt="{$value.attach_name}" width="50"></a>
                                            {/if}
                                        </td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li><a href="{$value.attach_url}" target="_blank">{$value.attach_name}</a></li>
                                                <li>
                                                    <abbr data-toggle="tooltip" data-placement="bottom" title="{$value.attach_time|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}">{$value.attach_time|date_format:$smarty.const.BG_SITE_DATE}</abbr>
                                                </li>
                                                {if $value.attach_size > 1024}
                                                    {$num_attachSize = $value.attach_size / 1024}
                                                    {$str_attachUnit = "KB"}
                                                {else if $value.attach_size > 1024 * 1024}
                                                    {$num_attachSize = $value.attach_size / 1024 / 1024}
                                                    {$str_attachUnit = "MB"}
                                                {else if $value.attach_size > 1024 * 1024 * 1024}
                                                    {$num_attachSize = $value.attach_size / 1024 / 1024 / 1024}
                                                    {$str_attachUnit = "GB"}
                                                {else}
                                                    {$num_attachSize = $value.attach_size}
                                                    {$str_attachUnit = "Byte"}
                                                {/if}
                                                <li>{$num_attachSize|string_format:"%.2f"} {$str_attachUnit}</li>
                                                <li>
                                                    {if $value.attach_type == "image"}
                                                        <div class="dropdown">
                                                            <button class="btn btn-default dropdown-toggle btn-sm" type="button" id="attach_{$value.attach_id}" data-toggle="dropdown">
                                                                {$lang.btn.thumb}
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                {foreach $value.attach_thumb as $key_thumb=>$value_thumb}
                                                                    <li><a href="{$value_thumb.thumb_url}" target="_blank">{$value_thumb.thumb_width}x{$value_thumb.thumb_height} {$type.thumb[$value_thumb.thumb_type]}</a></li>
                                                                {/foreach}
                                                            </ul>
                                                        </div>
                                                    {/if}
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-nowrap td_md">
                                            <ul class="list-unstyled">
                                                <li class="label_baigo">
                                                    <span class="label label-{$css_status}">{$lang.label[$value.attach_box]}</span>
                                                </li>
                                                <li>
                                                    {if isset($value.adminRow.admin_name)}
                                                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&admin_id={$value.attach_admin_id}">{$value.adminRow.admin_name}</a>
                                                    {else}
                                                        {$lang.label.unknown}
                                                    {/if}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <span id="msg_attach_id"></span>
                                    </td>
                                    <td colspan="3">
                                        <input type="hidden" name="act_post" value="primary">
                                        <button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.setPrimary}</button>
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
    var opts_validator_list = {
        attach_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='attach_id']", type: "radio" },
            msg: { selector: "#msg_attach_id", too_few: "{$alert.x120214}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=article",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        var obj_validate_list = $("#attach_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#attach_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}