{function custom_list arr=""}
    {foreach $arr as $key=>$value}
        {if $value.custom_childs}
            <div class="custom_group custom_group_{$value.custom_cate_id} col-md-12">
                <h4>
                    <span class="label label-default">{$value.custom_name}</span>
                </h4>
            </div>
        {else}
            <div class="custom_group custom_group_{$value.custom_cate_id} col-md-6">
                <div class="form-group">
                    <label class="control-label">{$value.custom_name}<span id="msg_article_custom_{$value.custom_id}"></span></label>
                    {if $value.custom_type == "radio"}
                        {foreach $value.custom_opt as $key_option=>$value_option}
                            <div class="radio_baigo">
                                <label for="article_customs_{$value.custom_id}_{$key_option}">
                                    <input type="radio" id="article_customs_{$value.custom_id}_{$key_option}" {if isset($tplData.articleRow.article_customs["custom_{$value.custom_id}"]) && $tplData.articleRow.article_customs["custom_{$value.custom_id}"] == $value_option}checked{/if} name="article_customs[{$value.custom_id}]" value="{$value_option}" data-validate="article_customs_{$value.custom_id}">
                                    {$value_option}
                                </label>
                            </div>
                        {/foreach}
                    {else if $value.custom_type == "select"}
                        <select id="article_customs_{$value.custom_id}" name="article_customs[{$value.custom_id}]" data-validate class="form-control">
                            <option value="">{$lang.option.pleaseSelect}</option>
                            {foreach $value.custom_opt as $key_option=>$value_option}
                                <option {if isset($tplData.articleRow.article_customs["custom_{$value.custom_id}"]) && $tplData.articleRow.article_customs["custom_{$value.custom_id}"] == $value_option}selected{/if} value="{$value_option}">
                                    {$value_option}
                                </option>
                            {/foreach}
                        </select>
                    {else if $value.custom_type == "textarea"}
                        <textarea id="article_customs_{$value.custom_id}" name="article_customs[{$value.custom_id}]" data-validate class="form-control text_md">{if isset($tplData.articleRow.article_customs["custom_{$value.custom_id}"])}{$tplData.articleRow.article_customs["custom_{$value.custom_id}"]}{/if}</textarea>
                    {else}
                        <input type="text" id="article_customs_{$value.custom_id}" name="article_customs[{$value.custom_id}]" value="{if isset($tplData.articleRow.article_customs["custom_{$value.custom_id}"])}{$tplData.articleRow.article_customs["custom_{$value.custom_id}"]}{/if}" data-validate class="form-control">
                    {/if}
                </div>
            </div>
        {/if}

        {if $value.custom_childs}
            {custom_list arr=$value.custom_childs}
        {/if}
    {/foreach}
{/function}

{function custom_validataJson arr=""}
    {foreach $arr as $key=>$value}
        {if !$value.custom_childs}
            article_customs_{$value.custom_id}: {
                len: { min: {$value.custom_require}, max: 90 },
                validate: { type: "{$value.custom_type}"{if $value.custom_type != "radio" && $value.custom_type != "select"}, format: "{$value.custom_format}"{/if} },
                msg: { selector: "#msg_article_custom_{$value.custom_id}", {if $value.custom_type != "radio" && $value.custom_type != "select"}too_short: "{$alert.x120216}{$value.custom_name}"{else}too_few: "{$alert.x120218}{$value.custom_name}"{/if}{if $value.custom_type != "radio" && $value.custom_type != "select"}, too_long: "{$value.custom_name}{$alert.x120217}"{/if} }
            },
        {/if}

        {if $value.custom_childs}
            {custom_validataJson arr=$value.custom_childs}
        {/if}
    {/foreach}
{/function}

{function cate_select arr="" level=""}
    {foreach $arr as $key=>$value}
        <option {if $value.cate_id == $tplData.articleRow.article_cate_id}selected{/if} {if $value.cate_type != "normal"}disabled{/if} value="{$value.cate_id}">
            {if $value.cate_level > 1}
                {for $_i=2 to $value.cate_level}
                    &nbsp;&nbsp;
                {/for}
            {/if}
            {$value.cate_name}
        </option>

        {if $value.cate_childs}
            {cate_select arr=$value.cate_childs level=$value.cate_level}
        {/if}
    {/foreach}
{/function}

{function cate_checkbox arr="" level=""}
    <ul class="list-unstyled{if $level > 0} list_padding{/if}">
        {foreach $arr as $key=>$value}
            <li>
                <div class="checkbox_baigo">
                    <label for="cate_ids_{$value.cate_id}">
                        <input type="checkbox" {if $value.cate_id|in_array:$tplData.articleRow.cate_ids}checked{/if} {if $value.cate_type != "normal"}disabled{/if} value="{$value.cate_id}" name="cate_ids[]" id="cate_ids_{$value.cate_id}">
                        {$value.cate_name}
                    </label>
                </div>

                {if $value.cate_childs}
                    {cate_checkbox arr=$value.cate_childs level=$value.cate_level}
                {/if}
            </li>
        {/foreach}
    </ul>
{/function}

{if $tplData.articleRow.article_id < 1}
    {$title_sub = $lang.page.add}
    {$sub_active = "form"}
{else}
    {$title_sub = $lang.page.edit}
    {$sub_active = "list"}
{/if}

{$cfg = [
    title          => "{$adminMod.article.main.title} - {$title_sub}",
    menu_active    => "article",
    sub_active     => $sub_active,
    baigoValidator => "true",
    baigoSubmit    => "true",
    tinymce        => "true",
    datepicker     => "true",
    tagmanager     => "true",
    upload         => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
    <li>{$title_sub}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=article#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="article_form" id="article_form">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="submit">
        <input type="hidden" name="article_id" value="{$tplData.articleRow.article_id}">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_article_title">
                                <label class="control-label">{$lang.label.articleTitle}<span id="msg_article_title">*</span></label>
                                <input type="text" name="article_title" id="article_title" value="{$tplData.articleRow.article_title}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group" data-spy="affix" data-offset-top="260">
                            <div class="btn-group">
                                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=form&article_id={$tplData.articleRow.article_id}&view=iframe" class="btn btn-success" data-toggle="modal" data-target="#article_modal">
                                    <span class="glyphicon glyphicon-picture"></span>
                                    {$lang.href.uploadList}
                                </a>
                                {if $tplData.articleRow.article_id > 0}
                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=article&article_id={$tplData.articleRow.article_id}" class="btn btn-default">
                                        {$lang.href.attachArticle}
                                    </a>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{$lang.label.articleContent}</label>
                            <textarea name="article_content" id="article_content" class="tinymce text_bg">{$tplData.articleRow.article_content}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">{$lang.label.excerptType}</label>
                            <div>
                                {foreach $type.excerpt as $key=>$value}
                                    <label for="article_excerpt_type_{$key}" class="radio-inline">
                                        <input type="radio" name="article_excerpt_type" id="article_excerpt_type_{$key}" {if $tplData.articleRow.article_excerpt_type == $key}checked{/if} value="{$key}" class="article_excerpt_type">
                                        {$value}
                                    </label>
                                {/foreach}
                            </div>
                        </div>

                        <div id="group_article_excerpt">
                            <label class="control-label">{$lang.label.articleExcerpt}</label>
                            <div class="form-group">
                                <textarea name="article_excerpt" id="article_excerpt" class="tinymce text_md">{$tplData.articleRow.article_excerpt}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">{$lang.label.articleTag}<span id="msg_article_tag"></span></label>
                            <div class="tm-input-group form-inline">
                                <input type="text" name="article_tag" id="article_tag" data-validate class="form-control tm-input tm-input-success">
                                <button type="button" class="btn btn-info btn-sm tm-btn" id="tag_add"><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_article_link" {if $tplData.articleRow.article_link}class="has-warning"{/if}>
                                <label class="control-label">{$lang.label.articleLink}<span id="msg_article_link"></span></label>
                                <input type="text" name="article_link" id="article_link" value="{$tplData.articleRow.article_link}" data-validate class="form-control">
                                <p class="help-block">{$lang.label.articleLinkNote}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                {custom_list arr=$tplData.customRows}
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="go_submit btn btn-primary">{$lang.btn.save}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    {if $tplData.articleRow.article_id > 0}
                        <div class="form-group">
                            <label class="control-label">{$lang.label.id}</label>
                            <p class="form-control-static">{$tplData.articleRow.article_id}</p>
                        </div>
                    {/if}

                    <div class="form-group">
                        <div id="group_article_cate_id">
                            <label class="control-label">{$lang.label.articleCate}<span id="msg_article_cate_id">*</span></label>
                            <select name="article_cate_id" id="article_cate_id" data-validate class="form-control">
                                <option value="">{$lang.option.pleaseSelect}</option>
                                {cate_select arr=$tplData.cateRows}
                            </select>
                        </div>
                    </div>

                    <div class="checkbox">
                        <label for="cate_ids_checkbox">
                            <input type="checkbox" {if count($tplData.articleRow.cate_ids) > 1}checked{/if} id="cate_ids_checkbox" name="cate_ids_checkbox" value="1">
                            {$lang.label.articleBelong}
                        </label>
                    </div>

                    <div class="form-group">
                        <div id="cate_ids_input">
                            {cate_checkbox arr=$tplData.cateRows}
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_article_status">
                            <label class="control-label">{$lang.label.status}<span id="msg_article_status">*</span></label>
                            {foreach $status.article as $key=>$value}
                                <div class="radio_baigo">
                                    <label for="article_status_{$key}">
                                        <input type="radio" name="article_status" id="article_status_{$key}" {if $tplData.articleRow.article_status == $key}checked{/if} value="{$key}" data-validate="article_status">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_article_box">
                            <label class="control-label">{$lang.label.box}<span id="msg_article_box">*</span></label>
                            <div class="radio_baigo">
                                <label for="article_box_normal">
                                    <input type="radio" name="article_box" id="article_box_normal" {if $tplData.articleRow.article_box == "normal"}checked{/if} value="normal" data-validate="article_box">
                                    {$lang.label.normal}
                                </label>
                            </div>
                            <div class="radio_baigo">
                                <label for="article_box_draft">
                                    <input type="radio" name="article_box" id="article_box_draft" {if $tplData.articleRow.article_box == "draft"}checked{/if} value="draft" data-validate="article_box">
                                    {$lang.label.draft}
                                </label>
                            </div>
                            <div class="radio_baigo">
                                <label for="article_box_recycle">
                                    <input type="radio" name="article_box" id="article_box_recycle" {if $tplData.articleRow.article_box == "recycle"}checked{/if} value="recycle" data-validate="article_box">
                                    {$lang.label.recycle}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">{$lang.label.articleMark}</label>
                        <select name="article_mark_id" class="form-control">
                            <option value="">{$lang.option.noMark}</option>
                            {foreach $tplData.markRows as $key=>$value}
                                <option {if $value.mark_id == $tplData.articleRow.article_mark_id}selected{/if} value="{$value.mark_id}">{$value.mark_name}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="time_pub_checkbox">
                                <input type="checkbox" {if $tplData.articleRow.article_time_pub > $smarty.now}checked{/if} name="time_pub_checkbox" id="time_pub_checkbox" value="1">
                                {$lang.label.timePub}
                                <span id="msg_article_time_pub"></span>
                            </label>
                        </div>
                    </div>
                    <div id="time_pub_input">
                        <div class="form-group">
                            <input type="text" name="article_time_pub" id="article_time_pub" value="{$tplData.articleRow.article_time_pub|date_format:"%Y-%m-%d %H:%M"}" data-validate class="form-control input_date">
                            <p class="help-block">{$lang.label.timeNote}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="time_hide_checkbox">
                                <input type="checkbox" {if $tplData.articleRow.article_time_hide > 0}checked{/if} id="time_hide_checkbox" name="time_hide_checkbox" value="1">
                                {$lang.label.timeHide}
                                <span id="msg_article_time_hide"></span>
                            </label>
                        </div>
                    </div>

                    <div id="time_hide_input">
                        <div class="form-group">
                            <input type="text" name="article_time_hide" id="article_time_hide" value="{$tplData.articleRow.article_time_hide|date_format:"%Y-%m-%d %H:%M"}" data-validate class="form-control input_date">
                            <p class="help-block">{$lang.label.timeNote}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">{$lang.label.articleSpec}</label>
                        <div class="input-group">
                            <input type="text" id="spec_key" name="spec_key" placeholder="{$lang.label.key}" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="button" id="spec_search_btn">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                        <div id="spec_check_list">
                            {foreach $tplData.specRows as $key=>$value}
                                <div class="checkbox" id="spec_checkbox_{$value.spec_id}">
                                    <label for="article_spec_ids_{$value.spec_id}">
                                        <input type="checkbox" id="article_spec_ids_{$value.spec_id}" checked name="article_spec_ids[]" value="{$value.spec_id}">
                                        {$value.spec_name}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="article_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_form = {
        {custom_validataJson arr=$tplData.customRows}
        article_title: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_article_title" },
            msg: { selector: "#msg_article_title", too_short: "{$alert.x120201}", too_long: "{$alert.x120202}" }
        },
        article_link: {
            len: { min: 0, max: 900 },
            validate: { type: "str", format: "url", group: "#group_article_link" },
            msg: { selector: "#msg_article_link", too_long: "{$alert.x120204}", format_err: "{$alert.x120205}" }
        },
        article_excerpt: {
            len: { min: 0, max: 900 },
            validate: { type: "str", format: "text" },
            msg: { selector: "#msg_article_excerpt", too_long: "{$alert.x120206}" }
        },
        article_tag: {
            len: { min: 0, max: 0 },
            validate: { type: "str", format: "strDigit" },
            msg: { selector: "#msg_article_tag", format_err: "{$alert.x120215}" }
        },
        article_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_article_cate_id" },
            msg: { selector: "#msg_article_cate_id", too_few: "{$alert.x120207}" }
        },
        article_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='article_status']", type: "radio", group: "#group_article_status" },
            msg: { selector: "#msg_article_status", too_few: "{$alert.x120208}" }
        },
        article_box: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='article_box']", type: "radio", group: "#group_article_box" },
            msg: { selector: "#msg_article_box", too_few: "{$alert.x120209}" }
        },
        article_time_pub: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { selector: "#msg_article_time_pub", too_short: "{$alert.x120210}", format_err: "{$alert.x120211}" }
        },
        article_time_hide: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { selector: "#msg_article_time_hide", too_short: "{$alert.x120219}", format_err: "{$alert.x120220}" }
        }
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=article",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    function article_cate_id(_cate_id) {
        $(".custom_group").hide();
        $(".custom_group_0").show();
        $(".custom_group_" + _cate_id).show();
    }

    function excerpt_type(_excerpt_type) {
        if (_excerpt_type == "manual") {
            $("#group_article_excerpt").show();
        } else {
            $("#group_article_excerpt").hide();
        }
    }

    function cate_ids_check(_is_checked) {
        if (_is_checked) {
            $("#cate_ids_input").show();
        } else {
            $("#cate_ids_input").hide();
        }
    }

    function time_pub_check(_is_checked) {
        if (_is_checked) {
            $("#time_pub_input").show();
        } else {
            $("#time_pub_input").hide();
        }
    }

    function time_hide_check(_is_checked) {
        if (_is_checked) {
            $("#time_hide_input").show();
        } else {
            $("#time_hide_input").hide();
        }
    }

    $(document).ready(function(){
        article_cate_id("{$tplData.articleRow.article_cate_id}");
        excerpt_type("{$tplData.articleRow.article_excerpt_type}");
        cate_ids_check({if count($tplData.articleRow.cate_ids) > 1}true{else}false{/if});
        time_pub_check({if $tplData.articleRow.article_time_pub > $smarty.now}true{else}false{/if});
        time_hide_check({if $tplData.articleRow.article_time_hide > 0}true{else}false{/if});

        $("#article_modal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });

        $(".article_excerpt_type").click(function(){
            var _excerpt_type = $(this).val();
            excerpt_type(_excerpt_type);
        });

        $("#article_cate_id").change(function(){
            var _cate_id = $(this).val();
            article_cate_id(_cate_id);
        });

        $("#spec_search_btn").click(function(){
            var _spec_key = $("#spec_key").val();
            $("#article_modal").modal({ remote: "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=insert&target=article&article_id={$tplData.articleRow.article_id}&view=iframe&key=" + _spec_key });
        });

        var obj_validate_form = $("#article_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#article_form").baigoSubmit(opts_submit_form);
        $(".go_submit").click(function(){
            tinyMCE.triggerSave();
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $(".input_date").datetimepicker(opts_datetimepicker);

        $("#cate_ids_checkbox").click(function(){
            var _is_checked = $(this).prop("checked");
            cate_ids_check(_is_checked);
        });

        $("#time_pub_checkbox").click(function(){
            var _is_checked = $(this).prop("checked");
            time_pub_check(_is_checked);
        });

        $("#time_hide_checkbox").click(function(){
            var _is_checked = $(this).prop("checked");
            time_hide_check(_is_checked);
        });

        var obj_tagMan = jQuery("#article_tag").tagsManager({
            {if $tplData.articleRow.article_tags}
                prefilled: {$tplData.articleRow.article_tags},
            {/if}
            maxTags: 5,
            backspace: ""
        });

        $("#article_tag").typeahead({
            limit: 1000,
            prefetch: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=tag&act_get=list"
        }).on("typeahead:selected", function(e, d) {
            obj_tagMan.tagsManager("pushTag", d.value);
        });

        $("#tag_add").on("click", function(e) {
            var _str_tag = $("#article_tag").val();
            obj_tagMan.tagsManager("pushTag", _str_tag);
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}